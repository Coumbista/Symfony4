<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ClientRepository")
 */
class Client
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
    private $numeropiece;

    /**
     * @ORM\Column(type="string", length=25)
     */
    private $nomclient;

    /**
     * @ORM\Column(type="string", length=25)
     */
    private $adresseclient;

    /**
     * @ORM\Column(type="string", length=25)
     */
    private $telclient;

    /**
     * @ORM\Column(type="string", length=25)
     */
    private $emailclient;

    /**
     * @ORM\Column(type="string", length=25)
     */
    private $password;
     /**
   
      * @ORM\OneToMany(targetEntity = "App\Entity\Reservation", mappedBy = "client")
      */
   
      private $reservation;

    public function getId()
    {
        return $this->id;
    }

    public function getNumeropiece(): ?string
    {
        return $this->numeropiece;
    }

    public function setNumeropiece(string $numeropiece): self
    {
        $this->numeropiece = $numeropiece;

        return $this;
    }

    public function getNomclient(): ?string
    {
        return $this->nomclient;
    }

    public function setNomclient(string $nomclient): self
    {
        $this->nomclient = $nomclient;

        return $this;
    }

    public function getAdresseclient(): ?string
    {
        return $this->adresseclient;
    }

    public function setAdresseclient(string $adresseclient): self
    {
        $this->adresseclient = $adresseclient;

        return $this;
    }

    public function getTelclient(): ?string
    {
        return $this->telclient;
    }

    public function setTelclient(string $telclient): self
    {
        $this->telclient = $telclient;

        return $this;
    }

    public function getEmailclient(): ?string
    {
        return $this->emailclient;
    }

    public function setEmailclient(string $emailclient): self
    {
        $this->emailclient = $emailclient;

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
}
