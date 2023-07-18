<?php

namespace App\Form;

use App\Entity\Picture;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Vich\UploaderBundle\Form\Type\VichFileType;

class PictureType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add(
                'title',
                TextType::class,
                [
                    'label' => 'Titre',
                    'label_attr' => [
                        'class' => 'form-check-label text-uppercase letter-spacing mb-2'
                    ],
                    'attr' => [
                        'placeholder' => 'Titre de l\'image...',
                    ],
                ]
            )
            ->add('file', VichFileType::class, [
                'required'      => false,
                // 'allow_add' => true,
                'allow_delete'  => true, // not mandatory, default is true
                'download_uri' => true, // not mandatory, default is true
                'label' => 'Images',
                'label_attr' => [
                    'class' => 'form-check-label text-uppercase letter-spacing mb-2'
                ],
                'by_reference' => false,
                'disabled' => false,
            ])
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
            )
            ->add(
                'isAlbumCover',
                CheckboxType::class,
                [
                    'label' => 'Couverture de l\'album ?',
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
            'data_class' => Picture::class,
        ]);
    }
}
