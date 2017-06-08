<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use AppBundle\Entity\Habitaciones;

class HabitacionesType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('nombre', TextType::class, array('attr' => array('class' => 'form-control', 'placeholder'=>'Nombre')))
            ->add('planta', IntegerType::class, array(
                'attr' => array('class' => 'form-control', 'min' => $options['limit_min'], 'max' => $options['limit'])))
            ->add('idhotel', EntityType::class, array(
                'class' => 'AppBundle:Hoteles',
                'label' => 'Hotel',
                'attr' => array('class' => 'form-control')))
             ->add('idtipohab', EntityType::class, array(
                'class' => 'AppBundle:Tipohabs',
                'label' => 'Tipo de Habitación',
                'attr' =>array('class' => 'form-control')))
            ->add('save', SubmitType::class, array('label' => 'Guardar', 'attr'=>array('class'=>'form-control')))
            ;
    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => Habitaciones::class,
            'limit' => null,
            'limit_min' => null
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'appbundle_habitaciones';
    }


}
