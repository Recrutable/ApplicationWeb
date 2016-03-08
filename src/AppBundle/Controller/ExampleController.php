<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class ExampleController extends Controller {
	/**
	 * @Route("/example/")
	 */
	public function indexAction(Request $request) {
		$string = "Hello World !";
		return $this->render ( 'example/example.html.twig', array (
				'variable' => $string
		) );
	}
}
