<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\RegistrationType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class SecurityController extends AbstractController
{
    /**
     * @var UserPasswordEncoderInterface
     */
    private $encoder;

    public function __construct(UserPasswordEncoderInterface $encoder)
    {
        $this->encoder = $encoder;
    }
    /**
     * @Route("/inscription", name="security_registration")
     */
     public  function registration(Request $request, EntityManagerInterface $manager)
     {
         $user = new User();

         $form = $this->createForm(RegistrationType::class, $user);
         $form->handleRequest($request);

         if ($form->isSubmitted() && $form->isValid()) {   
          $user->setPassword($this->encoder->encodePassword($user, $user->getPassword()));

          $manager->persist($user);
          $manager->flush();
          return $this->redirectToRoute('login');
         }

         return $this->render('security/registration.html.twig',[
            'controller_name' => 'SecurityController',
            'form' => $form->createView()

         ]);

     }


    /**
     * @Route("/login", name="login")
     */
    public function login(AuthenticationUtils $authenticationUtils)
    {
        $error = $authenticationUtils->getLastAuthenticationError();
        $lastUsername = $authenticationUtils->getLastUsername();
 
        return $this->render('security/login.html.twig', [
            'controller_name' => 'SecurityController',
            'last_username' => $lastUsername,
            'error' => $error

        ]);

    }


    /**
     * @Route("/Deconnexion", name="logout")
     */
    public function logout()
    {
        $this->addFlash('success', 'Vous êtes bien déconnecté...');
        return $this->render('security/login.html.twig', [
            'controller_name' => 'SecurityController',
            
        ]);
    }
    
}
