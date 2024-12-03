<?php

namespace App\Core\Infrastructure\Repositories;

use App\Core\Domain\Entities\ProductEntity;
use App\Core\Domain\EnumProductStatus;
use App\Core\Domain\Repositories\ProductRepositoryInterface;
use App\Core\Infrastructure\Helpers\PaginationMapping;
use App\Core\Infrastructure\Helpers\ProductMapping;
use App\Core\Infrastructure\Transformers\ProductTransformer;
use App\Models\Product;
use DateTime;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\DB;

class EloquentProductRepository implements ProductRepositoryInterface
{
    public function all(): array
    {
        $products = Product::all();
        $mappedProduct = collect($products)->map(function ($product) {
            return ProductMapping::mapToEntity($product);
        })->toArray();
        return $mappedProduct;
    }
    public function index($filters = [])
    {
        $page = $filters['page'] ?? 1; // Página actual
        $perPage =  $filters['per_page'] ?? 50;

        $productName = $filters['productName'] ?? null;
        $productStatus = $filters["productStatus"] ?? null;

        $query = Product::query();

        //FITLROS
        if ($productName) {
            $query->where('name', 'LIKE', "%$productName%");
        }

        if ($productStatus) {
            $status = EnumProductStatus::tryFrom($productStatus);
            $query->where('active', $status);
        }
        //FIN_FILTROS

        $eloquentProducts = $query->with("assignmentPeople")->paginate($perPage, ["*"], "page", $page);
        $mappedProducts = $eloquentProducts->items(); // Devuelve la colección de productos de la página actual

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
        $eloquentProduct->id = $product->getId();
        $eloquentProduct->name = $product->getName();
        $eloquentProduct->total_quantity = $product->getTotal_quantity();
        $eloquentProduct->quantity_type = $product->getQuantityType();
        $eloquentProduct->quantity_available = $product->getQuantity_available();
        $eloquentProduct->ubication_id = $product->getUbication()->getId();
        $eloquentProduct->observation = $product->getObservation();
        $eloquentProduct->active = $product->isActive();
        $eloquentProduct->save();

        $product->setId($eloquentProduct->id);
        return $product;
    }

    public function update(ProductEntity $product, int $id): ProductEntity
    {
        $model = Product::find($id);
        if ($model) {
            $oldTotalQuantity = $model->total_quantity;

            $model->fill([
                'name' => $product->getName(),
                'total_quantity' => $product->getTotal_quantity(),
                'ubication_id' => $product->getUbication()->getId(),
                'observation' => $product->getObservation(),
                'active' => $product->isActive(),
            ]);
            if ($oldTotalQuantity !== $product->getTotal_quantity()) {
                $assignedQuantity = $model->assignmentPeople()->sum('assigned_quantity');
                $quantityAvailable = max(0, $product->getTotal_quantity() - $assignedQuantity);
                $model->quantity_available = $quantityAvailable;
            }
            $model->save();
        }
        return $product;
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

    public function verifyDisponibilityInInventory(int $productId, int $totalForAssignment): bool
    {
        $eloquentProduct = Product::find($productId, ['total_quantity', 'quantity_available']);
        if (!$eloquentProduct) {
            throw new \Exception("Producto no encontrado", 404);
        }
        if ($totalForAssignment > $eloquentProduct->total_quantity && $eloquentProduct->quantity_available < $totalForAssignment) {
            return false;
        }
        return true;
    }

    public function updateAvailableQuantity(int $productId, int $totalForAssignment)
    {
        DB::transaction(function () use ($productId, $totalForAssignment) {
            $eloquentProduct = Product::where('id', $productId)
                ->lockForUpdate()
                ->first();

            if (!$eloquentProduct) {
                throw new ModelNotFoundException("Producto no encontrado", 404);
            }
            $newQuantity = $eloquentProduct->quantity_available - $totalForAssignment;
            if ($newQuantity < 0) {
                throw new \Exception("La cantidad disponible no puede ser negativa");
            }
            $eloquentProduct->quantity_available =  $newQuantity;
            $eloquentProduct->save();
        });
    }
    public function updateAvailableQuantityByTotalQuantity(int $productId): ProductEntity
    {
        $eloquentProduct = Product::with("assignmentPeople")->where('id', $productId)
            ->lockForUpdate()
            ->first();
        DB::transaction(function () use ($eloquentProduct) {

            if (!$eloquentProduct) {
                throw new ModelNotFoundException("Producto no encontrado", 404);
            }
            $totalForAssignment = $eloquentProduct->assignmentPeople()->sum("assigned_quantity");
            $newQuantity = $eloquentProduct->total_quantity - $totalForAssignment;
            if ($newQuantity < 0) {
                throw new \Exception("La cantidad disponible no puede ser negativa");
            }
            $eloquentProduct->quantity_available =  $newQuantity;
            $eloquentProduct->save();
        });
        return ProductMapping::mapToEntity($eloquentProduct);
    }

    public function assignProductToPeople($productId, $peopleId, $assignedQuantity, $isUpdateable = false): ProductEntity
    {
        $eloquentProduct = Product::with("assignmentPeople")->find($productId);
        if (!$eloquentProduct) {
            throw new \Exception("Producto no encontrado", 404);
        }
        DB::transaction(function () use ($eloquentProduct, $peopleId, $assignedQuantity, $isUpdateable) {
            $existingAssignment = $eloquentProduct->assignmentPeople()->where('assignment_people.id', $peopleId)->first();
            $previousQuantity = $existingAssignment ? $existingAssignment->pivot->assigned_quantity : 0;
            $newAssignedQuantity = $isUpdateable ? $assignedQuantity : ($previousQuantity + $assignedQuantity);
            $dateTimeNow = new DateTime();
            $eloquentProduct->assignmentPeople()->syncWithoutDetaching([
                $peopleId => [
                    'assigned_quantity' => $newAssignedQuantity,
                    "assign_date" => $dateTimeNow->format('Y-m-d H:i:s')
                ]
            ]);
        });
        $eloquentProduct->load('assignmentPeople');
        return ProductMapping::mapToEntity($eloquentProduct);
    }

    public function countTotalOfProducts(): int
    {
        return Product::count("id");
    }

    public function countTotalActiveOfProducts(): int
    {
        return Product::where("active", "A")->count("id");
    }
    public function countTotalInactiveOfProducts(): int
    {
        return Product::where("active", "I")->count("id");
    }

    public function returnAssignment(int $productId, int $peopleId): array
    {
        $product = Product::findOrFail($productId);
        $existingAssignment = $product->assignmentPeople()->where('assignment_people.id', $peopleId)->first();
        $assignQuantity = $existingAssignment->pivot->assigned_quantity;
        $product->quantity_available +=  $existingAssignment->pivot->assigned_quantity;
        $product->assignmentPeople()->detach($peopleId);
        $product->save();
        return [ProductMapping::mapToEntity($product), $assignQuantity];
    }

    public function storeMassiveProducts(array $products): array
    {
        try {
            $productsSaved = [];
            $errors = [];
            DB::transaction(function () use ($products, &$productsSaved, &$errors) {
                foreach ($products as $index => $product) {
                    try {
                        $productsSaved[] = $this->store($product);
                    } catch (\Throwable $e) {
                        $errors[] = [
                            'index' => $index,
                            'error' => $e->getMessage(),
                        ];
                        throw $e;
                    }
                }
            });
        } catch (\Throwable $th) {
            //throw $th;
        }

        return [
            'products_saved' => $productsSaved,
            'errors' => $errors,
        ];
    }
    public function updateMassiveProducts(array $products): array
    {
        try {
            $productsSaved = [];
            $errors = [];
            DB::transaction(function () use ($products, &$productsSaved, &$errors) {
                foreach ($products as $index => $product) {
                    try {
                        $productsSaved[] = $this->update($product, $product->getId());
                    } catch (\Throwable $e) {
                        $errors[] = [
                            'index' => $index,
                            'error' => $e->getMessage(),
                        ];
                        throw $e;
                    }
                }
            });
        } catch (\Throwable $th) {
            //throw $th;
        }

        return [
            'products_saved' => $productsSaved,
            'errors' => $errors,
        ];
    }

    public function getByName(string $name): ?ProductEntity
    {
        $eloquentProduct = Product::whereRaw("LOWER(name) = ?", [strtolower($name)])->first();
        return $eloquentProduct ? ProductMapping::mapToEntity($eloquentProduct) : null;
    }
}
