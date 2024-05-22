<?php

namespace App\Controller;

use App\Entity\Address;
use App\Repository\AddressRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class OrderController extends AbstractController
{
    #[Route('/order/{id}', name: 'app_new_order')]
    public function new(): Response
    {
        return new Response('order blublu');
    }

    #[Route('/orders', name: 'app_show_order')]
    public function show(EntityManagerInterface $entityManager)
    {
        return new Response('orders...');
    }

    #[Route('/checkout', name: 'app_checkout_order')]
    public function checkoutOrder(AddressRepository $addressRepository)
    {
        $addresses = $addressRepository->findAll();

        return $this->render('order/checkout.html.twig', [
            'addresses' => $addresses
        ]);
    }

    #[Route('/submit/address', name: 'app_submit_address', methods: ['POST'])]
    public function submitAddress(EntityManagerInterface $entityManager, Request $request)
    {
        $address = new Address();
        $address->setProvince($request->request->get('province'));
        $address->setAddress($request->request->get('address'));
        $address->setPostcode($request->request->get('postcode'));
        $entityManager->persist($address);
        $entityManager->flush();

        return $this->redirectToRoute('app_checkout_order');
    }

    #[Route('new/address', name: 'app_new_address')]
    public function newAddress()
    {
        return $this->render('address/new.html.twig');
    }

    #[Route('remove/address/{id}', name: 'app_remove_address')]
    public function removeAddress(AddressRepository $addressRepository, $id)
    {
        $addressRepository->removeAddress($id);

        return $this->redirectToRoute('app_checkout_order');
    }
}
