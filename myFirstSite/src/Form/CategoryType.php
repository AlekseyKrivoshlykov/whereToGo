<?php

namespace App\Form;

use App\Entity\Category;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CategoryType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('image', FileType::class, array (
                'label' => 'Главное изображение',
                'required' => false,
                'mapped' => false,
            ))
            ->add('title', TextType::class, array (
                'label' => 'Заголовок категории',
                'attr' => [
                    'placeholder' => 'Введите текст',
                ]
            ))
            ->add('description', TextareaType::class, array (
                'label' => 'Описание категории',
                'attr' => [
                    'placeholder' => 'Введите описание',
                ]
            ))
            ->add('save', SubmitType::class, array (
                'label' => 'Сохранить',
                'attr' => [
                    'class' => 'btn btn-success btn-form-success mt-2',
                ]
            ))
            ->add('delete', SubmitType::class, array (
                'label' => 'Удалить',
                'attr' => [
                    'class' => 'btn btn-danger mt-2',
                ]
            ));
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Category::class,
        ]);
    }
}
