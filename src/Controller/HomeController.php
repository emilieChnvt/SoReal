<?php

namespace App\Controller;

use App\Entity\Image;
use App\Form\UserForm;
use App\Form\UserImageForm;
use App\Form\UserSearchForm;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class HomeController extends AbstractController
{
    #[Route('/home', name: 'app_home')]
    public function index(): Response
    {
        return $this->render('home/index.html.twig', [
            'controller_name' => 'HomeController',
        ]);
    }
    #[Route('/search', name: 'search')]
    public function search(Request $request, EntityManagerInterface $manager): Response
    {
        $image =new Image();
        $form = $this->createForm(UserImageForm::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $imageFile = $form->get('imageFile')->getData();
            if ($imageFile) {
                $image->setImageFile($imageFile);
            }
            $manager->persist($image);
            $manager->flush();

        }

        return $this->render('search/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }


}
