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
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\Routing\Attribute\Route;

final class HomeController extends AbstractController
{
    #[Route('/home', name: 'home')]
    public function index(MailerInterface $mailer): Response
    {
        $email = (new Email())
            ->from('hellooooo@example.com')
            ->to('yooooou@example.com')
            //->cc('cc@example.com')
            //->bcc('bcc@example.com')
            //->replyTo('fabien@example.com')
            //->priority(Email::PRIORITY_HIGH)
            ->subject('Time for Symfony Mailer!')
            ->text('Sending emails is fun again!');
         //   ->html('<p>See Twig integration for better HTML integration!</p>');

        $mailer->send($email);
        return $this->redirectToRoute('app_posts');

    }




}
