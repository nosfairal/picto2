<?php

namespace App\Form;

use App\Entity\Patient;
use App\Entity\Note;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\BirthdayType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class PatientRegisterType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            // Ajoute le champs firstname qui est de type "texte"
            ->add('firstname', TextType::class, [
                'label' => 'Prénom', // Label du champs
                'required' => true, // Le champs est requis
                'attr' => [
                    'placeholder' => 'Prénom du Patient',
                    'class' => 'form-control'
                ],
                // Ajoute des contraintes au champs
                'constraints' => [
                    new NotBlank(),
                    new Length([
                        'max' => 50
                    ])
                ]
            ])
            ->add('lastname', TextType::class, [
                'label' => 'Nom',
                'required' => true,
                'attr' => [
                    'placeholder' => 'Nom du Patient',
                    'class' => 'form-control'
                ],
                'constraints' => [
                    new NotBlank(),
                    new Length([
                        'max' => 50
                    ])
                ]
            ])
            ->add('birthday', BirthdayType::class, [
                'label' => 'Date de Naissance',
                'required' => true,
                'widget' => 'single_text',
                'attr' => [
                    'class' => 'form-control'
                ]
            ])
            ->add('schoolGrade', TextType::class, [
                'label' => 'Scolarité',
                'required' => true,
                'attr' => [
                    'placeholder' => 'Niveau Scolaire du Patient',
                    'class' => 'form-control'
                ],
                'constraints' => [
                    new Length([
                        'max' => 50
                    ])
                ]
            ])
            ->add('email', EmailType::class, [
                'label' => 'Email',
                'required' => true,
                'attr' => [
                    'placeholder' => 'Email du Patient',
                    'class' => 'form-control'
                ],
                'constraints' => [
                    new NotBlank(),
                    new Length([
                        'max' => 50
                    ])
                ]
            ])
            ->add('notes', CollectionType::class, [
                'entry_type' => NoteType::class,
                'entry_options' => ['label' => false],
                'allow_add' => true,
                'required' => true,
                'label' => 'Problématiques du Patient',
            ])
            ->add('submit', SubmitType::class, [
                'label' => 'Inscrire le Patient',
                'attr' => [
                    'class' => 'btn btn-sm py-2 px-3'
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Patient::class
        ]);
    }
}
