<?php

namespace QcmBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use QcmBundle\Form\QuestionnairesType;
use QcmBundle\Entity\Questionnaires;
use Symfony\Component\HttpFoundation\Request;


class GestionQcmController extends Controller
{
    /**
     * @Route("/Qcm/edit", name = "GestionQuestionnaires")
     */
    public function indexAction(Request $request)
    {
        $questionnaires = new Questionnaires();
    	$Form = $this->get('form.factory')->create(QuestionnairesType::class, $questionnaires);

    	if($Form->handleRequest($request)->isValid()){
    		$em = $this->getDoctrine()->getManager();
    		$em->persist($questionnaires);
    		$em->flush();
    	}

        return $this->render('QcmBundle:GestionQcm:index.html.twig', array(
            "Form" => $Form->createView(),
        ));
    

    }


    /**
     * @Route("/Qcm/index", name = "GestionQuestionnaires")
     */
    public function viewQuestionnaireAction()
    {
    	$repo = $this->getDoctrine()->getManager()->getRepository('QcmBundle:Questionnaires');
    	$listQuestionnaires = $repo->findAll();
    	echo '<pre>';
    	var_dump($listQuestionnaires);
    	echo'</pre>';


    }

    


}
