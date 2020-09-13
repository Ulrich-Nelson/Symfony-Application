<?php

namespace App\Controller\Admin;

use App\Entity\User;
use App\Entity\Property;
use App\Form\EditProfileType;
use App\Form\PropertyType;
use App\Repository\PropertyRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

//controller idéal pour faire le traitement
class AdminPropertyController extends AbstractController{

    private $repository;  
    private $em;  
    private $userSecurity;  //accéder au information de l'utilisateur connecté.

         
     /**
      * __construct
      *
      * @param  mixed $repository
      * @param  mixed $em
      * @return void
      */
     public function __construct(PropertyRepository $repository,  EntityManagerInterface $em, Security $userSecurity)
    {
        $this->repository = $repository;
        $this->em = $em;
        $this->userSecurity = $userSecurity;
    }


    /**
     *@Route("/admin", name="admin.property.index")
     * @return Response liste l'ensemble des biens de l'utilisateur
     */
    public function index(): Response
    {
        $properties = $this->repository->findAll();
        return $this->render('admin/property/index.html.twig', compact('properties'));
        
    }


    /**
     *@Route("/admin/profile", name="admin.profile.view")
     * @return Response (affiche les informations d'un utilisateur connecté)
     */
    public function profile(): Response
    {
        return $this->render('admin/profile/profile.html.twig');
    }


    /**
     *@Route("/admin/profile/{id}", name="admin.profile.edit")
     * @return Response éditer le profil de l'utilisateur
     */
    public function editProfile(Request $request): Response
    {
        $user = $this->getUser();
        $form = $this->createForm(EditProfileType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->em->persist($user);
            $this->em->flush();
            $this->addFlash('success', 'Votre profil a bien été modifié ');

            return $this->redirectToRoute('admin.profile.view');
        }
        return $this->render('admin/profile/editProfile.html.twig', [
            'form' => $form->createView()
        ]);
    }


    /**
     *@Route("/admin/property/create", name="admin.property.new")
     * @param  mixed $request
     * @return Response  la création d'un nouveau bien
     */
    public function new(Request $request): Response
    {
        $property = new Property();
        $form = $this->createForm(PropertyType::class, $property);
        $form->handleRequest($request);
          if ($form->isSubmitted() && $form->isValid()) {
            //associer un utilisateur à son bien avant l'injection dans la base de données.
            $userId = $this->userSecurity->getUser();
            $property->setUser($userId);
            $this->em->persist($property);
            $this->em->flush();
            $this->addFlash('success', 'Bien créé avec succès');

            return $this->redirectToRoute('admin.property.index');
        }
        //et si rien n'a été posté, on rend tout simplement cette page
        return $this->render('admin/property/new.html.twig', [
            'property' => $property,
            'form' => $form->createView()
        ]);

    }


    /**
     * @Route("/admin/property/{id}", name="admin.property.edit", methods="GET|POST")
     * @param  mixed $property
     * @param  mixed $request traitement du formulaire
     * @return Response modifier un bien 
     */
    public function edit(Property $property, Request $request):Response
    {
        $form = $this->createForm(PropertyType::class, $property);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->em->flush();
            $this->addFlash('success', 'Bien modifié avec succès');
            return $this->redirectToRoute('admin.property.index');
        }

        return $this->render('admin/property/edit.html.twig', [
            'property' => $property,
            'form' => $form->createView()
        ]);
    }


    /**
     * @Route("/admin/property/{id}", name="admin.property.delete", methods="DELETE")
     * @param  mixed $property
     * @param  mixed $request
     * @return Response la suppression d'un bien
     */
    public function delete (Property $property, Request $request):Response
    {   //cette condition permet de faire la vérification du formualaire fait à la main
        if ($this->isCsrfTokenValid('delete' . $property->getId(), $request->get('_token'))) {
            $this->em->remove($property);
            $this->em->flush();
            $this->addFlash('success', 'Bien supprimé avec succès');

        }
        return $this->redirectToRoute('admin.property.index');
   
}

}