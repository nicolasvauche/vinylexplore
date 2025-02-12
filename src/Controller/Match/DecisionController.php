<?php

namespace App\Controller\Match;

use App\Entity\Hub\Album;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class DecisionController extends AbstractController
{
    #[Route('/match/decision/{album}/{action}', name: 'app_match_decision')]
    public function index(EntityManagerInterface $entityManager,
                          string                 $album,
                          string                 $action): Response
    {
        $album = $entityManager->getRepository(Album::class)->findOneBy(['slug' => $album]);
        if($action === 'play') {
            $this->addFlash('success', "on écoute {$album->getTitle()}");
        } else {
            $this->addFlash('', "on zappe {$album->getTitle()}");
        }

        return $this->redirectToRoute('app_match_home', [], 301);
    }
}
