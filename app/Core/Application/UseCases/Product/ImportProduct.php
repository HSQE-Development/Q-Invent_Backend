<?php

namespace App\Core\Application\UseCases\Product;

use App\Core\Application\UseCases\ProductHistory\CreateProductHistory;
use App\Core\Application\UseCases\Ubication\FindUbicationByName;
use App\Core\Domain\Entities\ProductEntity;
use App\Core\Domain\Repositories\ProductRepositoryInterface;
use App\Core\Domain\Services\ExcelReaderServiceInterface;
use App\Core\Infrastructure\Helpers\ProductHistoryMapping;
use App\Core\Infrastructure\Helpers\UbicationMapping;
use App\Core\Infrastructure\Transformers\ProductTransformer;

class ImportProduct
{
    private ExcelReaderServiceInterface $excelReaderServiceInterface;
    private FindUbicationByName $findUbicationByName;
    private ProductRepositoryInterface $productRepositoryInterface;
    protected CreateProductHistory $createProductHistory;

    public function __construct(
        ExcelReaderServiceInterface $excelReaderServiceInterface,
        FindUbicationByName $findUbicationByName,
        ProductRepositoryInterface $productRepositoryInterface,
        CreateProductHistory $createProductHistory
    ) {
        $this->excelReaderServiceInterface = $excelReaderServiceInterface;
        $this->findUbicationByName = $findUbicationByName;
        $this->productRepositoryInterface = $productRepositoryInterface;
        $this->createProductHistory = $createProductHistory;
    }

    public function execute(string $filePath)
    {
        $importData = $this->excelReaderServiceInterface->readExcel($filePath);
        $productData = $importData[0];
        $fileErrors = $importData[1];


        $productsToUpdate = [];
        $productsToAdd = [];
        $allProducts = [];
        $errors = [];

        if (!empty($fileErrors)) {
            $errors = array_merge($errors, $fileErrors);
        }

        foreach ($productData as $index => $product) {

            try {

                if (
                    $product["name"] !== null
                    && $product["ubication"] !== null
                    && $product["total_quantity"] !== null
                    && $product["quantity_type"] !== null
                ) {
                    $existingUbication = $this->findUbicationByName->execute($product["ubication"]);
                    if (!$existingUbication) {
                        throw new \Exception("Ubicación no encontrada: {$product['ubication']}");
                    }
                    $existingProduct = $this->productRepositoryInterface->getByName(trim($product["name"]));

                    $productEntity = new ProductEntity(
                        id: $existingProduct?->getId(),
                        name: $product["name"],
                        total_quantity: $product["total_quantity"],
                        quantity_type: $product["quantity_type"],
                        ubication: UbicationMapping::dtoToEntity($existingUbication),
                        observation: null,
                        active: "A",
                        assignmentPeople: [],
                        quantity_available: $product["total_quantity"],
                    );
                    if ($existingProduct) {
                        $productsToUpdate[] = $productEntity;
                    } else {
                        $productsToAdd[] = $productEntity;
                    }
                }
            } catch (\Exception $e) {

                $errors[] = [
                    'index' => $index + 1,
                    'product' => $product,
                    'error' => $e->getMessage(),
                ];
            }
        }
        if (!empty($productsToUpdate)) {
            $updateResult = $this->productRepositoryInterface->updateMassiveProducts($productsToUpdate);
            foreach ($updateResult['products_saved'] as $updatedProduct) {
                $allProducts[] = $updatedProduct;
            }
            $errors = array_merge($errors, $updateResult['errors']);
        }
        if (!empty($productsToAdd)) {
            $storeResult = $this->productRepositoryInterface->storeMassiveProducts($productsToAdd);

            foreach ($storeResult['products_saved'] as $newP) {
                $history = $this->createProductHistory->execute(
                    null,
                    null,
                    null,
                    null,
                    null,
                    null,
                    "Producto agregado al inventario",
                    $newP->getId()
                );
                $newP->getProductHistories()[] = ProductHistoryMapping::dtoToEntity($history);
                $allProducts[] = $newP;
            }
            $errors = array_merge($errors, $storeResult['errors']);
        }
        return [ProductTransformer::toDTOs($allProducts), $errors];
    }
}
