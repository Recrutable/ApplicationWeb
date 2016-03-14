<?php

namespace OCUserBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use OCUserBundle\Entity\Chomeur;
use OCUserBundle\Form\ChomeurType;

/**
 * Chomeur controller.
 *
 * @Route("/profile_usr")
 */
class ChomeurController extends Controller
{
    /**
     * Lists all Chomeur entities.
     *
     * @Route("/", name="profile_usr_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $chomeurs = $em->getRepository('OCUserBundle:Chomeur')->findAll();

        return $this->render('OCUserBundle:Chomeur:index.html.twig', array(
            'chomeurs' => $chomeurs,
        ));
    }

    /**
     * Creates a new Chomeur entity.
     *
     * @Route("/new", name="profile_usr_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $chomeur = new Chomeur();
        $form = $this->createForm('OCUserBundle\Form\ChomeurType', $chomeur);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($chomeur);
            $em->flush();

            return $this->redirectToRoute('profile_usr_show', array('id' => $chomeur->getId()));
        }

        return $this->render('OCUserBundle:Chomeur:new.html.twig', array(
            'chomeur' => $chomeur,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Chomeur entity.
     *
     * @Route("/{id}", name="profile_usr_show")
     * @Method("GET")
     */
    public function showAction(Chomeur $chomeur)
    {
        $deleteForm = $this->createDeleteForm($chomeur);

        return $this->render('OCUserBundle:Chomeur:show.html.twig', array(
            'chomeur' => $chomeur,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Chomeur entity.
     *
     * @Route("/{id}/edit", name="profile_usr_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Chomeur $chomeur)
    {
        $deleteForm = $this->createDeleteForm($chomeur);
        $editForm = $this->createForm('OCUserBundle\Form\ChomeurType', $chomeur);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($chomeur);
            $em->flush();

            return $this->redirectToRoute('profile_usr_edit', array('id' => $chomeur->getId()));
        }

        return $this->render('OCUserBundle:Chomeur:edit.html.twig', array(
            'chomeur' => $chomeur,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a Chomeur entity.
     *
     * @Route("/{id}", name="profile_usr_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Chomeur $chomeur)
    {
        $form = $this->createDeleteForm($chomeur);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($chomeur);
            $em->flush();
        }

        return $this->redirectToRoute('profile_usr_index');
    }

    /**
     * Creates a form to delete a Chomeur entity.
     *
     * @param Chomeur $chomeur The Chomeur entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Chomeur $chomeur)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('profile_usr_delete', array('id' => $chomeur->getId())))
            ->setMethod('DELETE')
            ->getForm()
            ;
    }
}
