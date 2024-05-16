<?php

namespace App\Controller;

use App\Entity\Products;
use App\Repository\ProductsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProductsController extends AbstractController
{
  #[Route('/', name: 'app_homepage')]
  public function homepage(ProductsRepository $productsRepository): Response
  {
    $products = $productsRepository->findAll();

    return $this->render('products/homepage.html.twig', [
      'products' => $products
    ]);
  }

  #[Route('/products/{id}', name: 'app_products_show')]
  public function show(Products $products)
  {
    return $this->render('products/show.html.twig', [
      'product' => $products
    ]);
  }
}
