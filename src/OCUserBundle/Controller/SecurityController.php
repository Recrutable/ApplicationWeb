<?php
namespace OCUserBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class SecurityController extends Controller {
	/**
	 * @Route("/login")
	 */
	public function loginAction(Request $request) {
		// On recupere le service d'authentification
		$authenticationUtils = $this->get('security.authentication_utils');
		return $this->render ( 'OCUserBundle:Security:login.html.twig', array (
		// get the login error if there is one
				'last_username' => $authenticationUtils->getLastUsername (),
		// last username entered by the user
				'error' => $authenticationUtils->getLastAuthenticationError () 
		) );
	}
}