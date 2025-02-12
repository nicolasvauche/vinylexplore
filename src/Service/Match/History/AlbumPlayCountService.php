<?php

namespace App\Service\Match\History;

use App\Entity\Hub\Album;
use App\Repository\Match\ListeningFrequencyRepository;

readonly class AlbumPlayCountService
{
    public function __construct(private ListeningFrequencyRepository $listeningFrequencyRepository)
    {
    }

    public function getAlbumPlayCount(Album $album): int
    {
        return $this->listeningFrequencyRepository->findAlbumPlayCount($album) ?? 0;
    }

    public function getLastPlayedDate(Album $album): ?\DateTimeImmutable
    {
        return $this->listeningFrequencyRepository->findLastPlayedDate($album) ?? null;
    }

    public function updateAlbumFrequency(Album $album): void
    {
        $this->listeningFrequencyRepository->updateAlbumFrequency($album);
    }
}
