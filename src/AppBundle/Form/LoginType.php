<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;

class LoginType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add(
            'email',
            TextType::class,
            [
                'label' => 'Email',
                'required' => true,
                'attr' => [
                    'max_length' => 25,
                    'min_length' => 3,
                ],
            ]
        )->add(
        'password',
        PasswordType::class,
        [
            'label' => 'Password',
            'required' => true,
            'attr' => [
                'max_length' => 128,
                'min_length' => 3,
            ]
        ]
    );
    }
}