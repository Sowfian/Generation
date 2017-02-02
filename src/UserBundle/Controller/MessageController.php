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
            ->add('body', TextType::class)
            ->getForm();

        if ($form->isSubmitted() && $form->isValid()) {

            $message = \Swift_Message::newInstance()
                ->setSubject('Informations GENERATION PAUL VALÉRY')
                ->setFrom(array('monbonhlmmtp@gmail.com' => "GÉNÉRATION PAUL VALERY"))
                ->setTo($groupe)
                ->setCharset('utf-8')
                ->setContentType('text/html')
                ->setBody($body);

            $this->get('mailer')->send($message);

            return $this->render('UserBundle:Message:messageok.html.twig');
        }
    }
}
