<?php

namespace App\Repository\Hub;

use App\Entity\Hub\Album;
use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Album>
 */
class AlbumRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Album::class);
    }

    public function findUserAlbumsByFilters(User $user, array $filters): array
    {
        $qb = $this->createQueryBuilder('album')
            ->join('album.artist', 'artist')
            ->where('album.owner = :user')
            ->setParameter('user', $user);

        if(isset($filters['artist'])) {
            $qb->andWhere('LOWER(artist.name) LIKE :artist')
                ->setParameter('artist', '%' . strtolower($filters['artist']) . '%');
        }

        if(isset($filters['album'])) {
            $qb->andWhere('LOWER(album.title) LIKE :album')
                ->setParameter('album', '%' . strtolower($filters['album']) . '%');
        }

        if(isset($filters['genre'])) {
            $qb->join('album.genre', 'genre')
                ->andWhere('LOWER(genre.name) LIKE :genre')
                ->setParameter('genre', '%' . strtolower($filters['genre']) . '%');
        }

        if(isset($filters['style'])) {
            $qb->join('album.style', 'style')
                ->andWhere('LOWER(style.name) LIKE :style')
                ->setParameter('style', '%' . strtolower($filters['style']) . '%');
        }

        if(isset($filters['year'])) {
            $qb->andWhere('album.year = :year')
                ->setParameter('year', $filters['year']);
        }

        if(isset($filters['country'])) {
            $qb->join('artist.country', 'country')
                ->andWhere('LOWER(country.name) LIKE :country')
                ->setParameter('country', '%' . strtolower($filters['country']) . '%');
        }

        $qb->addOrderBy('artist.name', 'ASC')
            ->addOrderBy('album.year', 'ASC');

        return $qb->getQuery()->getResult();
    }

    public function findAlbumsForUser(User $user): array
    {
        $qb = $this->createQueryBuilder('a')
            ->select(
                'a.id',
                'g.name as genre',
                's.name as style',
                'lf.playCount',
                'lf.lastPlayedAt',
                'LOWER(m.name) as mood',
                'lc.dayOfWeek',
                'lc.timeOfDay',
                'lc.season',
                'lc.location',
                'CASE WHEN ls.id IS NULL THEN \'\' WHEN ls.listened = true THEN \'écouté\' ELSE \'ignoré\' END AS status',
                'ls.choiceAt'
            )
            ->leftJoin('a.moods', 'm')
            ->leftJoin('a.genre', 'g')
            ->leftJoin('a.style', 's')
            ->leftJoin('a.listeningFrequencies', 'lf')
            ->leftJoin('a.owner', 'o')
            ->leftJoin('a.listeningSessions', 'ls')
            ->leftJoin('ls.listeningContexts', 'lc')
            ->where('a.owner = :user')
            ->setParameter('user', $user);

        $results = $qb->getQuery()->getResult();

        $groupedResults = [];
        foreach($results as $result) {
            $albumId = $result['id'];

            if(!isset($groupedResults[$albumId])) {
                $groupedResults[$albumId] = [
                    'id' => $albumId,
                    'moods' => !empty($result['mood']) ? [] : null,
                    'genre' => $result['genre'],
                    'style' => $result['style'],
                    'playCount' => $result['playCount'],
                    'lastPlayedAt' => $result['lastPlayedAt'] instanceof \DateTimeImmutable
                        ? $result['lastPlayedAt']->getTimestamp()
                        : null,
                    'listeningHistory' => null,
                ];
            }

            if($result['status'] !== '') {
                $context = [
                    'dayOfWeek' => $result['dayOfWeek'],
                    'timeOfDay' => $result['timeOfDay'],
                    'season' => $result['season'],
                    'location' => $result['location'],
                    'status' => $result['status'],
                    'choiceAt' => $result['choiceAt'] instanceof \DateTimeImmutable
                        ? $result['choiceAt']->getTimestamp()
                        : null,
                ];

                if($groupedResults[$albumId]['listeningHistory'] === null) {
                    $groupedResults[$albumId]['listeningHistory'] = [];
                }

                $exists = false;
                foreach($groupedResults[$albumId]['listeningHistory'] as $existingContext) {
                    if($existingContext === $context) {
                        $exists = true;
                        break;
                    }
                }

                if(!$exists) {
                    $groupedResults[$albumId]['listeningHistory'][] = $context;
                }
            }

            if(!empty($result['mood']) && !in_array($result['mood'], $groupedResults[$albumId]['moods'], true)) {
                $groupedResults[$albumId]['moods'][] = $result['mood'];
            }
        }

        return array_values($groupedResults);
    }
}
