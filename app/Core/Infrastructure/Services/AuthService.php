<?php

namespace App\Core\Infrastructure\Services;

use App\Core\Domain\Entities\AuthEntity;
use App\Core\Domain\Entities\ComunEntity;
use App\Core\Domain\Entities\UserEntity;
use App\Core\Domain\Repositories\UserRepositoryInterface;
use App\Core\Domain\Services\AuthServiceInterface;
use App\Core\Domain\Services\PasswordHasherInterface;
use App\Core\Infrastructure\Helpers\UserMapping;
use App\Core\Infrastructure\Transformers\UserTransformer;
use App\Models\User;
use Exception;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthService implements AuthServiceInterface
{
    private UserRepositoryInterface $userRepository;
    private PasswordHasherInterface $passwordHasher;

    public function __construct(UserRepositoryInterface $userRepository,  PasswordHasherInterface $passwordHasher)
    {
        $this->userRepository = $userRepository;
        $this->passwordHasher = $passwordHasher;
    }

    public function login(array $credentials): AuthEntity
    {
        $user = $this->userRepository->findByEmail($credentials["email"]);

        if (!$user || !$this->passwordHasher->check($credentials["password"], $user->getPassword())) {
            throw new Exception('Credenciales Invalidas', 401);
        }

        if (!$user->getActivo()) {
            throw new Exception('Credenciales Invalidas o usuario inactivo.', 401);
        }
        if (!$token = JWTAuth::attempt($credentials)) {
            throw new Exception('Usuario no encontrado', 400);
        }
        return $this->respondWithToken($token);
    }

    public function me(): ?UserEntity
    {
        $authUser = auth("api")->user();
        if ($authUser  instanceof User) {
            return UserMapping::mapToEntity($authUser);
        }
        return null;
    }

    public function logout(): ComunEntity
    {
        auth("api")->logout();
        JWTAuth::invalidate(JWTAuth::parseToken());
        return $this->respondWithMessage("Successfully logged out");
    }


    protected function respondWithMessage(string $message): ComunEntity
    {
        return new ComunEntity($message);
    }
    protected function respondWithToken($token): AuthEntity
    {
        $authenticatedUser = auth("api")->user();
        $userDTO = UserTransformer::toDTO(new UserEntity(
            $authenticatedUser->id,
            $authenticatedUser->first_name,
            $authenticatedUser->last_name,
            $authenticatedUser->email,
            $authenticatedUser->activo,
            $authenticatedUser->password,
            $authenticatedUser->email_verified_at,
            $authenticatedUser->is_superuser,
        ));
        // Crear instancia de AuthEntity
        $tokenData = [
            'access_token' => trim($token),
            'token_type' => 'bearer',
            'expires_in' => JWTAuth::factory()->getTTL() * 60,
            'user' => $userDTO
        ];

        return AuthEntity::fromArray($tokenData);
    }
}
