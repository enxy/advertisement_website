<?php
/**
 * Created by PhpStorm.
 * User: Jolanta
 * Date: 28.03.2018
 * Time: 10:15
 */

namespace AppBundle\Form;

use AppBundle\Entity\User;
use Doctrine\DBAL\Types\IntegerType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class AccountType extends AbstractType{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add(
            'name',
            TextType::class,
            [
                'label' => 'Name',
                'attr' => [
                    'max_length' => 25,
                ],
            ]
        );
        $builder->add(
            'surname',
            TextType::class,
            [
                'label' => 'Surname',
                'attr' => [
                    'max_length' => 25,
                ],
            ]
        );
        $builder->add(
            'username',
            TextType::class,
            [
                'label' => 'Username',
                'required' => true,
                'attr' => [
                    'max_length' => 25,
                ],
            ]
        );
        $builder->add(
            'email',
            EmailType::class,
            [
                'label' => 'Email',
                'required' => true,
                'attr' => [
                    'max_length' => 25,
                ],
            ]
        );
        $builder->add(
            'phone',
            NumberType::class,
            [
                'label' => 'Phone',
                'attr' => [
                    'max_length' => 25,
                ],
            ]
        );
    }
}