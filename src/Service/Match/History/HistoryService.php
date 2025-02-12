<?php

namespace App\Service\Match\History;

use App\Entity\Hub\Album;
use App\Entity\User;

readonly class HistoryService
{
    public function __construct(private RecentListeningService $recentListeningService,
                                private AlbumPlayCountService  $albumPlayCountService)
    {
    }

    public function getHistory(User $user): array
    {
        return [
            'recentListening' => $this->recentListeningService->getRecentListening($user, 7),
        ];
    }

    public function getAlbumHistory(Album $album): array
    {
        return [
            'playCount' => $this->albumPlayCountService->getAlbumPlayCount($album),
            'lastPlayedDate' => $this->albumPlayCountService->getLastPlayedDate($album),
        ];
    }
}
