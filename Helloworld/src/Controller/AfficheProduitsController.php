<?php

namespace App\Controller;

use App\Entity\Produit;
use App\Form\AjoutProduitType;
use App\service\ProduitService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AfficheProduitsController extends AbstractController
{

    private $service;

    public function __construct(ProduitService $serviceprod)
    {
        $this->serviceprod = $serviceprod;
    }
    /**
     * @Route("/produit", name="tableauProduit")
     */
    public function index(): Response
    {
        $arrayObject = $this->serviceprod->findData();
        return $this->render('affiche_produits/index.html.twig', [
            'produitTable' => $arrayObject
        ]);
    }

    /**
     * cette methode ajoute et modifie selon la route appelé
     * @Route("/produit/formulaire", name="ajouter_formulaire")
     * @Route("/produit/formulaire/{id}", name="modif_form")
     */
    public function ajoutEtModif(?Produit $produit, Request $request, EntityManagerInterface $manager): Response
    {
        if (!$produit) {
            $produit = new Produit();
        }



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
     * recupère et affiche un produit en détail
     * @Route("/produit/details/{id}", name="details_produit")
     */
    public function searchByOne($id)
    {
        $prod = $this->serviceprod->trouveProduit($id);
        return $this->render('affiche_produits/details.html.twig', [
            'prodDetails' => $prod
        ]);
    }

    /**
     * methode qui supprime un element dans la base de donnée
     * @Route("/produit/delete/{id}", name="supprimer_produit")
     */
    public function delete($id, EntityManagerInterface $manager)
    {
        $prod = $this->serviceprod->trouveProduit($id);
        $manager->remove($prod);
        $manager->flush();
        return $this->redirectToRoute('tableauProduit');
    }
}
