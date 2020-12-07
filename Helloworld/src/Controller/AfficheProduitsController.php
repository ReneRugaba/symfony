<?php

namespace App\Controller;

use App\Entity\Produit;
use App\Form\AjoutProduitType;
use App\Repository\ProduitRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
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
     * @Route("/produit/formulaire", name="ajouter_formulaire")
     */
    public function ajout(Request $request, EntityManagerInterface $manager): Response
    {
        $produit = new Produit();

        $form = $this->createForm(AjoutProduitType::class, $produit);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $manager->persist($produit);
            $manager->flush();

            return $this->redirectToRoute('tableauProduit');
        }
        return $this->render('affiche_produits/ajout.html.twig', [
            'monForm' => $form->createView()
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
