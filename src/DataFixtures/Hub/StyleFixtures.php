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
        $style = new Style();
        $style->setName('Progressif');
        $manager->persist($style);
        $this->addReference('style', $style);

        $manager->flush();
    }

    public function getOrder(): int
    {
        return 5;
    }
}
