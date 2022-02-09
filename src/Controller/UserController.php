<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserChangeType;
use App\Form\UserMailType;
use App\Form\UserType;
use App\Repository\DesignRepository;
use App\Repository\UserRepository;
use App\Security\LoginFormAuthenticator;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\FormError;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\Security\Http\Authentication\UserAuthenticatorInterface;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use SymfonyCasts\Bundle\VerifyEmail\Exception\VerifyEmailExceptionInterface;
use SymfonyCasts\Bundle\VerifyEmail\VerifyEmailHelperInterface;

class UserController extends AbstractController
{
    private $em;


    function __construct(EntityManagerInterface $em)
    {

        $this->em = $em;
    }


    #[Route("/connexion", name: "connexion")]
    public function connexion(AuthenticationUtils $authenticationUtils, DesignRepository $designRepo): Response
    {
        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        $design =  $designRepo->find(1);
        return $this->render('user/connexion.html.twig', [
            'last_username' => $lastUsername,
            'design' => $design,
            'error' => $error,
        ]);
    }


    #[Route("/inscription", name: "inscription")]
    public function inscription(Request $request, VerifyEmailHelperInterface $verifyEmailHelper,  UserPasswordHasherInterface $passwordHasher, MailerInterface $mailer, DesignRepository $designRepo): Response
    {
        $user =  new User();
        $design =  $designRepo->find(1);
        $userForm = $this->createForm(UserType::class, $user);
        $userForm->handleRequest($request);
        if ($userForm->isSubmitted()) {

            if ($userForm->isValid()) {
                $hash = $passwordHasher->hashPassword($user, $user->getPassword());
                $user->setPassword($hash);
                $user->setIsVerified(false);
                $this->em->persist($user);
                $this->em->flush();
                $signatureComponents = $verifyEmailHelper->generateSignature(
                    'app_verify_email',
                    $user->getId(),
                    $user->getEmail(),
                    ['id' => $user->getId()]
                );
                $email = new TemplatedEmail();
                $email->to($user->getEmail())
                    ->subject('Bienvenue chez nous')
                    ->htmlTemplate('@email_templates/welcome.html.twig')
                    ->context([
                        'urlEmail' => $signatureComponents->getSignedUrl(),
                        'username' => $user->getFirstname()
                    ]);
                $mailer->send($email);

                $this->addFlash('success', 'Merci de vous être inscris chez nous il ne vous reste plus qu\'a confirmer votre email');
                return $this->redirectToRoute('home');
            }
        }
        return $this->render('user/inscription.html.twig', [
            'formInscription' => $userForm->createView(),
            'design' => $design
        ]);
    }

    #[Route("/verify", name: "app_verify_email")]
    public function verifyUserEmail(UserRepository $userRepo, LoginFormAuthenticator $loginForm, UserAuthenticatorInterface $authenticator, VerifyEmailHelperInterface $verifyEmailHelper, Request $request): Response
    {

        $user = $userRepo->find($request->query->get('id'));
        if (!$user) {
            throw $this->createNotFoundException();
        }
        try {
            $verifyEmailHelper->validateEmailConfirmation(
                $request->getUri(),
                $user->getId(),
                $user->getEmail(),
            );
        } catch (VerifyEmailExceptionInterface $e) {
            $this->addFlash('error', "Le lien n'est pas valide");
            return $this->redirectToRoute('inscription');
        }

        $user->setIsVerified(true);
        $this->em->flush();
        $this->addFlash('success', 'Votre compte e bien été verifié ! Bienvenue !.');
        return $authenticator->authenticateUser(
            $user,
            $loginForm,
            $request
        );
    }
}
