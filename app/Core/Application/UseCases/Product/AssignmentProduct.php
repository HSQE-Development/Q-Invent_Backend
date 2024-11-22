<?php

namespace App\Core\Application\UseCases\Product;

use App\Core\Domain\Entities\AssignmentPeopleEntity;
use App\Core\Domain\Repositories\AssignmentPeopleRepositoryInterface;
use App\Core\Domain\Repositories\ProductRepositoryInterface;
use App\Core\Domain\Helpers\StringHelper;
use App\Core\Infrastructure\Transformers\ProductTransformer;

class AssignmentProduct
{
    protected AssignmentPeopleRepositoryInterface $assignmentPeopleRepositoryInterface;
    protected ProductRepositoryInterface $productRepositoryInterface;
    public function __construct(
        AssignmentPeopleRepositoryInterface $assignmentPeopleRepositoryInterface,
        ProductRepositoryInterface $productRepositoryInterface
    ) {
        $this->assignmentPeopleRepositoryInterface = $assignmentPeopleRepositoryInterface;
        $this->productRepositoryInterface = $productRepositoryInterface;
    }

    public function execute(
        int $product_id,
        ?string $name,
        ?string $email,
        ?string $phone,
        string $assigned_quantity,
        ?int $people_id,
        bool $is_update = false
    ) {

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
                null
            );
            $existingPeople = $this->assignmentPeopleRepositoryInterface->store($newPeople);
        }
        $productWithAssignment = $this->productRepositoryInterface->assignProductToPeople($product_id, $existingPeople->getId(), $assigned_quantity,  $is_update);

        return ProductTransformer::toDTO($productWithAssignment);
    }
}
