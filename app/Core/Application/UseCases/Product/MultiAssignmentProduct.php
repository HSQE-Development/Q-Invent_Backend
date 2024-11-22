<?php

namespace App\Core\Application\UseCases\Product;

use App\Core\Infrastructure\Helpers\ProductMapping;
use App\Core\Infrastructure\Transformers\ProductTransformer;

class MultiAssignmentProduct
{
    protected AssignmentProduct $assignmentProduct;

    public function __construct(
        AssignmentProduct $assignmentProduct,
    ) {
        $this->assignmentProduct = $assignmentProduct;
    }

    public function execute(int $id, array $bulkData, bool $is_update = false)
    {
        $products = [];
        foreach ($bulkData as $assignment) {
            if (!isset($assignment['assigned_quantity'], $assignment['people_id'])) {
                throw new \InvalidArgumentException('Datos incompletos en una asignación.');
            }
            try {
                $assigned_quantity = $assignment['assigned_quantity'];
                $people_id = $assignment['people_id'];
                $product = $this->assignmentProduct->execute(
                    $id,
                    null,
                    null,
                    null,
                    $assigned_quantity,
                    $people_id,
                    $is_update
                );

                $products[] = $product;
            } catch (\Exception $e) {
                throw $e;
            }
        }
        return $products;
    }
}
