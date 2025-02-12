<?php

namespace App\Entity\Hub;

use App\Entity\Match\ListeningFrequency;
use App\Entity\Match\ListeningSession;
use App\Entity\User;
use App\Repository\Hub\AlbumRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

#[ORM\Entity(repositoryClass: AlbumRepository::class)]
class Album
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $title = null;

    #[ORM\Column(length: 255)]
    #[Gedmo\Slug(fields: ['title'])]
    private ?string $slug = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $cover = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $year = null;

    #[ORM\ManyToOne(inversedBy: 'albums')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Artist $artist = null;

    #[ORM\ManyToOne(inversedBy: 'albums')]
    private ?Genre $genre = null;

    #[ORM\ManyToOne(inversedBy: 'albums')]
    private ?Style $style = null;

    #[ORM\ManyToOne(inversedBy: 'albums')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $owner = null;

    /**
     * @var Collection<int, Mood>
     */
    #[ORM\ManyToMany(targetEntity: Mood::class, inversedBy: 'albums')]
    private Collection $moods;

    /**
     * @var Collection<int, ListeningSession>
     */
    #[ORM\OneToMany(targetEntity: ListeningSession::class, mappedBy: 'album', orphanRemoval: true)]
    private Collection $listeningSessions;

    /**
     * @var Collection<int, ListeningFrequency>
     */
    #[ORM\OneToMany(targetEntity: ListeningFrequency::class, mappedBy: 'album', orphanRemoval: true)]
    private Collection $listeningFrequencies;

    public function __construct()
    {
        $this->moods = new ArrayCollection();
        $this->listeningSessions = new ArrayCollection();
        $this->listeningFrequencies = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): static
    {
        $this->title = $title;

        return $this;
    }

    public function getSlug(): ?string
    {
        return $this->slug;
    }

    public function setSlug(string $slug): static
    {
        $this->slug = $slug;

        return $this;
    }

    public function getCover(): ?string
    {
        return $this->cover;
    }

    public function setCover(?string $cover): static
    {
        $this->cover = $cover;

        return $this;
    }

    public function getYear(): ?string
    {
        return $this->year;
    }

    public function setYear(?string $year): static
    {
        $this->year = $year;

        return $this;
    }

    public function getArtist(): ?Artist
    {
        return $this->artist;
    }

    public function setArtist(?Artist $artist): static
    {
        $this->artist = $artist;

        return $this;
    }

    public function getGenre(): ?Genre
    {
        return $this->genre;
    }

    public function setGenre(?Genre $genre): static
    {
        $this->genre = $genre;

        return $this;
    }

    public function getStyle(): ?Style
    {
        return $this->style;
    }

    public function setStyle(?Style $style): static
    {
        $this->style = $style;

        return $this;
    }

    public function getOwner(): ?User
    {
        return $this->owner;
    }

    public function setOwner(?User $owner): static
    {
        $this->owner = $owner;

        return $this;
    }

    /**
     * @return Collection<int, Mood>
     */
    public function getMoods(): Collection
    {
        return $this->moods;
    }

    public function addMood(Mood $mood): static
    {
        if (!$this->moods->contains($mood)) {
            $this->moods->add($mood);
        }

        return $this;
    }

    public function removeMood(Mood $mood): static
    {
        $this->moods->removeElement($mood);

        return $this;
    }

    /**
     * @return Collection<int, ListeningSession>
     */
    public function getListeningSessions(): Collection
    {
        return $this->listeningSessions;
    }

    public function addListeningSession(ListeningSession $listeningSession): static
    {
        if (!$this->listeningSessions->contains($listeningSession)) {
            $this->listeningSessions->add($listeningSession);
            $listeningSession->setAlbum($this);
        }

        return $this;
    }

    public function removeListeningSession(ListeningSession $listeningSession): static
    {
        if ($this->listeningSessions->removeElement($listeningSession)) {
            // set the owning side to null (unless already changed)
            if ($listeningSession->getAlbum() === $this) {
                $listeningSession->setAlbum(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, ListeningFrequency>
     */
    public function getListeningFrequencies(): Collection
    {
        return $this->listeningFrequencies;
    }

    public function addListeningFrequency(ListeningFrequency $listeningFrequency): static
    {
        if (!$this->listeningFrequencies->contains($listeningFrequency)) {
            $this->listeningFrequencies->add($listeningFrequency);
            $listeningFrequency->setAlbum($this);
        }

        return $this;
    }

    public function removeListeningFrequency(ListeningFrequency $listeningFrequency): static
    {
        if ($this->listeningFrequencies->removeElement($listeningFrequency)) {
            // set the owning side to null (unless already changed)
            if ($listeningFrequency->getAlbum() === $this) {
                $listeningFrequency->setAlbum(null);
            }
        }

        return $this;
    }
}
