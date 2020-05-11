<?php

namespace App\Controller;

use App\Entity\Property;
use App\Repository\PropertyRepository;
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
     * @return Response l'ensemble des biens de l'application
     */
    public function index(PaginatorInterface $paginator, Request $request): Response
    {
        $properties = $paginator->paginate($this->repository->findAllVisibleQuery(),
        $request->query->getInt('page', 1),
        12);
        
        return $this->render('property/index.html.twig', [
            'controller_name' => 'PropertyController',
            //pour rendre le boutton actiff au clique mais il sera modifier
            'current_menu' => 'properties',
            'properties' => $properties
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
