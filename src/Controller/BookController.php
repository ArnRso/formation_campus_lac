<?php

namespace App\Controller;

// Les use, équivalents aux "require", représentent toutes les classes qui sont utilisées
// dans le fichier.
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class BookController extends AbstractController
{
    /**
     * @Route("/books")
     */
    public function books(Request $request)
    {
        // ^ la $request représente toutes les super globales qui proviennent de la requète
        // actuelle. ($_GET, $_POST, $_SERVER, etc...)
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

        $getName = $request->query->get('name', 'inconnu');
        $getAge = $request->query->getInt('age', '18');

        // la méthode render n'a pas été codée dans notre controller
        // mais dans la classe parente AbstractController
        return $this->render('book/books.html.twig', [
            'books' => $books,
            'page_title' => 'Liste des livres',
            'name' => $getName,
            'age' => $getAge
        ]);
    }
}