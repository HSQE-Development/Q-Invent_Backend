<?php

namespace App\Http\Controllers\API;

use App\Core\Application\UseCases\Product\AssignmentProduct;
use App\Core\Application\UseCases\Product\CountOfProductsByState;
use App\Core\Application\UseCases\Product\CreateProduct;
use App\Core\Application\UseCases\Product\DeleteProduct;
use App\Core\Application\UseCases\Product\FindAllProducts;
use App\Core\Application\UseCases\Product\FindProductById;
use App\Core\Application\UseCases\Product\ImportProduct;
use App\Core\Application\UseCases\Product\MultiAssignmentProduct;
use App\Core\Application\UseCases\Product\ReturnAssignment;
use App\Core\Application\UseCases\Product\UpdateAvailableQuantity;
use App\Core\Application\UseCases\Product\UpdateProduct;
use App\Core\Application\UseCases\Product\VerifyDisponibility;
use App\Http\Controllers\API\BaseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class ProductController extends BaseController
{
    private FindAllProducts $findAllProducts;
    private FindProductById $findProductById;
    private UpdateProduct $updateProduct;
    private DeleteProduct $deleteProduct;
    private CreateProduct $createProduct;
    private AssignmentProduct $assignmentProduct;
    private MultiAssignmentProduct $multiAssignmentProduct;
    private VerifyDisponibility $verifyDisponibility;
    private UpdateAvailableQuantity $updateAvailableQuantity;
    private CountOfProductsByState $countOfProductsByState;
    private ReturnAssignment $returnAssignment;
    private ImportProduct $importProduct;

    public function __construct(
        FindAllProducts $findAllProducts,
        FindProductById $findProductById,
        UpdateProduct $updateProduct,
        DeleteProduct $deleteProduct,
        CreateProduct $createProduct,
        AssignmentProduct $assignmentProduct,
        MultiAssignmentProduct $multiAssignmentProduct,
        VerifyDisponibility $verifyDisponibility,
        UpdateAvailableQuantity $updateAvailableQuantity,
        CountOfProductsByState $countOfProductsByState,
        ReturnAssignment $returnAssignment,
        ImportProduct $importProduct
    ) {
        $this->findAllProducts = $findAllProducts;
        $this->findProductById = $findProductById;
        $this->updateProduct = $updateProduct;
        $this->deleteProduct = $deleteProduct;
        $this->createProduct = $createProduct;
        $this->assignmentProduct = $assignmentProduct;
        $this->multiAssignmentProduct = $multiAssignmentProduct;
        $this->verifyDisponibility = $verifyDisponibility;
        $this->updateAvailableQuantity = $updateAvailableQuantity;
        $this->countOfProductsByState = $countOfProductsByState;
        $this->returnAssignment = $returnAssignment;
        $this->importProduct = $importProduct;
    }

    public function index(Request $request)
    {
        try {
            $queryParams = $request->all();

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
                'ubication' => 'required|int',
                'observation' => 'string|max:255',
            ]);

            $product = $this->createProduct->execute(
                $validated['name'],
                $validated['total_quantity'],
                $validated['quantity_type'],
                $validated['ubication'],
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
                'ubication' => 'int',
                'observation' => 'string|max:255',
                'active' => 'string|max:2',
            ]);

            $product = $this->updateProduct->execute(
                id: $id,
                name: $validated['name'] ?? null,
                total_quantity: $validated['total_quantity'] ?? null,
                quantity_type: $validated['quantity_type'] ?? null,
                ubicationId: $validated['ubication'] ?? null,
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
                'data_assignment' => 'required|array',
                'data_assignment.name' => 'nullable|string|max:255',
                'data_assignment.email' => 'nullable|email',
                'data_assignment.phone' => 'nullable|string|max:255',
                'data_assignment.assigned_quantity' => 'required|integer|min:1',
                'data_assignment.people_id' => 'nullable|integer|exists:assignment_people,id',
                'is_update' => 'nullable|boolean'
            ]);

            $isForUpdate = (bool) $validated["is_update"];

            $totalForAssign = $validated["data_assignment"]["assigned_quantity"];
            if (!$this->verifyDisponibility->execute($id, $totalForAssign)) {
                return $this->sendError('Cantidad Insuficiente', "Esta cantidad no esta disponible en el inventario", 400);
            }
            $product = $this->assignmentProduct->execute(
                $id,
                $validated["data_assignment"]["name"],
                $validated["data_assignment"]["email"],
                $validated["data_assignment"]["phone"],
                $validated["data_assignment"]["assigned_quantity"],
                $validated["data_assignment"]["people_id"],
                $isForUpdate
            );
            $product = $this->updateAvailableQuantity->execute($id);

            return $this->sendResponse(["product" => $product], message: "Producto asignado correctamente.", code: 200);
        } catch (\Exception $e) {
            return $this->sendError('Error inesperado', [$e->getMessage()], 500);
        }
    }
    public function bulkAssignmentProduct(Request $request, int $id)
    {
        try {
            $validate = $request->validate([
                'data_assignment' => 'required|array',
                'data_assignment.*.assigned_quantity' => 'required|numeric|min:1',
                'data_assignment.*.people_id' => 'required|integer',
                "is_update" => 'boolean'
            ]);
            $data = $validate["data_assignment"];
            $isForUpdate = $validate["is_update"] ? true : false;
            if (empty($data)) {
                return $this->sendError('No se proporcionaron datos para la asignación.', [], 400);
            }

            $totalAssignedQuantity = array_sum(array_column($validate["data_assignment"], 'assigned_quantity'));

            if (!$this->verifyDisponibility->execute($id, $totalAssignedQuantity)) {
                return $this->sendError('Cantidad Insuficiente', "Esta cantidad no esta disponible en el inventario", 400);
            }
            $this->multiAssignmentProduct->execute($id, $data, $isForUpdate);
            $assignedProduct = $this->updateAvailableQuantity->execute($id);

            return $this->sendResponse(
                ['product' => $assignedProduct],
                'Productos asignados exitosamente.'
            );
        } catch (\InvalidArgumentException $e) {
            return $this->sendError('Datos inválidos.', [$e->getMessage()], 422);
        } catch (\Exception $e) {
            return $this->sendError('Error inesperado', [$e->getMessage()], 500);
        }
    }

    public function countProductsByState(Request $request)
    {
        try {
            $active = $this->countOfProductsByState->execute("A"); //Activos
            $inactive = $this->countOfProductsByState->execute("I"); //Inactivo
            $total = $this->countOfProductsByState->execute(null); //Todos

            return $this->sendResponse(
                ['counts' => [
                    "active" => $active,
                    "inactive" => $inactive,
                    "total" => $total,
                ]],
                'Cantidad de productos.'
            );
        } catch (\Exception $e) {
            return $this->sendError('Error inesperado', [$e->getMessage()], 500);
        }
    }

    public function unassignPeople(Request $request, int $product, int $people)
    {
        try {
            $product = $this->returnAssignment->execute($product, $people);
            return $this->sendResponse(
                ['product' => $product],
                'Devolucion Completa.'
            );
        } catch (\Exception $e) {
            return $this->sendError('Error inesperado', [$e->getMessage()], 500);
        }
    }

    public function importData(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'file_base64' => 'required|string',
        ]);
        if ($validator->fails()) {
            return $this->sendError("Error al cargar el archivo", $validator->errors(), 422);
        }

        $fileBase64 = $request->input('file_base64');
        $fileContent = base64_decode($fileBase64);
        $tempFilePath = storage_path('app/temp.xlsx');
        file_put_contents($tempFilePath, $fileContent);

        try {
            $result = $this->importProduct->execute($tempFilePath);
            $products = $result[0] ?? [];
            $errors = $result[1] ?? [];
            if (!empty($errors)) {
                return $this->sendError("Errores al importar productos", $errors, 400);
            }
            return $this->sendResponse(["products" => $products], "Cargue exitoso.");
        } catch (\Exception $e) {
            return $this->sendError("Error al importar productos", $e->getMessage(), 500);
        } finally {
            unlink($tempFilePath); // Eliminar el archivo temporal
        }
    }
}
