<?php

namespace QcmBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Questionnaires
 *
 * @ORM\Table(name="questionnaires")
 * @ORM\Entity(repositoryClass="QcmBundle\Repository\QuestionnairesRepository")
 */
class Questionnaires
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
     * @Assert\NotBlank()
     * @ORM\Column(name="domaine", type="string", length=255)
     */
    private $domaine;

    /**
     * @var string
     *
     * @ORM\Column(name="type", type="string", length=255)
     */
    private $type;

    /**
     * @ORM\ManyToOne(targetEntity="OCUserBundle\Entity\Entreprise")
     */
    private $entreprise;

    /**
     * @ORM\ManyToMany(targetEntity="CandidaturesBundle\Entity\Offres", cascade={"persist"}, mappedBy="offres")
     */
    private $offres;

    /**
     * @ORM\OneToMany(targetEntity="QcmBundle\Entity\Questionnaires", cascade={"persist"}, mappedBy="questions")
     */
    private $questions;

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
     * @return Questionnaires
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
     * Set domaine
     *
     * @param string $domaine
     *
     * @return Questionnaires
     */
    public function setDomaine($domaine)
    {
        $this->domaine = $domaine;

        return $this;
    }

    /**
     * Get domaine
     *
     * @return string
     */
    public function getDomaine()
    {
        return $this->domaine;
    }

    /**
     * Set type
     *
     * @param string $type
     *
     * @return Questionnaires
     */
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Get type
     *
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @return mixed
     */
    public function getEntreprise()
    {
        return $this->entreprise;
    }

    /**
     * @param mixed $entreprise
     */
    public function setEntreprise($entreprise)
    {
        $this->entreprise = $entreprise;
    }


    /**
     * Retourne le nom du formulaire
     * @return string
     */
    public function __toString()
    {
        return "{$this->getDomaine()} - {$this->getType()} - {$this->getNom()}";
    }
}

