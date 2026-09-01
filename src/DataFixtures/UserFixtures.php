<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\User;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserFixtures extends Fixture
{
    private UserPasswordHasherInterface $hasher;

    public function __construct(UserPasswordHasherInterface $hasher)
    {
        $this->hasher = $hasher;
    }

    public function load(ObjectManager $manager): void
    {
        $users = [
            [
                'email' => 'admin@resoflow.com',
                'password' => 'admin123'
            ],
            [
                'email' => 'user@resoflow.com',
                'password' => 'user123'
            ]
        ];

        foreach ($users as $userData) {
            $user = new User();
            $user->setEmail($userData['email']);
            $password = $this->hasher->hashPassword($user, $userData['password']);
            $user->setPassword($password);

            $manager->persist($user);
    }
        $manager->flush();
    }

}
