<?php
namespace AppBundle\Form;

use AppBundle\Entity\Hoteles;
use AppBundle\Form\HabitacionType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class HotelesType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('nombre')->add('categoria')
            ->add('telefono')->add('email')->add('localizacion')
            ->add('slug');
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => Hoteles::class,
        ));
    }
}