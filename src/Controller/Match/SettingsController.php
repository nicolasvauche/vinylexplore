<?php

namespace App\Controller\Match;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class SettingsController extends AbstractController
{
    #[Route('/match/parametres', name: 'app_match_settings')]
    public function index(): Response
    {
        return $this->render('match/settings/index.html.twig');
    }
}
