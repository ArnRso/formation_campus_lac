<?php

namespace App\Controller;

// Les use, équivalents aux "require", représentent toutes les classes qui sont utilisées
// dans le fichier.
use App\Repository\BookRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class BookController extends AbstractController
{
    // La route tire partie du paramètre name.
    // Au sein de notre code, il faudra utiliser ce nom lorsqu'on voudra y faire référence
    #[Route('/books', name: 'book_listing')]
    public function books(BookRepository $bookRepository)
    {
        $books = $bookRepository->findAll();
        return $this->render('book/books.html.twig', [
            'books' => $books
        ]);
    }

    // créer une route et un controller avec comme url /books/{id}
    #[Route('/books/{id}', name: 'book_detail')]
    public function bookDetail ($id, BookRepository $bookRepository){
        $book = $bookRepository->findOneBy([
            'id' => $id
        ]);

        return $this->render('book/bookDetail.html.twig', [
            'book' => $book
        ]);
    }
}