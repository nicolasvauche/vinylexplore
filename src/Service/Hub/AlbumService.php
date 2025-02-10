<?php

namespace App\Service\Hub;

use App\Entity\User;
use App\Repository\Hub\AlbumRepository;

class AlbumService
{
    public function __construct(private AlbumRepository $albumRepository)
    {
        $this->albumRepository = $albumRepository;
    }

    public function getUserAlbums(User $user, array $filters = []): array
    {
        return $this->albumRepository->findUserAlbumsByFilters($user, $filters);
    }
}
