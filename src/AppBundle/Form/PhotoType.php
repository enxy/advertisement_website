<?php
/**
 * Created by PhpStorm.
 * User: Jolanta
 * Date: 01.04.2018
 * Time: 16:16
 */

namespace AppBundle\Form;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\AbstractType;
use AppBundle\Entity\Admin;

class PhotoType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('photo',
            FileType::class,
            array(
                'label'=>'Wybierz zdjęcie  ',
                'data_class' => null
            ));
    }
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(
            [
                'data_class' => Admin::class,
                'validation_groups' => 'photo-default',
            ]
        );
    }
}