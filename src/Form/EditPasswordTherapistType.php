<?php

namespace App\Form;

use App\Entity\Therapist;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Regex;

class EditPasswordTherapistType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('oldPassword', PasswordType::class, [
                'label' => 'Mot de Passe Actuel',
                'mapped' => false,
                'attr' => [
                    'placeholder' => 'Saisir le mot de passe actuel',
                    'class' => 'form-control mb-2 mx-auto w-50'
                ],
                'constraints' => [
                    new NotBlank()
                ]
            ])
            ->add('newPassword', RepeatedType::class, [
                'type' => PasswordType::class,
                'mapped' => false,
                'invalid_message' => 'Le nouveau mot de passe et la confimation du nouveau mot de passe doivent être identiques.',
                'required' => true,
                'constraints' => [
                    new NotBlank(),
                    new Regex([
                        'pattern' => '/^((?=\S*?[A-Z])(?=\S*?[a-z])(?=\S*?[0-9]).{6,})\S$/',
                        'message' => 'Le mot de passe doit être doté d\'au moins 6 caractères et doit contenir au moins une majuscule, un petit caractère et un chiffre.'
                    ])
                ],
                'first_options' => [
                    'label' => 'Nouveau Mot de Passe',
                    'attr' => [
                        'placeholder' => 'Saisir le nouveau mot de passe',
                        'class' => 'form-control mb-2 mx-auto w-50'
                    ]
                ],
                'second_options' => [
                    'label' => 'Confirmation du Nouveau Mot de Passe',
                    'attr' => [
                        'placeholder' => 'Confirmer le nouveau mot de passe',
                        'class' => 'form-control mb-2 mx-auto w-50'
                    ]
                ]
            ])
            ->add('submit', SubmitType::class, [
                'label' => 'Modifier le Mot de Passe'
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Therapist::class,
        ]);
    }
}
