<?php

namespace App\Controller;

use App\Controller\BaseController;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Component\DependencyInjection\Loader\Configurator\validator;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\DependencyInjection\Loader\Configurator\serializer;

class UserController extends BaseController
{

  private $passwordHasher;
    private $jwtManager;
    private $tokenStorageInterface;
    public function __construct(UserPasswordHasherInterface $passwordHasher)
    {
        $this->passwordHasher = $passwordHasher;
    }
#[Route('/api/register', name: "app_user_api_me",methods: ['POST'])]
   
    public function apiMe(Request $request, SerializerInterface $serializer, EntityManagerInterface $em,ValidatorInterface $validator)
    {
    //    return $this->json($this->getUser(), 200, [], [
    //         'groups' => ['user:read']
    //     ]);
        $jsonRecu = $request->getContent();
        
        
        try {
                $user = $serializer->deserialize($jsonRecu,User::class,'json');
                $errors = $validator->validate( $user );

                if (count($errors) > 0) {
            
                return $this->json($errors , 400);
                }
                $user->setPassword($this->passwordHasher->hashPassword(   $user, $user->getPassword()));

                $em->persist($user);
                $em->flush();
              

        } catch(\Exception $ex) {

        
        return new JsonResponse(null, Response::HTTP_BAD_REQUEST);


        }

    }


}
