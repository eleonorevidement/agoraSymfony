<?php

namespace App\Controller;

use App\Entity\Item;
use App\Form\ItemType;
use App\Repository\ItemRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[Route('/item')]
class ItemController extends AbstractController
{
    #[Route('/', name: 'app_item_index', methods: ['GET'])]
    public function index(ItemRepository $itemRepository): Response
    {
        return $this->render('item/index.html.twig', [
            'items' => $itemRepository->findAll(),
        ]);
    }

    #[Route('/myItems', name: 'app_my_items_index', methods: ['GET'])]
    #[IsGranted('ROLE_SELLER')]
    public function indexForSeller(ItemRepository $itemRepository): Response
    {
        $seller = $this->getUser();
        return $this->render('item/index.html.twig', [
            'items' => $itemRepository->findBy([
                'seller' => $seller
            ]),
        ]);
    }

    #[Route('/new', name: 'app_item_new', methods: ['GET', 'POST']), ]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        // Utilisation du Voter pour verifier si l'utilisateur peut creer un item
        $this->denyAccessUnlessGranted('CREATE_ITEM');

        $item = new Item();
        $form = $this->createForm(ItemType::class, $item);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $item->setSeller($this->getUser());
            $entityManager->persist($item);
            $entityManager->flush();

            return $this->redirectToRoute('app_item_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('item/new.html.twig', [
            'item' => $item,
            'form' => $form,
        ]);
    }



    #[Route('/{id}', name: 'app_item_show', methods: ['GET'])]
    public function show(Item $item): Response
    {
        return $this->render('item/show.html.twig', [
            'item' => $item,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_item_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Item $item, EntityManagerInterface $entityManager): Response
    {
        // Utilisation du Voter pour verifier si l'utilisateur peut editer cet item
        $this->denyAccessUnlessGranted('EDIT_DELETE_ITEM', $item);

        $form = $this->createForm(ItemType::class, $item);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_item_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('item/edit.html.twig', [
            'item' => $item,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_item_delete', methods: ['POST']), ]
    public function delete(Request $request, Item $item, EntityManagerInterface $entityManager): Response
    {
        // Utilisation du Voter pour verifier si l'utilisateur peut supprimer cet item
        $this->denyAccessUnlessGranted('EDIT_DELETE_ITEM', $item);
        if ($this->isCsrfTokenValid('delete' . $item->getId(), $request->getPayload()->get('_token'))) {
            $entityManager->remove($item);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_item_index', [], Response::HTTP_SEE_OTHER);
    }
}







