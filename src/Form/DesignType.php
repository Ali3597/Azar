<?php

namespace App\Form;

use App\Entity\Design;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ColorType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
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
            ->add('pictureFile', FileType::class, [
                'required' => false,

                'label' => 'Photo'

            ]);;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Design::class,
        ]);
    }
}
