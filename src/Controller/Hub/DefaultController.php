<?php

namespace App\Controller\Hub;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class DefaultController extends AbstractController
{
    #[Route('/hub', name: 'app_hub_home')]
    public function index(): Response
    {
        return $this->render('hub/default/index.html.twig');
    }
}
