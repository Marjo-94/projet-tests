<?php
// Controller/DefaultController.php
namespace App\Controller;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

use App\Entity\Produit;
use App\Entity\Categorie;

class DefaultController extends AbstractController {
    //index
    public function index(){
        return $this->render('base.html.twig');
    }
    
    //contact
    public function contact(){
        return $this->render('contact.html.twig', [
            "titre" => "Contact",
        ]);
    }
    
    //boutique
    public function boutique(){
        return $this->render('boutique.html.twig', [
            "titre" => "Boutique",
        ]);
    }
    
    //panier
    public function panier(){
        return $this->render('panier.html.twig', [
            "titre" => "Panier",
        ]);
    }
    
    //hello
    public function hello($userName) {
        return $this->render('hello.html.twig', ['userName' => $userName, ]);
    }
    
    //hello
    public function connexion() {
        return $this->render('Security\login.html.twig');
    }
}
