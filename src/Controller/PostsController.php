<?php

namespace App\Controller;

use App\Repository\PostsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\SerializerInterface;

class PostsController extends AbstractController
{
    #[Route('/api/posts', name: 'posts',methods: ['GET'])]
    public function getPostList(PostsRepository $postsRepository,SerializerInterface $serializer): JsonResponse
    {
        // $this->denyAccessUnlessGranted('ROLE_USER');
        $postList = $postsRepository->findAll()  ;  
        $jsonPostList = $serializer->serialize( $postList, 'json');

        return new JsonResponse($jsonPostList, Response::HTTP_OK,[],true);
    }


    // for single post
    #[Route('/api/posts/{id}' , name: 'detailPost', methods: ['GET'])]
   public  function getDetailePost(int $id , PostsRepository $postsRepository, SerializerInterface $serializer):JsonResponse
    {

        $post = $postsRepository->find($id);
        if ($post) {

            $jsonPost = $serializer->serialize($post, 'json');
            return new JsonResponse($jsonPost, Response::HTTP_OK, [], true);
        }
         return new JsonResponse(null, Response::HTTP_NOT_FOUND);
    }


}
