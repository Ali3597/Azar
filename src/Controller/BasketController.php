<?php

namespace App\Controller;

use App\Entity\ComandProducts;
use App\Entity\Command;
use App\Entity\Produit;
use App\Repository\ProduitRepository;
use Doctrine\ORM\EntityManagerInterface;
use Exception;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/profile', name: 'profile_')]
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
        $totalNumber = $session->get("total", 0);
        $products = [];

        if ($basket) {
            foreach ($basket as $key => $value) {
                $product = $produitRepo->find($key);
                // if admin delete a product in a basket
                if (!$product) {
                    unset($basket[$key]);
                    $session->set("basket", $basket);
                    $session->set("total", $totalNumber - $value);
                } else {
                    $product->setBasketNumber($value);
                    array_push($products, $product);
                }
            }
        }
        return $this->render('basket/index.html.twig', [
            'basket' => $basket,
            'products' => $products,
            'idUser' => $this->getUser()->getId()
        ]);
    }


    #[Route('/panierAjaxAside', name: 'panierAjaxAside')]
    public function AsideAjax(Request $request): Response
    {
        if ($request->isXmlHttpRequest()) {
            $user = $this->getUser();
            $userProducts = $user->getWants();

            return $this->render('basket/aside.html.twig', [
                'basket' => sizeof($userProducts) == 0 ? null : true,
                "products" => $userProducts,
                'idUser' => $this->getUser()->getId()
            ]);
        } else {
            throw new Exception('Cette page n\'existe pas');
        }
    }

    #[Route('/panierAjaxBasket', name: 'panierAjaxBasket')]
    public function BasketAjax(SessionInterface $session, ProduitRepository $produitRepo, Request $request): Response
    {
        if ($request->isXmlHttpRequest()) {
            $basket =  $session->get("basket", null);
            $products = [];
            if ($basket) {
                foreach ($basket as $key => $value) {
                    $product = $produitRepo->find($key);
                    $product->setBasketNumber($value);
                    array_push($products, $product);
                }
            }
            return $this->render('basket/basket.html.twig', [
                'basket' => $basket,
                'products' => $products,
                'idUser' => $this->getUser()->getId()
            ]);
        } else {
            throw new Exception('Cette page n\'existe pas');
        }
    }

    #[Route('/putAsideItem/{id}', name: 'putAsideItem')]
    public function putAside(Produit $produit, Request $request): Response
    {
        if ($request->isXmlHttpRequest()) {
            $user = $this->getUser();
            $user->addWant($produit);
            $this->em->persist($user);
            $this->em->flush();
            return new JsonResponse(['sucess' => "ok"]);
        } else {
            throw new Exception('Cette page n\'existe pas');
        }
    }


    #[Route('/panier/confirmer', name: 'panier_confirm', methods: ['POST'])]
    public function confirm(SessionInterface $session, MailerInterface $mailer, Request $request, ProduitRepository $produitRepo): Response
    {
        $currentUser = $this->getUser();
        if ($this->isCsrfTokenValid('confirm' . $currentUser->getId(), $request->get('_token'))) {

            $basket =  $session->get("basket", null);
            $products = [];
            if ($basket) {
                $command = new Command();
                $command->setCreatedAt(new \DateTimeImmutable());
                $command->setUser($currentUser);
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
                $session->remove("total");
                $this->addFlash('success', 'Votre commande a bien ??tait pass?? nous reviendrons vers vous ulterieurement');
                return $this->redirectToRoute('commande_valide');
            } else {
                $this->addFlash('error', 'Vous n\'avez rien dans votre panier actuellement');
                return $this->redirectToRoute('panier');
            }
        } else {
            throw new Exception('Cette page n\'existe pas');
        }
    }

    #[Route('/panier/add/{id}', name: 'panier_add')]
    public function add(Produit $product, SessionInterface $session, Request $request): Response
    {
        if ($request->isXmlHttpRequest()) {
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
        } else {
            throw new Exception('Cette page n\'existe pas');
        }
    }

    #[Route('/aside/delete/{id}', name: 'aside_delete')]
    public function deleteAside(Produit $product, Request $request): Response
    {
        if ($request->isXmlHttpRequest()) {
            $user = $this->getUser();
            $user->removeWant($product);
            $this->em->flush();


            return new JsonResponse(['ok' => "ok"]);
        } else {
            throw new Exception('Cette page n\'existe pas');
        }
    }
}
