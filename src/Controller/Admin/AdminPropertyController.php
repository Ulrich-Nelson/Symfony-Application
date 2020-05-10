<?php

namespace App\Controller\Admin;

use App\Entity\Property;
use App\Repository\PropertyRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AdminPropertyController extends AbstractController{

    private $repository;    
    /**
     *
     * @param  repository
     * @return void
     */
     public function __construct(PropertyRepository $repository)
    {
        $this->repository = $repository;
    }
    
    /**
     *@Route("/admin", name="admin.property.index")
     * 
     * 
     */
    public function index(): Response
    {
        $properties = $this->repository->findAll();
        return $this->render('admin/property/index.html.twig', compact('properties'));
        
    }
    
    /**
     * @Route("/admin/{id}", name="admin.property.edit")
     *
     * @param  mixed $property
     * @return void
     */
    public function edit(Property $property):Response
    {
        return $this->render('admin/property/edit.html.twig', compact('property'));
    }
    
}