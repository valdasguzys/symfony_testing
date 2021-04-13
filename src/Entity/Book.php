<?php

namespace App\Entity;
use App\Repository\BookRepository;
use Doctrine\ORM\Mapping as ORM;

/** 
* @ORM\Entity(repositoryClass=BookRepository::class) 
* @ORM\Table(name="books")
*/
class Book 
{
    /**
     * @ORM\Id
     * @ORM\Column(type="bigint")
     */
    private $isbn;
    
    /** @ORM\Column(type="string", length=255) */
    private $title;

    public function getIsbn(): ?string 
    {
        return $this->isbn;
    }

    public function setIsbn(string $isbn): self 
    {
        $this->isbn = $isbn;
        return $this;
    }

    public function getTitle(): ?string 
    {
        return $this->title;
    }

    public function setTitle(string $title): self 
    {
        $this->title = $title;
        return $this;
    }
}

