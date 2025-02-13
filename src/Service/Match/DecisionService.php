<?php

namespace App\Service\Match;

use App\Entity\Hub\Album;
use App\Entity\Match\ListeningContext;
use App\Entity\Match\ListeningSession;
use App\Service\Match\History\AlbumPlayCountService;
use Doctrine\ORM\EntityManagerInterface;

readonly class DecisionService
{
    public function __construct(private EntityManagerInterface $entityManager,
                                private AlbumPlayCountService  $albumPlayCountService)
    {
    }

    public function saveDecision(Album $album, array $context, ?bool $played = false): void
    {
        $now = new \DateTimeImmutable();
        $listeningSession = new ListeningSession();
        $listeningSession->setAlbum($album)
            ->setListened($played)
            ->setChoiceAt($now);
        $this->entityManager->persist($listeningSession);

        $listeningContext = new ListeningContext();
        $listeningContext->setSession($listeningSession)
            ->setMood(strtolower($context['mood']))
            ->setLocation(strtolower($context['location']['name']))
            ->setSeason($context['season'])
            ->setDayOfWeek($context['dayOfWeek'])
            ->setTimeOfDay($context['timeOfDay']);
        $this->entityManager->persist($listeningContext);
        $this->entityManager->flush();

        if($played) {
            $this->albumPlayCountService->updateAlbumFrequency($album, $now);
        }
    }
}
