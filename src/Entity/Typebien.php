<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\TypebienRepository")
 */
class Typebien
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
    private $libelletype;
 
    /**
   
      * @ORM\OneToMany(targetEntity = "App\Entity\Bien", mappedBy = "typebien")
      */
   
     private $biens;
   

    public function getId()
    {
        return $this->id;
    }

    public function getLibelletype(): ?string
    {
        return $this->libelletype;
    }

    public function setLibelletype(string $libelletype): self
    {
        $this->libelletype = $libelletype;

        return $this;
    }
}
