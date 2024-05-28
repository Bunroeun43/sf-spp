<?php

namespace App\Form;

use App\Entity\Marque;
use App\Entity\Socket;
use App\Repository\MarqueRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class SocketType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom', TextType::class, [
                'label' => 'Nom du socket : ',
                'label_attr' => [
                    'class' => 'col-3 text-end me-2'
                ],
                'attr' => [
                    'class' => 'col-3 text-center'
                ]
            ])
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
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Socket::class,
        ]);
    }
}
