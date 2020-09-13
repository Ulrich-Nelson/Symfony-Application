<?php

namespace App\Controller;

use App\Entity\Contact;
use App\Entity\Property;
use App\Form\ContactType;
use App\Entity\PropertySearch;
use App\Form\PropertySearchType;
use App\Repository\PropertyRepository;
use App\Notification\ContactNotification;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Common\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class PropertyController extends AbstractController
{    
   
    private $repository;    
    private $em;
    
    public function __construct(PropertyRepository $repository, ManagerRegistry $em)
    {
        $this->repository = $repository;
        $this->em = $em;

    }
    
    /**
     * @Route("/biens", name="property.index")
     * 
     * @return Response liste l'ensemble des biens de l'application
     */
    public function index(PaginatorInterface $paginator, Request $request): Response
    {
        
        //traitement de la recherche d'un bien
        $search = new PropertySearch();
        $form = $this->createForm(PropertySearchType::class,  $search);
        $form->handleRequest($request);

        //système de pagination
        $properties = $paginator->paginate(
        $this->repository->findAllVisibleQuery($search),
        $request->query->getInt('page', 1),
        12);
        
        return $this->render('property/index.html.twig', [
            'controller_name' => 'PropertyController',
            //pour rendre le boutton actif au clique mais il sera modifier
            'current_menu' => 'properties',
            'properties' => $properties,
            'form' => $form->createView()

        ]);
    }

    /**
     * @Route("/biens/{slug}-{id}", name="property.show", requirements={"slug": "[a-z0-9\-]*"})
     *
     * @return Response afficher les détails d'un bien en particulier
     */
    public function show(Property $property, string $slug, Request $request, ContactNotification $notification):Response
    {
       
        if ($property->getSlug() !== $slug) {
            return $this->redirectToRoute('property.show', [
                'id' => $property->getId(),
                'slug' => $property->getSlug()
            ], 301);
        }

         //création du formulaire de contact
        $contact = new Contact();
        $contact->setProperty($property);
        $form = $this->createForm(ContactType::class, $contact);
        $form->handleRequest($request);
        

        //traitement de la requête 
        if ($form->isSubmitted() && $form->isValid()) {
            //traiment de l'envoie dans le classe ContactNotification
            $notification->notify($contact);
            $this->addFlash('success', "Message envoyé, il vous repondra dans les brefs délais!");
            return $this->redirectToRoute('property.show', [
                'id' => $property->getId(),
                'slug' => $property->getSlug()
            ]);
        }

        return $this->render('property/show.html.twig', [
            'controller_name' => 'PropertyController',
            'property' => $property,
            //pour rendre le boutton actif au clique mais il sera modifier
            'current_menu' => 'properties',
            'form' => $form->createView()
            ]);

    }
}
