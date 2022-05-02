<?php

namespace App\Repository;

use App\Entity\Book;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class BookRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Book::class);
    }

    public function findBooksWithAuthor()
    {
        $qb = $this->createQueryBuilder('book')
            ->select('book')
            ->join('book.author', 'author')
            ->addSelect('author')
        ;

        $query = $qb->getQuery();
        return $query->execute();
    }

    public function findOneBookByIdWithAuthorAndBookKind($id)
    {
        $qb = $this->createQueryBuilder('book')
            ->select('book')
            ->join('book.author', 'author')
            ->addSelect('author')
            ->join('book.kinds', 'kinds')
            ->addSelect('kinds')
            ->where('book.id = :id')
            ->setParameter('id', $id)
        ;

        $query = $qb->getQuery();
        return $query->getOneOrNullResult();
    }
}
