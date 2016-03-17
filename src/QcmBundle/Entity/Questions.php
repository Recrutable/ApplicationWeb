<?php

namespace QcmBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Questions
 *
 * @ORM\Table(name="questions")
 * @ORM\Entity(repositoryClass="QcmBundle\Repository\QuestionsRepository")
 */
class Questions
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
     * @ORM\Column(name="question", type="string", length=255)
     */
    private $question;

    /**
     * @var string
     *
     * @ORM\Column(name="reponseA", type="string", length=255)
     */
    private $reponseA;

    /**
     * @var string
     *
     * @ORM\Column(name="reponseB", type="string", length=255)
     */
    private $reponseB;

    /**
     * @var string
     *
     * @ORM\Column(name="reponseC", type="string", length=255)
     */
    private $reponseC;

    /**
     * @var string
     *
     * @ORM\Column(name="bonne_reponse", type="string", length=255)
     */
    private $bonneReponse;

    /**
     * @ORM\ManyToOne(targetEntity="QcmBundle\Entity\Questionnaires" , inversedBy="questionnaires")
     * @ORM\JoinColumn(nullable=false)
     */
    private $idQuestionnaire;

    /**
     * @ORM\ManyToMany(targetEntity="QcmBundle\Entity\Reponses", mappedBy="reponses")
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
     * Set question
     *
     * @param string $question
     *
     * @return Questions
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
     * @return Questions
     */
    public function setReponseA($reponseA)
    {
        $this->reponseA = $reponseA;

        return $this;
    }

    /**
     * Get reponse
     *
     * @return string
     */
    public function getReponseA()
    {
        return $this->reponseA;
    }

    /**
     * Set reponse
     *
     * @param string $reponse
     *
     * @return Questions
     */
    public function setReponseB($reponseB)
    {
        $this->reponseB = $reponseB;

        return $this;
    }

    /**
     * Get reponse
     *
     * @return string
     */
    public function getReponseB()
    {
        return $this->reponseB;
    }

    /**
     * Set reponse
     *
     * @param string $reponse
     *
     * @return Questions
     */
    public function setReponseC($reponseC)
    {
        $this->reponseC = $reponseC;

        return $this;
    }

    /**
     * Get reponse
     *
     * @return string
     */
    public function getReponseC()
    {
        return $this->reponseC;
    }

    /**
     * Set bonneReponse
     *
     * @param string $bonneReponse
     *
     * @return Questions
     */
    public function setBonneReponse($bonneReponse)
    {
        $this->bonneReponse = $bonneReponse;

        return $this;
    }

    /**
     * Get bonneReponse
     *
     * @return string
     */
    public function getBonneReponse()
    {
        return $this->bonneReponse;
    }


    public function getIdQuestionnaire()
    {
        return $this->idQuestionnaire;
    }

    public function setIdQuestionnaire($idQuestionnaire)
    {
        $this->idQuestionnaire = $idQuestionnaire;
        return $this;
    }
}