<?php

require_once __DIR__ . '/vendor/autoload.php';
use App\Core\Database;

$db = new Database(
    'localhost', // host
    'iran2', // database
    'root', // username
    ''  // password
);