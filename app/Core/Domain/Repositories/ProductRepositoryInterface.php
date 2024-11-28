<?php

namespace App\Core\Domain\Repositories;

use App\Core\Domain\Entities\ProductEntity;
use App\Core\Domain\EnumProductStatus;

interface ProductRepositoryInterface
{
    /**
     * Obtiene todos los usuarios.
     * @param array $filters Los filtros a realizar
     * @return array
     */
    public function index(array $filters = []);
    /**
     * Obtiene un usuario por su ID.
     *
     * @param int $id
     * @return ProductEntity|null
     */
    public function getById(int $id): ?ProductEntity;

    /**
     * Obtiene un registros por su los ids.
     *
     * @param array $ids
     * @return array
     */
    public function getByIds(array $ids): array;

    /**
     * Almacena un nuevo usuario usando Eloquent y lo mapea a la entidad de dominio.
     *
     * @param ProductEntity $user
     * @return ProductEntity
     */
    public function store(ProductEntity $user): ProductEntity;

    /**
     * Actualiza un usuario existente.
     *
     * @param ProductEntity $user
     * @param int $id
     * @return ProductEntity
     */
    public function update(ProductEntity $user, int $id): ProductEntity;

    /**
     * Actualizar datos especificos del usuraio, debe usarse con un array asociativo  ["campo_a_cambiar" => "nuevo_valor"]
     * @param int $id
     * @param array $data_to_change
     * @return \App\Core\Domain\Entities\ProductEntity
     * 
     * 
     */
    public function updateEspecificColumn(int $id, array $data_to_change): ?ProductEntity;

    /**
     * Elimina un usuario por su ID.
     *
     * @param int $id
     * @return bool
     */
    public function delete(int $id): bool;

    /**
     * Asigna cierta cantidad del producto a una persona;
     * IMPORTANTE - Esta funcion asume que ya se valido que este disponible la cantidad a ser asignado
     * @param int $productId
     * @param int $peopleId
     * @param int $assignedQuantity
     * @param bool $isUpdateable
     * @return \App\Core\Domain\Entities\ProductEntity
     */
    public function assignProductToPeople(int $productId, int $peopleId, int $assignedQuantity, string $observation, bool $isUpdateable = false): ProductEntity;

    /**
     * Verificar si la cantidad a asignar de un producto esta disponible en el inventario o no
     * @param int $productId
     * @param int $totalForAssignment
     * @return void
     */
    public function verifyDisponibilityInInventory(int $productId, int $totalForAssignment): bool;

    public function updateAvailableQuantity(int $productId, int $totalForAssignment);
    public function updateAvailableQuantityByTotalQuantity(int $productId): ProductEntity;

    public function countTotalOfProducts(): int;
    public function countTotalActiveOfProducts(): int;
    public function countTotalInactiveOfProducts(): int;
    public function returnAssignment(int $productId, int $peopleId): ProductEntity;

    public function storeMassiveProducts(array $products): array;
    public function updateMassiveProducts(array $products): array;
    public function getByName(string $name): ?ProductEntity;
}
