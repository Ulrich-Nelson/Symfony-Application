<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\PictureRepository;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Symfony\Component\Validator\Constraints as Assert;


/**
 * @ORM\Entity(repositoryClass=PictureRepository::class)
 * @Vich\Uploadable()
 * 
 */
class Picture
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @var File|null 
	 * @Assert\Image(
     *     mimeTypes = { "image/png",   "image/jpeg", "image/jpg" })
     * @Vich\UploadableField(mapping="property_image", fileNameProperty="fileName")
     */
    private $imageFile;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $filename;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Property", inversedBy="pictures")
     * @ORM\JoinColumn(nullable=false)
     */
    private $property;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFilename(): ?string
    {
        return $this->filename;
    }

    public function setFilename(?string $filename): self
    {
        $this->filename = $filename;

        return $this;
    }

    public function getProperty(): ?Property
    {
        return $this->property;
    }

    public function setProperty(?Property $property): self
    {
        $this->property = $property;

        return $this;
    }

    
    /**
     * @return  File|null
     */ 
    public function getImageFile(): ?File
    {
        return $this->imageFile;
    }

    /**
     * @param  File|null 
     * @return  Property
     */ 
    public function setImageFile($imageFile): self
    {
        $this->imageFile = $imageFile;

        return $this;
    }
}
