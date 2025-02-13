<?php

namespace App\Controller\Settings\Location;

use App\Entity\Settings\Location;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class EditController extends AbstractController
{
    #[Route('/parametres/modifier-les-lieux', name: 'app_settings_location_edit')]
    public function index(Request                $request,
                          EntityManagerInterface $entityManager): Response
    {
        if($request->isMethod('POST')) {
            $locationId = $request->request->get('id');
            $locationName = $request->request->get('name');
            $locationDescription = $request->request->get('description');

            $location = $entityManager->getRepository(Location::class)->find($locationId);
            $location->setName($locationName)
                ->setDescription($locationDescription);
            $entityManager->persist($location);
            $entityManager->flush();

            return $this->redirectToRoute('app_settings_home', [], 301);
        }

        return $this->render('settings/location/edit/index.html.twig');
    }
}
