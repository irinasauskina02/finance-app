<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Service\HomePageService;

class HomePageController extends AbstractController
{
    #[Route('/', name: 'app_home_page')]
    public function index(): Response
    {
        $userId = 1;
        $service = new HomePageService($userId);
        $income = $service->getIncome();
        $expense = $service->getExpense();

        if($userId === 1) {
            return $this->render('home_page/index.html.twig', [
                'controller_name' => 'HomePageController',
                'income' => $income,
                'expense' => $expense
            ]);
        } else {
            return $this->render('home_page/login.html.twig', []);
        }
    }
}
