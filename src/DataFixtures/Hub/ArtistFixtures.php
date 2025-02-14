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
        $datas = [
            [
                'name' => 'Pink Floyd',
                'country' => 'uk',
                'reference' => 'pink-floyd',
            ],
            [
                'name' => 'Amy Winehouse',
                'country' => 'us',
                'reference' => 'amy-winehouse',
            ],
            [
                'name' => 'Rammstein',
                'country' => 'allemagne',
                'reference' => 'rammstein',
            ],
            [
                'name' => 'Scorpions',
                'country' => 'allemagne',
                'reference' => 'scorpions',
            ],
            [
                'name' => 'Bérurier Noir',
                'country' => 'france',
                'reference' => 'berurier-noir',
            ],
            [
                'name' => 'The Beatles',
                'country' => 'uk',
                'reference' => 'the-beatles',
            ],
            [
                'name' => 'Led Zeppelin',
                'country' => 'uk',
                'reference' => 'led-zeppelin',
            ],
            [
                'name' => 'Nirvana',
                'country' => 'us',
                'reference' => 'nirvana',
            ],
            [
                'name' => 'Metallica',
                'country' => 'us',
                'reference' => 'metallica',
            ],
            [
                'name' => 'Queen',
                'country' => 'uk',
                'reference' => 'queen',
            ],
            [
                'name' => 'Black Sabbath',
                'country' => 'uk',
                'reference' => 'black-sabbath',
            ],
            [
                'name' => 'Johnny Cash',
                'country' => 'us',
                'reference' => 'johnny-cash',
            ],
            [
                'name' => 'Massive Attack',
                'country' => 'uk',
                'reference' => 'massive-attack',
            ],
            [
                'name' => 'Daft Punk',
                'country' => 'france',
                'reference' => 'daft-punk',
            ],
            [
                'name' => 'Linkin Park',
                'country' => 'us',
                'reference' => 'linkin-park',
            ],
            [
                'name' => 'Frank Ocean',
                'country' => 'us',
                'reference' => 'frank-ocean',
            ],
            [
                'name' => 'System Of A Down',
                'country' => 'us',
                'reference' => 'system-of-a-down',
            ],
            [
                'name' => 'Jeff Buckley',
                'country' => 'us',
                'reference' => 'jeff-buckley',
            ],
            [
                'name' => 'Radiohead',
                'country' => 'uk',
                'reference' => 'radiohead',
            ],
            [
                'name' => 'The Strokes',
                'country' => 'us',
                'reference' => 'the-strokes',
            ],
            [
                'name' => 'Depeche Mode',
                'country' => 'uk',
                'reference' => 'depeche-mode',
            ],
            [
                'name' => 'Tool',
                'country' => 'us',
                'reference' => 'tool',
            ],
            [
                'name' => 'Fleetwood Mac',
                'country' => 'uk',
                'reference' => 'fleetwood-mac',
            ],
            [
                'name' => 'Tame Impala',
                'country' => 'australie',
                'reference' => 'tame-impala',
            ],
            [
                'name' => 'The Killers',
                'country' => 'us',
                'reference' => 'the-killers',
            ],
            [
                'name' => 'The Smiths',
                'country' => 'uk',
                'reference' => 'the-smiths',
            ],
            [
                'name' => 'Animal Collective',
                'country' => 'us',
                'reference' => 'animal-collective',
            ],
            [
                'name' => 'Wilco',
                'country' => 'us',
                'reference' => 'wilco',
            ],
            [
                'name' => 'Arctic Monkeys',
                'country' => 'uk',
                'reference' => 'arctic-monkeys',
            ],
            [
                'name' => 'David Bowie',
                'country' => 'uk',
                'reference' => 'david-bowie',
            ],
            [
                'name' => 'Portishead',
                'country' => 'uk',
                'reference' => 'portishead',
            ],
            [
                'name' => 'R.E.M.',
                'country' => 'us',
                'reference' => 'r-e-m',
            ],
            [
                'name' => 'Queens Of The Stone Age',
                'country' => 'us',
                'reference' => 'queens-of-the-stone-age',
            ],
            [
                'name' => 'Pixies',
                'country' => 'us',
                'reference' => 'pixies',
            ],
            [
                'name' => 'My Bloody Valentine',
                'country' => 'irlande',
                'reference' => 'my-bloody-valentine',
            ],
            [
                'name' => 'Nine Inch Nails',
                'country' => 'us',
                'reference' => 'nine-inch-nails',
            ],
            [
                'name' => 'Pearl Jam',
                'country' => 'us',
                'reference' => 'pearl-jam',
            ],
            [
                'name' => 'Rage Against The Machine',
                'country' => 'us',
                'reference' => 'rage-against-the-machine',
            ],
            [
                'name' => 'AC/DC',
                'country' => 'australie',
                'reference' => 'ac-dc',
            ],
            [
                'name' => 'Red Hot Chili Peppers',
                'country' => 'us',
                'reference' => 'red-hot-chili-peppers',
            ],
            [
                'name' => 'The Black Keys',
                'country' => 'us',
                'reference' => 'the-black-keys',
            ],
            [
                'name' => 'Stevie Wonder',
                'country' => 'us',
                'reference' => 'stevie-wonder',
            ],
            [
                'name' => 'Gorillaz',
                'country' => 'uk',
                'reference' => 'gorillaz',
            ],
            [
                'name' => 'Arcade Fire',
                'country' => 'canada',
                'reference' => 'arcade-fire',
            ],
            [
                'name' => 'Fiona Apple',
                'country' => 'us',
                'reference' => 'fiona-apple',
            ],
            [
                'name' => 'Kate Bush',
                'country' => 'uk',
                'reference' => 'kate-bush',
            ],
            [
                'name' => 'LCD Soundsystem',
                'country' => 'us',
                'reference' => 'lcd-soundsystem',
            ],
        ];

        foreach($datas as $data) {
            $artist = (new Artist())
                ->setName($data['name'])
                ->setCountry($this->getReference('country-' . $data['country'], Country::class));
            $manager->persist($artist);
            $this->addReference('artist-' . $data['reference'], $artist);
        }

        $manager->flush();
    }

    public function getOrder(): int
    {
        return 3;
    }
}
