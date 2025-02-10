<?php

namespace App\DataFixtures\Hub;

use App\Entity\Hub\Artist;
use App\Entity\Hub\Country;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class ArtistFixtures extends Fixture implements OrderedFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $artist = new Artist();
        $artist->setName('Pink Floyd')
            ->setCountry($this->getReference('country', Country::class));
        $manager->persist($artist);
        $this->addReference('artist', $artist);

        $manager->flush();
    }

    public function getOrder(): int
    {
        return 3;
    }
}
