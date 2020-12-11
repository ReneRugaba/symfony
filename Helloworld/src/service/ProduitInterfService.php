<?php

namespace App\service;

use App\Entity\Produit;

interface ProduitInterfService
{

    public function findData(): array;

    public function trouveProduit(int $id): Produit;

    public function PersistProduit(Produit $produit): void;
}
