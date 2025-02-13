<?php

namespace App\Repository\Match;

use App\Entity\Hub\Album;
use App\Entity\Match\ListeningFrequency;
use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<ListeningFrequency>
 */
class ListeningFrequencyRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ListeningFrequency::class);
    }

    public function findAlbumPlayCount(Album $album): ?int
    {
        $result = $this->createQueryBuilder('lf')
            ->select('lf.playCount')
            ->where('lf.album = :album')
            ->setParameter('album', $album)
            ->getQuery()
            ->getOneOrNullResult();

        return $result ? (int)$result['playCount'] : 0;
    }

    public function findLastPlayedDate(Album $album): ?\DateTimeImmutable
    {
        $result = $this->createQueryBuilder('lf')
            ->select('lf.lastPlayedAt')
            ->where('lf.album = :album')
            ->setParameter('album', $album)
            ->getQuery()
            ->getOneOrNullResult();

        return $result ? $result['lastPlayedAt'] : null;
    }

    public function updateAlbumFrequency(Album $album, \DateTimeImmutable $now): void
    {
        $entityManager = $this->getEntityManager();

        $listeningFrequency = $this->findOneBy(['album' => $album]);

        if(!$listeningFrequency) {
            $listeningFrequency = new ListeningFrequency();
            $listeningFrequency->setAlbum($album);
            $listeningFrequency->setPlayCount(1);
            $listeningFrequency->setLastPlayedAt($now);
        } else {
            $listeningFrequency->setPlayCount($listeningFrequency->getPlayCount() + 1);
            $listeningFrequency->setLastPlayedAt($now);
        }

        $entityManager->persist($listeningFrequency);
        $entityManager->flush();
    }
}
