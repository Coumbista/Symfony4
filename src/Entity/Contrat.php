<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ContratRepository")
 */
class Contrat
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="datetime")
     */
    private $datecontrat;

    /**
     * @ORM\Column(type="integer")
     */
    private $caution;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $duree;
    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Client",inversedBy="contrats")
     * @ORM\JoinColumn(nullable=false)   */

    private $client;
     /**

   * @ORM\OneToMany(targetEntity = "App\Entity\Paiement", mappedBy = "contrat")
   */

  private $paiements;
  /**
   * @ORM\ManyToOne(targetEntity="App\Entity\Bien")
   * @ORM\JoinColumn(nullable=false)   */

    private $bien;

    public function getId()
    {
        return $this->id;
    }

    public function getDatecontrat(): ?\DateTimeInterface
    {
        return $this->datecontrat;
    }

    public function setDatecontrat(\DateTimeInterface $datecontrat): self
    {
        $this->datecontrat = $datecontrat;

        return $this;
    }

    public function getCaution(): ?int
    {
        return $this->caution;
    }

    public function setCaution(int $caution): self
    {
        $this->caution = $caution;

        return $this;
    }

    public function getDuree(): ?string
    {
        return $this->duree;
    }

    public function setDuree(string $duree): self
    {
        $this->duree = $duree;

        return $this;
    }

    /**
     * Get the value of bien
     */ 
    public function getBien()
    {
        return $this->bien;
    }

    /**
     * Set the value of bien
     *
     * @return  self
     */ 
    public function setBien($bien)
    {
        $this->bien = $bien;

        return $this;
    }

    /**
     * Get the value of client
     */ 
    public function getClient()
    {
        return $this->client;
    }

    /**
     * Set the value of client
     *
     * @return  self
     */ 
    public function setClient($client)
    {
        $this->client = $client;

        return $this;
    }

  /**
   * Get the value of paiements
   */ 
  public function getPaiements()
  {
    return $this->paiements;
  }

  /**
   * Set the value of paiements
   *
   * @return  self
   */ 
  public function setPaiements($paiements)
  {
    $this->paiements = $paiements;

    return $this;
  }
  public function __toString(){
    return $this->duree;
}
}
