<?php

namespace App\Controller;

use App\Entity\ComandProducts;
use App\Entity\Command;
use App\Entity\Produit;
use App\Repository\ComandProductsRepository;
use App\Repository\CommandRepository;
use App\Repository\ProduitRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Routing\Annotation\Route;

class BasketController extends AbstractController
{

    private $em;



    function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }
    #[Route('/panier', name: 'panier')]
    public function index(SessionInterface $session, ProduitRepository $produitRepo): Response
    {

        $basket =  $session->get("basket", null);

        $products = [];
        if ($basket) {
            foreach ($basket as $key => $value) {
                $product = $produitRepo->find($key);
                $product->setBasketNumber($value);
                array_push($products, $product);
            }
        }
        return $this->render('basket/index.html.twig', [
            'basket' => $basket,
            'products' => $products,
            'idUser' => $this->getUser()->getId()
        ]);
    }


    #[Route('/panier/confirmer', name: 'panier_confirm', methods: ['POST'])]
    public function confirm(SessionInterface $session, MailerInterface $mailer, Request $request, ProduitRepository $produitRepo, CommandRepository $commandRepo, ComandProductsRepository $comandProductsRepo): Response
    {
        if ($this->isCsrfTokenValid('confirm' . $this->getUser()->getId(), $request->get('_token'))) {

            $basket =  $session->get("basket", null);
            $products = [];
            if ($basket) {
                $command = new Command();
                $command->setCreatedAt(new \DateTimeImmutable());
                $command->setTreated(false);
                $this->em->persist($command);
                $this->em->flush();


                foreach ($basket as $key => $value) {
                    $product = $produitRepo->find($key);
                    $commandProduct = new ComandProducts();
                    $commandProduct->setCommands($command);
                    $commandProduct->setProducts($product);
                    $commandProduct->setNumber($value);
                    $this->em->persist($commandProduct);

                    $product->setBasketNumber($value);
                    array_push($products, $product);
                }
                $this->em->flush();
                //new command


                //email client
                $emailCurrentUser = $this->getUser()->getUserIdentifier();
                $emailValue = $emailCurrentUser;
                $emailClient = new TemplatedEmail();
                $emailClient->to($emailValue)
                    ->subject('Nouvelle commande')
                    ->htmlTemplate('@email_templates/commandClient.html.twig')
                    ->context([
                        'products' => $products,
                    ]);
                $mailer->send($emailClient);
                //emial admin 
                $emailValue = "anaisazar@gmail.com";
                $emailAdmin = new TemplatedEmail();
                $emailAdmin->to($emailValue)
                    ->subject('Nouvelle commande')
                    ->htmlTemplate('@email_templates/commandAdmin.html.twig')
                    ->context([
                        'emailUser' => $emailCurrentUser,
                    ]);
                $mailer->send($emailAdmin);
                $session->remove("basket");
                $this->addFlash('success', 'Votre commande a bien était passé nous reviendrons ver vous ulterieurement');
                return $this->redirectToRoute('commande_valide');
            } else {
                return $this->redirectToRoute('panier');
            }
        }
        dd("nonnnnnnnnnnnnn");
        $basket =  $session->get("basket", null);
        dd($basket);


        return $this->redirectToRoute('commande_valide');
    }

    #[Route('/panier/add/{id}', name: 'panier_add')]
    public function add(Produit $product, SessionInterface $session, Request $request): Response
    {
        $data = json_decode($request->getContent(), true);
        $nbr = $data["nbrProducts"];
        $id = $product->getId();
        $basket =  $session->get("basket");
        $totalNumber = $session->get("total", 0);
        $totalNumber += $nbr;
        if (isset($basket[$id])) {
            $basket[$id] += $nbr;
            if ($basket[$id] == 0) {
                unset($basket[$id]);
            }
        } else {
            $basket[$id] = $nbr;
        }
        $session->set("total", $totalNumber);
        $session->set("basket", $basket);

        return new JsonResponse(['nbr' => $totalNumber]);
    }
}
