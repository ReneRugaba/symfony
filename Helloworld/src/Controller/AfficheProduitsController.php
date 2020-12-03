<?php

namespace App\Controller;

use App\Entity\Produit;
use App\Repository\ProduitRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AfficheProduitsController extends AbstractController
{
    /**
     * @Route("/produit", name="tableauProduit")
     */
    public function index(ProduitRepository $produit): Response
    {
        $arrayObject = $produit->findAll(Produit::class);
        return $this->render('affiche_produits/index.html.twig', [
            'produitTable' => $arrayObject
        ]);
    }

    /**
     * @Route("/produit/formulaire", name="formulaire")
     */
    public function ajout(): Response
    {
        return $this->render('affiche_produits/ajout.html.twig', [
            'variable' => 'CECI EST UN FORMULAIRE',
        ]);
    }

    /**
     * @Route("/produit/details/{id}", name="detailsProduit",requirements={"id"="\D+"})
     */
    public function detailsProduit($id): Response
    {
        return $this->render('affiche_produits/details.html.twig', [
            'produit' => $id,
        ]);
    }
}
