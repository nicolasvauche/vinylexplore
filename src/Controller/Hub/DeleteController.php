<?php

namespace App\Controller\Hub;

use App\Entity\Hub\Album;
use App\Service\Hub\FileUploaderService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class DeleteController extends AbstractController
{
    #[Route('/hub/supprimer-un-album/{slug}', name: 'app_hub_delete')]
    public function index(EntityManagerInterface $entityManager,
                          FileUploaderService    $fileUploaderService,
                          Album                  $album): Response
    {
        if($album->getCover()) {
            $fileUploaderService->remove($album->getCover());
        }

        $entityManager->remove($album);
        $entityManager->flush();

        $this->addFlash('danger', "L'album {$album->getTitle()} de {$album->getArtist()->getName()} a été supprimé !");

        return $this->redirectToRoute('app_hub_home', [], Response::HTTP_SEE_OTHER);
    }
}
