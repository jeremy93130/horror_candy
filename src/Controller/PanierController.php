<?php

namespace App\Controller;

use App\Repository\BonbonRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Routing\Attribute\Route;

class PanierController extends AbstractController
{
    #[Route('/panier', name: 'app_panier')]
    public function index(Session $session): Response
    {
        $panier = $session->get('panier') ?? null;

        return $this->render('panier/index.html.twig', [
            'controller_name' => 'PanierController',
            'panier' => $panier
        ]);
    }

    #[Route('/addPanier', name: 'add_panier')]

    public function addPanier(Request $request, Session $session, BonbonRepository $bonbonRepository): JsonResponse
    {
        $data = json_decode($request->getContent(), true);
        $bonbon = $bonbonRepository->find($data);
        $panierSession = $session->get('panier', []);
        $nombreArticles = $session->get('nb', 0);
        $bonbonFound = false;

        foreach ($panierSession as &$panier) {
            // Accéder correctement à l'objet Bonbon stocké dans le panier
            if ($bonbon->getId() == $panier['bonbon']->getId()) {
                // Si le bonbon est déjà dans le panier, on incrémente la quantité
                $panier['quantity']++; // Incrémenter la quantité
                $bonbonFound = true; // Indiquer que le bonbon a été trouvé
                break; // Sortir de la boucle
            }
        }

        if (!$bonbonFound) {
            // Ajouter un nouveau bonbon avec une quantité initiale de 1
            $panierSession[] = [
                'bonbon' => $bonbon, // Stocker l'objet bonbon
                'quantity' => 1 // Initialiser la quantité à 1
            ];
            $nombreArticles++;
        }

        $session->set('panier', $panierSession);
        $session->set('nb', $nombreArticles);

        // Retourner une réponse JSON avec le nombre d'articles
        return new JsonResponse(['nombreArticles' => $nombreArticles]);
    }

    #[Route('/supp', name: 'app_supp')]
    public function removePanier(Request $request, Session $session): JsonResponse
    {
        $data = json_decode($request->getContent(), true);
        $panierSession = $session->get('panier', []);
        $nombreArticles = $session->get('nb', []);

        foreach ($panierSession as $key => &$panier) {
            if ($panier['bonbon']->getId() == $data) {
                unset($panierSession[$key]);
                $nombreArticles -= $panier['quantity'];
                break;
            }
        }

        $panierSession = array_values($panierSession); // On réindexe le tableau pour éviter les clés vides

        $session->set('panier', $panierSession);

        $session->get('nb') !== 0 ? $session->set('nb', $nombreArticles) : 0;

        return new JsonResponse(['nombreArticles' => $nombreArticles]);
    }
}
