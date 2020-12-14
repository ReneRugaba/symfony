<?php

namespace App\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProfilUserController extends AbstractController
{
    /**
     * @Route("/profil", name="profil_user")
     */
    public function index(): Response
    {
        $user = $this->getUser();
        return $this->render('profil_user/index.html.twig', [
            'ProfilUser' => $user
        ]);
    }
}
