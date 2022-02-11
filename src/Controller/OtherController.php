<?php

namespace App\Controller;

use App\Entity\Message;
use App\Form\MessageType;
use App\Repository\DesignRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Routing\Annotation\Route;

class OtherController extends AbstractController
{



    private $em;


    function __construct(EntityManagerInterface $em)
    {

        $this->em = $em;
    }

    #[Route('/APropos', name: 'aboutUs')]
    public function AboutUs(DesignRepository $designRepo): Response
    {
        $design = $designRepo->find(1);
        return $this->render('other/aboutUs.html.twig', [
            'design' => $design,
        ]);
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
            return $this->redirectToRoute('contact');
        }

        return $this->render('other/contact.html.twig', [
            'controller_name' => 'ContactController',
            'form' => $form->createView()
        ]);
    }
}
