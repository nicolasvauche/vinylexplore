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
            ->where('album.owner = :user')
            ->setParameter('user', $user);

        if(isset($filters['artist'])) {
            $qb->join('album.artist', 'artist')
                ->andWhere('LOWER(artist.name) LIKE :artist')
                ->setParameter('artist', '%' . strtolower($filters['artist']) . '%')
                ->addOrderBy('artist.name', 'ASC');
        }

        if(isset($filters['album'])) {
            $qb->andWhere('LOWER(album.title) LIKE :album')
                ->setParameter('album', '%' . strtolower($filters['album']) . '%');
        }

        if(isset($filters['year'])) {
            $qb->andWhere('album.year = :year')
                ->setParameter('year', $filters['year']);
        }

        if(isset($filters['genre'])) {
            $qb->join('album.genre', 'genre')
                ->andWhere('LOWER(genre.name) LIKE :genre')
                ->setParameter('genre', '%' . strtolower($filters['genre']) . '%')
                ->addOrderBy('genre.name', 'ASC');
        }

        if(isset($filters['style'])) {
            $qb->join('album.style', 'style')
                ->andWhere('LOWER(style.name) LIKE :style')
                ->setParameter('style', '%' . strtolower($filters['style']) . '%')
                ->addOrderBy('style.name', 'ASC');
        }

        $qb->addOrderBy('album.year', 'ASC');

        return $qb->getQuery()->getResult();
    }
}
