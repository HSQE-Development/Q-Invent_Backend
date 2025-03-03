<?php

namespace App\Core\Domain\Repositories;

use App\Core\Domain\Entities\AssignmentPeopleEntity;

interface AssignmentPeopleRepositoryInterface
{
    /**
     * Obtiene todos los elementos.
     * @param array $filters Los filtros a realizar
     * @return array
     */
    public function index(array $filters = []);

    /**
     * Obtiene todos los elementos con paginación
     * @param array $filters
     * @return array
     */
    public function allPaginate(array $filters = []): array;

    /**
     * Obtiene un elemento por su ID.
     *
     * @param int $id
     * @return AssignmentPeopleEntity|null
     */
    public function getById(int $id): ?AssignmentPeopleEntity;

    /**
     * Obtiene un elemento por una o unas columnas, debe usarse con un array asociativo  ["campo_a_buscar" => "valor_a_buscar"].
     *
     * @param array $search
     * @return AssignmentPeopleEntity|null
     */
    public function getByEspecificColumn(array $search): ?AssignmentPeopleEntity;

    /**
     * Obtiene un registros por su los ids.
     *
     * @param array $ids
     * @return array
     */
    public function getByIds(array $ids): array;

    /**
     * Almacena un nuevo elemento usando Eloquent y lo mapea a la entidad de dominio.
     *
     * @param AssignmentPeopleEntity $people
     * @return AssignmentPeopleEntity
     */
    public function store(AssignmentPeopleEntity $people): AssignmentPeopleEntity;

    /**
     * Actualiza un elemento existente.
     *
     * @param AssignmentPeopleEntity $people
     * @param int $id
     * @return AssignmentPeopleEntity
     */
    public function update(AssignmentPeopleEntity $people, int $id): AssignmentPeopleEntity;

    /**
     * Actualizar datos especificos del elemento, debe usarse con un array asociativo  ["campo_a_cambiar" => "nuevo_valor"]
     * @param int $id
     * @param array $data_to_change
     * @return AssignmentPeopleEntity
     */
    public function updateEspecificColumn(int $id, array $data_to_change): ?AssignmentPeopleEntity;

    /**
     * Elimina un elemento por su ID.
     *
     * @param int $id
     * @return bool
     */
    public function delete(int $id): bool;
}
