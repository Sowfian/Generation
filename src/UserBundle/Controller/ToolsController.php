<?php

namespace UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class ToolsController extends Controller
{
    public function exportAction()
    {
        $adherents = $em->getRepository('UserBundle:Adherent');

        $response = new StreamedResponse();
        $response->setCallback(function() use ($adherents) {
            $handle = fopen('php://output', 'w+');

            fputcsv($handle, ['Nom', 'Prénom', 'Date de naissance', 'Adresse', 'Code postal', 'Ville', 'Département', 'Email', 'Téléphone', 'Niveau', 'Groupe'], ';');

            $results = $adherents->findAll();
            foreach ($results as $adherent) {
                fputcsv(
                    $handle,
                    [$adherent->getNom(), $adherent->getPrenom(), $adherent->getDateNaissance(), $adherent->getAdresse(), $adherent->getCodePostal(), $adherent->getVille(), $adherent->getDepartement(), $adherent->getEmail(), $adherent->getTelephone(), $adherent->getNiveau(), $adherent->getGroupe()->getNom()],
                    ';'
                );
            }

            var_dump($handle);die;

            fclose($handle);
        });

        $response->setStatusCode(200);
        $response->headers->set('Content-Type', 'text/csv; charset=utf-8');
        $response->headers->set('Content-Disposition','attachment; filename="export-adherents.csv"');

        return $response;

    }

    public function deleteAction()
    {
        $adherents = $em->getRepository('UserBundle:Adherent')->findAll();

        $em = $this->getDoctrine()->getManager();
        $em->remove($adherents);
        $em->flush();

        return $this->redirectToRoute('user_homepage');
    }
}
