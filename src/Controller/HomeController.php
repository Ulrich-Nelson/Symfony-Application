<?php

namespace App\Controller;

use App\Repository\PropertyRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class HomeController extends AbstractController
{


    /**
     * @Route("/", name="home")
     * 
     * 
     * @return Response
     */     
    
    public function index(PropertyRepository $repository): Response
    {

    $properties = $repository->findLatest();

        return $this->render('pages/index.html.twig', [
            'controller_name' => 'HomeController',
            'properties' =>  $properties
        ]);
    }
}
