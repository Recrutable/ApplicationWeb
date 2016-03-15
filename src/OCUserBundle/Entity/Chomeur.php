<?php

namespace OCUserBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Chomeur
 *
 * @ORM\Table(name="chomeur")
 * @ORM\Entity(repositoryClass="OCUserBundle\Repository\ChomeurRepository")
 */
class Chomeur
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="nom", type="string", length=255)
     */
    private $nom;

    /**
     * @var string
     *
     * @ORM\Column(name="prenom", type="string", length=255)
     */
    private $prenom;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="birthday", type="date")
     */
    private $birthday;

    /**
     * @var string
     *
     * @ORM\Column(name="presentation", type="text")
     */
    private $presentation;

    /**
     * @ORM\OneToOne(targetEntity="OCUserBundle\Entity\User", cascade={"remove"})
     */
    private $user;

    /**
     * @var string
     *
     * @ORM\Column(name="CV", type="text")
     */
    private $CV;

    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set nom
     *
     * @param string $nom
     *
     * @return Chomeur
     */
    public function setNom($nom)
    {
        $this->nom = $nom;

        return $this;
    }

    /**
     * Get nom
     *
     * @return string
     */
    public function getNom()
    {
        return $this->nom;
    }

    /**
     * Set prenom
     *
     * @param string $prenom
     *
     * @return Chomeur
     */
    public function setPrenom($prenom)
    {
        $this->prenom = $prenom;

        return $this;
    }

    /**
     * Get prenom
     *
     * @return string
     */
    public function getPrenom()
    {
        return $this->prenom;
    }

    /**
     * Set birthday
     *
     * @param \DateTime $birthday
     *
     * @return Chomeur
     */
    public function setBirthday($birthday)
    {
        $this->birthday = $birthday;

        return $this;
    }

    /**
     * Get birthday
     *
     * @return \DateTime
     */
    public function getBirthday()
    {
        return $this->birthday;
    }

    /**
     * Set presentation
     *
     * @param string $presentation
     *
     * @return Chomeur
     */
    public function setPresentation($presentation)
    {
        $this->presentation = $presentation;

        return $this;
    }

    /**
     * Get presentation
     *
     * @return string
     */
    public function getPresentation()
    {
        return $this->presentation;
    }

    /**
     * @param $User
     * @return $this
     */
    public function setUser($User)
    {
        $this->user = $User;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * @param $CV
     * @return $this
     */
    public function setCV($CV)
    {
        $this->CV = $CV;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getCV()
    {
        return $this->CV;
    }
}
