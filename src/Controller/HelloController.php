<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;

class HelloController extends AbstractController
{
    #[Route('/hello', name: 'app_hello')]
    public function index(): JsonResponse
    {
        return $this->json(['message' => 'hello , GI4' , 'status' => 200]
);
    }
}
