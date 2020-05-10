<?php

namespace App\Controller;

use App\Entity\Property;
use App\Repository\PropertyRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Common\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class PropertyController extends AbstractController
{    
   
    private $repository;    
    private $em;
    
    public function __construct(PropertyRepository $repository, ManagerRegistry $EntityManager)
    {
        $this->repository = $repository;
        $this->em = $EntityManager;

    }
    

    /**
     * @Route("/biens", name="property.index")
     * 
     * @return Response
     */
    public function index(): Response
    {
        return $this->render('property/property.html.twig', [
            'controller_name' => 'PropertyController',
            //pour rendre le boutton actiff au clique mais il sera modifier
            'current_menu' => 'properties'
        ]);
    }

    /**
     * @Route("/biens/{slug}-{id}", name="property.show", requirements={"slug": "[a-z0-9\-]*"})
     *
     * @return Response
     */
    public function show(Property $property, string $slug): Response
    {
        if ($property->getSlug() !== $slug) {
            return $this->redirectToRoute('property.show', [
                'id' => $property->getId(),
                'slug' => $property->getSlug()
            ], 301);
        }

        return $this->render('property/show.html.twig', [
            'controller_name' => 'PropertyController',
            'property' => $property,
            //pour rendre le boutton actiff au clique mais il sera modifier
            'current_menu' => 'properties'
            ]);

    }
}
