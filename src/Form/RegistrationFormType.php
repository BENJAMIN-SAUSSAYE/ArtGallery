<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\IsTrue;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class RegistrationFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('firstname', TextType::class, [
                'attr' => [
                    'class' => 'form-control border border-light placeholder-style mb-3',
                ],
                'label' => 'Prénom',
                'label_attr' => [
                    'class' => 'form-label text-uppercase letter-spacing mb-3'
                ],
            ])
            ->add('lastname', TextType::class, [
                'attr' => [
                    'class' => 'form-control border border-light placeholder-style mb-3',
                ],
                'label' => 'Nom',
                'label_attr' => [
                    'class' => 'form-label text-uppercase letter-spacing mb-3'
                ],
            ])
            ->add('email', EmailType::class, [
                'attr' => [
                    'class' => 'form-control border border-light placeholder-style mb-3',
                ],
                'label_attr' => [
                    'class' => 'form-label text-uppercase letter-spacing mb-3'
                ],
            ])
            ->add('agreeTerms', CheckboxType::class, [
                'mapped' => false,
                'attr' => [
                    'class' => 'form-check border border-light placeholder-style mb-3',
                ],
                'label_attr' => [
                    'class' => 'mx-3'
                ],
                'constraints' => [
                    new IsTrue([
                        'message' => 'Vous devez accepter les conditions générales.',
                    ]),
                ],
            ])
            ->add('plainPassword', PasswordType::class, [
                // instead of being set onto the object directly,
                // this is read and encoded in the controller
                'always_empty' => false,
                'mapped' => false,
                'label' => 'Mot de passe',
                'label_attr' => [
                    'class' => 'form-label text-uppercase letter-spacing mb-3'
                ],
                'attr' => [
                    'autocomplete' => 'new-password',
                    'class' => 'form-control border border-light placeholder-style mb-3'
                ],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Merci de saisir un mot de passe',
                    ]),
                    new Length([
                        'min' => 6,
                        'minMessage' => 'Votre mot de passe doit faire au moins {{ limit }} caractères',
                        // max length allowed by Symfony for security reasons
                        'max' => 4096,
                    ]),
                ],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
