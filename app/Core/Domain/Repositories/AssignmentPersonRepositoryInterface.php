<?php

namespace App\Core\Domain\Repositories;

use App\Core\Domain\Entities\AssignmenPeopleEntity;

interface AssignmentPersonRepositoryInterface
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
     * @return AssignmenPeopleEntity|null
     */
    public function getById(int $id): ?AssignmenPeopleEntity;

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
     * @param AssignmenPeopleEntity $user
     * @return AssignmenPeopleEntity
     */
    public function store(AssignmenPeopleEntity $user): AssignmenPeopleEntity;

    /**
     * Actualiza un usuario existente.
     *
     * @param AssignmenPeopleEntity $user
     * @param int $id
     * @return AssignmenPeopleEntity
     */
    public function update(AssignmenPeopleEntity $user, int $id): AssignmenPeopleEntity;

    /**
     * Actualizar datos especificos del usuraio, debe usarse con un array asociativo  ["campo_a_cambiar" => "nuevo_valor"]
     * @param int $id
     * @param array $data_to_change
     * @return \App\Core\Domain\Entities\AssignmenPeopleEntity
     * 
     * 
     */
    public function updateEspecificColumn(int $id, array $data_to_change): ?AssignmenPeopleEntity;

    /**
     * Elimina un usuario por su ID.
     *
     * @param int $id
     * @return bool
     */
    public function delete(int $id): bool;
}
