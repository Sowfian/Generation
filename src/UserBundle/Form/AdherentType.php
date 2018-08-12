<?php

namespace UserBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\BirthdayType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class AdherentType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nom', TextType::class, array('required' => false))
            ->add('prenom', TextType::class, array('required' => false))
            ->add('dateNaissance', BirthdayType::class, array('required' => false))
            ->add('adresse', TextType::class, array('required' => false))
            ->add('codePostal', TextType::class, array('required' => false))
            ->add('ville', TextType::class, array('required' => false))
            ->add('departement', TextType::class, array('required' => false))
            ->add('email', TextType::class, array('required' => false))
            ->add('telephone', TextType::class, array('required' => false))
            ->add('niveau', ChoiceType::class, array(
                'choices'  => array(
                    'Enfant' => 'Enfant',
                    'Adulte' => 'Adulte',
                    'AquaGym' => 'AquaGym',
                )))
            ->add('groupe', EntityType::class, array(
                'class' => 'UserBundle:Groupe',
                'choice_label' => 'nom',
                'multiple' => true, ))
            ->add('save', SubmitType::class, array('label' => 'Envoyer'));
    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'UserBundle\Entity\Adherent'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'userbundle_adherent';
    }


}
