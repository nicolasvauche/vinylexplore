<?php

namespace App\Controller\Hub;

use App\Entity\Hub\Album;
use App\Entity\Hub\Mood;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class MoodController extends AbstractController
{
    #[Route('/hub/associer-album-humeur/{albumId}/{moodId}', name: 'app_hub_mood')]
    public function index(EntityManagerInterface $entityManager,
                          int                    $albumId,
                          int                    $moodId): Response
    {
        $album = $entityManager->getRepository(Album::class)->find($albumId);
        $mood = $entityManager->getRepository(Mood::class)->find($moodId);

        if($album->getMoods()->contains($mood)) {
            $album->removeMood($mood);
        } else {
            $album->addMood($mood);
        }
        $entityManager->persist($album);
        $entityManager->flush();

        return $this->redirectToRoute('app_hub_view', ['slug' => $album->getSlug()], 301);
    }
}
