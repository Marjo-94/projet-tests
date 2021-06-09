<?php
declare(strict_types=1);

namespace App\Tests\Services;

use App\Entity\Produit;
use App\Repository\ProduitRepository;
use PHPUnit\Framework\TestCase;
use App\Service\PanierService;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Doctrine\ORM\EntityManagerInterface;

final class PanierServiceTest extends TestCase
{
    // Test si le constructeur donne bien une instance de PanierService
    public function testCanBeCreated(): void
    {
        $session = $this->createMock(SessionInterface::class);
        $entityManager = $this->createMock(EntityManagerInterface::class);
        $produitRepository = $this->createMock(ProduitRepository::class);

        $panierService = new PanierService($session, $produitRepository, $entityManager);

        $this->assertInstanceOf(
            PanierService::class,
            $panierService
        );
    }

    // Test de la fontion getContenu
    public function testGetContenu(){

        $session = $this->createMock(SessionInterface::class);
        $session->method('get')->willReturn([2 => 12, 1 => 15]);
        //$session->expects($this->exactly(1))->method('set')->with('panier', [2 => 12, 1 => 15]);

        $entityManager = $this->createMock(EntityManagerInterface::class);
        $produitRepository = $this->createMock(ProduitRepository::class);

        $panier = new PanierService($session, $produitRepository, $entityManager);
        $panier->getContenu();

    }

    // Test de la fonction EnleverProduit
    public function testPanierEnleverProduit(){

        $session = $this->createMock(SessionInterface::class);
        $session->method('get')->willReturn([2 => 2, 1 => 12]);
        $session->expects($this->exactly(1))->method('set')->with('panier', [2 => 1, 1 => 12]);

        $entityManager = $this->createMock(EntityManagerInterface::class);

        $produitRepository = $this->getMockBuilder(ProduitRepository::class)
            ->disableOriginalConstructor()
            ->setMethods(['findOneById'])
            ->getMock();

        // Configurer le bouchon.
        $produitRepository->method('findOneById')
            ->willReturn(true);

        $panier = new PanierService($session, $produitRepository, $entityManager);
        $panier->enleverProduit(2, 1);
    }

    // Test de la fonction vider
    public function testVider(){

        $session = $this->createMock(SessionInterface::class);
        $session->method('get')->willReturn([2 => 12, 1 => 15]);
        $session->expects($this->exactly(1))->method('set')->with('panier', []);

        $entityManager = $this->createMock(EntityManagerInterface::class);
        $produitRepository = $this->createMock(ProduitRepository::class);

        $panier = new PanierService($session, $produitRepository, $entityManager);
        $panier->vider();
    }

    // Test de la fonction supprimerProduit
    public function testSupprimerProduit(){

        $session = $this->createMock(SessionInterface::class);
        $session->method('get')->willReturn([ 2 => 1, 1 => 12]);
        $session->expects($this->exactly(1))->method('set')->with('panier', [1 => 12]);

        $entityManager = $this->createMock(EntityManagerInterface::class);

        $produitRepository = $this->getMockBuilder(ProduitRepository::class)
            ->disableOriginalConstructor()
            ->setMethods(['findOneById'])
            ->getMock();

        // Configurer le bouchon.
        $produitRepository->method('findOneById')
            ->willReturn(true);

        $panier = new PanierService($session, $produitRepository, $entityManager);
        $panier->supprimerProduit(2);
    }

}