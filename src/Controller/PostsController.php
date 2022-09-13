<?php

namespace App\Controller;

use App\Repository\PostsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;

class PostsController extends AbstractController
{
    #[Route('/api/posts', name: 'posts',methods: ['GET'])]
    public function getPostList(PostsRepository $postsRepository): JsonResponse
    {

        $postList = $postsRepository->findAll()  ;  
    
        return new JsonResponse([
        
            'posts' => $postList,
        
        ]);
    }
}
