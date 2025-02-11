<?php

namespace App\Controller\Hub;

use App\Entity\Hub\Album;
use App\Entity\Hub\Artist;
use App\Entity\Hub\Country;
use App\Entity\Hub\Genre;
use App\Entity\Hub\Style;
use App\Form\Hub\AddType;
use App\Service\Hub\FileUploaderService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\String\Slugger\SluggerInterface;

final class EditController extends AbstractController
{
    #[Route('/hub/modifier-un-album/{slug}', name: 'app_hub_edit')]
    public function index(Request                $request,
                          EntityManagerInterface $entityManager,
                          SluggerInterface       $slugger,
                          FileUploaderService    $fileUploaderService,
                          Album                  $album): Response
    {
        $form = $this->createForm(AddType::class, $album);
        $form->get('artist')->setData($album->getArtist()->getName());
        $form->get('genre')->setData($album->getGenre()->getName());
        $form->get('style')->setData($album->getStyle()->getName());
        $form->get('country')->setData($album->getArtist()->getCountry()->getName());
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            /** @var UploadedFile $coverFile */
            $coverFile = $form->get('cover')->getData();
            if($coverFile) {
                if($album->getCover()) {
                    $fileUploaderService->remove($album->getCover());
                }
                $coverFileName = $fileUploaderService->upload($coverFile, $this->getUser()->getId() . '-' . strtolower($slugger->slug($form->get('artist')->getData())) . '-' . strtolower($slugger->slug($form->get('title')->getData())));
                $album->setCover($coverFileName);
            }

            $artist = $entityManager->getRepository(Artist::class)->findOneBy(['name' => $form->get('artist')->getData()]);
            if(!$artist) {
                $artist = new Artist();
                $artist->setName($form->get('artist')->getData());
            }

            $country = $entityManager->getRepository(Country::class)->findOneBy(['name' => $form->get('country')->getData()]);
            if(!$country) {
                $country = new Country();
                $country->setName($form->get('country')->getData());
                $entityManager->persist($country);
            }
            $artist->setCountry($country);
            $entityManager->persist($artist);

            if($form->get('genre')->getData()) {
                $genre = $entityManager->getRepository(Genre::class)->findOneBy(['name' => $form->get('genre')->getData()]);
                if(!$genre) {
                    $genre = new Genre();
                    $genre->setName($form->get('genre')->getData());
                    $entityManager->persist($genre);
                }
            } else {
                $genre = null;
            }

            if($form->get('style')->getData()) {
                $style = $entityManager->getRepository(Style::class)->findOneBy(['name' => $form->get('style')->getData()]);
                if(!$style) {
                    $style = new Style();
                    $style->setName($form->get('style')->getData());
                    $entityManager->persist($style);
                }
            } else {
                $style = null;
            }

            $album->setArtist($artist)
                ->setGenre($genre)
                ->setStyle($style);

            $entityManager->persist($album);
            $entityManager->flush();

            $this->addFlash('info', "L'album {$album->getTitle()} a été modifié.");

            return $this->redirectToRoute('app_hub_view', ['slug' => $album->getSlug()], 301);
        }

        return $this->render('hub/edit/index.html.twig', [
            'form' => $form->createView(),
            'album' => $album,
        ], new Response(null, $form->isSubmitted() && !$form->isValid() ? 422 : 200));
    }
}
