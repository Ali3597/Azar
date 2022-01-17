<?php

namespace App\Form;

use App\Entity\Category;
use App\Repository\CategoryRepository;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class LowCategoryType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [

                'label' => 'Nom'

            ])
            ->add('description', TextareaType::class, [

                'label' => 'Description'

            ])
            ->add('slug', TextType::class, [

                'label' => 'Slug'

            ])
            ->add('category_parent', EntityType::class, [
                'class' => Category::class,
                'query_builder' => function (CategoryRepository $er) {
                    return $er->createQueryBuilder('c')
                        ->where('c.category_parent is NULL')
                        ->orderBy('c.name', 'ASC');
                },
                'choice_label' => 'name',
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Category::class,
        ]);
    }
}
