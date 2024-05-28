<?php

namespace App\Form;

use Assert\Range;
use App\Entity\User;
use App\Entity\Boitier;
use App\Entity\Memoire;
use App\Entity\DisqueM2;
use App\Entity\CarteMere;
use App\Entity\DisqueDur;
use App\Entity\DisqueSsd;
use App\Entity\Processeur;
use App\Entity\TypeMemoire;
use App\Entity\Alimentation;
use App\Entity\Configurateur;
use PHPUnit\Framework\Assert;
use App\Entity\CarteGraphique;
use App\Entity\FormatAlimentation;
use Symfony\Component\Form\FormEvent;
use App\Repository\DisqueM2Repository;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;

class ConfigurateurType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom', TextType::class, [
                'label' => 'Nom de la configuration : ',
                'label_attr' => [
                    'class' => 'col-3 text-end me-2'
                ],
                'attr' => [
                    'class' => 'col-3 text-center'
                ]
            ])
            ->add('cartemere', EntityType::class, [
                'class' => CarteMere::class,
                'choice_label' =>  function ($carteMere){
                    return $carteMere->getMarque()->getNom().' '.$carteMere->getModele();                                                                                             
                },
                'placeholder' => ' <!=== faites votre sélection ===!>',
                'label' => 'Carte mère : ',
                'label_attr' => [
                    'class' => 'col-3 text-end me-2'
                ],
                'attr' => [
                    'class' => 'col-3 text-center'
                ]
            ])
        ;


        // Fonction permettant de faire la sélection des composants compatibles suivant la carte mère

        $formProcesseur = function(FormInterface $form, CarteMere $carteMere = null) {
            // On n'affiche que les élements compatibles à la carte mère que si carte mère existe
            $processeur = null === $carteMere ? [] : $carteMere->getSocket()->getProcesseurs();
            $m2 = null === $carteMere ? [] : $carteMere->isM2();
            $disqueM2 = null === $carteMere ? [] : $carteMere->getDisqueM2();
            $memoire = null === $carteMere ? [] : $carteMere->getTypeMemoire()->getMemoires();
            $boitier  = null === $carteMere ? [] : $carteMere->getFormat()->getBoitiers();
            $carteGraphique = null === $carteMere ? [] : $carteMere->getPcie1()->getCarteGraphiques();
            $carteGraphique2 = null === $carteMere ? [] : $carteMere->getPcie2()->getCarteGraphiques();
            $sata = null === $carteMere ? [] : $carteMere->getSata();
            
            // $alimentation = null === $boitier ? [] : $boitier->getFormatalimentation()->getalimentations();
            $form->add('processeur', EntityType::class, [
                'class' => Processeur::class,
                'choices' => $processeur,
                'label' => 'Processeur : ',
                // On concatène la marque et le modele dans la liste de choix
                'choice_label' => function ($processeur){
                    return $processeur->getMarque()->getNom().' '.$processeur->getModele();
                },
                'label_attr' => [
                    'class' => 'col-3 text-end me-2'
                ],
                'attr' => [
                    'class' => 'col-3 text-center',
                ]
                ])
                ->add('typememoire', EntityType::class, [
                    'class' => Memoire::class,
                    'choices' => $memoire,
                    // On concatène la marque et le modele dans la liste de choix
                    'choice_label' => function ($memoire){
                    return $memoire->getMarque()->getNom().' '.$memoire->getModele();
                },
                    'label' => 'Mémoire : ',
                    'label_attr' => [
                        'class' => 'col-3 text-end me-2'
                    ],
                    'attr' => [
                        'class' => 'col-3 text-center'
                    ]
                ])
                ->add('cartegraphique', EntityType::class, [
                    'class' => CarteGraphique::class,
                    'choices' => $carteGraphique,
                    // On concatène la marque et le modele dans la liste de choix
                    'choice_label' => function ($carteGraphique){
                    return $carteGraphique->getMarque()->getNom().' '.$carteGraphique->getModele();
                },
                    'label' => 'Carte graphique : ',
                    'label_attr' => [
                        'class' => 'col-3 text-end me-2'
                    ],
                    'attr' => [
                        'class' => 'col-3 text-center'
                    ]
                ])
                ->add('cartegraphique2', EntityType::class, [
                    'class' => CarteGraphique::class,
                    'required' => false,
                    'choices' => $carteGraphique,
                    // On concatène la marque et le modele dans la liste de choix
                    'choice_label' => function ($carteGraphique){
                    return $carteGraphique->getMarque()->getNom().' '.$carteGraphique->getModele();
                },
                    'label' => 'Carte supplémentaire : ',
                    'label_attr' => [
                        'class' => 'col-3 text-end me-2'
                    ],
                    'attr' => [
                        'class' => 'col-3 text-center'
                    ]
                ])
                    ->add('disquem2', EntityType::class, [
                    'class' => DisqueM2::class,
                //     'query_builder' => function (DisqueM2Repository $er) {
                //     return $er->createQueryBuilder('u')
                //         ->orderBy('u.modele', 'ASC');
                // },
                    // 'choices' => function ($m2){
                    //     $m2 ? $disqueM2 : "no";
                    //     return $m2;
                    // },
                    'placeholder' => '',
                    'choice_label' => 'modele',
                    'label' => 'Disque m2 : ',
                    'label_attr' => [
                        'class' => 'col-3 text-end me-2'
                    ],
                    'attr' => [
                        'class' => 'col-3 text-center'
                    ]
                    ])
                ->add('disquessd', EntityType::class, [
                    'required' => false,
                    'class' => DisqueSsd::class,
                    'choice_label' => 'modele',
                    'label' => 'Disque SSD : ',
                    'label_attr' => [
                        'class' => 'col-3 text-end me-2'
                    ],
                    'attr' => [
                        'class' => 'col-3 text-center'
                    ]
                ])
                ->add('disquedur', EntityType::class, [
                    'required' => false,
                    'class' => DisqueDur::class,
                    'choice_label' => 'modele',
                    'label' => 'Disque dur : ',
                    'label_attr' => [
                        'class' => 'col-3 text-end me-2'
                    ],
                    'attr' => [
                        'class' => 'col-3 text-center',
                        
                ]
                ])
                ->add('quantitedisquedur', IntegerType::class, [
                    'required' => true,
                    // 'choices' => new Assert/Range([
                    //     'min' => 0,
                    //     'max' => $sata,
                    // ]),
                    'label' => 'quantité : ',
                        'label_attr' => [
                            'class' => 'col-3 text-end me-2'
                        ],
                        'attr' => [
                            'class' => 'col-3 text-center',
                            'min' => 0,
                            'max' => 4,
                        ],
                        // 'error' => 'test'
                    ])                 
                ->add('alimentation', EntityType::class, [
                    'class' => Alimentation::class,
                    'choice_label' => 'modele',
                    'label' => 'Alimentation : ',
                    'label_attr' => [
                        'class' => 'col-3 text-end me-2'
                    ],
                    'attr' => [
                        'class' => 'col-3 text-center'
                    ]
                ])
                ->add('boitier', EntityType::class, [
                    'class' => Boitier::class,
                    'choices' => $boitier,
                    // On concatène la marque et le modele dans la liste de choix
                    'choice_label' => function ($boitier){
                    return $boitier->getMarque()->getNom().' '.$boitier->getModele();
                },
                    'label' => 'Boitier : ',
                    'label_attr' => [
                        'class' => 'col-3 text-end me-2'
                    ],
                    'attr' => [
                        'class' => 'col-3 text-center'
                    ]
                ])
                ->add('isactive', CheckboxType::class, [
                'label' => 'Soumettre le devis. ',
                'label_attr' => [
                    'class' => 'col-3 text-end me-2'
                ],
                'required' => false,
            ])
            ;
            };

            // On pose un écouteur d'évènement sur le choix de la carte mère

            $builder->addEventListener(
            FormEvents::PRE_SET_DATA,
            function(FormEvent $event) use ($formProcesseur){
                $data = $event->getData();
                $formProcesseur($event->getForm(), $data->getCarteMere());
            });


            $builder->get('cartemere')->addEventListener(
                FormEvents::POST_SUBMIT,
                function(FormEvent $event) use  ($formProcesseur) {
                    $processeur = $event->getForm()->getData();
                    $formProcesseur($event->getForm()->getParent(), $processeur);
                }
            )
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Configurateur::class,
        ]);
    }
}
