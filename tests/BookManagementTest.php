<?php


namespace App\Tests;
use App\Entity\Book;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class BookManagementTest extends WebTestCase 
{
    private $entityManager;

    private $client;

    public function setUp(): void 
    {
        $this->client = static::createClient();
        $kernel = self::bootKernel();
        DatabasePrimer::prime($kernel);
        $this->entityManager = $kernel->getContainer()->get('doctrine')->getManager();
    }

    public function tearDown(): void 
    {
        parent::tearDown();
        $this->entityManager->close();
        $this->entityManager == null;
    }

    /** @test */
    public function books_can_be_retrieved()
    {
        // given / when
        $this->client->request('GET', '/book');
        // then
        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());
        $this->assertEquals('[]', $this->client->getResponse()->getContent());
    }

    /** @test */
    public function book_can_be_added()
    {
        // given / when
        $this->client->request('POST', '/book', [], [], 
                ['CONTENT_TYPE' => 'application/json'], 
                '{"isbn":"111", "title": "Optimal"}');
        // then
        $this->assertEquals(201, $this->client->getResponse()->getStatusCode());
        $this->assertEquals('{"status":"Book created!"}', $this->client->getResponse()->getContent());
        $this->client->request('GET', '/book');
        $this->assertEquals('[{"isbn":"111","title":"Optimal"}]', $this->client->getResponse()->getContent());
    }
}
