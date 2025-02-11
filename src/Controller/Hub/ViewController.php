<?php

namespace App\Controller\Hub;

use App\Entity\Hub\Album;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class ViewController extends AbstractController
{
    #[Route('/hub/album/{slug}', name: 'app_hub_view')]
    public function index(Album $album): Response
    {
        return $this->render('hub/view/index.html.twig', [
            'album' => $album,
        ]);
    }
}
