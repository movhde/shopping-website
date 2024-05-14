<?php

namespace App\DataFixtures;

use App\Factory\ProductsFactory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        // ProductsFactory::createMany(10);

        // $manager->flush();
    }
}
