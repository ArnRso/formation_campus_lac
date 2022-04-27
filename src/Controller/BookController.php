<?php

namespace App\Controller;

// Les use, équivalents aux "require", représentent toutes les classes qui sont utilisées
// dans le fichier.
use App\Entity\Book;
use App\Form\BookType;
use App\Repository\BookRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
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

    #[Route('/books/new', name: 'book_new')]
    public function bookNew(Request $request, EntityManagerInterface $entityManager)
    {
        $newBook = new Book();
        $form = $this->createForm(BookType::class, $newBook);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()){
            $bookToSave = $form->getData();
            $entityManager->persist($bookToSave);
            $entityManager->flush();

            return $this->redirectToRoute('book_listing');
        }

        return $this->render('book/bookNew.html.twig', [
            'bookForm' => $form->createView()
            ]);
    }

    #[Route('/books/{id}/edit', name: 'book_edit')]
    public function bookEdit($id, BookRepository $bookRepository, Request $request, EntityManagerInterface $entityManager)
    {
        $book = $bookRepository->findOneBy([
            'id' => $id
        ]);

        if (!$book) {
            return $this->redirectToRoute('book_listing');
        }

        $form = $this->createForm(BookType::class, $book);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()){
            $bookToSave = $form->getData();
            $entityManager->persist($bookToSave);
            $entityManager->flush();

            return $this->redirectToRoute('book_listing');
        }

        return $this->render('book/bookEdit.html.twig', [
            'bookForm' => $form->createView()
        ]);
    }

    // créer une route et un controller avec comme url /books/{id}
    #[Route('/books/{id}', name: 'book_detail')]
    public function bookDetail ($id, BookRepository $bookRepository){
        $book = $bookRepository->findOneBy([
            'id' => $id
        ]);

        if (!$book) {
            return $this->redirectToRoute('book_listing');
        }

        return $this->render('book/bookDetail.html.twig', [
            'book' => $book
        ]);
    }
}