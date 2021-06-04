<?php

namespace App\DataFixtures;

use App\Entity\Categorie;
use App\Entity\Produit;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Repository\ProduitRepository;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $categorie = new Categorie();
        $categorie->setLibelle('Test');

        $manager->persist($categorie);

        $produit = new Produit();
        $produit->setPrix(2,00);
        $produit->setIdCategorie($categorie);
        $produit->setLibelle('Test');
        $produit->setTexte('Test');

        $manager->persist($produit);

        $manager->flush();
    }

}
