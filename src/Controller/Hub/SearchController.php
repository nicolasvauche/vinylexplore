<?php

namespace App\Controller\Hub;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class SearchController extends AbstractController
{
    #[Route('/hub/rechercher', name: 'app_hub_search')]
    public function index(): Response
    {
        return $this->render('hub/search/index.html.twig');
    }
}
