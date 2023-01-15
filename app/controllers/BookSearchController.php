<?php
declare (strict_types = 1);

namespace App\Controllers;

use App\Services\Logger;
use App\Models\Book;
use App\Models\Bookshop\BookshopFiktivneKnihy;
use App\Models\Bookshop\BookshopNonReal;
use GuzzleHttp\Client;

// This class is responsible for searching books in all active bookshops
class BookSearchController
{
    // Add additional cases for other bookshops when introduced to the system
    const BOOKSHOP_MAPPER = [
        'fiktivne-knihy.sk' => BookshopFiktivneKnihy::class,
        'nonrealbookshop.com' => BookshopNonReal::class,
    ];

    /**
     * Search for books by query (title of a book) in all active bookshops and return them sorted by price
     *
     * @return Book[] $books
     */
    public static function search(
        string $query,
        array $bookshop_names,
        $client = new Client()
    ) {
        $logger = Logger::getInstance();

        $books = [];

        foreach ($bookshop_names as $name) {
            // initialize bookshop classes
            if (isset(self::BOOKSHOP_MAPPER[$name])) {
                $bookshop = new (self::BOOKSHOP_MAPPER[$name])($client);
                $books = array_merge($books, $bookshop->search($query));
            } else {
                $logger->error('Bookshop not found', ['name' => $name]);
            }
        }

        // sort books by price in ascending order
        usort($books, function ($a, $b) {
            return $a->getPrice() <=> $b->getPrice();
        });

        $logger->info('Books found', ['amount' => count($books)]);

        // return array of books
        return $books;
    }

}
