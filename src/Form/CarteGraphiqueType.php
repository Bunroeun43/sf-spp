<?php

namespace App\Form;

use App\Entity\Pcie;
use App\Entity\Marque;
use App\Entity\CarteGraphique;
use App\Repository\MarqueRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;

class CarteGraphiqueType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('marque', EntityType::class, [
                'class' => Marque::class,
                'query_builder' => function (MarqueRepository $er) {
                    return $er->createQueryBuilder('u')
                        ->orderBy('u.nom', 'ASC');
                },
                'choice_label' => 'nom',
                'label' => 'Marque : ',
                'label_attr' => [
                    'class' => 'col-3 text-end me-2'
                ],
                'attr' => [
                    'class' => 'col-3 text-center'
                ]
            ])
            ->add('modele', TextType::class, [
                'label' => 'Nom du modèle : ',
                'label_attr' => [
                    'class' => 'col-3 text-end me-2'
                ],
                'attr' => [
                    'class' => 'col-3 text-center'
                ]
            ])
            ->add('memoire', IntegerType::class, [
                'label' => 'Mémoire en Go : ',
                'label_attr' => [
                    'class' => 'col-3 text-end me-2'
                ],
                'attr' => [
                    'class' => 'col-3 text-center'
                ]
            ])
            ->add('longueur', IntegerType::class, [
                'label' => 'Longueur en mm : ',
                'label_attr' => [
                    'class' => 'col-3 text-end me-2'
                ],
                'attr' => [
                    'class' => 'col-3 text-center'
                ]
            ])
            ->add('pcie', EntityType::class, [
                'class' => Pcie::class,
                'choice_label' => 'nom',
                'label' => 'PCI-E : ',
                'label_attr' => [
                    'class' => 'col-3 text-end me-2'
                ],
                'attr' => [
                    'class' => 'col-3 text-center'
                ]
            ])
            ->add('photo', FileType::class, [
                'label' => 'Image : ',
                'label_attr' => [
                    'class' => 'col-3 text-end me-2'
                ],
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
                    'class' => 'col',
                ],
                'data_class' => null,
            ])
            ->add('prix', NumberType::class, [
                'label' => 'Prix : ',
                'label_attr' => [
                    'class' => 'col-3 text-end me-2'
                ],
                'attr' => [
                    'class' => 'col-3 text-center'
                ]
            ])
            ->add('isActive', CheckboxType::class, [
                'required' => false,
                'label' => 'Actif : ',
                'label_attr' => [
                    'class' => 'col-3 text-end me-2'
                ],
                'attr' => [
                    'class' => 'col-3 text-center'
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => CarteGraphique::class,
        ]);
    }
}
