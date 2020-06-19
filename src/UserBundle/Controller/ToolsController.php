<?php

namespace UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use UserBundle\Entity\Adherent;
use UserBundle\Entity\Groupe;
use Symfony\Component\HttpFoundation\StreamedResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;


class ToolsController extends Controller
{
    public function exportAction()
    {

        $results = $this->getDoctrine()->getManager()->getRepository('UserBundle:Adherent')->findAll();

        $response = new StreamedResponse();

        $response->setCallback(
            function () use ($results) {
                $handle = fopen('php://output', 'r+');
                foreach ($results as $row) {

                    //array list fields you need to export
                    $data = array(
                    	$row->getId(),
                        $row->getNom(),
                        $row->getPrenom(),
                        $row->getAdresse(),
                        $row->getCodePostal(),
                        $row->getVille(),
                        $row->getDepartement(),
                        $row->getEmail(),
                        $row->getTelephone(),
                    );
                    fputcsv($handle, $data);
                }
                fclose($handle);
            }
        );
        $response->headers->set('Content-Type', 'application/force-download');
        $response->headers->set('Content-Disposition', 'attachment; filename="export.csv"');

        return $response;
    
    }


    public function deleteAction()
    {

        $adherents = $this->getDoctrine()->getManager()->getRepository('UserBundle:Adherent')->findAll();

		foreach ($adherents as $adherent) {
		    $this->getDoctrine()->getManager()->remove($adherent);
		}

		$this->getDoctrine()->getManager()->flush();

        return $this->redirectToRoute('user_homepage');
    }
}
