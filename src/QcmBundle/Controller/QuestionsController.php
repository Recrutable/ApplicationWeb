<?php

namespace QcmBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use QcmBundle\Entity\Questions;
use QcmBundle\Form\QuestionsType;

/**
 * Questions controller.
 *
 * 
 */
class QuestionsController extends Controller
{
    /**
     * Lists all Questions entities.
     *
     * @Route("questions/show", name="questions_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $questions= $em->getRepository('QcmBundle:Questions')->findAll();

        return $this->render('QcmBundle:Questions:index.html.twig', array(
            'questions' => $questions,
        ));
    }

    /**
     * Creates a new Questions entity.
     *
     * @Route("questions/new", name="questions_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $question = new Questions();
        $form = $this->createForm('QcmBundle\Form\QuestionsType', $question);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($question);
            $em->flush();

            return $this->redirectToRoute('questions_show', array('id' => $question->getId()));
        }

        return $this->render('QcmBundle:Questions:new.html.twig', array(
            'question' => $question,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Questions entity.
     *
     * @Route("/{id}", name="questions_show")
     * @Method("GET")
     */
    public function showAction(Questions $question)
    {
        $deleteForm = $this->createDeleteForm($question);

        return $this->render('questions/show.html.twig', array(
            'question' => $question,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Questions entity.
     *
     * @Route("/{id}/edit", name="questions_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Questions $question)
    {
        $deleteForm = $this->createDeleteForm($question);
        $editForm = $this->createForm('QcmBundle\Form\QuestionsType', $question);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($question);
            $em->flush();

            return $this->redirectToRoute('questions_edit', array('id' => $question->getId()));
        }

        return $this->render('questions/edit.html.twig', array(
            'question' => $question,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a Questions entity.
     *
     * @Route("/{id}", name="questions_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Questions $question)
    {
        $form = $this->createDeleteForm($question);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($question);
            $em->flush();
        }

        return $this->redirectToRoute('questions_index');
    }

    /**
     * Creates a form to delete a Questions entity.
     *
     * @param Questions $question The Questions entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Questions $question)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('questions_delete', array('id' => $question->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
