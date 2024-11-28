<?php

namespace App\Core\Application\UseCases\Product;

use App\Core\Application\UseCases\ProductHistory\CreateProductHistory;
use App\Core\Application\UseCases\Ubication\FindUbicationById;
use App\Core\Domain\Entities\ProductEntity;
use App\Core\Domain\Repositories\ProductRepositoryInterface;
use App\Core\Infrastructure\Helpers\ProductHistoryMapping;
use App\Core\Infrastructure\Helpers\UbicationMapping;
use App\Core\Infrastructure\Transformers\ProductTransformer;
use Exception;

class CreateProduct
{
    protected ProductRepositoryInterface $productRepositoryInterface;
    protected CreateProductHistory $createProductHistory;
    protected FindUbicationById $findUbicationById;

    public function __construct(
        ProductRepositoryInterface $productRepositoryInterface,
        FindUbicationById $findUbicationById,
        CreateProductHistory $createProductHistory
    ) {
        $this->productRepositoryInterface = $productRepositoryInterface;
        $this->findUbicationById = $findUbicationById;
        $this->createProductHistory = $createProductHistory;
    }

    public function execute(
        string $name,
        int $total_quantity,
        string $quantity_type,
        int $ubicationId,
        string $observation,
        string $active = "A"
    ) {

        $ubication = $this->findUbicationById->execute($ubicationId);

        if (!$ubication) {
            throw new Exception("No se encontro la ubicación", 404);
        }

        $product = new ProductEntity(
            null,
            $name,
            $total_quantity,
            $quantity_type,
            UbicationMapping::dtoToEntity($ubication),
            $observation,
            $active,
            [],
            $total_quantity
        );
        $product = $this->productRepositoryInterface->store($product);
        $history = $this->createProductHistory->execute(
            null,
            null,
            null,
            null,
            null,
            null,
            "Producto agregado al inventario",
            $product->getId()
        );
        $product->getProductHistories()[] = ProductHistoryMapping::dtoToEntity($history);


        return ProductTransformer::toDTO($product);
    }
}
