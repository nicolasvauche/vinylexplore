<?php

namespace App\Service\Match\History;

use App\Entity\User;
use App\Repository\Match\ListeningSessionRepository;

readonly class RecentListeningService
{
    public function __construct(private ListeningSessionRepository $listeningSessionRepository)
    {
    }

    public function getRecentListening(User $user, int $days = 7): array
    {
        return $this->listeningSessionRepository->findUserRecentListeningHistory($user, $days);
    }
}
