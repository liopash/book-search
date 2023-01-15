<?php
declare (strict_types = 1);

namespace App\Models\Bookshop;

use App\Models\Book;
use App\Services\Logger;
use Exception;

/**
 * Bookshop Non-Real bookshop
 * url: https://nonrealbookshop.com
 * query: https://nonrealbookshop.com/search?title=harry
 * response:
 * [
 *     {
 *          "title": "Harry Potter a kamen mudrcov",
 *          "price": "7",
 *          "currency": "€",
 *          "lang": "SK"
 *     },
 *     {
 *          "title": "Harry Potter a tajomna komnata",
 *          "price": "15",
 *          "currency": "€",
 *          "lang": "SK"
 *     },
 *     {
 *          "title": "Harry Potter a vazen z Azkabanu",
 *          "price": "18",
 *          "currency": "€",
 *          "lang": "SK"
 *     }
 * ]
 */
class BookshopNonReal extends Bookshop
{
    const NAME = "NonReal Bookshop";
    const URL = "http://nonrealbookshop.com"; // URL of the bookshop using non-secure HTTP protocol (http://) for testing purposes

    /**
     * Search for books
     *
     * @return Book[]
     */
    public function search($query)
    {
        $logger = Logger::getInstance();
        $logger->info('Searching for books', [
            'bookshop' => self::NAME,
            'query' => $query,
        ]);

        // GET request to bookshop
        try {
            $response = $this->client->get(self::URL . '/search', [
                'query' => [
                    'title' => $query,
                ],
            ]);

            $data = json_decode((string) $response->getBody(), true);

        } catch (Exception $e) {
            $logger->error('Error encountered while searching for books in bookshop', [
                'bookshop' => self::NAME,
                'query' => $query,
                'error' => $e->getMessage(),
            ]);

            return []; // Return empty array if error occurs to be able to continue with other bookshops
        }

        // Iterate over books and create Book objects
        $books = [];
        foreach ($data as $bookData) {
            $books[] = new Book($bookData['title'], (float) $bookData['price'], self::NAME);
        }

        return $books;
    }
}
