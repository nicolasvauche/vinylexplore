<?php

namespace App\Entity\Match;

use App\Repository\Match\ListeningContextRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ListeningContextRepository::class)]
class ListeningContext
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $dayOfWeek = null;

    #[ORM\Column(length: 255)]
    private ?string $timeOfDay = null;

    #[ORM\Column(length: 255)]
    private ?string $season = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $mood = null;

    #[ORM\ManyToOne(inversedBy: 'listeningContexts')]
    #[ORM\JoinColumn(nullable: false)]
    private ?ListeningSession $session = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $location = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDayOfWeek(): ?string
    {
        return $this->dayOfWeek;
    }

    public function setDayOfWeek(string $dayOfWeek): static
    {
        $this->dayOfWeek = $dayOfWeek;

        return $this;
    }

    public function getTimeOfDay(): ?string
    {
        return $this->timeOfDay;
    }

    public function setTimeOfDay(string $timeOfDay): static
    {
        $this->timeOfDay = $timeOfDay;

        return $this;
    }

    public function getSeason(): ?string
    {
        return $this->season;
    }

    public function setSeason(string $season): static
    {
        $this->season = $season;

        return $this;
    }

    public function getMood(): ?string
    {
        return $this->mood;
    }

    public function setMood(?string $mood): static
    {
        $this->mood = $mood;

        return $this;
    }

    public function getSession(): ?ListeningSession
    {
        return $this->session;
    }

    public function setSession(?ListeningSession $session): static
    {
        $this->session = $session;

        return $this;
    }

    public function getLocation(): ?string
    {
        return $this->location;
    }

    public function setLocation(?string $location): static
    {
        $this->location = $location;

        return $this;
    }
}
