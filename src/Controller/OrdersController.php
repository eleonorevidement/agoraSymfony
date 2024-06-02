<?php
namespace App\Controller;

use App\Entity\Orders;
use App\Entity\OrdersDetails;
use App\Form\PaymentType;
use App\Repository\ItemRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/commandes', name: 'app_orders_')]
class OrdersController extends AbstractController
{
    #[Route('/ajout', name: 'add')]
    public function add(Request $request, EntityManagerInterface $em, SessionInterface $session, ItemRepository $itemRepository): Response
    {
        $this->denyAccessUnlessGranted('ROLE_USER');

        $cart = $session->get('cart', []);

        if ($cart === []) {
            $this->addFlash('message', 'Votre panier est vide');
            return $this->redirectToRoute('home');
        }

        // Create the order entity
        $order = new Orders();
        $order->setUser($this->getUser());
        $order->setReference(uniqid());

        // Create and handle the payment form
        $paymentForm = $this->createForm(PaymentType::class);
        $paymentForm->handleRequest($request);

        if ($paymentForm->isSubmitted() && $paymentForm->isValid()) {
            $paymentData = $paymentForm->getData();
            $order->setPaymentMethod($paymentData['paymentMethod']);
            $order->setCardNumber($paymentData['cardNumber']);
            $order->setCvv($paymentData['cvv']);
            $order->setExpirationDate($paymentData['expirationDate']);
            $order->setAddress($paymentData['address']);
            $order->setPostalCode($paymentData['postalCode']);
            $order->setCity($paymentData['city']);
            $order->setCountry($paymentData['country']);
            $order->setPhoneNumber($paymentData['phoneNumber']);

            // Add order details from the cart
            foreach ($cart as $product => $quantity) {
                // Retrieve item from repository
                $item = $itemRepository->find($product);

                // Create order detail
                $orderDetail = new OrdersDetails();
                $orderDetail->setItem($item);
                $orderDetail->setPrice($item->getPrice());
                $orderDetail->setQuantity($quantity);

                // Add order detail to order
                $order->addOrdersDetail($orderDetail);
            }

            // Persist and flush the order
            $em->persist($order);
            $em->flush();

            // Clear the cart
            $session->remove('cart');

            // Redirect with success message
            $this->addFlash('message', 'Commande créée avec succès');
            return $this->redirectToRoute('home');
        }

        // Render the form along with your existing order form...
        return $this->render('orders/add.html.twig', [
            'paymentForm' => $paymentForm->createView(),
        ]);
    }

    #[Route('/mes-commandes', name: 'list')]
    public function list(EntityManagerInterface $em): Response
    {
        $this->denyAccessUnlessGranted('ROLE_USER');

        $user = $this->getUser();
        $orders = $em->getRepository(Orders::class)->findBy(['user' => $user], ['timestamp' => 'DESC']);

        return $this->render('orders/list.html.twig', [
            'orders' => $orders,
        ]);
    }
}
