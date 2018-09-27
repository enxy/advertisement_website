<?php
/**
 * Created by PhpStorm.
 * User: Jolanta
 * Date: 28.03.2018
 * Time: 10:22
 */

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;

class AdminPasswordType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options){
        $builder->add(
            'password',
            RepeatedType::class,
            [
                'type' => PasswordType::class,
                'invalid_message' => 'Niepoprawne haslo',
                'options' => array('attr' => array('class' => 'password-field')),
                'required' => true,
                'first_options'  => array('label' => 'Haslo'),
                'second_options' => array('label' => 'Powtorz haslo'),
            ]
        );
    }

}