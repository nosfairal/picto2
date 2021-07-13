<?php

namespace App\Form;

use App\Entity\Institution;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class InstitutionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class, [
                'required' => true,
                'label' => 'Nom de l\'Entreprise',
                'attr' => [
                    'class' => 'form-control'
                ],
                'constraints' => [
                    new Length([
                        'min' => 2,
                        'max'=>50,
                        'minMessage'=> 'Le nom de l\'entreprise est trop court.',
                        'maxMessage'=> 'Le nom de l\'entreprise est trop long.',
                    ])
                ]
            ])
            ->add('email', EmailType::class, [
                'label' => 'Email',
                'required' => true,
                'attr' => [
                    'class' => 'form-control'
                ]
            ])
            ->add('code', TextType::class, [
                'label' => 'Code',
                'required' => true,
                'help' => 'Le code doit avoir 10 caractères minimum et être unique à chaque institution. Il sera envoyé automatiquement à l\'adresse mail indiquée.',
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'ex. "NomEntreprise12345"'
                ],
                'constraints' => [
                    new Length([
                        'min' => 10,
                        'max'=>30,
                        'minMessage'=> 'Votre code est trop court.',
                        'maxMessage'=> 'Votre code est trop long.'
                    ])
                ]
            ])
            ->add('submit', SubmitType::class, [
                'label' => 'Enregistrer'
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Institution::class,
        ]);
    }
}
