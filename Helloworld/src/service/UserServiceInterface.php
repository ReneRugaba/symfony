<?php

namespace App\service;

use App\Entity\User;


interface UserServiceInterface
{
    public function registerUser(User $user);
}
