<?php

namespace App\Form;

use App\Entity\Institution;
use App\Entity\Therapist;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\EqualTo;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Regex;
use Symfony\Component\Validator\Constraints\Type;

class RegisterType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('firstName', TextType::class, [
                'label' => 'Prénom',
                'required' => true,
                'attr' => [
                    'placeholder' => 'Votre Prénom',
                    'class' => 'form-control'
                ],
                'constraints' => [
                    new NotBlank(),
                    new Length([
                        'max' => 50
                    ])
                ]
            ])
            ->add('lastName', TextType::class, [
                'label' => 'Nom',
                'attr' => [
                    'placeholder' => 'Votre Nom',
                    'class' => 'form-control'
                ],
                'constraints' => [
                    new NotBlank(),
                    new Length([
                        'max' => 50
                    ])
                ]
            ])
            ->add('job', TextType::class, [
                'label' => 'Fonction',
                'attr' => [
                    'placeholder' => 'Votre Fonction',
                    'class' => 'form-control'
                ],
                'constraints' => [
                    new NotBlank(),
                    new Length([
                        'max' => 100
                    ])
                ]
            ])
            ->add('institution', EntityType::class, [
                'label' => 'Institution/Entreprise',
                'required' => true,
                'attr' => [
                    'placeholder' => 'Votre Entreprise ou Institution',
                    'class' => 'form-control'
                ],
                'class' => Institution::class,
                'choice_label' => 'name'
            ])
            ->add('institutionCode', TextType::class, [
                'label' => 'Code fourni par l\'Entreprise/Institut',
                'required' => true,
                'attr' => [
                    'placeholder' => 'Code de votre Entreprise ou Institution',
                    'class' => 'form-control'
                ],
                'mapped' => false,
                /*'constraints' => [
                    new EqualTo('Institution::class->getCode()')
                ]*/
            ])
            ->add('email', EmailType::class, [
                'label' => 'Email',
                'required' => true,
                'attr' => [
                    'placeholder' => 'Votre Email',
                    'class' => 'form-control'
                ]
            ])
            ->add('password', RepeatedType::class, [
                'type' => PasswordType::class,
                'invalid_message' => 'Le mot de passe et la confirmation doivent être identiques',
                'label' => 'Mot de Passe',
                'required' => true,
                'first_options' => [
                    'label' => 'Mot de Passe',
                    'attr' => [
                        'placeholder' => 'Votre Mot de Passe',
                        'class' => 'form-control'
                    ],
                    'constraints' => [
                        new Regex([
                            'pattern' => '/^((?=\S*?[A-Z])(?=\S*?[a-z])(?=\S*?[0-9]).{6,})\S$/',
                            'message' => 'Le mot de passe doit être doté d\'au moins 6 caractères et doit contenir au moins une majuscule, un petit caractère et un chiffre.'
                        ])
                    ],
                    'help' => 'Le mot de passe doit être doté d\'au moins 6 caractères et doit contenir au moins une majuscule, un petit caractère et un chiffre.'
                ],
                'second_options' => [
                    'label' => 'Confirmation du Mot de Passe',
                    'attr' => [
                        'placeholder' => 'Confirmation de Votre Mot de Passe',
                        'class' => 'form-control'
                    ]]
            ])
            ->add('submit', SubmitType::class, [
                'label' => 'S\'inscrire',
                'attr' => [
                    'class' => 'btn register'
                ]
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
