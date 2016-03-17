<?php

namespace CandidaturesBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Candidatures
 *
 * @ORM\Table(name="candidatures")
 * @ORM\Entity(repositoryClass="CandidaturesBundle\Repository\CandidaturesRepository")
 */
class Candidatures
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
     * @ORM\ManyToOne(targetEntity="CandidaturesBundle\Entity\Offres", cascade={"persist"})
     */
    private $offres;

    /**
     * @ORM\ManyToOne(targetEntity="OCUserBundle\Entity\User", cascade={"persist"})
     */
    private $user;

    /**
     * @var array
     *
     * @ORM\Column(name="reponses", type="array")
     */
    private $reponses;


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
     * Set offres
     *
     * @param \stdClass $offres
     *
     * @return Candidatures
     */
    public function setOffres($offres)
    {
        $this->offres = $offres;

        return $this;
    }

    /**
     * Get offres
     *
     * @return \stdClass
     */
    public function getOffres()
    {
        return $this->offres;
    }

    /**
     * Set user
     *
     * @param \stdClass $user
     *
     * @return Candidatures
     */
    public function setUser($user)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return \stdClass
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Set reponses
     *
     * @param array $reponses
     *
     * @return Candidatures
     */
    public function setReponses($reponses)
    {
        $this->reponses = $reponses;

        return $this;
    }

    /**
     * Get reponses
     *
     * @return array
     */
    public function getReponses()
    {
        return $this->reponses;
    }
}

