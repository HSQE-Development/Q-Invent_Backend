<?php

namespace App\Core\Infrastructure\Repositories;

use App\Core\Domain\Entities\ProductEntity;
use App\Core\Domain\Repositories\ProductRepositoryInterface;
use App\Core\Infrastructure\Helpers\PaginationMapping;
use App\Core\Infrastructure\Helpers\ProductMapping;
use App\Core\Infrastructure\Transformers\ProductTransformer;
use App\Models\Product;

class EloquentProductRepository implements ProductRepositoryInterface
{
    public function index($filters = [])
    {
        $page = isset($filters['page']) ? $filters['page'] : 1; // Página actual
        $perPage = isset($filters['per_page']) ? $filters['per_page'] : 10;

        $query = Product::query();

        $eloquentProducts = $query->paginate($perPage, ["*"], "page", $page);
        $mappedProducts = $eloquentProducts->items(); // Devuelve la colección de productos de la página actual

        $mappedProducts = collect($mappedProducts)->map(function ($product) {
            // Agrupamos los assignments por email
            $groupedAssignments = $product->assignments->groupBy('email');

            $groupedAssignments = $groupedAssignments->map(function ($assignments) {
                $totalAssignedQuantity = $assignments->sum('assigned_quantity');
                return [
                    'assignments' => $assignments,  // Las asignaciones para este email
                    'total_assigned_quantity' => $totalAssignedQuantity, // El total de assigned_quantity
                ];
            });
            // Asignamos las asignaciones agrupadas al producto
            $product->grouped_assignments = $groupedAssignments;

            return $product;
        });

        $mappedProducts = collect($mappedProducts)->map(function ($eloquentProduct) {
            return ProductMapping::mapToEntity($eloquentProduct);
        })->toArray();


        return PaginationMapping::mapToEntity(ProductTransformer::toDTOs($mappedProducts), $eloquentProducts)->toArray();
    }
    public function getById($id): ?ProductEntity
    {
        $eloquentUser =  Product::find($id);

        return $eloquentUser ? ProductMapping::mapToEntity($eloquentUser) : null;
    }
    public function getByIds($ids): array
    {
        $eloquentProduct =  Product::whereIn("id", $ids)->get();
        if ($eloquentProduct->isEmpty()) {
            throw new \Exception("Uno o más productos no encontrados", 404);
        }
        return $eloquentProduct->map(fn($product) => ProductMapping::mapToEntity($product))->toArray();
    }

    public function store(ProductEntity $product): ProductEntity
    {
        $eloquentProduct = new Product();
        $eloquentProduct->name = $product->getName();
        $eloquentProduct->total_quantity = $product->getTotal_quantity();
        $eloquentProduct->ubication = $product->getUbication();
        $eloquentProduct->observation = $product->getObservation();
        $eloquentProduct->active = $product->isActive();
        $eloquentProduct->save();

        $product->setId($eloquentProduct->id);

        return $product;
    }

    public function update(ProductEntity $user, int $id): ProductEntity
    {
        $model = Product::find($id);
        if ($model) {
            $model->fill([
                'name' => $user->getName(),
                'total_quantity' => $user->getTotal_quantity(),
                'ubication' => $user->getUbication(),
                'observation' => $user->getObservation(),
                'active' => $user->isActive(),
            ]);
            $model->save();
        }

        return $user;
    }

    public function updateEspecificColumn(int $id, array $data_to_change): ?ProductEntity
    {
        $model = Product::find($id);
        if ($model) {
            $model->fill($data_to_change);
            $model->save();
            return ProductMapping::mapToEntity($model);
        }
        return null;
    }

    public function delete($id): bool
    {
        return Product::destroy($id);
    }
}
