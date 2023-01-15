<?php

namespace Tests\Unit\Models\Bookshop;

use App\Models\Book;
use App\Models\Bookshop\BookshopNonReal;
use GuzzleHttp\Client;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\TestCase;

class BookshopNonRealTest extends TestCase
{
    public function testSearch()
    {
        // Create a mock client
        $mock = new MockHandler([
            new Response(200, [], '[{"title": "Harry Potter a kamen mudrcov","price": "7","currency": "€","lang": "SK"},{"title": "Harry Potter a tajomna komnata","price": "15","currency": "€","lang": "SK"},{"title": "Harry Potter a vazen z Azkabanu","price": "18","currency": "€","lang": "SK"}]'),
        ]);
        $handler = HandlerStack::create($mock);
        $client = new Client(['handler' => $handler]);

        // Instantiate the BookshopNonReal class with the mock client
        $bookshop = new BookshopNonReal($client);

        // Search for books with the query "harry potter"
        $books = $bookshop->search('harry potter');

        // Assert that the response is an array of 3 books
        $this->assertCount(3, $books);

        // Assert that the first book in the array is an instance of the Book class
        $this->assertInstanceOf(Book::class, $books[0]);

        // Assert that the first book in the array has the correct title and price
        $this->assertEquals('Harry Potter a kamen mudrcov', $books[0]->getTitle());
        $this->assertEquals(7, $books[0]->getPrice());

        // Assert that the second book in the array has the correct title and price
        $this->assertEquals('Harry Potter a tajomna komnata', $books[1]->getTitle());
        $this->assertEquals(15, $books[1]->getPrice());

        // Assert that the third book in the array has the correct title and price
        $this->assertEquals('Harry Potter a vazen z Azkabanu', $books[2]->getTitle());
        $this->assertEquals(18, $books[2]->getPrice());
    }
}
