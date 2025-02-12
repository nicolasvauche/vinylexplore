<?php

namespace App\Service\Match;

use App\Entity\Hub\Album;
use App\Entity\User;
use App\Service\Hub\AlbumService;
use App\Service\Match\Context\ContextService;
use App\Service\Match\History\HistoryService;

readonly class SuggestService
{
    public function __construct(private AlbumService   $albumService,
                                private ContextService $contextService,
                                private HistoryService $historyService)
    {
    }

    public function suggest(User $user): Album
    {
        $context = $this->contextService->getContext($user);
        $history = $this->historyService->getHistory($user);

        /*dd($context, $history);*/

        $albums = $this->albumService->getUserAlbums($user);

        return $albums[0];
    }
}
