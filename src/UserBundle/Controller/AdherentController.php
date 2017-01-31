<?php

namespace UserBundle\Controller;

use UserBundle\Entity\Adherent;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * Adherent controller.
 *
 */
class AdherentController extends Controller
{
    /**
     * Lists all adherent entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $adherents = $em->getRepository('UserBundle:Adherent')->findAll();

        return $this->render('adherent/index.html.twig', array(
            'adherents' => $adherents,
        ));
    }

    /**
     * Creates a new adherent entity.
     *
     */
    public function newAction(Request $request)
    {
        $adherent = new Adherent();
        $form = $this->createForm('UserBundle\Form\AdherentType', $adherent);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($adherent);
            $em->flush($adherent);

            return $this->redirectToRoute('adherent_show', array('id' => $adherent->getId()));
        }

        return $this->render('adherent/new.html.twig', array(
            'adherent' => $adherent,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a adherent entity.
     *
     */
    public function showAction(Adherent $adherent)
    {
        $deleteForm = $this->createDeleteForm($adherent);
        $groupes = $adherent->getGroupe()->getValues();
        return $this->render('adherent/show.html.twig', array(
            'adherent' => $adherent,
            'delete_form' => $deleteForm->createView(),
            'groupes' => $groupes,
        ));
    }

    /**
     * Displays a form to edit an existing adherent entity.
     *
     */
    public function editAction(Request $request, Adherent $adherent)
    {
        $deleteForm = $this->createDeleteForm($adherent);
        $editForm = $this->createForm('UserBundle\Form\AdherentType', $adherent);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('adherent_edit', array('id' => $adherent->getId()));
        }

        return $this->render('adherent/edit.html.twig', array(
            'adherent' => $adherent,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a adherent entity.
     *
     */
    public function deleteAction(Request $request, Adherent $adherent)
    {
        $form = $this->createDeleteForm($adherent);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($adherent);
            $em->flush($adherent);
        }

        return $this->redirectToRoute('adherent_index');
    }

    /**
     * Creates a form to delete a adherent entity.
     *
     * @param Adherent $adherent The adherent entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Adherent $adherent)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('adherent_delete', array('id' => $adherent->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
