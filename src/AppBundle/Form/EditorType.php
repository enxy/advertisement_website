<?php
/**
 * Created by PhpStorm.
 * User: Jolanta
 * Date: 18.04.2018
 * Time: 10:38
 */
namespace AppBundle\Form;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\AbstractType;
use Ivory\CKEditorBundle\Form\Type\CKEditorType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;

class EditorType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('content', CKEditorType::class, array(
            'config' => array(
                'uiColor' => '#ffffff',
                'extraPlugins' => "save",
            ),
            'plugins' => array(
                'save' => array(
                    'path'     => '../../../web/bundles/ivoryckeditor/plugins/save/',
                    'filename' => 'plugin.js',),
            ),
            'input_sync' => true,
            'inline' => true
        ));
    }
}