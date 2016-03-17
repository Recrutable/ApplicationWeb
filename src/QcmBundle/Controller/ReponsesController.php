<?php

namespace QcmBundle\Controller;

use QcmBundle\Entity\Questionnaires;
use QcmBundle\Entity\Reponses;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use QcmBundle\Entity\Questions;
use QcmBundle\Form\ReponsesType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;

/**
 * Questions controller.
 *
 * @Route("/rep/{id_questionnaires}")
 * @ParamConverter("questionnaires", class="QcmBundle:Questionnaires", options={"id" = "id_questionnaires"})
 */
class ReponsesController extends Controller
{

    /**
     * Creates as many Reponse entity than a Questionaires entity has response
     *
     * @Route("/{id_offre}/{page}", name="postuler_questionnaire")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request, Questionnaires $questionnaires,$id_offre, $page = 0)
    {

        // On récupere la question numero $page du questionnaire
        $repoQuestionnaires = $this->getDoctrine()->getRepository('QcmBundle:Questions');
        $Question = $repoQuestionnaires->getQuestion($questionnaires,$page);
        $nextQuestion = $repoQuestionnaires->getQuestion($questionnaires,$page+1);


        // On crée le formulaire
        $action = $this->generateUrl('postuler_questionnaire',array(
                'id_questionnaires'=>$questionnaires->getId(),
                'id_offre'=>$id_offre,
                'page'=>$page,
            )
        );

        $reponses = new Reponses();
        $form = $this->createForm('QcmBundle\Form\ReponsesType', $reponses, array(
            'action'=>$action,
        ));
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            // On verifie la reponse
            $bonneReponse = $Question->getBonneReponse();
            $reponse = $reponses->getReponse();

            $reponses->setUser(
                array(
                    $this->getUser()
                ));
            $reponses->setQuestion(array(
                $Question
            ));
            $reponses->setTopBonneReponse(
                ($bonneReponse == $reponse)
            );

            //On Sauvegarde
            $em->persist($reponses);
            $em->flush();

            // On reprend le formulaire
            if($nextQuestion) {
                return $this->redirectToRoute('postuler_questionnaire', array(
                    'id_questionnaires'=>$questionnaires->getId(),
                    'id_offre'=>$id_offre,
                    'page' => $page+1
                ));
            } else {
                return $this->redirectToRoute('offres_show', array(
                    'id'=>$id_offre,
                ));
            }
        }



        return $this->render('QcmBundle:reponses:new.html.twig', array(
            'question' => $Question,
            'form' => $form->createView(),
            'page'=>$page,
            'questionnaire' => $questionnaires,
        ));



        // Si le form est valide
        // Si la reponse est bonne,
        // on passe le top_bonne_reponse a true
        // On sauvegarde

        // On affiche la question suivante


    }
}
