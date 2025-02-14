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
        $datas = [
            [
                'name' => 'Rock',
                'reference' => 'rock',
            ],
            [
                'name' => 'Hard Rock',
                'reference' => 'hard-rock',
            ],
            [
                'name' => 'Métal',
                'reference' => 'metal',
            ],
            [
                'name' => 'Punk',
                'reference' => 'punk',
            ],
            [
                'name' => 'Soul',
                'reference' => 'soul',
            ],
            [
                'name' => 'Grunge',
                'reference' => 'grunge',
            ],
            [
                'name' => 'Country',
                'reference' => 'country',
            ],
            [
                'name' => 'Électro',
                'reference' => 'electro',
            ],
            [
                'name' => "R&B",
                'reference' => 'rnb',
            ],
            [
                'name' => 'Indie',
                'reference' => 'indie',
            ],
        ];

        foreach($datas as $data) {
            $genre = (new Genre())
                ->setName($data['name']);
            $manager->persist($genre);
            $this->addReference('genre-' . $data['reference'], $genre);
        }

        $manager->flush();
    }

    public function getOrder(): int
    {
        return 4;
    }
}
