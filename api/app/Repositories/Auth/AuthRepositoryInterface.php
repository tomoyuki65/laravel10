<?php

namespace App\Repositories\Auth;

interface AuthRepositoryInterface
{
    public function createFirebaseUser(
        string $email,
        string $password
    );
}