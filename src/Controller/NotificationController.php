<?php

namespace App\Controller;

use App\Entity\Notification;
use App\Repository\NotificationRepository;
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


}
