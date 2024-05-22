<?php

namespace App\Controller;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
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
}
