<?php

namespace App\Controller;

use App\Entity\User;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use SebastianBergmann\CodeCoverage\Driver\Xdebug2NotEnabledException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Config\Builder\Method;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserController extends AbstractController
{

    private $passwordHasher;

    public function __construct(UserPasswordHasherInterface $passwordHasher)
    {
        $this->passwordHasher = $passwordHasher;
    }
    
    #[Route('/api/user', name: 'addUser',methods:['POST'])]
    public function user(Request $request, SerializerInterface $serializer, EntityManagerInterface $em,ValidatorInterface $validator): JsonResponse 

    {

        $jsonRecu = $request->getContent();
        

        // $jsonRecu->setPassword();
        
        try {
                $user = $serializer->deserialize($jsonRecu,User::class,'json');
                $errors = $validator->validate( $user );

                if (count($errors) > 0) {
            
                return $this->json($errors , 400);
                }
                $user->setPassword($this->passwordHasher->hashPassword(   $user, $user->getPassword()));

                $em->persist($user);
                $em->flush();
                return $this->json($user,201,[]);

        } catch(Xdebug2NotEnabledException $e) {

            return $this->json([
            'status'=> 400,
            'message' =>$e->getMessage()

            ],400);

        }

    }
}
