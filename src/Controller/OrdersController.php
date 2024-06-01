<?php

namespace App\Controller;

use App\Entity\Orders;
use App\Entity\OrdersDetails;
use App\Repository\ItemRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Attribute\Route;
#[Route('/commandes', name: 'app_orders_')]
class OrdersController extends AbstractController
{
    #[Route('/ajout', name: 'add')]
    public function add(EntityManagerInterface $em,SessionInterface $session, ItemRepository $itemRepository): Response
    {
        $this->denyAccessUnlessGranted('ROLE_USER');

        $cart = $session->get('cart', []);

        if($cart === []){
            $this->addFlash('message','Votre panier est vide');
            return $this->redirectToRoute('home');
        }
        //le panier n'est pas vide, on crée la commande
        $order = new Orders();

        //on remplit la commande
        $order->setUser($this->getUser());
        $order->setReference(uniqid());


        //On parcourt le panier pour créer les details de commande
        foreach($cart as $product => $quantity){
            $orderDetails = new OrdersDetails();

            //on cherche l'item
            $item = $itemRepository->find($product);

            $price = $item->getPrice();

            //On crée le detail de commande
            $orderDetails->setItem($item);
            $orderDetails->setPrice($price);
            $orderDetails->setQuantity($quantity);

            //On ajoute

            $order->addOrdersDetail($orderDetails);

        }

        //on persiste et flush

        $em->persist($order);
        $em->flush();

        $session->remove('cart');

       $this->addFlash('message','Commande créée avec succès');
       return $this->redirectToRoute('home');
    }
}
