<?php

namespace QcmBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Reponses
 *
 * @ORM\Table(name="reponses")
 * @ORM\Entity(repositoryClass="QcmBundle\Repository\ReponsesRepository")
 */
class Reponses
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
     * @ORM\ManyToMany(targetEntity="OCUserBundle\Entity\User", inversedBy="user")
     */
    private $user;

    /**
     * @ORM\ManyToMany(targetEntity="QcmBundle\Entity\Questions", inversedBy="question")
     */
    private $question;

    /**
     * @var string
     *
     * @ORM\Column(name="reponse", type="text")
     */
    private $reponse;

    /**
     * @var bool
     *
     * @ORM\Column(name="top_bonne_reponse", type="boolean")
     */
    private $topBonneReponse;


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
     * Set user
     *
     * @param string $user
     *
     * @return Reponses
     */
    public function setUser($user)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return string
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Set question
     *
     * @param string $question
     *
     * @return Reponses
     */
    public function setQuestion($question)
    {
        $this->question = $question;

        return $this;
    }

    /**
     * Get question
     *
     * @return string
     */
    public function getQuestion()
    {
        return $this->question;
    }

    /**
     * Set reponse
     *
     * @param string $reponse
     *
     * @return Reponses
     */
    public function setReponse($reponse)
    {
        $this->reponse = $reponse;

        return $this;
    }

    /**
     * Get reponse
     *
     * @return string
     */
    public function getReponse()
    {
        return $this->reponse;
    }

    /**
     * Set topBonneReponse
     *
     * @param boolean $topBonneReponse
     *
     * @return Reponses
     */
    public function setTopBonneReponse($topBonneReponse)
    {
        $this->topBonneReponse = $topBonneReponse;

        return $this;
    }

    /**
     * Get topBonneReponse
     *
     * @return bool
     */
    public function getTopBonneReponse()
    {
        return $this->topBonneReponse;
    }
}

