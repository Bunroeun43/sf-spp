<?php

namespace App\Form;

use App\Entity\Marque;
use App\Entity\Socket;
use App\Entity\Processeur;
use App\Entity\TypeMemoire;
use App\Repository\MarqueRepository;
use App\Repository\SocketRepository;
use Symfony\Component\Form\AbstractType;
use App\Repository\TypeMemoireRepository;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;

class ProcesseurType extends AbstractType
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
                'placeholder' => '',
                'choice_label' => 'nom',
                'label' => 'Marque : ',
                'label_attr' => [
                    'class' => 'col-3 text-end me-2'
                ],
                'attr' => [
                    'class' =>'col-3 text-center'
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
            ->add('coeur', IntegerType::class, [
                'label' => 'Nombre de coeurs : ',
                'label_attr' => [
                    'class' => 'col-3 text-end me-2'
                ],
                'attr' => [
                    'class' => 'col-3 text-center'
                ]
            ])
            ->add('cache', NumberType::class, [
                'label' => 'Taille du cache en Mo : ',
                'label_attr' => [
                    'class' => 'col-3 text-end me-2'
                ],
                'attr' => [
                    'class' => 'col-3 text-center'
                ]
            ])
            ->add('frequence', NumberType::class, [
                'label' => 'Fréquence en Ghz : ',
                'label_attr' => [
                    'class' => 'col-3 text-end me-2'
                ],
                'attr' => [
                    'class' => 'col-3 text-center'
                ]
            ])
            ->add('typememoire', EntityType::class, [
                'class' => TypeMemoire::class,
                'query_builder' => function (TypeMemoireRepository $er) {
                    return $er->createQueryBuilder('u')
                        ->orderBy('u.nom', 'ASC');
                },
                'placeholder' => '',
                'choice_label' => 'nom',
                'label' => 'Type de mémoire : ',
                'label_attr' => [
                    'class' => 'col-3 text-end me-2'
                ],
                'attr' => [
                    'class' =>'col-3 text-center'
                ]
            ])
            ->add('socket', EntityType::class, [
                'class' => Socket::class,
                'query_builder' => function (SocketRepository $er) {
                    return $er->createQueryBuilder('u')
                        ->orderBy('u.nom', 'ASC');
                },
                'placeholder' => '',
                'choice_label' => 'nom',
                'label' => 'Socket : ',
                'label_attr' => [
                    'class' => 'col-3 text-end me-2'
                ],
                'attr' => [
                    'class' =>'col-3 text-center'
                ]
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
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Processeur::class,
        ]);
    }
}
