<?php

namespace App\DataFixtures;

use Faker\Factory;
use App\Entity\User;
use App\Entity\Posts;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use phpDocumentor\Reflection\DocBlock\Tags\Reference\Url;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{

    private $userPasswordHasher;
    
    public function __construct(UserPasswordHasherInterface $userPasswordHasher)
    {
        $this->userPasswordHasher = $userPasswordHasher;
    }
    public function load(ObjectManager $manager): void
    {
     
        $faker = Factory::create('fr_FR');
        for ($i = 0; $i < 20; $i++) {
            $livre = new Posts;
            $livre->setTitre($faker->sentence);
            $livre->setContenu($faker->text);
            $livre->setCreateAt($faker->dateTime);
            $livre->setCreateBy($faker->firstName);
            $livre->setImageUrl($faker->imageUrl());
            $manager->persist($livre);
        }
        // Création d'un user "normal"
        $user = new User();
        $user->setEmail("user@bookapi.com");
        $user->setRoles(["ROLE_USER"]);
        $user->setPassword($this->userPasswordHasher->hashPassword($user, "password"));
        $user->setFullName('naglaa');
        $user->setPhoneNumro('0770377294');
            
        $manager->persist($user);

        // Création d'un user admin
        $userAdmin = new User();
        $userAdmin->setEmail("admin@bookapi.com");
        $userAdmin->setRoles(["ROLE_ADMIN"]);
        $userAdmin->setPassword($this->userPasswordHasher->hashPassword($userAdmin, "password"));
         $userAdmin->setFullName('admin');
          $userAdmin->setPhoneNumro('0750256897');
        $manager->persist($userAdmin);
    

        $manager->flush();
    }
}
