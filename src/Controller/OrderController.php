<?php

namespace App\Controller;

use App\Entity\Order;
use App\Repository\ProductsRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\FrameworkBundle\Controller\RedirectController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Attribute\Route;

class OrderController extends AbstractController
{
    #[Route('/order/{id}', name: 'app_new_order')]
    public function new(EntityManagerInterface $entityManager, ProductsRepository $productsRepository, int $id): Response
    {
        $product = $productsRepository->find($id);
        $user = $this->getUser();

        if (!$user) {
            throw new NotFoundHttpException('ابتدا وارد حساب کاربری خود شوید');
        }

        $order = new Order();
        $order->setAmount($product->getPrice());
        $order->setCustomerId($user);

        $entityManager->persist($order);
        $entityManager->flush();

        return $this->redirectToRoute('app_homepage');
    }
}
