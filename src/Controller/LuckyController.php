<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class LuckyController extends AbstractController
{
    /**
     * @Route("/lucky/number")
     */
    public function number(): Response
    {
        $number = random_int(0, 100);
        $books = [
            [
                'title' => 'titre 1',
                'author' => [
                    'firstname' => 'John',
                    'lastname' => 'Doe'
                ],
                'available' => true
            ],
            [
                'title' => 'titre 2',
                'author' => [
                    'firstname' => 'Jane',
                    'lastname' => 'Smith'
                ],
                'available' => false
            ]
        ];

        return $this->render('lucky/number.html.twig', [
            'number' => $number,
            'books' => $books
        ]);
    }
}