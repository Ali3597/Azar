<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('email', null, ['label' => 'Email', 'attr' => array(

                'error_bubbling' => true,

            )])
            ->add('firstname', null, ['label' => 'Prénom',])
            ->add('lastname', null, ['label' => 'Nom'])
            ->add('telephone', null, ['label' => 'Numero de téléphone'])
            ->add('addresse', null, ['label' => 'addresse (optionnelle)'])
            ->add('password', RepeatedType::class, [
                'type' => PasswordType::class,

                'invalid_message' => 'Les mots de passe ne sont pas identiques',
                'options' => array('attr' => array('class' => 'password-field')),
                'required' => true,
                'first_options'  => ['label' => 'Mot de passe'],
                'second_options' => ['label' => 'Confirmez le mot de passe', 'error_bubbling' => true]
            ]);
    }


    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
            "csrf_protection" => true,

            'error_bubbling' => true,
        ]);
    }
}
