<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\SubscribeType;
use App\service\UserServiceInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use App\service\exception\UserServiceException;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserAuthController extends AbstractController
{
    public function __construct(UserServiceInterface $serviceUser)
    {
        $this->serviceUser = $serviceUser;
    }

    /**
     * @Route("/", name="app_login")
     */
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        // if ($this->getUser()) {
        //     return $this->redirectToRoute('tableauProduit');
        // }

        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('security/login.html.twig', ['last_username' => $lastUsername, 'error' => $error]);
    }

    /**
     * @Route("/logout", name="app_logout")
     */
    public function logout()
    {
        throw new \LogicException('This method can be blank - it will be intercepted by the logout key on your firewall.');
    }

    /**
     * @Route("/souscrire", name="subscribe_user")
     */
    public function register(Request $resquest, UserPasswordEncoderInterface $encode)
    {
        $user = new User();

        $form = $this->createForm(SubscribeType::class, $user);
        $form->handleRequest($resquest);
        if ($form->isSubmitted() && $form->isValid()) {
            $pass = $encode->encodePassword($user, $user->getPassword());
            $user->setPassword($pass);
            try {
                $this->serviceUser->registerUser($user);
            } catch (UserServiceException $e) {
                return $this->render('security/souscrire.html.twig', [
                    'erreur' => 'une erreur vient de se produire, merci de d\'essayer à nouveau ulterieurement!'
                ]);
            }
            $this->addFlash(
                "success",
                "Votre inscribtion a été validé avec succès! Vous pouvez desormais vous connecter en toute sécurité!"
            );
            return $this->redirectToRoute('app_login');
        }
        return $this->render('security/souscrire.html.twig', [
            'form_sub' => $form->createView()
        ]);
    }
}
