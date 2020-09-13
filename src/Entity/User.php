<?php

namespace App\Entity;

use App\Entity\Property;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Entity(repositoryClass="App\Repository\UserRepository")
 * @UniqueEntity(
 * fields={"username"}, message="Le nom d'utilisateur que vous avez tapé est déjà utilisé !")
 * @UniqueEntity(
 * fields={"phone"}, message="Numéro de télephone déjà utilisé par une autre personne !")
 * @UniqueEntity(
 * fields={"email"}, message="L'email que vous avez indiqué est déjà utilisé par une autre personne !")
 * 
 */
class User implements UserInterface,\Serializable
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\Length( min = 5, minMessage = "Nom d'utilisateur trop court...")
     */
    private $username;

    /**
     * @ORM\Column(type="string", length=255)
     *   @Assert\Regex(
     *  pattern="/[0-9]{10}/"
     * )
     */
    private $phone;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\EqualTo(propertyPath = "confirm_password",
     * message="Les deux mots de passe ne concordent pas !" )
     * 
     */
    private $password;

    /**
     * @Assert\Length(
     * min = 6,
     * max = 15,
     * maxMessage = "Votre mot de passe ne doit pas dépasser {{ limit }} caractères",
     * minMessage = "Votre mot de passe doit comporter au minimum {{ limit }} caractères")
     * @Assert\EqualTo(propertyPath = "password", message="Vous n'avez pas saisi le même mot de passe !" )
     */
    private $confirm_password;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\Email()
     */
    private $email;

    /**
     * @ORM\OneToMany(targetEntity=Property::class, mappedBy="user", orphanRemoval=true, cascade={"persist"})
     */
    private $properties;

    public function __construct()
    {
        $this->properties = new ArrayCollection();
    }



    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUsername(): ?string
    {
        return $this->username;
    }

    public function setUsername(string $username): self
    {
        $this->username = $username;

        return $this;
    }

    public function getPhone(): ?string
    {
        return $this->phone;
    }

    public function setPhone(string $phone): self
    {
        $this->phone = $phone;

        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    public function getConfirmPassword()
    {
        return $this->confirm_password;
    }


    public function setConfirmPassword($confirm_password)
    {
        $this->confirm_password = $confirm_password;

        return $this;
    }

    public function getRoles()
    {
        return ['ROLE_USER'];
    }


    public function eraseCredentials()
    {

    }

    public function getSalt()
    {

    }

    /**
     * String representation of object
     * @link https://php.net/manual/en/serializable.serialize.php
     * @return string the string representation of the object or null
     * @since 5.1.0
     */
    public function serialize()
    {
        return serialize([
            $this->id,
            $this->username,
            $this->email,
            $this->password
           
        ]);
    }

    /**
     * Constructs the object
     * @link https://php.net/manual/en/serializable.unserialize.php
     * @param string $serialized <p>
     * The string representation of the object.
     * </p>
     * @return void
     */
    public function unserialize($serialized)
    {
        list(
            $this->id,
            $this->username,
            $this->email,
            $this->password
        ) = unserialize($serialized, ['allowed_classes' => false]);
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    /**
     * @return Collection|Property[]
     */
    public function getProperties(): Collection
    {
        return $this->properties;
    }

    public function addProperty(Property $property): self
    {
        if (!$this->properties->contains($property)) {
            $this->properties[] = $property;
            $property->setUser($this);
        }

        return $this;
    }

    public function removeProperty(Property $property): self
    {
        if ($this->properties->contains($property)) {
            $this->properties->removeElement($property);
            // set the owning side to null (unless already changed)
            if ($property->getUser() === $this) {
                $property->setUser(null);
            }
        }

        return $this;
    }

 
    
}
