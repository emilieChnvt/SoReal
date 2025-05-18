<?php

namespace App\Controller;

use App\Entity\Notification;
use App\Repository\NotificationRepository;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class NotificationController extends AbstractController
{
    #[Route('/notifications', name: 'app_notifications')]
    public function index(NotificationRepository $notificationRepository): Response
    {
        $notifications = $this->getUser()->getProfile()->getNotifications();
        return $this->render('notification/index.html.twig', [
            'notifications' => $notifications,
        ]);
    }

    #[Route('notification/{id}', name: 'app_notification_isseen')]
    public function isSeen(Notification $notification, EntityManagerInterface $manager): Response
    {
        if (!$this->getUser()) {
            return $this->redirectToRoute('app_login');
        }

        if ($notification->getAuthor() == $this->getUser()->getProfile()) {
            return $this->redirectToRoute('app_login');
        }
        if (!$notification->isSeen()) {
            $notification->setIsSeen(true);
            $manager->remove($notification);
            $manager->flush();
        }

        return $this->json(['isSeen' => $notification->isSeen()]);

    }
}