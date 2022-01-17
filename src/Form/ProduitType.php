<?php

namespace App\Form;

use App\Entity\Category;
use App\Entity\Marque;
use App\Entity\Produit;
use App\Repository\CategoryRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ProduitType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [

                'label' => 'Nom'

            ])
            ->add('slug', TextType::class, [

                'label' => 'Slug'

            ])
            ->add('description', TextareaType::class, [

                'label' => 'Description'

            ])
            ->add('stock', IntegerType::class, [

                'label' => 'Stock'

            ])
            ->add('unite', TextType::class, [

                'label' => 'Unite'

            ])
            ->add('afficher')
            ->add('categoryParent', EntityType::class, [
                'required' => false,
                'class' => Category::class,
                'query_builder' => function (CategoryRepository $er) {
                    return $er->createQueryBuilder('c')
                        ->where('c.category_parent is NULL')
                        ->orderBy('c.name', 'ASC');
                },
                'choice_label' => 'name',
                'placeholder' => 'Chosisser une haute categorie'
            ])
            ->add('category', EntityType::class, [
                'class' => Category::class,
                'choice_label' => 'name',
                'required' => false,
                'placeholder' => 'Chosisser une sous category',
                'choices' => []
            ])
            ->add('marque', EntityType::class, [
                'class' => Marque::class,
                'choice_label' => 'name',
                'placeholder' => 'aucune marque',
                'required' => false,

            ])
            ->add('pictureFiles', FileType::class, [
                'required' => false,
                'multiple' => true,
            ]);

        $formModifier = function (FormInterface $form, Category $category = null) {
            $categoriesChildren = null === $category ? [] : $category->getCategoriesChildrens();
            $form->add('category', EntityType::class, [
                'class' => Category::class,
                'required' => false,
                'choice_label' => 'name',
                'placeholder' => 'Chosisser une sous category',
                'choices' => $categoriesChildren
            ]);
        };


        $builder->get('categoryParent')->addEventListener(
            FormEvents::PRE_SET_DATA,
            function (FormEvent $event) use ($formModifier) {

                $category = $event->getData();
                $formModifier($event->getForm()->getParent(), $category);
            }
        );
        $builder->get('categoryParent')->addEventListener(
            FormEvents::POST_SUBMIT,
            function (FormEvent $event) use ($formModifier) {
                $category = $event->getForm()->getData();
                $formModifier($event->getForm()->getParent(), $category);
            }

        );
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Produit::class,
            "csrf_protection" => false,
        ]);
    }
}
