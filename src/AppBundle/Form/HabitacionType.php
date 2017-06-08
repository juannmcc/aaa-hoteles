<?php
namespace AppBundle\Form;

use AppBundle\Entity\Habitaciones;
use AppBundle\Form\TipoHabsType;
use AppBundle\Form\HotelesType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class HabitacionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('nombre')->add('planta')
            ->add('idTipoHab', TipoHabsType::class, array(
                'attr' => array('class' => 'form-control')
            ))->add('idHotel', HotelesType::class, array(
                'attr' => array('class' => 'form-control')
            ));
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => Habitaciones::class,
        ));
    }

        /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'appbundle_habitacion';
    }
}