<?php

namespace App\Controller;

use App\Entity\Comment;
use App\Entity\Image;
use App\Entity\Post;
use App\Form\CommentForm;
use App\Form\PostForm;
use App\Form\UserImageForm;
use App\Repository\PostRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class PostController extends AbstractController
{
    #[Route('/posts', name: 'app_posts')]
    public function index(PostRepository $postRepository): Response
    {
        if(!$this->getUser()){
            return $this->redirectToRoute('app_login');
        }
        return $this->render('post/index.html.twig', [
            'posts'=> $postRepository->findAll(),
        ]);
    }

    #[Route('/posts/show/{id}', name: 'app_post_show')]
    public function show(Post $post): Response
    {
        $comment = new Comment();
        $commentForm = $this->createForm(CommentForm::class , $comment);
        return $this->render('post/show.html.twig', [
            'post' => $post,
            'commentForm' => $commentForm->createView(),
        ]);
    }

    #[Route('/post/edit/{id}', name: 'app_post_edit')]
    public function edit(Post $post, Request $request, EntityManagerInterface $manager, Image $image): Response
    {
        $form = $this->createForm(PostForm::class, $post);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $post->setImage($image);
            $manager->persist($post);
            $manager->flush();
            return $this->redirectToRoute('app_post_show', ['id' => $post->getId()]);
        }
        return $this->render('post/edit.html.twig', [
            'form' => $form,
            'post' => $post,
            'image' => $image,
        ]);

    }



    #[Route('/post/addImage', name: 'app_post_addImage')]
    public function addImage(Request $request, EntityManagerInterface $manager): Response
    {
        if(!$this->getUser()){
            return $this->redirectToRoute('app_login');
        }
        $image =new Image();
        $form = $this->createForm(UserImageForm::class, $image);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $manager->persist($image);
            $manager->flush();
            return $this->redirectToRoute('app_post_create',['id'=> $image->getId()]);

        }

        return $this->render('post/addImage.html.twig', [
            'form' => $form,
        ]);
    }

    #[Route('/post/create/{id}', name: 'app_post_create')]
    public function create(Request $request, EntityManagerInterface $manager, Image $image): Response
    {
        if(!$image || !$this->getUser()){
            return $this->redirectToRoute('app_login');
        }

        $post = new Post();
        $form = $this->createForm(PostForm::class, $post);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $post->setCreateAt(new \DateTime());
            $post->setAuthor($this->getUser()->getProfile());
            $post->setImage($image);
            $manager->persist($post);
            $manager->flush();
            return $this->redirectToRoute('app_posts');
        }
        return $this->render('post/create.html.twig', [
            'form' => $form,
            'image' => $image,

        ]);
    }

    #[Route('/post/delete/{id}', name: 'app_post_delete')]
    public function delete(Post $post, EntityManagerInterface $manager): Response
    {
        if (
            !$this->getUser() ||
            ($post->getAuthor()->getId() !== $this->getUser()->getId() && !in_array('ROLE_ADMIN', $this->getUser()->getRoles()))
        ) {
            return $this->redirectToRoute('app_login');
        }


        if (!$post) {
            return $this->redirectToRoute('app_posts');
        }

        $image = $post->getImage();
        if ($image) {
            $manager->remove($image);
        }

        $manager->remove($post);
        $manager->flush();

        return $this->redirectToRoute('app_posts');
    }

}
