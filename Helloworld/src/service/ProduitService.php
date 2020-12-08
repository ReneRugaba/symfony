<?php

namespace App\service;

use App\Repository\ProduitRepository;

class ProduitService
{

    private $produitRepository;

    public function __construct(ProduitRepository $produitRepository)
    {
        $this->produitRepository = $produitRepository;
    }

    public function findData()
    {
        return $this->produitRepository->findAll(Produit::class);
    }

    public function searchById($id)
    {
        return $this->produitRepository->findOneById($id);
    }

    public function trouveProduit($id)
    {
        return $this->produitRepository->findOneById($id);
    }
}
