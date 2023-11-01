<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PalindromeController extends AbstractController
{
    #[Route('/palindrome', name: 'app_palindrome')]
    public function index(): Response
    {
        return $this->render('palindrome/index.html.twig', [
            'controller_name' => 'PalindromeController',
        ]);
    }
}
