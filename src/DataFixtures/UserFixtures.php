<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserFixtures extends Fixture implements OrderedFixtureInterface
{
    private UserPasswordHasherInterface $passwordHasher;

    public function __construct(UserPasswordHasherInterface $passwordHasher)
    {
        $this->passwordHasher = $passwordHasher;
    }

    public function load(ObjectManager $manager): void
    {
        $user = new User();
        $user->setEmail('nvauche@gmail.com')
            ->setPassword($this->passwordHasher->hashPassword($user, 'nicolas'))
            ->setName('Nicolas')
            ->setActive(true);
        $manager->persist($user);
        $this->addReference('user', $user);

        $manager->flush();
    }

    public function getOrder(): int
    {
        return 1;
    }
}
