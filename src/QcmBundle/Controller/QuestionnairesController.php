<?php

namespace QcmBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use QcmBundle\Entity\Questionnaires;
use QcmBundle\Form\QuestionnairesType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

/**
 * @Security("has_role('ROLE_ENTREPRISE')")
 */
class QuestionnairesController extends Controller
{
    /**
     * Lists all Questionnaires entities.
     *
     * @Route("Qcm/show", name="Qcm_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $repo = $this->getDoctrine()->getManager()->getRepository('QcmBundle:Questionnaires');
        $listQuestionnaires = $repo->findAll();

        return $this->render('QcmBundle:Questionnaires:index.html.twig', array(
            'questionnaires' => $listQuestionnaires,
        ));
    }

    /**
     * Creates a new Questionnaires entity.
     *
     * @Route("Qcm/new", name="Qcm_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $questionnaire = new Questionnaires();
        $form = $this->createForm('QcmBundle\Form\QuestionnairesType', $questionnaire);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($questionnaire);
            $em->flush();

            return $this->redirectToRoute('Qcm_show', array('id' => $questionnaire->getId()));
        }

        return $this->render('QcmBundle:Questionnaires:new.html.twig', array(
            'questionnaire' => $questionnaire,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Questionnaires entity.
     *
     * @Route("/{id}", name="Qcm_show")
     * @Method("GET")
     */
    public function showAction(Questionnaires $questionnaire)
    {
        $deleteForm = $this->createDeleteForm($questionnaire);

        return $this->render('QcmBundle:Questionnaires:show.html.twig', array(
            'questionnaire' => $questionnaire,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Questionnaires entity.
     *
     * @Route("/{id}/edit", name="Qcm_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Questionnaires $questionnaire)
    {
        $deleteForm = $this->createDeleteForm($questionnaire);
        $editForm = $this->createForm('QcmBundle\Form\QuestionnairesType', $questionnaire);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($questionnaire);
            $em->flush();

            return $this->redirectToRoute('Qcm_edit', array('id' => $questionnaire->getId()));
        }

        return $this->render('QcmBundle:Questionnaires:edit.html.twig', array(
            'questionnaire' => $questionnaire,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a Questionnaires entity.
     *
     * @Route("/{id}", name="Qcm_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Questionnaires $questionnaire)
    {
        $form = $this->createDeleteForm($questionnaire);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($questionnaire);
            $em->flush();
        }

        return $this->redirectToRoute('Qcm_index');
    }

    /**
     * Creates a form to delete a Questionnaires entity.
     *
     * @param Questionnaires $questionnaire The Questionnaires entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Questionnaires $questionnaire)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('Qcm_delete', array('id' => $questionnaire->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }

    public function ajoutQuestions()
    {
        /* 
            Lors du clique sur le boutons "Ajouter" on doit arrive sur la page new de questions
        */
    }
}
