<?php

namespace App\Twig\Components\Hub\Album;

use App\Entity\User;
use App\Service\Hub\AlbumService;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
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

    #[LiveProp(writable: true, onUpdated: 'resetPage')]
    public ?string $artist = null;

    #[LiveProp(writable: true, onUpdated: 'resetPage')]
    public ?string $album = null;

    #[LiveProp(writable: true, onUpdated: 'resetPage')]
    public ?string $genre = null;

    #[LiveProp(writable: true, onUpdated: 'resetPage')]
    public ?string $style = null;

    #[LiveProp(writable: true, onUpdated: 'resetPage')]
    public ?string $year = null;

    #[LiveProp(writable: true, onUpdated: 'resetPage')]
    public ?string $country = null;

    #[LiveProp(writable: true)]
    public int $page = 1;

    private const ITEMS_PER_PAGE = 6;

    public function __construct(
        private readonly EntityManagerInterface $entityManager,
        private readonly AlbumService           $albumService,
        private readonly PaginatorInterface     $paginator
    )
    {
    }

    private function getUser(int $userId): User
    {
        return $this->entityManager->getRepository(User::class)->find($userId);
    }

    #[LiveAction]
    public function getAlbums(#[LiveArg] int $userId): array
    {
        $filters = $this->buildFilters();
        $query = $this->albumService->getUserAlbums($this->getUser($userId), $filters);

        $pagination = $this->paginator->paginate(
            $query,
            $this->page,
            self::ITEMS_PER_PAGE
        );

        return [
            'albums' => $pagination->getItems(),
            'pagination' => $pagination,
        ];
    }

    #[LiveAction]
    public function changePage(#[LiveArg] int $page): void
    {
        $this->page = $page;
    }

    public function resetPage(): void
    {
        $this->page = 1;
    }

    #[LiveAction]
    public function resetFilters(#[LiveArg] string $filter): void
    {
        match ($filter) {
            'artist' => $this->artist = null,
            'album' => $this->album = null,
            'genre' => $this->genre = null,
            'style' => $this->style = null,
            'year' => $this->year = null,
            'country' => $this->country = null,
            default => null,
        };

        $this->page = 1;
    }

    private function buildFilters(): array
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

        return $filters;
    }
}
