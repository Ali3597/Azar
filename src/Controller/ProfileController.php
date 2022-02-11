<?php

namespace App\Controller;


use App\Form\UserChangeType;

use Doctrine\ORM\EntityManagerInterface;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\FormError;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;


class ProfileController extends AbstractController
{
    private $em;


    function __construct(EntityManagerInterface $em)
    {

        $this->em = $em;
    }
    #[Route('/profile', name: 'profile')]
    public function index(): Response
    {
        return $this->render('user/index.html.twig', [
            'controller_name' => 'UserController',
        ]);
    }



    #[Route("/profile/commandes", name: "commande_valide")]
    public function command(): Response
    {

        return $this->render('user/commands.html.twig', []);
    }




    #[Route('/profile/parametres', name: 'parameters')]
    public function parameters(Request $request, UserPasswordHasherInterface $passwordHasher, TokenStorageInterface $tokenStorageInterface): Response
    {

        $user = $this->getUser();


        $passwordForm = $this->createFormBuilder()
            ->add('actualPassword', PasswordType::class, [
                'label' => 'Actuel mot de passe ',
                'constraints' => [
                    new Length([
                        'min' => 6,
                        'minMessage' => 'Le mot de passe doit faire au moins 6 caractères.'
                    ]),
                    new NotBlank([
                        'message' => 'Veuillez renseigner un mot de passe.'
                    ])
                ]
            ])
            ->add('newPassword', PasswordType::class, [
                'label' => 'Nouveau mot de passe',
                'constraints' => [
                    new Length([
                        'min' => 6,
                        'minMessage' => 'Le mot de passe doit faire au moins 6 caractères.'
                    ]),
                    new NotBlank([
                        'message' => 'Veuillez renseigner un mot de passe.'
                    ])
                ]
            ])
            ->add('confirmPassword', PasswordType::class, [
                'label' => 'Confirmer votre nouveau mot de passe',
                'constraints' => [
                    new Length([
                        'min' => 6,
                        'minMessage' => 'Le mot de passe doit faire au moins 6 caractères.'
                    ]),
                    new NotBlank([
                        'message' => 'Veuillez renseigner un mot de passe.'
                    ])
                ]
            ])
            ->getForm();

        $passwordForm->handleRequest($request);


        if ($passwordForm->isSubmitted() && $passwordForm->isSubmitted()) {
            $datas = $passwordForm->getData();
            $actualPassword = $datas["actualPassword"];
            $newPassword = $datas["newPassword"];
            $confirmPassword = $datas["confirmPassword"];
            $verifyHash = $passwordHasher->isPasswordValid($user, $actualPassword);
            if ($verifyHash) {

                if ($newPassword != $confirmPassword) {
                    $passwordForm->get('confirmPassword')->addError(new FormError('Vos deux mot de passe ne sont pas identiques'));
                } else {
                    $hash = $passwordHasher->hashPassword($user, $newPassword);
                    $user->setPassword($hash);
                    $this->em->persist($user);
                    $this->em->flush();
                    $this->addFlash('success', 'Votre mot de passe a bien été modifié ');
                }
            } else {
                $passwordForm->get('actualPassword')->addError(new FormError('Le mot de passe n\'est pas valide'));
            }

            // if ($formMail->isValid()) {
            //     dd("ts");
            //     $plainPassword = $user->getPlainPassword();
            //     $verifyHash = $passwordHasher->isPasswordValid($user, $plainPassword);
            //     if ($verifyHash) {
            //         $this->em->persist($user);
            //         $this->em->flush();
            //         $this->addFlash('success', 'Votre email a bien été modifié ');
            //     } else {
            //         $formMail->get('plainPassword')->addError(new FormError('Le mot de passe n\'est pas valide'));
            //     }
            // } else {
            // }
        }
        $changeForm = $this->createForm(UserChangeType::class, $user);
        $changeForm->handleRequest($request);
        if ($changeForm->isSubmitted() && $changeForm->isSubmitted()) {
            $this->em->persist($user);
            $this->em->flush();
            $this->addFlash('success', 'Vos informations   ont  bien été modifié ');
        }


        return $this->render('user/parameters.html.twig', [
            'passwordForm' => $passwordForm->createView(),
            'changeForm' => $changeForm->createView()
        ]);
    }
}
