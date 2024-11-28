<?php

namespace App\Core\Application\UseCases\Product;

use App\Core\Application\UseCases\ProductHistory\CreateProductHistory;
use App\Core\Domain\Repositories\AssignmentPeopleRepositoryInterface;
use App\Core\Domain\Repositories\ProductRepositoryInterface;
use App\Core\Infrastructure\Helpers\ProductHistoryMapping;
use App\Core\Infrastructure\Transformers\ProductTransformer;
use DateTime;

class ReturnAssignment
{
    protected ProductRepositoryInterface $productRepositoryInterface;
    protected CreateProductHistory $createProductHistory;
    protected AssignmentPeopleRepositoryInterface $assignmentPeopleRepositoryInterface;
    public function __construct(
        ProductRepositoryInterface $productRepositoryInterface,
        CreateProductHistory $createProductHistory,
        AssignmentPeopleRepositoryInterface $assignmentPeopleRepositoryInterface
    ) {
        $this->productRepositoryInterface = $productRepositoryInterface;
        $this->createProductHistory = $createProductHistory;
        $this->assignmentPeopleRepositoryInterface = $assignmentPeopleRepositoryInterface;
    }

    public function execute(int $productId, int $peopleId, string $observation)
    {
        $people = $this->assignmentPeopleRepositoryInterface->getById($peopleId);
        $product = $this->productRepositoryInterface->returnAssignment($productId, $people->getId());

        $dateTimeNow = new DateTime();
        $history = $this->createProductHistory->execute(
            $people->getName(),
            $people->getPhone(),
            $people->getEmail(),
            null,
            $dateTimeNow->format('Y-m-d H:i:s'),
            null,
            $observation,
            $product->getId()
        );
        $product->getProductHistories()[] = ProductHistoryMapping::dtoToEntity($history);

        return ProductTransformer::toDTO($product);
    }
}
