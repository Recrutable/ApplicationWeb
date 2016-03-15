<?php

namespace OCUserBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use OCUserBundle\Entity\Chomeur;
use OCUserBundle\Form\ChomeurType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

use OCUserBundle\Entity\Entreprise;
use OCUserBundle\Form\EntrepriseType;


/**
 * Entreprise controller.
 *
 * @Route("/profile_ent")
 * @Security("has_role('ROLE_ENTREPRISE')")
 */
class EntrepriseController extends UserController
{
    /**
     * Lists all Entreprise entities.
     *
     * @Route("/", name="profile_ent_index")
     * @Method("GET")
     * @Security("has_role('ROLE_ADMIN')")
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
     * Crée une nouvelle entreprise
     *
     * @Route("/new", name="profile_ent_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        // On crée le form
        $entreprise = new Entreprise();
        $form = $this->createForm(
            'OCUserBundle\Form\EntrepriseType',
            $entreprise,
            array(
                'action' => $this->generateUrl('profile_ent_new'),
            )
        );
        $form->handleRequest($request);

        // Si c'est ok, on insere
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            // On passe le user
            $entreprise->setUser($this->getUser());
            $em->persist($entreprise);
            $em->flush();

            // Et on redirige
            return $this->redirectToRoute('profile_ent_show', array('id' => $entreprise->getId()));
        }

        // On rend le formulaire
        return $this->render('OCUserBundle:Entreprise:new.html.twig', array(
            'entreprise' => $entreprise,
            'form' => $form->createView(),
        ));
    }

    /**
     * Affiche le profil de l'entreprise {id}
     *
     * @Route("/{id}", name="profile_ent_show")
     * @Method("GET")
     */
    public function showAction(Entreprise $entreprise)
    {
        $this->verifIsUserOrAdmin($entreprise->getUser());
        $deleteForm = $this->createDeleteForm($entreprise);

        return $this->render('OCUserBundle:Entreprise:show.html.twig', array(
            'entreprise' => $entreprise,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Edition de l'entreprise {id}
     *
     * @Route("/{id}/edit", name="profile_ent_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Entreprise $entreprise)
    {
        // On vérifie les droits de la demande
        $this->verifIsUserOrAdmin($entreprise->getUser());

        // On récupere les forms
        $deleteForm = $this->createDeleteForm($entreprise);
        $editForm = $this->createForm('OCUserBundle\Form\EntrepriseType', $entreprise);
        $editForm->handleRequest($request);

        // Si validation, on update
        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entreprise);
            $em->flush();

            // Et on redirige
            return $this->redirectToRoute('profile_ent_show', array('id' => $entreprise->getId()));
        }

        // On retourne la vue
        return $this->render('OCUserBundle:Entreprise:edit.html.twig', array(
            'entreprise' => $entreprise,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Suppression de l'entreprise {id}
     *
     * @Route("/{id}", name="profile_ent_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Entreprise $entreprise)
    {
        // On vérifie les droits
        $this->verifIsUserOrAdmin($entreprise->getUser());

        // On crée le form de supression
        $form = $this->createDeleteForm($entreprise);
        $form->handleRequest($request);

        // Si c'est OK, on suprime
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($entreprise);
            $em->flush();
        }

        // On redirige sur la page d'index si c'est un admin, sur la page de logout sinon
        $routingRedirect = 'fos_user_security_logout';
        if(in_array('ROLE_ADMIN',$this->getUser()->getRoles())) {
            $routingRedirect = 'profile_ent_index';
        }
        return $this->redirectToRoute($routingRedirect);
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
            ->getForm();
    }
}
