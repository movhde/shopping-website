<?php

namespace App\Controller;

use App\Entity\Address;
use App\Entity\Order;
use App\Entity\OrderItem;
use App\Repository\AddressRepository;
use App\Repository\CityRepository;
use App\Repository\OrderItemRepository;
use App\Repository\OrderRepository;
use App\Repository\ProductsRepository;
use App\Repository\ProvinceRepository;
use App\Repository\ShoppingCartRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Core\Authentication\RememberMe\PersistentTokenInterface;

class OrderController extends AbstractController
{
    #[Route('/order', name: 'app_new_order')]
    public function new(Request $request, AddressRepository $addressRepository, EntityManagerInterface $entityManager, OrderRepository $orderRepository, ShoppingCartRepository $shoppingCartRepository): Response
    {
        $address = $addressRepository->find($request->request->get('address'));
        $order = new Order();
        $order->setCustomer($this->getUser());
        $order->setAddress($address);
        $entityManager->persist($order);

        $shop = $shoppingCartRepository->findBy(['user' => $this->getUser()]);

        foreach ($shop as $shopItem) {
            $orderItem = new OrderItem();
            $orderItem->setProduct($shopItem->getProduct());
            $orderItem->setAmount($shopItem->getAmount());
            $orderItem->setUserOrder($order);
            $entityManager->persist($orderItem);
            // remove shopItem
        }

        $entityManager->flush();

        return $this->redirectToRoute('app_show_order', [
            'id' => $order->getId()
        ]);
    }

    #[Route('/orders/{id}', name: 'app_show_order')]
    public function show($id, OrderItemRepository $orderItemRepository, ProductsRepository $productsRepository, EntityManagerInterface $entityManager)
    {
        $orders = $orderItemRepository->findBy(['userOrder' => $id]);

        return $this->render('order/show.html.twig', [
            'orders' => $orders
        ]);
    }

    #[Route('/checkout', name: 'app_checkout_order')]
    public function checkoutOrder(ShoppingCartRepository $shoppingCartRepository, AddressRepository $addressRepository, ProvinceRepository $provinceRepository, CityRepository $cityRepository)
    {
        $cartItems = $shoppingCartRepository->findBy(['user' => $this->getUser()]);

        $totalPrice = 0;
        foreach ($cartItems as $items) {
            $totalPrice += $items->getAmount() * $items->getProduct()->getPrice();
        }

        $addresses = $addressRepository->findBy(['user' => $this->getUser()]);
        $provinces = $provinceRepository->findAll();
        $cities = $cityRepository->findAll();


        return $this->render('order/checkout.html.twig', [
            'addresses' => $addresses,
            'provinces' => $provinces,
            'cities' => $cities,
            'totalPrice' => $totalPrice
        ]);
    }
}
