<?php

/**
 * Application Bootstrap File
 * 
 * This file initializes the application by:
 * 1. Loading the Composer autoloader
 * 2. Loading the application configuration
 * 3. Defining global constants for database and cache settings
 * 
 * Global Constants:
 * - DB_HOST: Database server hostname
 * - DB_NAME: Database name
 * - DB_USERNAME: Database username
 * - DB_PASSWORD: Database password
 * - CACHE_ENABLED: Whether caching is enabled (1 or 0)
 * - CACHE_EXPIRE_TIME: Cache expiration time in seconds
 * - CACHE_DIR: Cache directory path
 * 
 * @package App
 */

require_once __DIR__ . '/vendor/autoload.php';
$config = require __DIR__ . '/app/core/config.php';

define('DB_HOST', $config['db']['host']);
define('DB_NAME', $config['db']['name']);
define('DB_USERNAME', $config['db']['username']);
define('DB_PASSWORD', $config['db']['password']);

define('CACHE_ENABLED', $config['cache']['enabled']);
define('CACHE_EXPIRE_TIME', $config['cache']['exp']);
define('CACHE_DIR', $config['cache']['dir']);
