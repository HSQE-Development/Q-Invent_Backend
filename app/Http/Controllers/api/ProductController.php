<?php

namespace App\Http\Controllers\API;

use App\Core\Application\UseCases\Product\AssignmentProduct;
use App\Core\Application\UseCases\Product\CreateProduct;
use App\Core\Application\UseCases\Product\DeleteProduct;
use App\Core\Application\UseCases\Product\FindAllProducts;
use App\Core\Application\UseCases\Product\FindProductById;
use App\Core\Application\UseCases\Product\UpdateProduct;
use App\Http\Controllers\API\BaseController;
use App\Models\AssignmentPerson;
use App\Models\AssignPeople;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class ProductController extends BaseController
{
    private FindAllProducts $findAllProducts;
    private FindProductById $findProductById;
    private UpdateProduct $updateProduct;
    private DeleteProduct $deleteProduct;
    private CreateProduct $createProduct;
    private AssignmentProduct $assignmentProduct;

    public function __construct(
        FindAllProducts $findAllProducts,
        FindProductById $findProductById,
        UpdateProduct $updateProduct,
        DeleteProduct $deleteProduct,
        CreateProduct $createProduct,
        AssignmentProduct $assignmentProduct
    ) {
        $this->findAllProducts = $findAllProducts;
        $this->findProductById = $findProductById;
        $this->updateProduct = $updateProduct;
        $this->deleteProduct = $deleteProduct;
        $this->createProduct = $createProduct;
        $this->assignmentProduct = $assignmentProduct;
    }

    public function index(Request $request)
    {
        try {
            $queryParams = [];

            $products = $this->findAllProducts->execute($queryParams);
            return $this->sendResponse(["products" => $products], "Lista de Productos.");
        } catch (\Exception $e) {
            return $this->sendError('Error inesperado', [$e->getMessage()], 500);
        }
    }

    public function show(int $id)
    {
        $product = $this->findProductById->execute($id);
        return $this->sendResponse(["product" => $product], "Informaciòn producto.");
    }

    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'total_quantity' => 'required|int',
                'quantity_type' => 'required|string',
                'ubication' => 'required|string|max:255',
                'observation' => 'string|max:255',
            ]);

            $product = $this->createProduct->execute(
                $validated['name'],
                $validated['total_quantity'],
                $validated['quantity_type'],
                $validated['observation'],
                $validated['observation'],
            );
            return $this->sendResponse(["product" => $product], "Producto creado correctamente.", 201);
        } catch (ValidationException $e) {
            return $this->sendError('Errores de validación', $e->validator->errors()->all(), 422);
        } catch (\Exception $e) {
            return $this->sendError('Error inesperado', [$e->getMessage()], 500);
        }
    }


    public function update(Request $request, int $id)
    {
        try {
            $validated = $request->validate([
                'name' => 'string|max:255',
                'total_quantity' => 'int',
                'quantity_type' => 'string',
                'ubication' => 'string|max:255',
                'observation' => 'string|max:255',
                'active' => 'string|max:2',
            ]);

            $product = $this->updateProduct->execute(
                id: $id,
                name: $validated['name'] ?? null,
                total_quantity: $validated['total_quantity'] ?? null,
                quantity_type: $validated['quantity_type'] ?? null,
                ubication: $validated['ubication'] ?? null,
                observation: $validated['observation'] ?? null,
                active: $validated['active'] ?? null,
            );
            return $this->sendResponse(["product" => $product], "Producto actualizado correctamente.", 200);
        } catch (ValidationException $e) {
            // Capturar errores de validación
            return $this->sendError('Errores de validación', $e->validator->errors()->all(), 422);
        } catch (\Exception $e) {
            // Manejo de otros errores
            return $this->sendError('Error inesperado', [$e->getMessage()], 500);
        }
    }

    public function destroy(Request $request, int $id)
    {
        try {
            $deleted = $this->deleteProduct->execute($id);
            return $this->sendResponse(["deleted" => $deleted], message: "Producto eliminado correctamente.", code: 200);
        } catch (\Exception $e) {
            return $this->sendError('Error inesperado', [$e->getMessage()], 500);
        }
    }
    public function assignmentProduct(Request $request, int $id)
    {
        try {
            $validated = $request->validate([
                'name' => 'string|max:255',
                'email' => 'string',
                'phone' => 'string|max:255',
                'assigned_quantity' => 'integer',
                'people_id' => 'nullable|int'
            ]);

            $product = $this->assignmentProduct->execute(
                $id,
                $validated["name"],
                $validated["email"],
                $validated["phone"],
                $validated["assigned_quantity"],
                $validated["people_id"],
            );

            return $this->sendResponse(["product" => $product], message: "Producto asignado correctamente.", code: 200);
        } catch (\Exception $e) {
            return $this->sendError('Error inesperado', [$e->getMessage()], 500);
        }
    }
}
