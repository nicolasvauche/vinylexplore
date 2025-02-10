<?php

namespace App\DataFixtures\Hub;

use App\Entity\Hub\Genre;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class GenreFixtures extends Fixture implements OrderedFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $genre = new Genre();
        $genre->setName('Rock');
        $manager->persist($genre);
        $this->addReference('genre', $genre);

        $manager->flush();
    }

    public function getOrder(): int
    {
        return 4;
    }
}
