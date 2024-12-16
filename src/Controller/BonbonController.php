<?php

namespace App\Controller;

use App\Repository\BonbonRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class BonbonController extends AbstractController
{
    #[Route('/bonbon', name: 'app_bonbon')]
    public function index(BonbonRepository $bonbonRepository): Response
    {
        $bonbons = $bonbonRepository->findAll();
        // dd($bonbons); 
        return $this->render('bonbon/index.html.twig', [
            'controller_name' => 'BonbonController',
            'bonbons' => $bonbons
        ]);
    }

    #[Route('/detailsBonbons/{id}', name: 'app_detail')]

    public function details(BonbonRepository $bonbonbonRepository, int $id): Response
    {
        $bonbon = $bonbonbonRepository->find($id);
        return $this->render('bonbon/details.html.twig', [
            'bonbon' => $bonbon
        ]);
    }
}
