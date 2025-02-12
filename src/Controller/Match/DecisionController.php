<?php

namespace App\Controller\Match;

use App\Entity\Hub\Album;
use App\Entity\User;
use App\Service\Match\Context\ContextService;
use App\Service\Match\DecisionService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class DecisionController extends AbstractController
{
    #[Route('/match/decision/{album}/{action}', name: 'app_match_decision')]
    public function index(EntityManagerInterface $entityManager,
                          DecisionService        $decisionService,
                          ContextService         $contextService,
                          string                 $album,
                          string                 $action): Response
    {
        $user = $entityManager->getRepository(User::class)->find($this->getUser()->getId());
        $album = $entityManager->getRepository(Album::class)->findOneBy(['slug' => $album]);
        if($action === 'play') {
            $decisionService->saveDecision($album, $contextService->getContext($user), true);
            $this->addFlash('success', "on écoute {$album->getTitle()}");
        } else {
            $decisionService->saveDecision($album, $contextService->getContext($user));
            $this->addFlash('', "on zappe {$album->getTitle()}");
        }

        return $this->redirectToRoute('app_match_home', [], 301);
    }
}
