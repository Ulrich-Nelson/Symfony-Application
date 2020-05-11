<?php

namespace App\Controller\Admin;

use App\Entity\Property;
use App\Form\PropertyType;
use App\Repository\PropertyRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AdminPropertyController extends AbstractController{

    private $repository;  
    private $em;        
         
     /**
      * __construct
      *
      * @param  mixed $repository
      * @param  mixed $em
      * @return void
      */
     public function __construct(PropertyRepository $repository, EntityManagerInterface $em)
    {
        $this->repository = $repository;
        $this->em = $em;
    }

    
    
    /**
     *@Route("/admin", name="admin.property.index")
     * @return Response (liste l'ensemble des biens de l'utilisateur)
     */
    public function index(): Response
    {
        $properties = $this->repository->findAll();
        return $this->render('admin/property/index.html.twig', compact('properties'));
        
    }


    /**
     *@Route("/admin/property/create", name="admin.property.new")
     * @param  mixed $request
     * @return Response qui est la création d'un nouveau bien
     */
    public function new(Request $request): Response
    {
        $property = new Property();
        $form = $this->createForm(PropertyType::class, $property);
        $form->handleRequest($request);

          if ($form->isSubmitted() && $form->isValid()) {
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
     * @return Response (un bien)
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
     * @return Response Response qui est la suppression d'un bien
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