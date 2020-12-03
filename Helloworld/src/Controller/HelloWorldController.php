<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HelloWorldController extends AbstractController
{
    /**
     * @Route("/teste/{id}", name="hello_world",requirements={"id"="\d+"})
     */
    public function index($id): Response
    {
        return $this->render('hello_world/index.html.twig', [
            'nom' => 'RUGABA Rene Jean ' . $id,
        ]);
    }
}
