<?php

namespace App\Controller;

use App\Entity\Produit;
use App\Form\AjoutProduitType;
use App\service\ProduitInterfService;
use Doctrine\ORM\EntityManagerInterface;
use App\service\exception\ProduitServiceException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AfficheProduitsController extends AbstractController
{

    public function __construct(ProduitInterfService $serviceprod)
    {
        $this->serviceprod = $serviceprod; //factorisation de l'instanciation des objet Produit service en passant par l'interface
    }

    /**
     * methode qui recupère toute les données de ma bd et les affiche
     * @Route("/produit", name="tableauProduit")
     */
    public function index(): Response
    {
        $this->denyAccessUnlessGranted('ROLE_USER');
        try {
            $arrayObject = $this->serviceprod->findData();
        } catch (ProduitServiceException $e) {
            return $this->render('affiche_produits/index.html.twig', [
                'produitTable' => [],
                'erreur' => 'une erreur vient de se produire, 
                il est pour le moment impossible d\'afficher les produits. 
                Merci de réessayer ulterieurement!'
            ]);
        }
        return $this->render('affiche_produits/index.html.twig', [
            'produitTable' => $arrayObject
        ]);
    }

    /**
     * cette methode ajoute et modifie selon la route appelée
     * @Route("/produit/formulaire", name="ajouter_formulaire")
     * @Route("/produit/formulaire/{id}", name="modif_form")
     */
    public function ajoutEtModif(?Produit $produit, Request $request): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');

        if (!$produit) {
            $produit = new Produit();
        }



        $form = $this->createForm(AjoutProduitType::class, $produit);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            try {
                $this->serviceprod->PersistProduit($produit);
            } catch (ProduitServiceException $e) {
                return $this->render('affiche_produits/index.html.twig', [
                    'produitTable' => [],
                    'erreur' => 'une erreur vient de se produire, merci de d\'essayer à nouveau ulterieurement!'
                ]);
            }
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
        $this->denyAccessUnlessGranted('ROLE_USER');
        try {
            $prod = $this->serviceprod->trouveProduit($id);
        } catch (ProduitServiceException $e) {
            return $this->render('affiche_produits/index.html.twig', [
                'produitTable' => [],
                'erreur' => 'une erreur vient de se produire, 
                merci de d\'essayer à nouveau ulterieurement!'
            ]);
        }
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
        $this->denyAccessUnlessGranted('ROLE_ADMIN');
        $prod = $this->serviceprod->trouveProduit($id);
        $manager->remove($prod);
        $manager->flush();
        return $this->redirectToRoute('tableauProduit');
    }
}
