<?php

namespace App\Core\Application\UseCases\Product;

use App\Core\Application\UseCases\ProductHistory\CreateProductHistory;
use App\Core\Domain\Entities\AssignmentPeopleEntity;
use App\Core\Domain\Repositories\AssignmentPeopleRepositoryInterface;
use App\Core\Domain\Repositories\ProductRepositoryInterface;
use App\Core\Domain\Helpers\StringHelper;
use App\Core\Infrastructure\Helpers\ProductHistoryMapping;
use App\Core\Infrastructure\Transformers\ProductTransformer;
use App\DTO\ProductDTO;
use DateTime;

class AssignmentProduct
{
    protected AssignmentPeopleRepositoryInterface $assignmentPeopleRepositoryInterface;
    protected ProductRepositoryInterface $productRepositoryInterface;
    protected CreateProductHistory $createProductHistory;

    public function __construct(
        AssignmentPeopleRepositoryInterface $assignmentPeopleRepositoryInterface,
        ProductRepositoryInterface $productRepositoryInterface,
        CreateProductHistory $createProductHistory
    ) {
        $this->assignmentPeopleRepositoryInterface = $assignmentPeopleRepositoryInterface;
        $this->productRepositoryInterface = $productRepositoryInterface;
        $this->createProductHistory = $createProductHistory;
    }

    public function execute(
        int $product_id,
        ?string $name,
        ?string $email,
        ?string $phone,
        int $assigned_quantity,
        ?int $people_id,
        bool $is_update = false
    ): ProductDTO {

        $existingPeople = $people_id
            ? $this->assignmentPeopleRepositoryInterface->getById($people_id)
            : $this->assignmentPeopleRepositoryInterface->getByEspecificColumn([
                "name" => StringHelper::convertMinusculesWithoutTyldes($name),
                "email" => StringHelper::convertMinusculesWithoutTyldes($email),
            ]);



        if (!$existingPeople) {
            $newPeople = new AssignmentPeopleEntity(
                null,
                $name,
                $email,
                $phone,
                null,
                null,
                null
            );
            $existingPeople = $this->assignmentPeopleRepositoryInterface->store($newPeople);
        }
        $productWithAssignment = $this->productRepositoryInterface->assignProductToPeople(
            $product_id,
            $existingPeople->getId(),
            $assigned_quantity,
            $is_update
        );

        $existingProduct = $this->productRepositoryInterface->getById($product_id);
        $difference = null;
        foreach ($existingProduct->getAssignmentPeople() as $assign) {
            if ($assign->getId() === $existingPeople->getId()) {
                if ($assigned_quantity < $assign->getAssigned_quantity()) {
                    $difference = $assign->getAssigned_quantity() - $assigned_quantity;
                }
            }
        }


        $dateTimeNow = new DateTime();
        $history = $this->createProductHistory->execute(
            $existingPeople->getName(),
            $existingPeople->getPhone(),
            $existingPeople->getEmail(),
            $assigned_quantity,
            $dateTimeNow->format('Y-m-d H:i:s'),
            $difference ? $dateTimeNow->format('Y-m-d H:i:s') : null,
            $difference ? "Se devolvieron {$difference} unidades" : "Se asignaron {$assigned_quantity} unidades",
            $productWithAssignment->getId()
        );
        $productWithAssignment->getProductHistories()[] = ProductHistoryMapping::dtoToEntity($history);

        return ProductTransformer::toDTO($productWithAssignment);
    }
}
