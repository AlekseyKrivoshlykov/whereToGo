<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('email', EmailType::class, array (
                'label' => 'Введите email',

            ))
            ->add('plainPassword', RepeatedType::class, array (
                'type' => PasswordType::class, 
                    'first_options' => array (
                        'label' => 'Введите пароль',
                    ),
                    'second_options' => array (
                        'label' => 'Введите пароль повторно',
                    )
                
            ))
            ->add('save', SubmitType::class, array (
                'label' => 'Сохранить',
            ));
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
