<?php

namespace App\Repository\Match;

use App\Entity\Match\ListeningSession;
use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<ListeningSession>
 */
class ListeningSessionRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ListeningSession::class);
    }

    public function findUserRecentListeningHistory(User $user, int $days): array
    {
        return $this->createQueryBuilder('l')
            ->join('l.album', 'a')
            ->where('a.owner = :user')
            ->andWhere('l.choiceAt >= :dateLimit')
            ->setParameter('user', $user)
            ->setParameter('dateLimit', new \DateTimeImmutable("-$days days"))
            ->orderBy('l.choiceAt', 'DESC')
            ->getQuery()
            ->getResult();
    }
}
