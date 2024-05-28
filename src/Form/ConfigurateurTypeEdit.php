<?php

namespace App\Form;

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
use App\Entity\CarteGraphique;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ConfigurateurTypeAdmin extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('cartemere', EntityType::class, [
                'class' => CarteMere::class,
                // 'choice_label' => 'modele',
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
            // ->add('processeur')
            // ->add('typememoire')
        ;

        $formProcesseur = function(FormInterface $form, CarteMere $carteMere = null) {
            $processeur = null === $carteMere ? [] : $carteMere->getSocket()->getProcesseurs();
            $m2 = null === $carteMere ? [] : $carteMere->isM2();
            $memoire = null === $carteMere ? [] : $carteMere->getTypeMemoire()->getMemoires();
            $boitier  = null === $carteMere ? [] : $carteMere->getFormat()->getBoitiers();
            $carteGraphique = null === $carteMere ? [] : $carteMere->getPcie1()->getCarteGraphiques();
            // $alimentation = null === $boitier ? [] : $boitier->getFormatAlimentation()->getAlimentations();
            $form->add('processeur', EntityType::class, [
                'class' => Processeur::class,
                'choices' => $processeur,
                'label' => 'Processeur : ',
                'choice_label' => function ($processeur){
                    return $processeur->getMarque()->getNom().' '.$processeur->getModele();
                },
                // 'choice_label' => 'modele',
                'label_attr' => [
                    'class' => 'col-3 text-end me-2'
                ],
                // 'placeholder' => ' Carte mère',
                'attr' => [
                    'class' => 'col-3 text-center',
                ]
                ])
                ->add('typememoire', EntityType::class, [
                    'class' => Memoire::class,
                    'choices' => $memoire,
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
                ])->add('cartegraphique', EntityType::class, [
                    'class' => CarteGraphique::class,
                    'choices' => $carteGraphique,
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
                   ->add('disquem2', EntityType::class, [
                    'class' => DisqueM2::class,
                    'choice_label' => function ($disqueM2){
                            return $disqueM2->getMarque()->getNom().' '.$disqueM2->getModele(); 
                },
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
                    // 'choices' => DisqueSsd['m2'],
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
                        'class' => 'col-3 text-center'
                    ]
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
                ]);
            };


            $builder->addEventListener(
            FormEvents::PRE_SET_DATA,
            function(FormEvent $event) use ($formProcesseur){
                $data = $event->getData();
                $formProcesseur($event->getForm(), $data->getProcesseur());
            });

            // Onpose écouteur d'événement sur l'input de la carte mère
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
