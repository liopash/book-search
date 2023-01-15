<?php
declare (strict_types = 1);

namespace App\Models\Bookshop;

use GuzzleHttp\Client;

/**
 * Abstract class Bookshop
 * Provides a common implementaion for all bookshops
 */
abstract class Bookshop
{
    const NAME = "BOOKSHOP_NAME";
    const URL = "https://BOOKSHOP_URL";

    protected $client;

    public function getName(): string
    {
        return self::NAME;
    }

    public function getBaseUrl(): string
    {
        return self::URL;
    }

    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    /**
     * Search for books by query (title of a book) in the bookshop
     *
     * Implementation of this method is specific to each bookshop
     * it will need to consider the structure of the response
     * and specificities of the bookshop API (e.g. pagination, localization, etc.)
     *
     * @return Books[]
     */
    abstract protected function search(string $query);
}
