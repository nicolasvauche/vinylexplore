<?php

namespace App\DataFixtures\Settings;

use App\Entity\Settings\Location;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class LocationFixtures extends Fixture implements OrderedFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $location = new Location();
        $location->setName('Maison')
            ->setDescription('à la maison')
            ->setOwner($this->getReference('user-nicolas', User::class));
        $manager->persist($location);
        $this->addReference('location-maison', $location);

        $location = new Location();
        $location->setName('Chérie')
            ->setDescription('chez votre chérie')
            ->setOwner($this->getReference('user-nicolas', User::class));
        $manager->persist($location);
        $this->addReference('location-cherie', $location);

        $location = new Location();
        $location->setName('Travail')
            ->setDescription('au travail')
            ->setOwner($this->getReference('user-nicolas', User::class));
        $manager->persist($location);
        $this->addReference('location-travail', $location);

        $manager->flush();
    }

    public function getOrder(): int
    {
        return 8;
    }
}
