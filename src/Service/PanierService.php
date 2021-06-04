<?php

namespace App\Service;

use App\Repository\ProduitRepository;
use Doctrine\ORM\EntityManagerInterface;
use Exception;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class PanierService {

    const PANIER_SESSION = 'panier';

    private $session;
    private $produRepo;
    private $panier;
    private $entMana;

    /**
     * PanierService constructor.
     *
     * @param SessionInterface       $session
     * @param ProduitRepository      $produRepo
     * @param EntityManagerInterface $entMana
     */
    public function __construct(
        SessionInterface $session,
        ProduitRepository $produRepo,
        EntityManagerInterface $entMana
    ) {
        $this->session = $session;
        $this->produRepo = $produRepo;
        $this->panier = $this->session->get(self::PANIER_SESSION, []);
        $this->entMana = $entMana;
    }

    /**
     * @return array
     */
    public function getContenu(): array
    {
        return $this->session->get(self::PANIER_SESSION, []);
    }

    /**
     * @return float
     * @throws Exception
     */
    public function getTotal(): float {
        $total = 0;
        foreach ($this->getContenu() as $id => $quantity) {
            $this->verifierProduitExiste($id);
            $total += $this->produRepo->findOneById($id)->getPrix() * $quantity;
        }
        return $total;
    }

    /**
     * @return int
     */
    public function getNbProduits(): int {
        $nbProduits = 0;
        foreach ($this->getContenu() as $quantity) {
            $nbProduits += $quantity;
        }
        return $nbProduits;
    }

    public function getNbProduit(int $productId): int {
        if (isset($this->getContenu()[$productId])) {
            return $this->getContenu()[$productId];
        } else {
            return 0;
        }
    }

    /**
     * @param int $idProduit
     * @param int $quantity
     *
     * @throws Exception
     */
    public function ajouterProduit(int $idProduit, int $quantity = 1): void {
        $this->verifierProduitExiste($idProduit);
        if (isset($this->panier[$idProduit])) {
            $this->panier[$idProduit] += $quantity;
        } else {
            $this->panier[$idProduit] = $quantity;
        }
        $this->session->set(self::PANIER_SESSION, $this->panier);
    }

    /**
     * @param int $idProduit
     * @param int $quantity
     *
     * @throws Exception
     */
    public function enleverProduit(int $idProduit, int $quantity = 1): void {
        $this->verifierProduitExiste($idProduit);
        if (isset($this->panier[$idProduit])) {
            $initialQuantity = $this->panier[$idProduit];
        } else {
            $initialQuantity = 0;
        }
        if ($initialQuantity !== null && $initialQuantity > $quantity) {
            $this->panier[$idProduit] -= $quantity;
        } else {
            unset($this->panier[$idProduit]);
        }
        $this->session->set(self::PANIER_SESSION, $this->panier);
    }

    /**
     * @param int $idProduit
     *
     * @throws Exception
     */
    public function supprimerProduit(int $idProduit): void {
        $this->verifierProduitExiste($idProduit);
        unset($this->panier[$idProduit]);
        $this->session->set(self::PANIER_SESSION, $this->panier);
    }

    public function vider(): void {
        $this->panier = [];
        $this->session->set(self::PANIER_SESSION, $this->panier);
    }

    /**
     * @param int $productId
     *
     * @throws Exception
     */
    private function verifierProduitExiste(int $productId) {
        if (!$this->produRepo->findOneById($productId)) {
            throw new Exception('Le produit n\'existe pas');
        }
    }
}