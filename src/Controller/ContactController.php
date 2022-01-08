<?php

namespace App\Controller;

use App\Entity\Message;
use App\Form\MessageType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Routing\Annotation\Route;

class ContactController extends AbstractController
{

    private $em;


    function __construct(EntityManagerInterface $em)
    {

        $this->em = $em;
    }
    #[Route('/contact', name: 'contact')]
    public function index(Request $request, MailerInterface $mailer): Response
    {
        $message = new Message();
        $form = $this->createForm(MessageType::class, $message);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            $emailCurrentUser = "ansiazar@gmail.com";
            $emailValue = $emailCurrentUser;
            $emailToAdmin = new TemplatedEmail();
            $emailToAdmin->to($emailValue)
                ->subject('Nouvelle commande')
                ->htmlTemplate('@email_templates/contact.html.twig')
                ->context([
                    'subject' => $message->getSubject(),
                    'name' => $message->getName(),
                    'emailClient' => $message->getEmail(),
                    'content' => $message->getContent()
                ]);
            $mailer->send($emailToAdmin);
            $this->addFlash('success', 'Votre Message a bien été envoyé ');
            return $this->redirectToRoute('home');
        }

        return $this->render('contact/index.html.twig', [
            'controller_name' => 'ContactController',
            'form' => $form->createView()
        ]);
    }
}
