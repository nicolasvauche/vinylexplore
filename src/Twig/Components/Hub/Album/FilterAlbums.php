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
    public ?string $artist = null;

    #[LiveProp(writable: true)]
    public ?string $album = null;

    #[LiveProp(writable: true)]
    public ?string $genre = null;

    #[LiveProp(writable: true)]
    public ?string $style = null;

    #[LiveProp(writable: true)]
    public ?string $year = null;

    #[LiveProp(writable: true)]
    public ?string $country = null;

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

        if($this->album && strlen($this->album) > 2) {
            $filters['album'] = $this->album;
        }

        if($this->genre && strlen($this->genre) > 2) {
            $filters['genre'] = $this->genre;
        }

        if($this->style && strlen($this->style) > 2) {
            $filters['style'] = $this->style;
        }

        if($this->year && strlen($this->year) === 4) {
            $filters['year'] = $this->year;
        }

        if($this->country && strlen($this->country) > 1) {
            $filters['country'] = $this->country;
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
            case 'album':
                $this->album = null;
                break;
            case 'genre':
                $this->genre = null;
                break;
            case 'style':
                $this->style = null;
                break;
            case 'year':
                $this->year = null;
                break;
            case 'country':
                $this->country = null;
                break;
            default:
                break;
        }
    }
}
