<?php

namespace App\Repositories\Auth;

use Kreait\Firebase\Contract\Auth as FirebaseAuth;

class AuthRepository implements AuthRepositoryInterface
{
    public function __construct(FirebaseAuth $firebaseAuth)
    {
        $this->firebaseAuth = $firebaseAuth;
    }

    public function createFirebaseUser(
        string $email,
        string $password
    )
    {
        $userProperties = [
            'email' => $email,
            'password' => $password,
        ];
        $createdUser = $this->firebaseAuth->createUser($userProperties);

        return $createdUser;
    }

    public function deleteFirebaseUser(string $uid)
    {
        $this->firebaseAuth->deleteUser($uid);
    }
}