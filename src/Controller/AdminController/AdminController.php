<?php

namespace App\Controller\AdminController;

use App\Repository\DesignRepository;
use App\Repository\ProduitRepository;
use App\Service\StatUse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;



class AdminController extends AbstractController
{


    private $statUse;


    function __construct(StatUse $statUse)
    {

        $this->statUse = $statUse;
    }
    #[Route('/admin', name: 'admin')]
    public function index(): Response
    {



        return $this->render('admin/index.html.twig', [
            'connected' => true,
        ]);
    }
    #[Route('/admin/weeklyStat', name: 'admin_weeklyStat')]
    public function weeklyStat(Request $request): Response
    {
        $data = json_decode($request->getContent(), true);
        $graphArray = $this->statUse->getWeeklyStat($data);
        return new JsonResponse(['graph' => $graphArray]);
    }

    #[Route('/admin/monthlyStat', name: 'admin_monthlyStat')]
    public function monthlyStat(Request $request): Response
    {

        $data = json_decode($request->getContent(), true);
        $graphArray = $this->statUse->getMonthlyStat($data);
        return new JsonResponse(['graph' => $graphArray]);
    }

    #[Route('/admin/yearlyStat', name: 'admin_yearlyStat')]
    public function yearlyStat(Request $request): Response
    {
        $data = json_decode($request->getContent(), true);

        $graphArray = $this->statUse->getYearlyStat($data);

        return new JsonResponse(['graph' => $graphArray]);
    }
}
