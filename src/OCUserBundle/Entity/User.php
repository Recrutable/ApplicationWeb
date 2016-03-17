<?php

namespace OCUserBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use FOS\UserBundle\Model\User as BaseUser;
/**
 * User
 *
 * @ORM\Table(name="user")
 * @ORM\Entity(repositoryClass="OCUserBundle\Repository\UserRepository")
 */
class User extends BaseUser
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\Column(name="tel", type="string", length=20)
     */
    protected $tel;

    /**
     * @ORM\ManyToMany(targetEntity="QcmBundle\Entity\Reponses", mappedBy="reponses")
     */
    private $reponses;

    public function getTel()
    {
        return $this->tel;
    }

    public function setTel($Tel)
    {
        $this->tel = $Tel;
    }
}

