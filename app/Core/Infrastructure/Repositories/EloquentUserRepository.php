<?php

namespace App\Core\Infrastructure\Repositories;

use App\Core\Domain\Repositories\UserRepositoryInterface;
use App\Models\User;
use \App\Core\Domain\Entities\UserEntity;
use App\Core\Infrastructure\Helpers\UserMapping;
use App\Core\Infrastructure\Services\PasswordHasher;

class EloquentUserRepository implements UserRepositoryInterface
{
    private PasswordHasher $passwordHasher;
    /**
     * Create a new class instance.
     */
    public function __construct(PasswordHasher $passwordHasher)
    {
        $this->passwordHasher = $passwordHasher;
    }

    public function index($filters = []): array
    {
        $query = User::query();
        $eloquentUsers = $query->get();
        return $eloquentUsers->map(function ($eloquentUser) {
            return UserMapping::mapToEntity($eloquentUser);
        })->toArray();
    }
    public function getById($id): ?UserEntity
    {

        $eloquentUser =  User::with("roles", "permissions")->find($id);

        return $eloquentUser ? UserMapping::mapToEntity($eloquentUser) : null;
    }
    public function getByIds($ids): array
    {
        $eloquentUser =  User::whereIn("id", $ids)->get();
        if ($eloquentUser->isEmpty()) {
            throw new \Exception("Uno o más usuarios no encontrados", 404);
        }
        return $eloquentUser->map(fn($user) => UserMapping::mapToEntity($user))->toArray();
    }
    public function findByEmail(string $email): ?UserEntity
    {
        $eloquentUser =  User::where("email", $email)->where("activo", true)->first();
        return $eloquentUser ? UserMapping::mapToEntity($eloquentUser) : null;
    }

    public function store(UserEntity $user): UserEntity
    {
        $eloquentUser = new User();
        $eloquentUser->first_name = $user->getFirstName();
        $eloquentUser->last_name = $user->getLastName();
        $eloquentUser->email = $user->getEmail();
        $eloquentUser->password = $user->getPassword();
        $eloquentUser->activo = $user->getActivo();

        $eloquentUser->save();

        $user->setId($eloquentUser->id);

        return $user;
    }

    public function update(UserEntity $user, int $id): UserEntity
    {
        $model = User::find($id);
        if ($model) {
            $model->fill([
                'first_name' => $user->getFirstName(),
                'last_name' => $user->getLastName(),
                'email' => $user->getEmail(),
                'password' => $user->getPassword(),
                'activo' => $user->getActivo(),
            ]);
            $model->save();
        }

        return $user;
    }

    public function updateEspecificColumn(int $id, array $data_to_change): ?UserEntity
    {
        $model = User::find($id);
        if ($model) {
            $model->fill($data_to_change);
            $model->save();
            return UserMapping::mapToEntity($model);
        }
        return null;
    }

    public function delete($id): bool
    {
        return User::destroy($id);
    }

    public function changePassword($id, $password): ?UserEntity
    {
        $user = null;
        $user = $this->getById($id);
        if ($user) {
            $hashed_password = $this->passwordHasher->hash($password);
            $user = $this->updateEspecificColumn($user->getId(), ["password" => $hashed_password]);
        }
        return $user;
    }

    public function hasPermission(int $id, string $permissionIdentify): bool
    {
        $user = User::find($id);
        // Verifica el rol directamente
        if ($user->permissions()->where('identify', $permissionIdentify)->exist()) return true;
        // Verifica si el usuario tiene el permiso a través de sus roles
        return $user->roles()->whereHas('permissions', function ($query) use ($permissionIdentify) {
            $query->where('identify', $permissionIdentify);
        })->exist();
    }
}
