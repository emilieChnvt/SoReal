<?php

namespace App\Controller;

use App\Entity\User;
use App\Repository\PostRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\UX\Chartjs\Builder\ChartBuilderInterface;
use Symfony\UX\Chartjs\Model\Chart;

#[Route('/admin/')]
final class AdminController extends AbstractController
{
    #[Route('', name: 'app_admin')]
    public function index(
        UserRepository $userRepository,
        PostRepository $postRepository,
        ChartBuilderInterface $chartBuilder
    ): Response {
        $postStats = $postRepository->countPostsByProfile();

        $labels = array_column($postStats, 'displayName');
        $data = array_column($postStats, 'post_count');

        $chart = $chartBuilder->createChart(Chart::TYPE_BAR);
        $chart->setData([
            'labels' => $labels,
            'datasets' => [[
                'label' => 'Nombre de posts par profil',
                'backgroundColor' => 'rgba(75, 192, 192, 0.5)',
                'borderColor' => 'rgba(75, 192, 192, 1)',
                'borderWidth' => 1,
                'data' => $data,
            ]],
        ]);

        $chart->setOptions([
            'scales' => [
                'y' => [
                    'beginAtZero' => true,
                ],
            ],
        ]);
        return $this->render('admin/index.html.twig', [
            'users' => $userRepository->findAll(),
            'chart' => $chart,
        ]);
    }

    #[Route('promote/{id}', name: 'app_promote')]
    public function promote(User $user, EntityManagerInterface $entityManager): Response
    {
        if(!in_array('ROLE_ADMIN', $user->getRoles())){
            $user->setRoles(['ROLE_ADMIN']);
            $entityManager->persist($user);
            $entityManager->flush();

        }
        return $this->redirectToRoute('app_admin');
    }

    #[Route('demote/{id}', name: 'app_demote')]
    public function demote(User $user, EntityManagerInterface $entityManager): Response
    {
        if(in_array('ROLE_ADMIN', $user->getRoles())){
            $user->setRoles(['']);
            $entityManager->persist($user);
            $entityManager->flush();
        }
        return $this->redirectToRoute('app_admin');
    }
}
