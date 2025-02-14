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
        $datas = [
            [
                'name' => 'UK',
                'reference' => 'uk',
            ],
            [
                'name' => 'US',
                'reference' => 'us',
            ],
            [
                'name' => 'Allemagne',
                'reference' => 'allemagne',
            ],
            [
                'name' => 'France',
                'reference' => 'france',
            ],
            [
                'name' => 'Australie',
                'reference' => 'australie',
            ],
            [
                'name' => 'Irlande',
                'reference' => 'irlande',
            ],
            [
                'name' => 'Canada',
                'reference' => 'canada',
            ],
        ];

        foreach($datas as $data) {
            $country = (new Country())
                ->setName($data['name']);
            $manager->persist($country);
            $this->addReference('country-' . $data['reference'], $country);
        }

        $manager->flush();
    }

    public function getOrder(): int
    {
        return 2;
    }
}
