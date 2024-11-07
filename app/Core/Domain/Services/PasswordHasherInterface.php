<?php

namespace App\Core\Domain\Services;

interface PasswordHasherInterface
{
    public function check(string $password, string $hashedPassword): bool;
    public function hash(string $password): string;
}
