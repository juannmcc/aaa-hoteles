<?php
namespace AppBundle\Form;

use AppBundle\Entity\Personas;
use AppBundle\Entity\Registros;
use AppBundle\Form\RegistroType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PersonaType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('nombre')->add('apellidos')->add('save', SubmitType::class, array('label' => 'Guardar', 'attr'=>array('class'=>'form-control')))
            /*->add('registros', CollectionType::class, array(
                'entry_type'     => RegistrosType::class,
                'label'          => 'Registros',
                'by_reference'   => false,
                'prototype_data' => Registros::class,
                'allow_delete'   => true,
                'allow_add'      => true,
                'attr'           => array(
                    'class' => 'row'
                )
            ))*/;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => Personas::class,
        ));
    }
}