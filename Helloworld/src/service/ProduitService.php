<?php

namespace App\service;

use App\Entity\Produit;
use App\Repository\ProduitRepository;
use Doctrine\ORM\EntityManagerInterface;
use App\service\ProduitInterfService;
use Doctrine\DBAL\Exception;
use App\service\exception\ProduitServiceException;

class ProduitService implements ProduitInterfService
{

    private $produitRepository;
    private $manager;

    public function __construct(ProduitRepository $produitRepository, EntityManagerInterface $manager)
    {
        $this->produitRepository = $produitRepository;
        $this->manager = $manager;
    }

    public function findData(): array
    {
        try {
            return $this->produitRepository->findAll(Produit::class);
        } catch (Exception $e) {
            throw new ProduitServiceException($e->getMessage());
        }
    }

    public function trouveProduit(int $id): Produit
    {
        try {
            return $this->produitRepository->findOneById($id);
        } catch (Exception $e) {
            throw new ProduitServiceException($e->getMessage());
        }
    }

    public function PersistProduit(Produit $produit): void
    {
        try {
            $this->manager->persist($produit);
            $this->manager->flush();
        } catch (Exception $e) {
            throw new ProduitServiceException($e->getMessage());
        }
    }
}
