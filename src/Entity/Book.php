<?php

namespace App\Entity;

use App\Repository\BookRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

// Indique à doctrine qu'il faut surveiller cette entité
#[ORM\Entity(repositoryClass: BookRepository::class)]
class Book
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    // décrire la colonne en DB
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'text', length: 255)]
    private $title;

    #[ORM\ManyToOne(targetEntity: Author::class, inversedBy: "books")]
    private $author;

    #[ORM\Column(type: 'string')]
    private $isbn;

    #[ORM\ManyToMany(targetEntity: BookKind::class, inversedBy: 'books')]
    private $kinds;

    public function __construct()
    {
        $this->kinds = new ArrayCollection();
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id): void
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param mixed $title
     */
    public function setTitle($title): void
    {
        $this->title = $title;
    }

    /**
     * @return mixed
     */
    public function getAuthor()
    {
        return $this->author;
    }

    /**
     * @param mixed $author
     */
    public function setAuthor($author): void
    {
        $this->author = $author;
    }

    /**
     * @return mixed
     */
    public function getIsbn()
    {
        return $this->isbn;
    }

    /**
     * @param mixed $isbn
     */
    public function setIsbn($isbn): void
    {
        $this->isbn = $isbn;
    }

    /**
     * @return mixed
     */
    public function getKinds()
    {
        return $this->kinds;
    }

    public function setKinds($kinds)
    {
        $this->kinds = $kinds;
    }

    public function addKind(BookKind $bookKind)
    {
        // Vérifie qu'un genre ne soit pas déjà attribué avant de l'ajouter
        if (!$this->kinds->contains($bookKind)) {
            $this->kinds->add($bookKind);
        }
    }

    public function removeKind(BookKind $bookKind)
    {
        // Vérifie que le livre a le genre qu'on souhaite enlever
        if ($this->kinds->contains($bookKind)) {
            $this->kinds->remove($bookKind);
        }
    }

}
