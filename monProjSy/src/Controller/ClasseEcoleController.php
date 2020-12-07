<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ClasseEcoleController extends AbstractController
{
    /**
     * @Route("/classe/ecole", name="classe_ecole")
     */
    public function index(): Response
    {
        return $this->render('classe_ecole/index.html.twig', [
            'controller_name' => 'ClasseEcoleController',
        ]);
    }
}
