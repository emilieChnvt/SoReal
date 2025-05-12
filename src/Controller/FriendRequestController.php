<?php

namespace App\Controller;

use App\Entity\Friendship;
use App\Entity\FriendshipRequest;
use App\Entity\Profile;
use App\Form\UserSearchForm;
use App\Repository\FriendshipRequestRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class FriendRequestController extends AbstractController
{


    #[Route('/send/{id}', name: 'send_friend_request')]
    public function send(Profile $profile, EntityManagerInterface $entityManager, FriendshipRequestRepository $friendshipRequestRepository): Response
    {

        $sender = $this->getUser()->getProfile();
        $receiver = $profile;
        $friendRequest = new FriendshipRequest();
        $friendRequest->setSender($sender);
        $friendRequest->setReceiver($receiver);

        if(!$friendshipRequestRepository->findBy(['sender' => $sender, 'receiver' => $receiver])
            && !$friendshipRequestRepository->findBy(['sender' => $receiver, 'receiver' => $sender])
            && !$this->getUser()->getProfile()->isFriendWith($friendRequest->getReceiver())

        ){
            $entityManager->persist($friendRequest);
            $entityManager->flush();
        }




        return $this->redirectToRoute('profiles');
    }


    #[Route('/accept/{id}', name: 'accept_friend_request')]
    public function accept(FriendshipRequest $friendRequest, EntityManagerInterface $entityManager): Response
    {
        if(!$friendRequest){
            return $this->redirectToRoute('profiles');
        }
        $frienship = new Friendship();
        $frienship->setPersonA($friendRequest->getSender());
        $frienship->setPersonB($friendRequest->getReceiver());
        $entityManager->remove($friendRequest);
        $entityManager->persist($frienship);
        $entityManager->flush();

        return $this->redirectToRoute('profiles');
    }


    #[Route('decline/{id}', name: 'decline_friend_request')]
    public function decline(FriendshipRequest $friendRequest, EntityManagerInterface $entityManager): Response
    {
        if(!$friendRequest){
            return $this->redirectToRoute('profiles');
        }
        $entityManager->remove($friendRequest);
        $entityManager->flush();

        return $this->redirectToRoute('profiles');
    }

}
