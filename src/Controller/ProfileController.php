<?php

namespace App\Controller;

use App\Entity\Image;
use App\Entity\Profile;
use App\Form\ProfileForm;
use App\Form\UserImageForm;
use App\Form\UserSearchForm;
use App\Repository\ProfileRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class ProfileController extends AbstractController
{

    #[Route('/profiles', name: 'profiles')]
    public function index(ProfileRepository $profileRepository, Request $request): Response
    {
        $form = $this->createForm(UserSearchForm::class);
        $form->handleRequest($request);
        return $this->render('friends/index.html.twig', [
            'profiles' => $profileRepository->findAll(),
            'form' => $form
        ]);
    }
    #[Route('/profile/{id}', name: 'app_profile')]
    public function show(Profile $profile): Response
    {
        return $this->render('profile/index.html.twig', [
            'profile'=>$profile,
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
            return $this->redirectToRoute('app_profile', ['id' => $profile->getId()]);

        }

        return $this->render('profile/edit.html.twig', [
            'profile'=>$profile,
            'form'=>$profileForm->createView(),
        ]);
    }

    #[Route('/profile/addImage/{id}', name: 'app_profile_add_image')]
    public function addImage(Profile $profile, Request $request, EntityManagerInterface $entityManager): Response
    {
        if(!$this->getUser()){
            return $this->redirectToRoute('app_login');
        }
        $image = new Image();
        $imageForm = $this->createForm(UserImageForm::class, $image);
        $imageForm->handleRequest($request);
        if($imageForm->isSubmitted() && $imageForm->isValid()){
            $image->setProfile($profile);
            $entityManager->persist($image);
            $entityManager->flush();
            return $this->redirectToRoute('app_profile_edit', ['id' => $profile->getId()]);
        }
        return $this->render('profile/addImageProfile.html.twig', [
            'imageForm'=>$imageForm->createView(),
        ]);

    }
}
