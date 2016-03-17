<?php

namespace QcmBundle\Controller;

use QcmBundle\Entity\Questionnaires;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use QcmBundle\Entity\Questions;
use QcmBundle\Form\QuestionsType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;

/**
 * Questions controller.
 *
 * @Route("/questions/{id_questionnaires}")
 * @ParamConverter("questionnaires", class="QcmBundle:Questionnaires", options={"id" = "id_questionnaires"})
 */
class QuestionsController extends Controller
{
    private $questionnaire;

    /**
     * Lists all Questions entities.
     *
     * @Route("/", name="questions_index")
     * @Method("GET")
     */
    public function indexAction(Questionnaires $questionnaires)
    {
        $em = $this->getDoctrine()->getManager();

        $questions = $em->getRepository('QcmBundle:Questions')->findBy(
            array(
                'idQuestionnaire'=>$questionnaires,
            )
        );

        return $this->render('QcmBundle:questions:index.html.twig', array(
            'questions' => $questions,
            'questionnaire'=>$questionnaires,
        ));
    }

    /**
     * Creates a new Questions entity.
     *
     * @Route("/new", name="questions_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request, Questionnaires $questionnaires)
    {
        $question = new Questions();
        $form = $this->createForm('QcmBundle\Form\QuestionsType', $question);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $question->setIdQuestionnaire($questionnaires);
            $em->persist($question);
            $em->flush();

            // On reprend le formulaire
            return $this->redirectToRoute('questions_new', array('id_questionnaires' => $questionnaires->getId()));
        }

        return $this->render('QcmBundle:questions:new.html.twig', array(
            'question' => $question,
            'form' => $form->createView(),
            'questionnaire' => $questionnaires,
        ));
    }

    /**
     * Finds and displays a Questions entity.
     *
     * @Route("/{id}", name="questions_show")
     * @Method("GET")
     */
    public function showAction(Questionnaires $questionnaires,Questions $question)
    {
        $this->isMyQuestion($questionnaires->getEntreprise()->getUser());
        $deleteForm = $this->createDeleteForm($question,$questionnaires);

        return $this->render('QcmBundle:questions:show.html.twig', array(
            'question' => $question,
            'delete_form' => $deleteForm->createView(),
            'questionnaire'=>$questionnaires,
        ));
    }

    /**
     * Displays a form to edit an existing Questions entity.
     *
     * @Route("/{id}/edit", name="questions_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request,Questionnaires $questionnaires, Questions $question)
    {
        $this->isMyQuestion($questionnaires->getEntreprise()->getUser());
        $deleteForm = $this->createDeleteForm($question,$questionnaires);
        $editForm = $this->createForm('QcmBundle\Form\QuestionsType', $question);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($question);
            $em->flush();

            return $this->redirectToRoute('questions_show', array('id' => $question->getId(),'id_questionnaires'=>$questionnaires->getId()));
        }

        return $this->render('QcmBundle:questions:edit.html.twig', array(
            'question' => $question,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
            'questionnaire'=>$questionnaires,
        ));
    }

    /**
     * Deletes a Questions entity.
     *
     * @Route("/{id}", name="questions_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request,Questionnaires $questionnaires, Questions $question)
    {
        $this->isMyQuestion($questionnaires->getEntreprise()->getUser());
        $form = $this->createDeleteForm($question,$questionnaires);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($question);
            $em->flush();
        }

        return $this->redirectToRoute('questions_index',array(
            'id_questionnaires'=>$questionnaires->getId(),
        ));
    }

    /**
     * Creates a form to delete a Questions entity.
     *
     * @param Questions $question The Questions entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Questions $question,Questionnaires $questionnaires)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('questions_delete', array('id' => $question->getId(), 'id_questionnaires'=>$questionnaires->getId())))
            ->setMethod('DELETE')
            ->getForm()
            ;
    }

    /**
     * Verifie s'il s'agit de ma question ou si je suis un admin
     * @param $user
     * @throws AccessDeniedException
     */
    private function isMyQuestion($user)
    {
        if($this->getUser() !== $user && !in_array('ROLE_ADMIN',$this->getUser()->getRoles())) {
            throw new AccessDeniedException();
        }
    }
}
