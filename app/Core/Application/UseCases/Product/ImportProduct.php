<?php

namespace App\Core\Application\UseCases\Product;

use App\Core\Application\UseCases\Ubication\FindUbicationByName;
use App\Core\Domain\Entities\ProductEntity;
use App\Core\Domain\Repositories\ProductRepositoryInterface;
use App\Core\Domain\Services\ExcelReaderServiceInterface;
use App\Core\Infrastructure\Helpers\UbicationMapping;
use App\Core\Infrastructure\Transformers\ProductTransformer;

class ImportProduct
{
    private ExcelReaderServiceInterface $excelReaderServiceInterface;
    private FindUbicationByName $findUbicationByName;
    private ProductRepositoryInterface $productRepositoryInterface;
    public function __construct(
        ExcelReaderServiceInterface $excelReaderServiceInterface,
        FindUbicationByName $findUbicationByName,
        ProductRepositoryInterface $productRepositoryInterface
    ) {
        $this->excelReaderServiceInterface = $excelReaderServiceInterface;
        $this->findUbicationByName = $findUbicationByName;
        $this->productRepositoryInterface = $productRepositoryInterface;
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
                    $existingProduct = $this->productRepositoryInterface->getByName($product["name"]);

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
            $allProducts = array_merge($allProducts, $updateResult['products_saved']);
            $errors = array_merge($errors, $updateResult['errors']);
        }
        if (!empty($productsToAdd)) {
            $storeResult = $this->productRepositoryInterface->storeMassiveProducts($productsToAdd);
            $allProducts = array_merge($allProducts, $storeResult['products_saved']);
            $errors = array_merge($errors, $storeResult['errors']);
        }
        return [ProductTransformer::toDTOs($allProducts), $errors];
    }
}
