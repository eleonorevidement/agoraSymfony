<?php

namespace App\Controller;

use App\Entity\Item;
use App\Repository\ItemRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Attribute\Route;


#[Route('/cart', name: 'app_cart')]
class CartController extends AbstractController
{
    #[Route('/',name:'_index')]
    public function index(SessionInterface $session, ItemRepository $ItemRepository)
    {
        $cart =$session->get('cart',[]);

        $data =[];
        $total = 0;
        foreach($cart as $id => $quantity){
            $item = $ItemRepository->find($id);

            $data[] = [
                'item' => $item,
                'quantity' => $quantity,
            ];
            $total += $item->getPrice() * $quantity;
        }
        return $this->render('cart/index.html.twig',[
            'data' => $data,
            'total' => $total
        ]);

    }

    #[Route('/add/{id}',name:'_add')]
    public function add(Item $item,SessionInterface $session)
    {
        $id = $item->getId();

        $cart =$session->get('cart',[]);
        if(empty($cart[$id])){
            $cart[$id] =1;
        }
        else{
            $cart[$id]++;
        }

        $session->set('cart',$cart);

        return $this->redirectToRoute('app_cart_index');



    }
    #[Route('/remove/{id}',name:'_remove')]
    public function remove(Item $item,SessionInterface $session)
    {
        $id = $item->getId();

        $cart = $session->get('cart', []);
        if (!empty($cart[$id])) {
            if ($cart[$id] > 1) {
                $cart[$id]--;
            } else {
                unset($cart[$id]);
            }
        }


        $session->set('cart',$cart);

        return $this->redirectToRoute('app_cart_index');



    }
    #[Route('/delete/{id}',name:'_delete')]
    public function delete(Item $item,SessionInterface $session)
    {
        $id = $item->getId();

        $cart = $session->get('cart', []);
        if (!empty($cart[$id])) {
            unset($cart[$id]);
        }


        $session->set('cart',$cart);

        return $this->redirectToRoute('app_cart_index');



    }
    #[Route('/empty',name:'_empty')]
    public function empty(SessionInterface $session)
    {
        $session->remove('cart');

        return $this->redirectToRoute('app_cart_index');



    }
}






