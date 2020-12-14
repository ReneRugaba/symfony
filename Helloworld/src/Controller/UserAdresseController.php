<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\UserAdresse;
use App\Form\UserAdressType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class UserAdresseController extends AbstractController
{
    /**
     * @Route("/useradresse/{id}", name="user_adresse")
     */
    public function index(Request $request, EntityManagerInterface $manager, ?UserAdresse $userAdresse, User $user): Response
    {
        if (!$userAdresse) {
            $userAdresse = new UserAdresse();
        }
        $user = $this->getUser();
        $adressForm = $this->createForm(UserAdressType::class, $userAdresse);
        $adressForm->handleRequest($request);
        if ($adressForm->isSubmitted() && $adressForm->isValid()) {
            $user->setAdresse($userAdresse);
            $manager->persist($user);
            $manager->flush();
            return $this->redirectToRoute('profil_user');
        }
        return $this->render('user_adresse/adresseuser.html.twig', [
            'UserAdresse' => $adressForm->createView()
        ]);
    }
}
