<?php

namespace App\Controller;

use App\Entity\Post;
use App\Entity\Reaction;
use App\Repository\ReactionRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class ReactionController extends AbstractController
{
    #[Route('/post/reaction/{id}/{type}', name: 'reaction')]
    public function toggleReaction(EntityManagerInterface $entityManager, ReactionRepository $reactionRepository, Post $post, string $type): Response
    {
        if(!$this->getUser()){
            return $this->redirectToRoute('app_login');
        }
        $profile = $this->getUser()->getProfile();
        $isLiked = false;

        $reaction = $reactionRepository->findOneBy(['author' => $profile, 'post' => $post, 'type' => $type]);


        if($reaction){
            $entityManager->remove($reaction);
        } else{
            $reaction = new Reaction();
            $reaction->setPost($post);
            $reaction->setAuthor($profile);
            $reaction->setType($type);
            $entityManager->persist($reaction);
            $isLiked = true;

        }
        $entityManager->flush();

        return $this->json([
            'isLiked' => $isLiked,
            'likeCount' => $reactionRepository->count(['post' => $post, 'type' => 'like']),
            'loveCount' => $reactionRepository->count(['post' => $post, 'type' => 'love']),
        ]);



    }
}
