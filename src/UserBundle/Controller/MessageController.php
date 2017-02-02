<?php

namespace UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class MessageController extends Controller
{
    public function indexAction()
    {
        $data = array();
        $form = $this->createFormBuilder($data)
            ->add('groupe', EntityType::class, array(
                'class' => 'UserBundle:Groupe',
                'choice_label' => 'nom',
                'multiple' => true, ))
            ->add('sujet', TextType::class)
            ->getForm();
        
        if ($form->isSubmitted() && $form->isValid()) {

            $message = \Swift_Message::newInstance()
                ->setSubject('Une personne est intéressé par votre annonce')
                ->setFrom(array('monbonhlmmtp@gmail.com' => "MonbonHLM"))
                ->setTo($annonce->getAuteur()->getEmailCanonical())
                ->setCharset('utf-8')
                ->setContentType('text/html')
                ->setBody($this->renderView('MonbonHLMHomeBundle:Message:messageauteur.html.twig',
                    array('adherant' => $adherant,)));

            $this->get('mailer')->send($message);

            return $this->render('UserBundle:Message:messageok.html.twig');
        }
    }
}
