<?php

namespace OCUserBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use OCUserBundle\Entity\Entreprise;
use OCUserBundle\Form\EntrepriseType;

/**
 * Entreprise controller.
 *
 * @Route("/profile_ent")
 */
class EntrepriseController extends Controller
{
    /**
     * Lists all Entreprise entities.
     *
     * @Route("/", name="profile_ent_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entreprises = $em->getRepository('OCUserBundle:Entreprise')->findAll();

        return $this->render('OCUserBundle:Entreprise:index.html.twig', array(
            'entreprises' => $entreprises,
        ));
    }

    /**
     * Creates a new Entreprise entity.
     *
     * @Route("/new", name="profile_ent_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $entreprise = new Entreprise();
        $form = $this->createForm('OCUserBundle\Form\EntrepriseType', $entreprise);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entreprise);
            $em->flush();

            return $this->redirectToRoute('profile_ent_show', array('id' => $entreprise->getId()));
        }

        return $this->render('OCUserBundle:Entreprise:new.html.twig', array(
            'entreprise' => $entreprise,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Entreprise entity.
     *
     * @Route("/{id}", name="profile_ent_show")
     * @Method("GET")
     */
    public function showAction(Entreprise $entreprise)
    {
        $deleteForm = $this->createDeleteForm($entreprise);

        return $this->render('OCUserBundle:Entreprise:show.html.twig', array(
            'entreprise' => $entreprise,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Entreprise entity.
     *
     * @Route("/{id}/edit", name="profile_ent_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Entreprise $entreprise)
    {
        $deleteForm = $this->createDeleteForm($entreprise);
        $editForm = $this->createForm('OCUserBundle\Form\EntrepriseType', $entreprise);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entreprise);
            $em->flush();

            return $this->redirectToRoute('profile_ent_edit', array('id' => $entreprise->getId()));
        }

        return $this->render('OCUserBundle:Entreprise:edit.html.twig', array(
            'entreprise' => $entreprise,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a Entreprise entity.
     *
     * @Route("/{id}", name="profile_ent_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Entreprise $entreprise)
    {
        $form = $this->createDeleteForm($entreprise);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($entreprise);
            $em->flush();
        }

        return $this->redirectToRoute('profile_ent_index');
    }

    /**
     * Creates a form to delete a Entreprise entity.
     *
     * @param Entreprise $entreprise The Entreprise entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Entreprise $entreprise)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('profile_ent_delete', array('id' => $entreprise->getId())))
            ->setMethod('DELETE')
            ->getForm()
            ;
    }
}
