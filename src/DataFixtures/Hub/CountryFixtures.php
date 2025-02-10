<?php

namespace App\DataFixtures\Hub;

use App\Entity\Hub\Country;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class CountryFixtures extends Fixture implements OrderedFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $country = new Country();
        $country->setName('UK');
        $manager->persist($country);
        $this->addReference('country', $country);

        $manager->flush();
    }

    public function getOrder(): int
    {
        return 2;
    }
}
