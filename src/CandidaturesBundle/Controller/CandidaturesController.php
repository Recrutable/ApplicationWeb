<?php

namespace CandidaturesBundle\Controller;

use CandidaturesBundle\Entity\Candidatures;
use CandidaturesBundle\Entity\Offres;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;

/**
 * Questions controller.
 *
 * @Route("/postuler/{id_offre}")
 * @ParamConverter("offres", class="CandidaturesBundle:Offres", options={"id" = "id_offre"})
 */
class CandidaturesController extends Controller
{
    /**
     * @Route("/profils/", name="profil_offre")
     */
    public function viewProfils(Offres $offres)
    {
        // On récupere la liste des user ayant postulés :
        $candidaturesRepo = $this->getDoctrine()->getRepository('CandidaturesBundle:Candidatures');
        $candidatures = $candidaturesRepo->findBy(
            array(
                'offres'=>$offres,
            )
        );

        return $this->render('CandidaturesBundle:Candidatures:profils.html.twig', array(
            'offres' => $offres,
            'candidatures' => $candidatures,
        ));
    }

    /**
     * @Route("/", name="postuler_offre")
     */
    public function postulerAction(Offres $offres)
    {
        // On récupere la liste des formulaires, et l'etat pour chacun :
        $listeQuestionnaire = $offres->getQuestionnaires();
        $ReponseRepo = $this->getDoctrine()->getRepository('QcmBundle:Reponses');
        $retourQuestionnaire = array();

        $qcmFinis = true;
        foreach($listeQuestionnaire as $questionnaire) {
            $arrayEtat = $ReponseRepo->getEtatQuestionnaire($questionnaire->getId(),$this->getUser()->getId());
            $qcmFinis = $qcmFinis && ($arrayEtat['nb_reponse'] >= $arrayEtat['nb_question']);
            $retourQuestionnaire[] = array(
                'questionnaire' => $questionnaire,
                'etat' => $arrayEtat,
                'qcmFini'=>($arrayEtat['nb_reponse'] >= $arrayEtat['nb_question']),
            );
        }

        // On affiche la liste des formulaire :
        return $this->render('CandidaturesBundle:Candidatures:postuler.html.twig', array(
            'offres' => $offres,
            'questionnaires' => $retourQuestionnaire,
            'qcmFinis'=>$qcmFinis,
        ));
    }

    /**
     * @Route("/fin", name="postuler_fin_offre")
     */
    public function postulerFinAction(Offres $offres)
    {
        $candidature = new Candidatures();
        $candidature->setOffres($offres);
        $candidature->setUser($this->getUser());

        // On récupere la liste des formulaires, et l'etat pour chacun :
        $listeQuestionnaire = $offres->getQuestionnaires();
        $ReponseRepo = $this->getDoctrine()->getRepository('QcmBundle:Reponses');
        $retourQuestionnaire = array();

        $qcmFinis = true;
        // Pour chaques questionnaires
        foreach($listeQuestionnaire as $questionnaire) {
            // On verifie que tout est repondu
            $arrayEtat = $ReponseRepo->getEtatQuestionnaire($questionnaire->getId(),$this->getUser()->getId());
            $qcmFinis = $qcmFinis && ($arrayEtat['nb_reponse'] >= $arrayEtat['nb_question']);

            // On stock les resultat :
            $retourQuestionnaire[$questionnaire->getNom()] = $ReponseRepo->getPourcentage(
                $questionnaire->getId(),
                $this->getUser()->getId()
            );
        }

        if($qcmFinis){
            $em = $this->getDoctrine()->getManager();
            $candidature->setReponses($retourQuestionnaire);
            $em->persist($candidature);
            $em->flush();
        }

        // On passe les requltats :
        $candidature->setReponses(
            array(
                'test1'=>'50%'
            )
        );

        return $this->redirectToRoute('offres_index');
    }

}
