<?php

namespace App\Controller;

use App\Entity\Book;
use App\Repository\BookRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

class BookController extends AbstractController 
{
    /** @Route("/book", name="book.index", methods={"GET"}) */
    public function index(BookRepository $bookRepository, SerializerInterface $serializer): Response 
    {
        $books = $bookRepository->findAll();
        return new Response($serializer->serialize($books, 'json'));
    }

    /** @Route("/book", name="book.create", methods={"POST"}) */
    public function create(Request $request): JsonResponse 
    {
        $book = new Book();
        $data = json_decode($request->getContent(), true);
        // ... validation and return error response if incorrect date
        $book->setIsbn($data['isbn']);
        $book->setTitle($data['title']);

        $em = $this->getDoctrine()->getManager();
        $em->persist($book);
        $em->flush();

        return new JsonResponse(['status' => 'Book created!'], Response::HTTP_CREATED); 
    }

}

 