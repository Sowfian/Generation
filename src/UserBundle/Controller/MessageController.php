<?php

namespace UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;
use UserBundle\Entity\Groupe;

class MessageController extends Controller
{
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();
        $groups = $em->getRepository('UserBundle:Groupe')->findAll();


        return $this->render('UserBundle:Message:index.html.twig',
            array('groups' => $groups)
        );
    }

    public function composeAction(Groupe $groupe, Request $request) {

        $data = array(
            'sujet' => 'Le sujet du mail',
            'message' => 'Votre message...');

        $form = $this->createFormBuilder($data)
            ->add('sujet', TextType::class)
            ->add('message', TextareaType::class)
            ->add('save', SubmitType::class, array('label' => 'Envoyer'))
            ->getForm();

        $form->handleRequest($request);

        $adherents = $groupe->getAdherents()->getValues();
        $nbAdhent = count($adherents);
        if ($form->isSubmitted() && $form->isValid()) {
            foreach ($adherents as $ad) {
                $message = \Swift_Message::newInstance()
                    ->setSubject('Une personne est intéressé par votre annonce')
                    ->setFrom(array('monbonhlmmtp@gmail.com' => "MonbonHLM"))
                    ->setTo($ad->getEmail())
                    ->setCharset('utf-8')
                    ->setContentType('text/html')
                   // ->setBody($this->renderView('UserBundle:Message:messageauteur.html.twig',
                    ->setBody("Test Email !! Salut !!");
                var_dump($this->get('swiftmailer.mailer')->send($message));
            }

            return $this->render('UserBundle:Message:messageok.html.twig',
                array( 'groupe' => $groupe)
            );
        }

        return $this->render('UserBundle:Message:compose.html.twig',
            array( 'groupe' => $groupe,
                'form' => $form->createView(),
                'nbAdherents' => $nbAdhent)
        );
    }


    public function sendAction(Request $request) {

    }
}
