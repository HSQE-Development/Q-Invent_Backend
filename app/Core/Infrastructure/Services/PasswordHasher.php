<?php

namespace App\Core\Infrastructure\Services;

use App\Core\Domain\Services\PasswordHasherInterface;
use Illuminate\Support\Facades\Hash;

class PasswordHasher implements PasswordHasherInterface
{
    /**
     * Create a new class instance.
     */
    public function check(string $password, string $hashedPassword): bool
    {
        return Hash::check($password, $hashedPassword);
    }

    public function hash(string $password): string
    {
        return Hash::make($password);
    }
}
