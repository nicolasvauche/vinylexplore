<?php

namespace App\Controller\Settings;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class DefaultController extends AbstractController
{
    #[Route('/parametres', name: 'app_settings_home')]
    public function index(): Response
    {
        return $this->render('settings/default/index.html.twig');
    }
}
