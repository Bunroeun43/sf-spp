<?php

namespace App\Form;

use App\Entity\User;
use App\Entity\Genre;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\Validator\Constraints\IsTrue;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class UserEditType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('email', EmailType::class, [
                'label' => 'Votre email : ',
                'attr' => [
                    'class' => 'form-control'
                ]
            ])
            ->add('nom', TextType::class, [
                'label' => 'Votre nom : ',
                'attr' => [
                    'class' => 'form-control'
                ]
            ])
            ->add('prenom', TextType::class, [
                'label' => 'Votre prénom : ',
                'attr' => [
                    'class' => 'form-control'
                ]
            ])
            ->add('naissance', DateType::class, [
                'label' => 'Indiquez votre date de naissance :',
                'format' => 'dd / MM / yyyy',
                'widget' => 'choice',
                'years' => range(date('Y')-90,date('Y')-18)
            ])
            ->add('avatar', FileType::class, [
                'label' => 'Choisissez votre image de profil : ',
                'mapped' => false,
                'required' => false,
                'constraints' => [
                    new File([
                        'maxSize' => '16384k',
                        'maxSizeMessage' => 'Taille de fichier trop grande',
                        'mimeTypes' => [
                            'image/jpeg',
                            'image/png',
                            'image/svg',
                            'image/jpg',
                            'image/webp',
                            'image/bmp',
                            'image/gif',
                        ],
                        'mimeTypesMessage' => 'Extension de fichier invalide',
                    ])
                    ],
                'attr' => [
                    'class' => 'form-control',
                ],
                'data_class' => null,
            ])
            ->add('genre', EntityType::class, [
                'class' => Genre::class,
                'choice_label' => 'nom',
                'multiple' => false,
                'attr' => [
                    'class' => 'form-select'
                ]
            ])
            ->add('adresse', TextareaType::class, [
                'label' => 'Votre adresse : ',
                'attr' => [
                    'class' => 'form-control'
                ]
            ])
            ->add('codepostal', NumberType::class, [
                'label' => 'Votre code postal : ',
                'attr' => [
                    'class' => 'form-control'
                ]
            ])
            ->add('ville', TextType::class, [
                'label' => 'Votre ville : ',
                'attr' => [
                    'class' => 'form-control'
                ]
            ])
            ->add('telephone', TextType::class, [
                'label' => 'Votre numéro de téléphone : ',
                'attr' => [
                    'class' => 'form-control'
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
