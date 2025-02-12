<?php

namespace App\Service\Match;

use App\Entity\Hub\Album;
use App\Entity\User;
use App\Service\Hub\AlbumService;

class SuggestService
{
    public function __construct(private readonly AlbumService $albumService)
    {

    }

    public function suggest(User $user): Album
    {
        $albums = $this->albumService->getUserAlbums($user);

        return $albums[0];
    }
}
