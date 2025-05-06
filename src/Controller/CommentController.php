<?php

namespace App\Controller;

use App\Entity\Comment;
use App\Entity\Post;
use App\Form\CommentForm;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class CommentController extends AbstractController
{
    #[Route('/comment', name: 'app_comment')]
    public function index(): Response
    {
        return $this->render('comment/index.html.twig', [
            'controller_name' => 'CommentController',
        ]);
    }

    #[Route('/comment/{id}', name: 'app_comment_create')]
    public function create(EntityManagerInterface $manager, Request $request, Post $post): Response
    {
        if(!$this->getUser()){
            return $this->redirectToRoute('app_login');
        }
        $comment = new Comment();
        $commentForm = $this->createForm(CommentForm::class , $comment);
        $commentForm->handleRequest($request);
        if($commentForm->isSubmitted() && $commentForm->isValid()){
            $comment->setAuthor($this->getUser()->getProfile());
            $comment->setPost($post);
            $manager->persist($comment);
            $manager->flush();
        }
        return $this->redirectToRoute('app_post_show', ['id' => $comment->getPost()->getId()]);

    }
}
