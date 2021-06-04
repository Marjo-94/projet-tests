<?php

namespace App\Controller;

use App\Entity\Produit;
use App\Service\PanierService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class PanierController extends AbstractController {
    
    private $panierService;
    
    public function __construct(PanierService $panierService) {
        $this->panierService = $panierService;
    }

    // Initialisation pour récupération des informations pour gérer le panier
    public function index() {
        $panierWithItems = [];
        $panier = $this->panierService->getContenu();

        try {
            $prixTotal = $this->panierService->getTotal();
        } catch (\Exception $e) {
            throw $this->createNotFoundException($e->getMessage());
        }

        foreach ($panier as $id => $quantity) {
            $panierWithItems[] = [
                'item' => $this->getDoctrine()->getRepository(Produit::class)->findOneById($id),
                'quantity' => $quantity,
            ];
        }
        
        return $this->render('Panier\index.html.twig',
            [
                "panier" => $panierWithItems,
                "prix"   => $prixTotal,
            ]
        );
    }

    // Fonction d'ajout un produit 
    public function ajouter(int $idProduit) {
        try {
            $this->panierService->ajouterProduit($idProduit);
        } catch (\Exception $e) {
            throw $this->createNotFoundException($e->getMessage());
        }

        return $this->redirectToRoute('panier');
    }

    // Fonction de supression d'un produit 
    public function enlever(int $idProduit) {
        try {
            $this->panierService->enleverProduit($idProduit);
        } catch (\Exception $e) {
            throw $this->createNotFoundException($e->getMessage());
        }

        return $this->redirectToRoute('panier');
    }

    // Fonction de supression totale d'un produit du panier
    public function supprimer(int $idProduit) {
        try {
            $this->panierService->supprimerProduit($idProduit);
        } catch (\Exception $e) {
            throw $this->createNotFoundException($e->getMessage());
        }

        return $this->redirectToRoute('panier');
    }

    // Fonction permettant de vider entièrement le panier
    public function vider() {
        $this->panierService->vider();

        return $this->redirectToRoute('panier');
    }
}