<?php

namespace App\DataFixtures;

use App\Entity\Produit;
use Faker\Factory;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class ProduitFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $faker = Factory::create('FR-fr');
        for ($i = 0; $i < 10; $i++) {
            $user = new Produit();
            $user->setDesignation($faker->name())
                ->setPrix('1500')
                ->setColor($faker->rgbcolor())
                ->setIsShipped('1')
                ->setVendeur($faker->company());
            $manager->persist($user);
        }

        $manager->flush();
    }
}
