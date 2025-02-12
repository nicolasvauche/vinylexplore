<?php

namespace App\Entity\Match;

use App\Entity\Hub\Album;
use App\Repository\Match\ListeningFrequencyRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ListeningFrequencyRepository::class)]
class ListeningFrequency
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?int $playCount = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $lastPlayedAt = null;

    #[ORM\ManyToOne(inversedBy: 'listeningFrequencies')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Album $album = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPlayCount(): ?int
    {
        return $this->playCount;
    }

    public function setPlayCount(int $playCount): static
    {
        $this->playCount = $playCount;

        return $this;
    }

    public function getLastPlayedAt(): ?\DateTimeImmutable
    {
        return $this->lastPlayedAt;
    }

    public function setLastPlayedAt(\DateTimeImmutable $lastPlayedAt): static
    {
        $this->lastPlayedAt = $lastPlayedAt;

        return $this;
    }

    public function getAlbum(): ?Album
    {
        return $this->album;
    }

    public function setAlbum(?Album $album): static
    {
        $this->album = $album;

        return $this;
    }
}
