<?php

namespace App\Controller;

use App\Entity\Address;
use App\Repository\AddressRepository;
use App\Repository\CityRepository;
use App\Repository\ProvinceRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class AddressController extends AbstractController
{
  #[Route('/submit/address', name: 'app_submit_address', methods: ['POST'])]
  public function submitAddress(EntityManagerInterface $entityManager, Request $request, ProvinceRepository $provinceRepository)
  {
    $province = $provinceRepository->find($request->request->get('state'));
    $address = new Address();
    $address->setProvince($province->getName());
    $address->setAddress($request->request->get('address'));
    $address->setPostcode($request->request->get('postcode'));
    $address->setArchive(false);
    $address->setUser($this->getUser());

    $entityManager->persist($address);
    $entityManager->flush();

    return $this->redirectToRoute('app_checkout_order');
  }

  #[Route('new/address', name: 'app_new_address')]
  public function newAddress(ProvinceRepository $provinceRepository, CityRepository $cityRepository)
  {
    $provinces = $provinceRepository->findAll();
    $cities = $cityRepository->findAll();

    return $this->render('address/new.html.twig', [
      'provinces' => $provinces,
      'cities' => $cities
    ]);
  }

  #[Route('remove/address/{id}', name: 'app_remove_address')]
  public function removeAddress(EntityManagerInterface $entityManager, AddressRepository $addressRepository, $id)
  {
    $address = $addressRepository->find($id);
    $address->setArchive(true);

    $entityManager->flush();

    return $this->redirectToRoute('app_checkout_order');
  }
}
