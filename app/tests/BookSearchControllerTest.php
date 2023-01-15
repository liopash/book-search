<?php

use App\Controllers\BookSearchController;
use App\Models\Bookshop\BookshopFiktivneKnihy;
use App\Models\Bookshop\BookshopNonReal;
use GuzzleHttp\Client;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\TestCase;

class BookSearchControllerTest extends TestCase
{
    public function testSearch()
    {
        // Create a mock client for bookshops
        $mock = new MockHandler([
            new Response(200, [], '{"data": [{"nazov": "Harry Potter a kamen mudrcov","cena": "10€"},{"nazov": "Harry Potter a tajomna komnata","cena": "11€"},{"nazov": "Harry Potter a vazen z Azkabanu","cena": "7€"}]}'),
            new Response(200, [], '[{"title": "Harry Potter a kamen mudrcov","price": "7","currency": "€","lang": "SK"},{"title": "Harry Potter a tajomna komnata","price": "15","currency": "€","lang": "SK"},{"title": "Harry Potter a vazen z Azkabanu","price": "18","currency": "€","lang": "SK"}]'),
        ]);
        $handler = HandlerStack::create($mock);
        $client = new Client(['handler' => $handler]);


        // Create an instance of the BookshopFiktivneKnihy and BookshopNonReal classes
        $bookshopFiktivneKnihy = new BookshopFiktivneKnihy($client);
        $bookshopNonReal = new BookshopNonReal($client);

        // Search for books with the title "Harry Potter" in the bookshops "fiktivne-knihy.sk" and "nonrealbookshop.com"
        $books = BookSearchController::search(
            'harry potter',
            ['fiktivne-knihy.sk', 'nonrealbookshop.com'],
            $client
        );

        // Assert that the result is an array of 6 books
        $this->assertCount(6, $books);

        // Assert that the first book in the result array is "Harry Potter a vazen z Azkabanu" with a price of 7
        $this->assertEquals(
            [
                'title' => 'Harry Potter a vazen z Azkabanu',
                'price' => 7,
                'bookshop' => 'Fiktivne Knihy',
            ],
            $books[0]->toArray()
        );

        // Assert that the second book in the result array is "Harry Potter a kamen mudrcov" with a price of 7"
        $this->assertEquals(
            [
                'title' => 'Harry Potter a kamen mudrcov',
                'price' => 7,
                'bookshop' => 'NonReal Bookshop',
            ],
            $books[1]->toArray()
        );

        // Asset that last book in the result array is "Harry Potter a vazen z Azkabanu" with a price of 18
        $this->assertEquals(
            [
                'title' => 'Harry Potter a vazen z Azkabanu',
                'price' => 18,
                'bookshop' => 'NonReal Bookshop',
            ],
            $books[array_key_last($books)]->toArray()
        );
    }
}
