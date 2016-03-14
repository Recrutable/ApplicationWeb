<?php

namespace OCUserBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

use OCUserBundle\Entity\Chomeur;
use OCUserBundle\Form\ChomeurType;
/**
 * Chomeur controller.
 *
 * @Route("/profile_usr")
 * @Security("has_role('ROLE_CHOMEUR')")
 */
class ChomeurController extends UserController
{
    /**
     * Liste de tous les chomeurs, (Zone Admin)
     *
     * @Route("/", name="profile_usr_index")
     * @Method("GET")
     *
     * @Security("has_role('ROLE_ADMIN')")
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
     * Crée un nouveau chomeur
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
            // On passe le user
            $chomeur->setUser($this->getUser());
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
     * Affiche le profil du chomeur {id}
     *
     * @Route("/{id}", name="profile_usr_show")
     * @Method("GET")
     */
    public function showAction(Chomeur $chomeur)
    {
        // On vérifie les droits
        $this->verifIsUserOrAdmin($chomeur->getUser());

        // On crée le form de supression
        $deleteForm = $this->createDeleteForm($chomeur);

        // On rend la vue
        return $this->render('OCUserBundle:Chomeur:show.html.twig', array(
            'chomeur' => $chomeur,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Edition du chomeur {id}
     *
     * @Route("/{id}/edit", name="profile_usr_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Chomeur $chomeur)
    {
        // On vérifie les droits de la demande
        $this->verifIsUserOrAdmin($chomeur->getUser());

        // On récupere les forms
        $deleteForm = $this->createDeleteForm($chomeur);
        $editForm = $this->createForm('OCUserBundle\Form\ChomeurType', $chomeur);
        $editForm->handleRequest($request);

        // Si validation, on update
        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($chomeur);
            $em->flush();

            // Et on redirige
            return $this->redirectToRoute('profile_usr_edit', array('id' => $chomeur->getId()));
        }

        // On retourne la vue
        return $this->render('OCUserBundle:Chomeur:edit.html.twig', array(
            'chomeur' => $chomeur,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Suppression du chomeur {id}
     *
     * @Route("/{id}", name="profile_usr_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Chomeur $chomeur)
    {
        // On vérifie les droits
        $this->verifIsUserOrAdmin($chomeur->getUser());

        // On crée le form de supression
        $form = $this->createDeleteForm($chomeur);
        $form->handleRequest($request);

        // Si c'est OK, on suprime
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($chomeur);
            $em->flush();
        }

        // On redirige sur la page d'index si c'est un admin, sur la page de logout sinon
        $routingRedirect = 'fos_user_security_logout';
        if(in_array('ROLE_ADMIN',$this->getUser()->getRoles())) {
            $routingRedirect = 'profile_usr_index';
        }
        return $this->redirectToRoute($routingRedirect);
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
