<?php
//mise en place du système de filtre dans nos recherches
namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
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
     * @var ArrayCollection
     */
    private $options;

    public function __construct()
    {
        $this->options = new ArrayCollection();
    }
    

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

    /**
     * Get option pour ajouter des options à nos biens
     *
     * @return  ArrayCollection
     */ 
    public function getOptions(): ArrayCollection
    {
        return $this->options;
    }

    /**
     * Set option pour ajouter des options à nos biens
     *
     * @param  ArrayCollection  $options  option pour ajouter des options à nos biens
     *
     */ 
    public function setOptions(ArrayCollection $options):void
    {
        $this->options = $options;

    }
}