<?php

namespace App\Controller;

use App\Entity\User;
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
    public function index(UserRepository $userRepository, ChartBuilderInterface $chartBuilder): Response
    {
        $chart = $chartBuilder->createChart(Chart::TYPE_LINE);

        $chart->setData([
            'labels' => ['January', 'February', 'March', 'April', 'May', 'June', 'July'],
            'datasets' => [
                [
                    'label' => 'My First dataset',
                    'backgroundColor' => 'rgb(255, 99, 132)',
                    'borderColor' => 'rgb(255, 99, 132)',
                    'data' => [0, 10, 5, 2, 20, 30, 45],
                ],
            ],
        ]);

        $chart->setOptions([
            'scales' => [
                'y' => [
                    'suggestedMin' => 0,
                    'suggestedMax' => 100,
                ],
            ],
        ]);

        return $this->render('admin/index.html.twig', [
            'users'=> $userRepository->findAll(),
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
