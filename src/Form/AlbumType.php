<?php

namespace App\Form;

use App\Entity\Album;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AlbumType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add(
                'name',
                TextType::class,
                [
                    'label' => 'Nom',
                    'attr' => [
                        'placeholder' => 'Nom de l\'album...',
                    ],
                    'label_attr' => [
                        'class' => 'form-label text-uppercase letter-spacing mb-2'
                    ],
                ]
            )
            ->add(
                'description',
                TextareaType::class,
                [
                    'label' => 'Description',
                    'attr' => [
                        'placeholder' => 'Description de l\'album...',
                    ],
                    'label_attr' => [
                        'class' => 'form-label text-uppercase letter-spacing mb-2'
                    ],
                ]
            )
            ->add(
                'isPrivate',
                CheckboxType::class,
                [
                    'label' => 'Privé ?',
                    'required' => false,
                    'label_attr' => [
                        'class' => 'form-check-label text-uppercase letter-spacing mb-2'
                    ],
                    'attr' => [
                        'class' => 'form-check-input fs-5',
                        'role' => "switch"
                    ],
                    'row_attr' => ['class' => "form-check form-switch"],
                ],
            );
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Album::class,
        ]);
    }
}
