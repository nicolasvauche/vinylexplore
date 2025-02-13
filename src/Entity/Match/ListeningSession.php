<?php

namespace App\Entity\Match;

use App\Entity\Hub\Album;
use App\Repository\Match\ListeningSessionRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ListeningSessionRepository::class)]
class ListeningSession
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?bool $listened = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $choiceAt = null;

    #[ORM\ManyToOne(inversedBy: 'listeningSessions')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Album $album = null;

    /**
     * @var Collection<int, ListeningContext>
     */
    #[ORM\OneToMany(targetEntity: ListeningContext::class, mappedBy: 'session', orphanRemoval: true)]
    private Collection $listeningContexts;

    public function __construct()
    {
        $this->listeningContexts = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function isListened(): ?bool
    {
        return $this->listened;
    }

    public function setListened(bool $listened): static
    {
        $this->listened = $listened;

        return $this;
    }

    public function getChoiceAt(): ?\DateTimeImmutable
    {
        return $this->choiceAt;
    }

    public function setChoiceAt(\DateTimeImmutable $choiceAt): static
    {
        $this->choiceAt = $choiceAt;

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

    /**
     * @return Collection<int, ListeningContext>
     */
    public function getListeningContexts(): Collection
    {
        return $this->listeningContexts;
    }

    public function addListeningContext(ListeningContext $listeningContext): static
    {
        if(!$this->listeningContexts->contains($listeningContext)) {
            $this->listeningContexts->add($listeningContext);
            $listeningContext->setSession($this);
        }

        return $this;
    }

    public function removeListeningContext(ListeningContext $listeningContext): static
    {
        if($this->listeningContexts->removeElement($listeningContext)) {
            // set the owning side to null (unless already changed)
            if($listeningContext->getSession() === $this) {
                $listeningContext->setSession(null);
            }
        }

        return $this;
    }
}
