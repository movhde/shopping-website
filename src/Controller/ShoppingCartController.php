<?php

namespace App\Controller;

use App\Entity\ShoppingCart;
use App\Repository\ProductsRepository;
use App\Repository\ShoppingCartRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Attribute\Route;

class ShoppingCartController extends AbstractController
{
    #[Route('/cart/{id}', name: 'app_new_cart')]
    public function new(EntityManagerInterface $entityManager, ShoppingCartRepository $shoppingCartRepository, ProductsRepository $productsRepository, Request $request, $id): Response
    {
        $product = $productsRepository->find($id);
        $user = $this->getUser();

        if (!$user) {
            throw new NotFoundHttpException('ابتدا وارد حساب کاربری خود شوید');
        }

        $shoppingCart = $shoppingCartRepository->findOneBy(['user' => $user, 'product' => $product]);

        if ($shoppingCart) {
            $totalAmount = $shoppingCart->getAmount() + $request->get('amount');
            $shoppingCart->setAmount($totalAmount);
        } else {
            $shoppingCart = new ShoppingCart();
            $shoppingCart->setUser($user);
            $shoppingCart->setProduct($product);
            $shoppingCart->setAmount($request->get('amount'));
        }

        $entityManager->persist($shoppingCart);
        $entityManager->flush();

        return $this->redirectToRoute('app_show_cart');
    }

    #[Route('/cart', name: 'app_show_cart')]
    public function show(ShoppingCartRepository $shoppingCartRepository)
    {
        $cartItems = $shoppingCartRepository->findBy(['user' => $this->getUser()]);

        $totalPrice = 0;
        foreach ($cartItems as $items) {
            $totalPrice += $items->getAmount() * $items->getProduct()->getPrice();
        }

        return $this->render('shopping_cart/show.html.twig', [
            'cartItems' => $cartItems,
            'totalPrice' => $totalPrice
        ]);
    }

    #[Route('/increase/{id}', name: "app_increaseAmount")]
    public function increaseAmount($id, ShoppingCartRepository $shoppingCartRepository, EntityManagerInterface $entityManager)
    {
        $shoppingCart = $shoppingCartRepository->find($id);
        $shoppingCart->setAmount($shoppingCart->getAmount() + 1);

        $entityManager->flush();

        return $this->redirectToRoute('app_show_cart');
    }

    #[Route('/decrease/{id}', name: "app_decreaseAmount")]
    public function decreaseAmount($id, ShoppingCartRepository $shoppingCartRepository, EntityManagerInterface $entityManager)
    {
        $shoppingCart = $shoppingCartRepository->find($id);
        $shoppingCart->setAmount($shoppingCart->getAmount() - 1);

        if ($shoppingCart->getAmount() === 0) {
            $shoppingCartRepository->removeProduct($shoppingCart->getProduct()->getId(), $this->getUser());
        }

        $entityManager->flush();

        return $this->redirectToRoute('app_show_cart');
    }

    #[Route('/delete/{id}', name: 'app_delete_cartItem')]
    public function deleteItem($id, ShoppingCartRepository $shoppingCartRepository, EntityManagerInterface $entityManager)
    {
        $shop = $shoppingCartRepository->find($id);
        $entityManager->remove($shop);
        $entityManager->flush();

        return $this->redirectToRoute('app_show_cart');
    }
}
