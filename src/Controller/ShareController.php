<?php

namespace App\Controller;

use App\Entity\Conversation;
use App\Entity\Message;
use App\Entity\Post;
use App\Entity\Share;
use App\Repository\ConversationRepository;
use App\Repository\PostRepository;
use App\Repository\ProfileRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Routing\Generator\UrlGenerator;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

final class ShareController extends AbstractController
{
    #[Route('/share/{id}', name: 'app_share')]
    public function shareWith(Post $post): Response
    {
        return $this->render('share/index.html.twig', [
            'post' => $post,
        ]);
    }

    #[Route('/share/{post}/{recipientId}', name: 'share_with')]
    public function share(EntityManagerInterface $manager, UrlGeneratorInterface $generator, Post $post, $recipientId, ProfileRepository $profileRepository): Response
    {
        if(!$post){return $this->redirectToRoute('app_posts');}
        $recipient = $profileRepository->find($recipientId);

        $postUrl = $generator->generate('app_post_show', ['id' => $post->getId()], UrlGeneratorInterface::ABSOLUTE_URL);


        $share = new Share();
        $share->setPost($post);
        $share->setSender($this->getUser()->getProfile());
        $share->setRecipient($recipient);
        $manager->persist($share);
        $manager->flush();

        $conversation = $this->getUser()->getProfile()->isChattingWith($recipient);

        if(!$conversation)
        {
            $conversation = new Conversation();
            $conversation->addPartcipant($this->getUser()->getProfile());
            $conversation->addPartcipant($recipient);
            $conversation->setCreateAt(new \DateTime());
            $manager->persist($conversation);
            $manager->flush();
        }

        $message = new Message();
        $message->setAuthor($this->getUser()->getProfile());
        $message->setConversation($conversation);
        $message->setContent("📎 Post partagé : $postUrl");
        $message->setCreateAt(new \DateTimeImmutable());
        $message->setType(2);
        $manager->persist($message);
        $manager->flush();

        return $this->redirectToRoute('app_chat', ['id' => $conversation->getId()]);
    }
}
