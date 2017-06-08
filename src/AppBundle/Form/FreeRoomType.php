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
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DatetimeType;
use Symfony\Component\Form\Extension\Core\Type\FormType;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class FreeRoomType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {

     /*   $builder->create('tipohabs', FormType::class, array('by_reference' => false))
    ->add('tipoHab', ChoiceType::class, array('label' => 'Tipo de Habitación')))
    'tipohabs', 'collection', array(
                    'type' => new TipoHabsType(), 
                    'allow_add' => true,))

                    $builder->create('registros', FormType::class, array('by_reference' => false))
                        ->add('fechaEntrada', DateTimeType::class, array(
                            'placeholder' => array(
                                'year' => 'Year', 'month' => 'Month', 'day' => 'Day',
                                'hour' => 'Hour', 'minute' => 'Minute', 'second' => 'Second',
                            ), 'label' => 'Fecha de Entrada '))
                        ->add('fechaSalida', DateTimeType::class, array(
                            'placeholder' => array(
                                'year' => 'Year', 'month' => 'Month', 'day' => 'Day',
                                'hour' => 'Hour', 'minute' => 'Minute', 'second' => 'Second',
                            ), 'label' => 'Fecha de Salida '))
                    */

        $builder->add('planta', IntegerType::class, array(
            'attr' => array('class' => 'form-control', 'min' => 1, 'max' => $options['limit'])))
            ->add('tipohabs', 'collection', array(
                'type' => new TipoHabsType(), 
                'allow_add' => true,))
            ->add('nombre', TextType::class, array(
                'class' => 'form-control',
                'label' => 'Nombre'))
            ->add('personas', 'collection', array(
                'type' => new PersonaType(), 
                'allow_add' => true,))
            ->add('personas', 'collection', array(
                'type' => new PersonaType(), 
                'allow_add' => true,))
            ->add('Registrar clientes', SubmitType::class);
    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Habitaciones',
            'limit' => null,
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'appbundle_habitaciones';
    }

    /* Relacionar Con habitaciones */

 /*   public function addRelations(
        \AppBundle\Entity\Personas $personas,
        \AppBundle\Entity\Registros $registros,
        \AppBundle\Entity\Tipohabs $tipohabs) {

        $registros->setIdhabitacion($this)
        $personas->addIdregistro($registros->getId());
        $registros->addIdpersona($personas->getId());
        $registros->addIdhabitacion($)
        $this->habitaciones->add($habitaciones);
    }*/


}