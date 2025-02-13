<?php

namespace App\Controller\Settings;

use App\Entity\Settings\Location;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class LocationController extends AbstractController
{
    #[Route('/parametres/lieu/{slug}', name: 'app_settings_location')]
    public function index(EntityManagerInterface $entityManager,
                          Location               $location): Response
    {
        $user = $entityManager->getRepository(User::class)->find($this->getUser()->getId());

        if($user->getLocation() === $location) {
            $user->setLocation(null);
        } else {
            $user->setLocation($location);
        }
        $entityManager->persist($user);
        $entityManager->flush();

        return $this->redirectToRoute('app_settings_home', [], 301);
    }
}
