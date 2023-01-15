<?php

namespace App\Models;

use Dotenv\Dotenv;

$dotenv = Dotenv::createImmutable(__DIR__.'/../../');
$dotenv->load();
$dotenv->required(['BOOKSHOP_NAMES']);
