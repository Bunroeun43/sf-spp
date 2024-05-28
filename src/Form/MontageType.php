<?php

namespace App\Form;

use App\Entity\Montage;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\NumberType;

class MontageType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('frais', NumberType::class, [
                'label' => 'Frais de montage : ',
                'label_attr' => [
                    'class' => 'col-3 text-end me-2'
                ],
                'attr' => [
                    'class' => 'col-3 text-center'
                ]
            ])
            ->add('tva', NumberType::class, [
                'label' => 'Taux de TVA : ',
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
            'data_class' => Montage::class,
        ]);
    }
}
