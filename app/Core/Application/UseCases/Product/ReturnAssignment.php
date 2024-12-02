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
        $dataToHistory = [];
        $people = $this->assignmentPeopleRepositoryInterface->getById($peopleId);
        $dateTimeNow = new DateTime();
        $dataToHistory = [
            "people_name" => $people->getName(),
            "people_phone" => $people->getPhone(),
            "people_email" => $people->getEmail(),
            "observation" => $observation,
            "assign_date" => $people->getAssign_date(),
            "devolution_date" => $dateTimeNow->format('Y-m-d H:i:s'),
        ];
        $result = $this->productRepositoryInterface->returnAssignment($productId, $people->getId());
        $product = $result[0];
        $dataToHistory["productId"] = $product->getId();
        $dataToHistory["assignment_quantity"] = $result[1];

        $history = $this->createProductHistory->execute(
            people_name: $dataToHistory["people_name"],
            people_phone: $dataToHistory["people_phone"],
            people_email: $dataToHistory["people_email"],
            assignment_quantity: $dataToHistory["assignment_quantity"],
            assign_date: $dataToHistory["assign_date"],
            devolution_date: $dataToHistory["devolution_date"],
            observation: $dataToHistory["observation"],
            productId: $dataToHistory["productId"]
        );
        $product->getProductHistories()[] = ProductHistoryMapping::dtoToEntity($history);

        return ProductTransformer::toDTO($product);
    }
}
