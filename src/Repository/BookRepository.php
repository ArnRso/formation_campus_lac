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

    public function findBooksWithAuthor($searchFormValues)
    {
        $qb = $this->createQueryBuilder('book')
            ->select('book')
            ->leftJoin('book.author', 'author')
            ->addSelect('author')
        ;

        if (!empty($searchFormValues['title'])) {
            $qb->andWhere('book.title LIKE :title')
                ->setParameter('title', '%' . $searchFormValues['title'] .'%');
        }

        if (!empty($searchFormValues['author'])) {
            $qb->andWhere('book.author = :author')
                ->setParameter('author', $searchFormValues['author']);
        }

        if (!empty($searchFormValues['isbn'])) {
            $qb->andWhere('book.isbn = :isbn')
                ->setParameter('isbn', $searchFormValues['isbn']);
        }

        if (!empty($searchFormValues['kinds'])) {
            $qb->andWhere(':kinds MEMBER OF book.kinds')
                ->setParameter('kinds', $searchFormValues['kinds']);
        }

        $query = $qb->getQuery();
        return $query->execute();
    }

    public function findOneBookByIdWithAuthorAndBookKind($id)
    {
        $qb = $this->createQueryBuilder('book')
            ->select('book')
            ->leftJoin('book.author', 'author')
            ->addSelect('author')
            ->leftJoin('book.kinds', 'kinds')
            ->addSelect('kinds')
            ->where('book.id = :id')
            ->setParameter('id', $id)
        ;

        $query = $qb->getQuery();
        return $query->getOneOrNullResult();
    }
}
