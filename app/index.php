<?php
declare (strict_types = 1);

require_once __DIR__ . '/vendor/autoload.php';
require_once __DIR__ . '/config/env.php';

use App\Controllers\BookSearchController;
use App\Services\Logger;

/**
 * HTTP status codes
 * framework would be used in a real world application and would handle this
 * but for readability and simplicity constants are used here
 */
const HTTP_OK = 200;
const HTTP_NOT_FOUND = 404;

/**
 * Using Dotenv to load environment variables from .env file.
 * Where bookstore names are stored as a comma separated string ex. 'BOOKSHOP_NAMES="fiktivne-knihy.sk,nonrealbookshop.com"'
 */
$bookshop_names = array_map('trim', explode(',', $_ENV['BOOKSHOP_NAMES']));

$logger = Logger::getInstance();
$logger->info('Active bookshops in configuration', ['bookshop_names' => $_ENV['BOOKSHOP_NAMES']]);

// check if the request method is GET, the path is /search and the query parameter is set
// this is a very basic implementation of a router
if ($_SERVER['REQUEST_METHOD'] === 'GET' && strpos($_SERVER['REQUEST_URI'], "/search") !== false && isset($_GET['title'])) {

    $logger->info('Request received', ['request_uri' => $_SERVER['REQUEST_URI'], 'request_method' => $_SERVER['REQUEST_METHOD'], 'query' => $_GET]);
    $query = $_GET['title'];

    // route the request to the BooksSearch controller with the query parameter
    $result = BookSearchController::search($query, $bookshop_names);

    // return the result as a JSON object
    header('Content-Type: application/json');
    http_response_code(HTTP_OK);
    echo json_encode(['status' => HTTP_OK, 'result' => array_map(function ($book) {
        return $book->toArray();
    }, $result)]);
} else {
    // return a 404 error if the request method, path or query parameter is invalid
    header('Content-Type: application/json');
    http_response_code(HTTP_NOT_FOUND);
    echo json_encode(['error' => 'Invalid request', 'request' => $_GET, 'method' => $_SERVER['REQUEST_METHOD'], 'uri' => $_SERVER['REQUEST_URI'], 'status' => HTTP_NOT_FOUND]);
}
