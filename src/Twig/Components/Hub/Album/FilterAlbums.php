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

    private ?User $user = null;

    #[LiveProp(writable: true)]
    public ?int $userId = null;

    #[LiveProp(writable: true)]
    public ?string $artist = null;

    public function __construct(private EntityManagerInterface $entityManager,
                                private AlbumService           $albumService)
    {
        $this->entityManager = $entityManager;
        $this->albumService = $albumService;
    }

    private function getUser(int $userId): User
    {
        return $this->entityManager->getRepository(User::class)->find($userId);
    }

    #[LiveAction]
    public function getAlbums(#[LiveArg] int $userId): array
    {
        $filters = [];

        if($this->artist && strlen($this->artist) > 2) {
            $filters['artist'] = $this->artist;
        }

        return $this->albumService->getUserAlbums($this->getUser($userId), $filters);
    }

    #[LiveAction]
    public function resetFilters(#[LiveArg] string $filter): void
    {
        switch($filter) {
            case 'artist':
                $this->artist = null;
                break;
            default:
                break;
        }
    }
}
