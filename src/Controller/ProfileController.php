<?php

namespace App\Controller;

use App\Entity\Profile;
use App\Repository\ProfileRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class ProfileController extends AbstractController
{
    #[Route('/profile/{id}', name: 'app_profile')]
    public function index(Profile $profile): Response
    {
        return $this->render('profile/index.html.twig', [
            'profile'=>'profile',
        ]);
    }

    public function edit(Profile $profile): Response
    {
        if(!$this->getUser()){
            return $this->redirectToRoute('app_login');
        }

        return $this->render('profile/edit.html.twig', [
            'profile'=>$profile,
        ]);
    }
}
