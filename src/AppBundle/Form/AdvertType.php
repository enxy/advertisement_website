<?php
/**
 * Created by PhpStorm.
 * User: Jolanta
 * Date: 28.03.2018
 * Time: 10:22
 */

namespace AppBundle\Form;

use AppBundle\Entity\Adverts;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Ivory\CKEditorBundle\Form\Type\CKEditorType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class AdvertType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add(
            'title',
            TextType::class,
            [
                'label' => 'Tytuł',
                'required' => true,
                'attr' => [
                    'max_length' => 25,
                ],
            ]
        );
        $builder->add(
            'content',
            CKEditorType::class,
            [
                'label' => 'Opis',
                'required' => true,
                'config' => array(
                    'uiColor' => '#ffffff',
                    'extraPlugins' => "save",
                ),
            ]
        );
        $builder->add(
            'photo',
            FileType::class,
            array(
                'label'=>'Dodaj zdjęcie',
                'data_class' => null,
            )
        );
        $builder->add(
            'category',
            ChoiceType::class,
            array(
                'choices'  => array(
                    'Wybierz' => 0,
                    'Kupię' => 'buy',
                    'Sprzedam' => 'sell',
                    'Wynajmę' => 'tenant',
                    'Oddam nieodpłątnie' => 'give',
                    ))
        );
        $builder->add(
            'voivodeship_id',
            EntityType::class,
            array(
                'label' => 'Województwo',
                'class' => 'AppBundle:Voivodeship',
                'choice_label' => 'name'
                )
        );
    }
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => Adverts::class,
        ));
    }
}