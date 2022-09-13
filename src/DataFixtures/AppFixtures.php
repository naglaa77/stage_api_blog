<?php

namespace App\DataFixtures;

use Faker\Factory;
use App\Entity\Posts;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        // $product = new Product();
        // $manager->persist($product);
        // Création d'une vingtaine de livres ayant pour titre
        $faker = Factory::create('fr_FR');
        for ($i = 0; $i < 70; $i++) {
            $livre = new Posts;
            $livre->setTitre($faker->sentence);
            $livre->setContenu($faker->text);
            $livre->setCreateAt($faker->dateTime);
            $livre->setCreateBy($faker->firstName);
            $manager->persist($livre);
        }

        $manager->flush();
    }
}
