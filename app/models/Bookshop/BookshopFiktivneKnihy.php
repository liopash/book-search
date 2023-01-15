<?php
declare (strict_types = 1);

namespace App\Models\Bookshop;

use App\Models\Book;
use App\Services\Logger;

/**
 * Bookshop Fiktivne Knihy
 *
 * url: https://fiktivne-knihy.sk
 * query:  https://fiktivne-knihy.sk/hladaj?nazov=harry%20Bpotter
 * response:
 * {
 *     "data": [
 *         {
 *             "nazov": "Harry Potter a kamen mudrcov",
 *             "cena": "10€"
 *         },
 *         {
 *             "nazov": "Harry Potter a  tajomna komnata",
 *             "cena": "11€"
 *         },
 *         {
 *             "nazov": "Harry Potter a vazen z Azkabanu",
 *             "cena": "7€"
 *         }
 *     ]
 * }
 */
class BookshopFiktivneKnihy extends Bookshop
{
    /**
     * Name of the bookshop (Fiktivne Knihy)
     * for PoC name is hardcoded but in real world it should be stored ex. in database
     * and fetched from there or fetched from some API endpoint based on bookshop ID
     */
    const NAME = "Fiktivne Knihy";
    /**
     * URL of the bookshop using non-secure HTTP protocol (http://)
     * as the bookshop does not support HTTPS protocol (https://) in docker environment
     * as it is just mock bookshop for testing purposes in a real world it should be https://
     */
    const URL = "http://fiktivne-knihy.sk";

    /**
     * Search for books
     *
     * In case of Fiktivne Knihy API is returning price with currency string (ex. "10€") therefor we need to drop it
     * and convert it to float. We are using helper function for that.
     *
     * @return Book[]
     */
    public function search(string $query): array
    {
        $logger = Logger::getInstance();
        $logger->info('Searching for books', [
            'bookshop' => self::NAME,
            'query' => $query,
        ]);

        // GET request to bookshop
        try {
            $response = $this->client->get(self::URL . '/hladaj', [
                'query' => [
                    'nazov' => $query,
                ],
            ]);

            ['data' => $data] = json_decode((string) $response->getBody(), true);

        } catch (\Exception$e) {
            $logger->error('Error encountered while searching for books in bookshop', [
                'bookshop' => self::NAME,
                'query' => $query,
                'error' => $e->getMessage(),
            ]);

            return []; // Return empty array if error occurs to be able to continue with other bookshops
        }

        // Drop currency string from price ex. "10€" -> 10, "11 €" -> 11 (helper function)
        $drop_currency = function ($str) {
            return (float) preg_replace('/[^0-9.]/', '', $str);
        };

        // Iterate over books from shops and create Book objects
        $books = [];
        foreach ($data as $bookData) {
            ['nazov' => $title, 'cena' => $price] = $bookData;
            $books[] = new Book($title, $drop_currency($price), self::NAME);
        }

        return $books;
    }
}
