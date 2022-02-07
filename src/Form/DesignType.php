<?php

namespace App\Form;

use App\Entity\Design;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\ColorType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class DesignType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('PrimaryColor', ColorType::class, [

                'label' => 'Couleur primaire'

            ])
            ->add('sencondaryColor', ColorType::class, [

                'label' => 'Couleur secondaire'

            ])
            ->add('headerTitle', TextType::class, [

                'label' => 'Titre header'

            ])
            ->add('headerSubTitle', TextType::class, [

                'label' => 'Slogan header'

            ])
            ->add('bandeTitle', TextType::class, [

                'label' => false

            ])->add('bandeLeft', TextType::class, [

                'label' => false

            ])->add('bandeCenter', TextType::class, [

                'label' => false

            ])->add('bandeRight', TextType::class, [

                'label' => false

            ])->add('bandeTitleLeft', TextType::class, [

                'label' => false

            ])->add('bandeTitleCenter', TextType::class, [

                'label' => false

            ])->add('bandeTitleRight', TextType::class, [

                'label' => false

            ])->add('position', ChoiceType::class, [
                'choices'  => [
                    'Pas présent' => null,
                    '1' => 1,
                    '2' => 2,
                    '3' => 3,
                    '4' => 4,
                    '5' => 5,
                    '6' => 6,
                    '7' => 7,
                    '8' => 8,
                    '9' => 9,
                    '10' => 10,
                    '11' => 11,
                    '12' => 12,
                    '13' => 13,
                    '14' => 14,
                    '15' => 15,
                ],
            ])
            ->add('colorBande', ColorType::class, [

                'label' => 'couleur de la bande'

            ])


            ->add('pictureFile', FileType::class, [
                'required' => false,

                'label' => 'Logo'

            ]);;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Design::class,
        ]);
    }
}
