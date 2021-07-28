<?php

namespace App\Form;

use App\Entity\Category;
use App\Entity\SubCategory;
use App\Entity\Therapist;
use Symfony\Component\Form\AbstractType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\BirthdayType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Security\Core\User\User;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\File;

class CreateSubCategoryType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class, [
                'label' => 'Nom de la sous-catégorie*:',
                'required' => true,
                'attr' => [
                    'class' => 'form-control'
                ],
                'constraints' => [
                    new NotBlank(),
                    new Length([
                        'min'=>2,
                        'max' => 50,
                        'minMessage'=> 'Le nom de la sous-catégorie est trop court. Il doit avoir au minimum 2 caractères.',
                        'maxMessage'=> 'Le nom de la sous-catégorie est trop long. Il doit avoir au maximum 50 caractères.',
                    ])
                ]
            ])
            ->add('subillustration', FileType::class, [
                'label' => 'Illustration de la sous-catégorie*: ',
                'attr' => [
                    'class' => 'form-control'
                ],
                'required' => true,
                'constraints' => [
                    new File([ 
                        'mimeTypes' => [ 
                          'image/png', 
                        ],
                    'mimeTypesMessage' => "Veuillez insérer un fichier au format png.",
                    ])
                ],
            ])
            ->add('category_id', EntityType::class, [
                'label' => 'Catégorie de la nouvelle sous-catégorie*:',
                'required' => true,
                'class' => Category::class,
                'choice_label' => 'name',
                'attr' => [
                    'class' => 'form-select'
                ],
            ])
            ->add('submit', SubmitType::class, [
                'label' => 'Ajouter la nouvelle sous-catégorie',
                'attr' => [
                    'class' => 'btn btn-sm py-2 px-3'
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => SubCategory::class
        ]);
    }
}
