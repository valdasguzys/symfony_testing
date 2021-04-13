<?php

namespace App\Tests;

use App\Entity\Book;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class BookManagementTest extends KernelTestCase 
{
    private $entityManager;

    public function setUp(): void
    {   
        $kernel = self::bootKernel();
        DatabasePrimer::prime($kernel);
        $this->entityManager = $kernel->getContainer()->get('doctrine')->getManager();
    }
 
    public function tearDown(): void {
        parent::tearDown();
        $this->entityManager->close();
        $this->entityManager == null;
    }

    /** @test  */
    public function book_can_be_added()
     {
        // given
        $book = new Book();
        $book->setIsbn('595145151');
        $book->setTitle('Holy Bible');

        // when 
        $this->entityManager->persist($book);
        $this->entityManager->flush();

        // then
        $booksRepo = $this->entityManager->getRepository(Book::class);
        $bookRetrived = $booksRepo->findOneBy(['title' => 'Holy Bible']);    
        $this->assertEquals('595145151', $bookRetrived->getIsbn());
        $this->assertEquals('Holy Bible', $bookRetrived->getTitle());
    }
}
