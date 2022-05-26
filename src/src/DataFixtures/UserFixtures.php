<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserFixtures extends Fixture
{
    private $userPasswordHasher;
    public function __construct(UserPasswordHasherInterface $userPasswordHasher)
    {
        $this->userPasswordHasher = $userPasswordHasher;
    }

    public function load(ObjectManager $manager): void
    {
        $user = new User();
        $user->setEmail('nariman@admin.com');
        $user->setPassword($this->userPasswordHasher->hashPassword($user, "12345"));
        $user->setRoles(['ROLE_ADMIN']);
        $manager->persist($user);

        $user2 = new User();
        $user2->setEmail('nariman@user.com');
        $user2->setPassword($this->userPasswordHasher->hashPassword($user2, "12345"));
        $manager->persist($user2);

        $manager->flush();
    }
}
