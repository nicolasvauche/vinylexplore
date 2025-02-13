<?php

namespace App\Controller\Settings;

use App\Entity\Hub\Mood;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class MoodController extends AbstractController
{
    #[Route('/parametres/humeur/{slug}', name: 'app_settings_mood')]
    public function index(EntityManagerInterface $entityManager,
                          Mood                   $mood): Response
    {
        $user = $entityManager->getRepository(User::class)->find($this->getUser()->getId());

        if($user->getMood() === $mood) {
            $user->setMood(null);
        } else {
            $user->setMood($mood);
        }
        $entityManager->persist($user);
        $entityManager->flush();

        return $this->redirectToRoute('app_settings_home', [], 301);
    }
}
