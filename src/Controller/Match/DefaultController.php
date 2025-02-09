<?php

namespace App\Controller\Match;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class DefaultController extends AbstractController
{
    #[Route('/match', name: 'app_match_home')]
    public function index(): Response
    {
        return $this->render('match/default/index.html.twig');
    }
}
