<?php

namespace OCUserBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class FinishRegisterController extends Controller {

    /**
	 * @Route("/finish-register")
	 */
	public function setRolesAction(Request $request) {

        // On récuepre le user :
        $entityManager = $this->getDoctrine()->getManager();
        $user = $this->getUser();

        // On crée le formulaire

        // On affiche le formulaire

        //Si le formulaire est OK

        // On affecte le role, et on redirige vers la suite des operations
        $user->setRoles(array('ROLE_ADMINISTRATEUR'));
        $entityManager->persist($user);
        $entityManager->flush();

        // On affiche le formulaire
		return $this->render('OCUserBundle:FinishRegister:setRoles.html.twig', array (
				'variable' => $user
		) );
	}
}
