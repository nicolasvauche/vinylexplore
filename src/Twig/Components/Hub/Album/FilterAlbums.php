<?php

namespace App\Twig\Components\Hub\Album;

use App\Entity\User;
use App\Service\Hub\AlbumService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\UX\LiveComponent\Attribute\AsLiveComponent;
use Symfony\UX\LiveComponent\Attribute\LiveAction;
use Symfony\UX\LiveComponent\Attribute\LiveArg;
use Symfony\UX\LiveComponent\Attribute\LiveProp;
use Symfony\UX\LiveComponent\DefaultActionTrait;

#[AsLiveComponent('FilterAlbums', template: 'hub/default/_component/_index.html.twig')]
class FilterAlbums
{
    use DefaultActionTrait;

    public function __construct(private EntityManagerInterface $entityManager,
                                private AlbumService           $albumService)
    {
        $this->entityManager = $entityManager;
        $this->albumService = $albumService;
    }

    #[LiveAction]
    public function getAlbums(#[LiveArg] int $userId): array
    {
        return $this->albumService->getUserAlbums($this->entityManager->getRepository(User::class)->find($userId));
    }

    #[LiveAction]
    public function resetFilters(): void
    {

    }
}
