<?php

namespace Tests;

use App\Models\Book;
use App\Models\Bookshop\BookshopFiktivneKnihy;
use GuzzleHttp\Client;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\TestCase;

class BookshopFiktivneKnihyTest extends TestCase
{
    public function testSearch()
    {
        // Create a mock client
        $mock = new MockHandler([
            new Response(200, [], '{"data": [{"nazov": "Harry Potter a kamen mudrcov","cena": "10€"},{"nazov": "Harry Potter a tajomna komnata","cena": "11€"},{"nazov": "Harry Potter a vazen z Azkabanu","cena": "7€"}]}'),
        ]);
        $handler = HandlerStack::create($mock);
        $client = new Client(['handler' => $handler]);

        // Instantiate the BookshopFiktivneKnihy class with the mock client
        $bookshop = new BookshopFiktivneKnihy($client);

        // Search for books with the query "harry potter"
        $books = $bookshop->search('harry potter');

        // Assert that the response is an array of 3 books
        $this->assertCount(3, $books);

        // Assert that the first book in the array is an instance of the Book class
        $this->assertInstanceOf(Book::class, $books[0]);

        // Assert that the first book in the array has the correct title and price
        $this->assertEquals('Harry Potter a kamen mudrcov', $books[0]->getTitle());
        $this->assertEquals(10, $books[0]->getPrice());

        // Assert that the second book in the array has the correct title and price
        $this->assertEquals('Harry Potter a tajomna komnata', $books[1]->getTitle());
        $this->assertEquals(11, $books[1]->getPrice());

        // Assert that the third book in the array has the correct title and price
        $this->assertEquals('Harry Potter a vazen z Azkabanu', $books[2]->getTitle());
        $this->assertEquals(7, $books[2]->getPrice());
    }
}
