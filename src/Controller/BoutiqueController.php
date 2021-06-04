<?php

namespace App\Controller;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Entity\Produit;
use App\Entity\Categorie;

class BoutiqueController extends AbstractController {
    //index
    public function index() {
        $categories = $this->getDoctrine()->getRepository(\App\Entity\Categorie::class)->findAll();
        $numberOfCategories = sizeof($this->getDoctrine()->getRepository(\App\Entity\Categorie::class)->findAll());

        return $this->render('boutique.html.twig', [
            "categories" => $categories,
            "numberOfCategories" => $numberOfCategories
        ]);
    }
    
    // Récupération des données pour l'affichage d'un rayon d'une catégorie
    public function rayon(int $idCategory) {
        $nameOfCategory = $this->getDoctrine()->getRepository(\App\Entity\Categorie::class)->find($idCategory);
        $products = $this->getDoctrine()->getRepository(\App\Entity\Produit::class)->findByIdCategorie($idCategory);

        return $this->render('rayon.html.twig', [
            "products" => $products,
            "numberOfProducts" => sizeof($products),
            "nameOfCategory" => $nameOfCategory
        ]);
    }
}
