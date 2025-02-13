<?php

namespace App\Service\Match;

use App\Entity\Hub\Album;
use App\Entity\User;
use App\Repository\Hub\AlbumRepository;
use App\Service\Hub\AlbumService;
use App\Service\Match\Context\ContextService;

readonly class SuggestService
{
    public function __construct(private AlbumRepository $albumRepository,
                                private AlbumService    $albumService,
                                private ContextService  $contextService)
    {
    }

    public function suggest(User $user): Album
    {
        $albums = $this->albumRepository->findAlbumsForUser($user);
        $context = $this->contextService->getContext($user);
        $context['location'] = $context['location']['name'];

        $data = [
            'context' => $context,
            'albums' => $albums,
        ];

        dd($data);

        $albums = $this->albumService->getUserAlbums($user);

        return $albums[array_rand($albums)];
    }
}
