<?php

namespace OCUserBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
/**
 * UserController controller.
 */
class UserController extends Controller
{
    /**
     * Verfie si le user passé est le user en cours, ou que le user en cours est un admin
     * @param $user
     * @throws AccessDeniedException
     */
    protected function verifIsUserOrAdmin($user)
    {
        if($this->getUser() !== $user && !in_array('ROLE_ADMIN',$this->getUser()->getRoles())) {
            throw new AccessDeniedException();
        }
    }
}
