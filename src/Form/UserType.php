<?php

namespace App\Form;

use App\Entity\User;
use App\Entity\Genre;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\Validator\Constraints\IsTrue;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class UserType extends AbstractType
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
            ->add('roles', ChoiceType::class,[
            'label' => 'Choisissez un ou plusieurs rôles :',
            'choices' => [
                'Administrateur' => 'ROLE_ADMIN',
                'Rédacteur' => 'ROLE_REDACTEUR',
                'Auteur' => 'ROLE_AUTEUR',
            ],
            'choice_attr' => [
                'Administrateur' => [
                    'class' => 'me-1'
                ],
                'Rédacteur' => [
                    'class' => 'ms-3 me-1'
                ],
                'Auteur' => [
                    'class' => 'ms-3 me-1'
                ],
            ],
            'multiple' => true,
            'expanded' => true,
            'attr' => [
                'class' => 'form-control'
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
            ->add('agreeTerms', CheckboxType::class, [
                'label' => 'J\'acceptes les conditions. ',
                'mapped' => false,
                'constraints' => [
                    new IsTrue([
                        'message' => 'You should agree to our terms.',
                    ]),
                ],
            ])
            ->add('plainPassword', RepeatedType::class, [
                'type' => PasswordType::class,
                'required' => 'true',
                'invalid_message' => 'Les mots de passes ne correspondent pas',
                'first_options' => [
                    'label' => 'Entrez un mot de passe',
                    'attr' => ['class' => 'form-control']
                ],
                'second_options' => [
                    'label' => 'Retapez le mot de passe',
                    'attr' => ['class' => 'form-control']
                ],
                'mapped' => false,
                'attr' => ['autocomplete' => 'new-password'],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Veuillez entrer un mot de passe',
                    ]),
                    new Length([
                        'min' => 6,
                        'minMessage' => 'Votre mot de passe doit comporter au moins {{ limit }} caractères',
                        // max length allowed by Symfony for security reasons
                        'max' => 4096,
                    ]),
                ],
            ])
        ;
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
