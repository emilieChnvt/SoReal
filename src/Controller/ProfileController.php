<?php

namespace App\Controller;

use App\Entity\Profile;
use App\Form\ProfileForm;
use App\Repository\ProfileRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
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


    #[Route('/profile/edit/{id}', name: 'app_profile_edit')]
    public function edit(EntityManagerInterface $entityManager, Request $request, Profile $profile): Response
    {
        if(!$this->getUser()){
            return $this->redirectToRoute('app_login');
        }
        $profileForm = $this->createForm(ProfileForm::class , $profile);
        $profileForm->handleRequest($request);
        if($profileForm->isSubmitted() && $profileForm->isValid()){
            $profile->setOfUser($this->getUser());
            $entityManager->persist($profile);
            $entityManager->flush();

        }

        return $this->render('profile/edit.html.twig', [
            'profile'=>$profile,
            'form'=>$profileForm->createView(),
        ]);
    }
}
