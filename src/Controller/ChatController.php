<?php

namespace App\Controller;

use App\Entity\Conversation;
use App\Entity\Message;
use App\Entity\Notification;
use App\Entity\Profile;
use App\Form\MessageForm;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class ChatController extends AbstractController
{
    #[Route('/chat/initiate/{id}', name: 'app_chat_initiate')]
    public function initiate(Profile $profile, EntityManagerInterface $entityManager): Response
    {
        if(!$profile){return $this->redirectToRoute('profiles');}

        $conversation = $this->getUser()->getProfile()->isChattingWith($profile);
        if(!$conversation)
        {
          $conversation = new Conversation();
          $conversation->addPartcipant($profile);
          $conversation->addPartcipant($this->getUser()->getProfile());
          $conversation->setCreateAt(new \DateTime());
          $entityManager->persist($conversation);
          $entityManager->flush();

        }

        return $this->redirectToRoute('app_chat', ['id' => $conversation->getId()]);
    }

    #[Route('/chat/{id}', name: 'app_chat')]
    public function chat(Conversation $chat, Request $request, EntityManagerInterface $manager): Response
    {
        if (!$chat) {
            return $this->redirectToRoute('profiles');
        }

        foreach ($chat->getPartcipants() as $participant) {
            if ($participant !== $this->getUser()->getProfile()) {
                $receiver = $participant;
            }
        }

        $message = new Message();
        $form = $this->createForm(MessageForm::class, $message);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $message->setCreateAt(new \DateTimeImmutable());
            $message->setAuthor($this->getUser()->getProfile());
            $message->setConversation($chat);
            $manager->persist($message);



            $notification =new Notification();
            $notification->setCreateAt(new \DateTime());
            $notification->setType(3);
            $notification->setContent('message sent');
            $notification->setProfile($receiver);
            $notification->setMessageNotification($message);
            $manager->persist($notification);

            $manager->flush();

            return $this->redirectToRoute('app_chat', ['id' => $chat->getId()]);
        }

        return $this->render('chat/chat.html.twig', [
            'chat' => $chat,
            'form' => $form,
            'receiver' => $receiver,
        ]);
    }


}
