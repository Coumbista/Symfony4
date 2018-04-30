<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\LocaliteRepository")
 */
class Localite
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=25)
     */
    private $libelleloca;
  
    /**
   
      * @ORM\OneToMany(targetEntity = "App\Entity\Bien", mappedBy = "localite")
      */
   
     private $bien;
  
 

    public function getId()
    {
        return $this->id;
    }

    public function getLibelleloca(): ?string
    {
        return $this->libelleloca;
    }

    public function setLibelleloca(string $libelleloca): self
    {
        $this->libelleloca = $libelleloca;

        return $this;
    }
}
