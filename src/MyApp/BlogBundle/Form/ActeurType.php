<?php

namespace MyApp\BlogBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;

class ActeurType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nom', 'text', array('label' => 'Nom de famille '))
            ->add('prenom', 'text', array('label' => 'Prénom'))
            ->add('dateNaissance', 'birthday', array('label' => 'Naissance')) 
            ->add('sexe', 'choice', array('choices' => array('F'=>'Féminin','M'=>'Masculin')))
           ->add('image') 
        ;
    }
    
    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'MyApp\BlogBundle\Entity\Acteur'
        ));
    }
}
