<?php

namespace App\Controller\Hub;

use App\Entity\Hub\Album;
use App\Entity\Hub\Artist;
use App\Entity\Hub\Country;
use App\Entity\Hub\Genre;
use App\Entity\Hub\Style;
use App\Entity\User;
use App\Form\Hub\AddType;
use App\Service\Hub\DiscogsService;
use App\Service\Hub\FileUploaderService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\DecodingExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;

final class AddController extends AbstractController
{
    public function __construct(private readonly EntityManagerInterface $entityManager)
    {
    }

    /**
     * @throws TransportExceptionInterface
     * @throws ServerExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws DecodingExceptionInterface
     * @throws ClientExceptionInterface
     */
    #[Route('/hub/ajouter/{artist}/{album}', name: 'app_hub_add')]
    public function index(Request                $request,
                          EntityManagerInterface $entityManager,
                          DiscogsService         $discogsService,
                          SluggerInterface       $slugger,
                          FileUploaderService    $fileUploaderService,
                          string                 $artist,
                          string                 $album): Response
    {
        $result = $discogsService->search($artist, $album);
        if(sizeof($result) === 0) {
            $this->addFlash('warning', "Aucun résultat trouvé pour l'album $album de $artist.");

            return $this->redirectToRoute('app_hub_import', [], 301);
        }

        $user = $entityManager->getRepository(User::class)->find($this->getUser()->getId());

        $artist = $this->entityManager->getRepository(Artist::class)->findOneBy(['name' => $result['artist']]);
        if(!$artist) {
            $artist = new Artist();
            $artist->setName($result['artist']);

            $country = $this->entityManager->getRepository(Country::class)->findOneBy(['name' => $result['country']]);
            if(!$country) {
                $country = new Country();
                $country->setName($result['country']);
            }

            $artist->setCountry($country);
        } else {
            $country = $artist->getCountry();
        }

        $genre = $this->entityManager->getRepository(Genre::class)->findOneBy(['name' => $result['genre']]);
        if(!$genre) {
            $genre = new Genre();
            $genre->setName($result['genre']);
        }

        $style = $this->entityManager->getRepository(Style::class)->findOneBy(['name' => $result['style']]);
        if(!$style) {
            $style = new Style();
            $style->setName($result['style']);
        }

        $album = $this->entityManager->getRepository(Album::class)->findOneBy(['title' => $result['title'], 'artist' => $artist]);
        if($album) {
            $this->addFlash('warning', "L'album {$album->getTitle()} de {$album->getArtist()->getName()} est déjà présent dans votre collection !");

            return $this->redirectToRoute('app_hub_import', [], 303);
        }
        $album = new Album();
        $album->setArtist($artist)
            ->setTitle($result['title'])
            ->setYear($result['year'])
            ->setGenre($genre)
            ->setStyle($style);

        $form = $this->createForm(AddType::class, $album);
        $form->get('artist')->setData($artist->getName());
        $form->get('genre')->setData($genre->getName());
        $form->get('style')->setData($style->getName());
        $form->get('country')->setData($country->getName());
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            /** @var UploadedFile $coverFile */
            $coverFile = $form->get('cover')->getData();
            $filename = $user->getId() . '-' . strtolower($slugger->slug($form->get('artist')->getData())) . '_' . strtolower($slugger->slug($form->get('title')->getData()));
            if($coverFile) {
                $coverFileName = $fileUploaderService->upload($coverFile, $filename);
            } else if($request->request->get('cover_alt')) {
                $coverFileName = $fileUploaderService->download($request->request->get('cover_alt'), $filename);
            } else {
                $coverFileName = 'placeholder.png';
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
                ->setStyle($style)
                ->setCover($coverFileName)
                ->setOwner($user);
            $entityManager->persist($album);
            $entityManager->flush();

            $this->addFlash('success', "L'album {$album->getTitle()} de {$album->getArtist()->getName()} a été ajouté à votre collection !");

            return $this->redirectToRoute('app_hub_home', [], 301);
        }

        return $this->render('hub/add/index.html.twig', [
            'form' => $form->createView(),
            'result' => $result,
        ], new Response(null, $form->isSubmitted() && !$form->isValid() ? 422 : 200));
    }
}
