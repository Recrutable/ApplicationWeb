<?php

namespace QcmBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class DefaultController extends Controller
{
    /**
     * @Route("/zrfzrfz/")
     */
    public function indexAction()
    {
        return $this->render('QcmBundle:Default:index.html.twig');
    }
}
