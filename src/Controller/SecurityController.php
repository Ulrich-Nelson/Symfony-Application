<?php

namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;


class SecurityController extends AbstractController{

    /**
     * @Route("/login", name="login")
     * 
     * @return Response
     */

     public function login(AuthenticationUtils $authenticationUtils)
     {
         //permet de récupérer les dernières informations (user et error)
         $error = $authenticationUtils->getLastAuthenticationError();
         $lastUsername = $authenticationUtils->getLastUsername();
         return $this->render('security/login.html.twig', [
             'last_username' => $lastUsername,
             'error' => $error
         ]);
     }

    
    /**
     * @Route("/", name="logout ")
     * @return void
     */
    public function logout()
    {
        //ne retourne rien car permet la deconnexion
    }

}