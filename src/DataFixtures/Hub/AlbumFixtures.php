<?php

namespace App\DataFixtures\Hub;

use App\Entity\Hub\Album;
use App\Entity\Hub\Artist;
use App\Entity\Hub\Genre;
use App\Entity\Hub\Style;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class AlbumFixtures extends Fixture implements OrderedFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $album = new Album();
        $album->setTitle('Wish You Were Here')
            ->setCover('pink-floyd_wish-you-were-here.jpg')
            ->setYear('1975')
            ->setArtist($this->getReference('artist', Artist::class))
            ->setGenre($this->getReference('genre', Genre::class))
            ->setStyle($this->getReference('style', Style::class))
            ->setOwner($this->getReference('user', User::class));
        $manager->persist($album);
        $this->addReference('album', $album);

        $manager->flush();
    }

    public function getOrder(): int
    {
        return 6;
    }
}
