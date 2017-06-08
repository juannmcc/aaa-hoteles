<?php
namespace AppBundle\Form;

use AppBundle\Entity\Registros;
use AppBundle\Form\HabitacionType;
use AppBundle\Entity\Personas;
use AppBundle\Form\PersonaType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use AppBundle\Form\Type\DateTimePickerType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;

class RegistrosType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('fechaEntrada', DateTimeType::class, array(
            'placeholder' => array(
                'year' => 'Year', 'month' => 'Month', 'day' => 'Day',
            )))
        ->add('fechaSalida', DateTimeType::class, array(
            'placeholder' => array(
                'year' => 'Year', 'month' => 'Month', 'day' => 'Day',
            )))
        ->add('estaPagado', CheckboxType::class, array('required' => false))
        /*->add('idHabitacion', HabitacionType::class, array(
            'attr' => array('class' => 'form-control')*/
        ->add('idHabitacion', EntityType::class, array(
            'class' => 'AppBundle:Habitaciones',
            'label' => 'Habitación',
            'multiple' => false,
            'expanded' => false,
            'attr' =>array('class' => 'form-control'),
            'query_builder' => null,
            'by_reference' => true, 
            'disabled' => true
        ))->add('idPersona', EntityType::class, array(
            'class' => 'AppBundle:Personas',
            'label' => 'Personas',
            'multiple' => true,
            'expanded' => false,
            'attr' =>array('class' => 'form-control'),
            'query_builder' => null,
            'by_reference' => true
          ))/*->add('idHotel', EntityType::class, array(
            'class' => 'AppBundle:Hoteles',
            'label' => 'Hotel',
            'multiple' => false,
            'expanded' => false,
            'attr' =>array('class' => 'form-control'),
            'query_builder' => null,
            'by_reference' => true,
            'disabled' => true*/
          ->add('save', SubmitType::class, array('label' => 'Ocupar habitación'));

            /*->add('personas', CollectionType::class, array(
                'entry_type'     => PersonaType::class,
                'label'          => 'Personas',
                'by_reference'   => false,
                'prototype_data' => Personas::class,
                'allow_delete'   => true,
                'allow_add'      => true,
                'attr'           => array(
                    'class' => 'row'
                )
            ));*/
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => Registros::class,
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'appbundle_registros';
    }
}