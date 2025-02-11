<?php

namespace App\Controller\Hub;

use App\Entity\Hub\Album;
use App\Entity\User;
use App\Form\Hub\ImportType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class ImportController extends AbstractController
{
    #[Route('/hub/importer', name: 'app_hub_import')]
    public function index(Request                $request,
                          EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(ImportType::class);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $artist = $form->get('artist')->getData();
            $album = $form->get('album')->getData();

            $albumExists = $entityManager->getRepository(Album::class)->findUserAlbumsByFilters($entityManager->getRepository(User::class)->find($this->getUser()->getId()), ['artist' => $artist, 'album' => $album]);
            if($albumExists) {
                $this->addFlash('warning', "L'album {$albumExists[0]->getArtist()->getName()} - {$albumExists[0]->getTitle()} est déjà présent dans votre collection !");

                return $this->redirectToRoute('app_hub_import', [], 303);
            }

            return $this->redirectToRoute('app_hub_add', ['artist' => $artist, 'album' => $album], 301);
        }

        return $this->render('hub/import/index.html.twig', [
            'form' => $form->createView(),
        ], new Response(null, $form->isSubmitted() && !$form->isValid() ? 422 : 200));
    }
}
