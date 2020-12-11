<?php

namespace App\service;

use App\Entity\User;
use App\service\exception\UserServiceException;
use Doctrine\DBAL\Driver\Exception;
use App\service\UserServiceInterface;
use Doctrine\ORM\EntityManagerInterface;


class UserService implements UserServiceInterface
{

    public function __construct(EntityManagerInterface $manager)
    {
        $this->manager = $manager;
    }

    public function registerUser(User $user)
    {
        try {
            $this->manager->persist($user);
            return $this->manager->flush();
        } catch (Exception $e) {
            throw new UserServiceException($e->getMessage());
        }
    }
}
