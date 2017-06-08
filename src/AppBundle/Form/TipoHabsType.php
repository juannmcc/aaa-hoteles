<?php // src/AppBundle/Form/Type/TagType.php
namespace AppBundle\Form;

use AppBundle\Entity\TipoHabs;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TipoHabsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('tipoHab')->add('precioBase')
        ->add('save', SubmitType::class, array('label' => 'Guardar tipo'));;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => TipoHabs::class,
        ));
    }
}