<?php

namespace CandidaturesBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use CandidaturesBundle\Entity\Offres;
use CandidaturesBundle\Form\OffresType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

/**
 * Offres controller.
 *
 * @Route("/offres")
 */
class OffresController extends Controller
{
    /**
     * Lists all Offres entities.
     *
     * @Route("/", name="offres_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $offres = $em->getRepository('CandidaturesBundle:Offres')->findAll();

        return $this->render('CandidaturesBundle:offres:index.html.twig', array(
            'offres' => $offres,
        ));
    }

    /**
     * Creates a new Offres entity.
     *
     * @Route("/new", name="offres_new")
     * @Method({"GET", "POST"})
     * @Security("has_role('ROLE_ENTREPRISE')")
     */
    public function newAction(Request $request)
    {
        $offre = new Offres();
        $form = $this->createForm('CandidaturesBundle\Form\OffresType', $offre);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            // On assigne l'entreprise en cours a l'offre :
            $offre->setEntreprise($em->getRepository('OCUserBundle:Entreprise')->findBy(
                array(
                    'user' => $this->getUser(),
                )
            )[0]);
            $em->persist($offre);
            $em->flush();

            return $this->redirectToRoute('offres_show', array('id' => $offre->getId()));
        }

        return $this->render('CandidaturesBundle:offres:new.html.twig', array(
            'offre' => $offre,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Offres entity.
     *
     * @Route("/{id}", name="offres_show")
     * @Method("GET")
     */
    public function showAction(Offres $offre)
    {
        $deleteForm = $this->createDeleteForm($offre);

        return $this->render('CandidaturesBundle:offres:show.html.twig', array(
            'offre' => $offre,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Offres entity.
     *
     * @Route("/{id}/edit", name="offres_edit")
     * @Method({"GET", "POST"})
     * @Security("has_role('ROLE_ENTREPRISE')")
     */
    public function editAction(Request $request, Offres $offre)
    {
        // Verification des droits
        $this->isEntrperiseProprietaireOrAdmin($offre->getEntreprise()->getUser());

        $deleteForm = $this->createDeleteForm($offre);
        $editForm = $this->createForm('CandidaturesBundle\Form\OffresType', $offre);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($offre);
            $em->flush();

            return $this->redirectToRoute('offres_show', array('id' => $offre->getId()));
        }

        return $this->render('CandidaturesBundle:offres:edit.html.twig', array(
            'offre' => $offre,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a Offres entity.
     *
     * @Route("/{id}", name="offres_delete")
     * @Method("DELETE")
     * @Security("has_role('ROLE_ENTREPRISE')")
     */
    public function deleteAction(Request $request, Offres $offre)
    {
        // Verification des droits
        $this->isEntrperiseProprietaireOrAdmin($offre->getEntreprise()->getUser());

        $form = $this->createDeleteForm($offre);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($offre);
            $em->flush();
        }

        return $this->redirectToRoute('offres_index');
    }

    /**
     * Creates a form to delete a Offres entity.
     *
     * @param Offres $offre The Offres entity
     * @Security("has_role('ROLE_ENTREPRISE')")
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Offres $offre)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('offres_delete', array('id' => $offre->getId())))
            ->setMethod('DELETE')
            ->getForm()
            ;
    }

    /**
     * Verifie que l'utilisateur passé est l'utilisateur en cours, ou que l'utilisateur en cours est un admin
     * @param $user
     * @throws AccessDeniedException
     */
    private function isEntrperiseProprietaireOrAdmin($user)
    {
        if($this->getUser() !== $user && !in_array('ROLE_ADMIN',$this->getUser()->getRoles())) {
            throw new AccessDeniedException();
        }
    }
}
