<?php

namespace App\Controller;

use App\Entity\Produit;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class UserProduitController extends AbstractController
{
    /**
     * @Route("/user/produits", name="user_produit")
     */
    public function index(): Response
    {
        $user = $this->getUser();
        $array = $user->getPanier();
        return $this->render('user_produit/index.html.twig', [
            'panierComp' => $array
        ]);
    }

    /**
     * fonfion qui ajoute une ligne dans la tanble jointure produit user
     * @Route("user/ajoutpanier/{id}", name="panier_produit")
     * @return void
     */
    public function ajoutPanier(Produit $produit, EntityManagerInterface $manager)
    {
        $user = $this->getUser();
        $user->addPanier($produit);
        $manager->persist($user);
        $manager->flush();
        return $this->redirectToRoute('user_produit');
    }

    /**
     * supprime article
     * @Route("user/supArticle/{id}", name="supressionArt")
     * @return void
     */
    public function supArticle(Produit $produit, EntityManagerInterface $manager)
    {
        $user = $this->getUser();
        $user->removePanier($produit);
        $manager->flush();
        return $this->redirectToRoute('user_produit');
    }
}
