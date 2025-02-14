<?php

namespace App\DataFixtures\Hub;

use App\Entity\Hub\Mood;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class MoodFixtures extends Fixture implements OrderedFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $mood = new Mood();
        $mood->setName('Motivé')
            ->setIcon('fa6-solid:hand-fist');
        $manager->persist($mood);
        $this->addReference('mood-motive', $mood);

        $mood = new Mood();
        $mood->setName('Paisible')
            ->setIcon('fa6-solid:peace');
        $manager->persist($mood);
        $this->addReference('mood-paisible', $mood);

        $mood = new Mood();
        $mood->setName('Amoureux')
            ->setIcon('mdi:heart');
        $manager->persist($mood);
        $this->addReference('mood-amoureux', $mood);

        $mood = new Mood();
        $mood->setName('En soirée')
            ->setIcon('fa6-solid:champagne-glasses');
        $manager->persist($mood);
        $this->addReference('mood-en-soiree', $mood);

        $mood = new Mood();
        $mood->setName('Mélancolique')
            ->setIcon('rivet-icons:sad');
        $manager->persist($mood);
        $this->addReference('mood-melancolique', $mood);

        $mood = new Mood();
        $mood->setName('Concentré')
            ->setIcon('ri:focus-2-fill');
        $manager->persist($mood);
        $this->addReference('mood-concentre', $mood);

        $manager->flush();
    }

    public function getOrder(): int
    {
        return 6;
    }
}
