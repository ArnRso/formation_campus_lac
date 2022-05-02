<?php

namespace App\DataFixtures;

use App\Entity\Author;
use App\Entity\Book;
use App\Entity\BookKind;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $numberOfBooks = 50;
        $numberOfAuthors = 7;
        $numberOfBookKinds = 8;

        $faker = Faker\Factory::create('fr_FR');

        $authors = [];
        for ($i=0; $i <= $numberOfAuthors; $i++) {
            $author = new Author;
            $author->setFirstName($faker->firstName);
            $author->setLastName($faker->lastName);
            $author->setDateOfBirth($faker->dateTimeThisCentury);
            $manager->persist($author);
            $authors[] = $author;
        }

        $bookKinds = [];

        for ($i=0; $i <= $numberOfBookKinds; $i++) {
            $bookKind = new BookKind();
            $bookKind->setLabel(implode(' ', $faker->words(2)));
            $manager->persist($bookKind);
            $bookKinds[] = $bookKind;
        }

//        $manager->flush();
        $books = [];
        for ($i=0; $i <= $numberOfBooks; $i++) {
            $book = new Book();
            $book->setTitle(implode(' ', $faker->words(5)));
            $book->setAuthor($authors[array_rand($authors)]);

            $book->addKind($bookKinds[array_rand($bookKinds)]);
            $book->addKind($bookKinds[array_rand($bookKinds)]);
            $book->setIsbn($faker->isbn13);
            $manager->persist($book);
            $books[] = $book;
        }

        $manager->flush();
    }
}
