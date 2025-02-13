<?php

namespace App\Controller\Match;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class DefaultController extends AbstractController
{
    #[Route('/', name: 'app_match_home')]
    public function index(): Response
    {
        if(sizeof($this->getUser()->getAlbums()) === 0) {
            $this->addFlash('warning', "Vous n'avez aucun album dans votre collection&nbsp;!");

            return $this->redirectToRoute('app_hub_import');
        }

        return $this->render('match/default/index.html.twig');
    }
}
