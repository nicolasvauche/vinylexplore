<?php

namespace App\DataFixtures\Hub;

use App\Entity\Hub\Style;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class StyleFixtures extends Fixture implements OrderedFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $datas = [
            [
                'name' => 'Progressif',
                'reference' => 'progressif',
            ],
            [
                'name' => 'Industriel',
                'reference' => 'industriel',
            ],
            [
                'name' => 'Classique',
                'reference' => 'classique',
            ],
            [
                'name' => 'Hard',
                'reference' => 'hard',
            ],
            [
                'name' => 'Thrash',
                'reference' => 'thrash',
            ],
            [
                'name' => 'Heavy',
                'reference' => 'heavy',
            ],
            [
                'name' => 'Trip-Hop',
                'reference' => 'trip-hop',
            ],
            [
                'name' => 'House',
                'reference' => 'house',
            ],
            [
                'name' => 'Nu-Métal',
                'reference' => 'nu-metal',
            ],
            [
                'name' => 'Alternatif',
                'reference' => 'alternatif',
            ],
            [
                'name' => 'Expérimental',
                'reference' => 'experimental',
            ],
            [
                'name' => 'Garage',
                'reference' => 'garage',
            ],
            [
                'name' => 'Synth-Pop',
                'reference' => 'synth-pop',
            ],
            [
                'name' => 'Soft',
                'reference' => 'soft',
            ],
            [
                'name' => 'Psychédélique',
                'reference' => 'psychedelique',
            ],
            [
                'name' => 'Indie',
                'reference' => 'indie',
            ],
            [
                'name' => 'Disco',
                'reference' => 'disco',
            ],
            [
                'name' => 'Stoner',
                'reference' => 'stoner',
            ],
            [
                'name' => 'Shoegaze',
                'reference' => 'shoegaze',
            ],
            [
                'name' => 'Fusion',
                'reference' => 'fusion',
            ],
            [
                'name' => 'Funk',
                'reference' => 'funk',
            ],
            [
                'name' => 'Blues',
                'reference' => 'blues',
            ],
            [
                'name' => 'Art-Pop',
                'reference' => 'art-pop',
            ],
            [
                'name' => 'Dance Punk',
                'reference' => 'dance-punk',
            ],
        ];

        foreach($datas as $data) {
            $style = (new Style())
                ->setName($data['name']);
            $manager->persist($style);
            $this->addReference('style-' . $data['reference'], $style);
        }

        $manager->flush();
    }

    public function getOrder(): int
    {
        return 5;
    }
}
