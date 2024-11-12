<?php

namespace App\Core\Domain\Repositories;

use App\Core\Domain\Entities\UserEntity;

interface UserRepositoryInterface
{
    /**
     * Obtiene todos los usuarios.
     * @param array $filters Los filtros a realizar
     * @return UserEntity[]
     */
    public function index(array $filters = []): array;
    /**
     * Obtiene un usuario por su ID.
     *
     * @param int $id
     * @return UserEntity|null
     */
    public function getById(int $id): ?UserEntity;

    /**
     * Obtiene un registros por su los ids.
     *
     * @param array $ids
     * @return array
     */
    public function getByIds(array $ids): array;

    /**
     * Encuentra un usuario por su email.
     *
     * @param string $email
     * @return UserEntity|null
     */
    public function findByEmail(string $email): ?UserEntity;

    /**
     * Almacena un nuevo usuario usando Eloquent y lo mapea a la entidad de dominio.
     *
     * @param UserEntity $user
     * @return UserEntity
     */
    public function store(UserEntity $user): UserEntity;

    /**
     * Actualiza un usuario existente.
     *
     * @param UserEntity $user
     * @param int $id
     * @return UserEntity
     */
    public function update(UserEntity $user, int $id): UserEntity;

    /**
     * Actualizar datos especificos del usuraio, debe usarse con un array asociativo  ["campo_a_cambiar" => "nuevo_valor"]
     * @param int $id
     * @param array $data_to_change
     * @return \App\Core\Domain\Entities\UserEntity
     * 
     * 
     */
    public function updateEspecificColumn(int $id, array $data_to_change): ?UserEntity;

    /**
     * Elimina un usuario por su ID.
     *
     * @param int $id
     * @return bool
     */
    public function delete(int $id): bool;

    /**
     * Cambiar password
     * @param int $id
     * @param string $password
     * @return void
     */
    public function changePassword(int $id, string $password): ?UserEntity;
}
