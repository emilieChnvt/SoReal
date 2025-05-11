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
    #[Route('/', name: 'home')]
    public function index(): Response
    {
        return new Response('<h1>Bienvenue sur SoReal !</h1>');
    }




}
