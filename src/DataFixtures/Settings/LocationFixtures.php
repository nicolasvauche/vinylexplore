<?php

namespace App\DataFixtures\Settings;

use App\Entity\Settings\Location;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class LocationFixtures extends Fixture implements OrderedFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $location = new Location();
        $location->setName('Maison')
            ->setDescription('à la maison');
        $manager->persist($location);
        $this->addReference('location-maison', $location);

        $location = new Location();
        $location->setName('Chérie')
            ->setDescription('chez votre chérie');
        $manager->persist($location);
        $this->addReference('location-cherie', $location);

        $location = new Location();
        $location->setName('Travail')
            ->setDescription('au travail');
        $manager->persist($location);
        $this->addReference('location-travail', $location);

        $location = new Location();
        $location->setName('Voiture')
            ->setDescription('en voiture');
        $manager->persist($location);
        $this->addReference('location-voiture', $location);

        $location = new Location();
        $location->setName('Dehors')
            ->setDescription('dehors');
        $manager->persist($location);
        $this->addReference('location-dehors', $location);

        $manager->flush();
    }

    public function getOrder(): int
    {
        return 8;
    }
}
