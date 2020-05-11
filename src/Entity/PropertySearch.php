<?php
//mise en place du système de filtre dans nos recherches
namespace App\Entity;

use Symfony\Component\Validator\Constraints as Assert;



/**
 * PropertySearch
 */
class PropertySearch
{    
    
    /**
     * maxPrice
     *
     * @var mixed
     */
    private $maxPrice;
    
    /**
     * minSurface
     * @Assert\Range( min = 10)
     * @var mixed
     */
    private $minSurface;


    

    /**
     * Get the value of maxPrice
     */ 
    public function getMaxPrice()
    {
        return $this->maxPrice;
    }

    /**
     * Set the value of maxPrice
     *
     * @return  self
     */ 
    public function setMaxPrice(int $maxPrice)
    {
        $this->maxPrice = $maxPrice;

        return $this;
    }

    /**
     * Get the value of minSurface
     */ 
    public function getMinSurface()
    {
        return $this->minSurface;
    }

    /**
     * Set the value of minSurface
     *
     * @return  self
     */ 
    public function setMinSurface(int $minSurface)
    {
        $this->minSurface = $minSurface;

        return $this;
    }
}