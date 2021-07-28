<?php

namespace App\Form;

use App\Entity\Therapist;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;


class DeletePatient extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('Password', PasswordType::class, [
                'label' => 'Veuillez entrer votre mot de passe pour valider la suppression du profil',
                'mapped' => false,
                'attr' => [
                    'placeholder' => 'Saisir votre mot de passe',
                    'class' => 'form-control mb-2 mx-auto w-50'
                ],
                'constraints' => [
                    new NotBlank()
                ]
            ])
            ->add('submit', SubmitType::class, [
                'label' => 'Supprimer le profil'
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