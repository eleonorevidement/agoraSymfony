<?php

namespace App\Entity;

use App\Repository\OrdersDetailsRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: OrdersDetailsRepository::class)]
class OrdersDetails
{

    #[ORM\Id]
    #[ORM\ManyToOne(targetEntity: Item::class, inversedBy: 'orderDetails')]
    #[ORM\JoinColumn(nullable: false)]
    private Item $item ;

    #[ORM\Column]
    private ?int $quantity = null;

    #[ORM\Column]
    private ?int $price = null;

    #[ORM\Id]
    #[ORM\ManyToOne(inversedBy: 'ordersDetails')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Orders $orders = null;




    public function setItem(Item $item): static
    {
        $this->item = $item;

        return $this;
    }

    public function getItem(): Item
    {
        return $this->item;
    }



    public function getQuantity(): ?int
    {
        return $this->quantity;
    }

    public function setQuantity(int $quantity): static
    {
        $this->quantity = $quantity;

        return $this;
    }

    public function getPrice(): ?int
    {
        return $this->price;
    }

    public function setPrice(int $price): static
    {
        $this->price = $price;

        return $this;
    }

    public function getOrders(): ?Orders
    {
        return $this->orders;
    }

    public function setOrders(?Orders $orders): static
    {
        $this->orders = $orders;

        return $this;
    }







}
