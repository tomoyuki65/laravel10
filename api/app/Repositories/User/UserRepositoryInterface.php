<?php

namespace App\Repositories\User;

use App\Models\User;

interface UserRepositoryInterface
{
    public function createUser(string $uid, string $name, string $email);
    public function saveUser(User $user);
    public function getAllUserWithTrashed();
    public function getUserFromUid(string $uid);
    public function deleteUser(User $user);
}