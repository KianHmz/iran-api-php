<?php

/**
 * Application Configuration File
 * 
 * This file contains the main configuration settings for the application.
 * You can change this file based on your own.
 * 
 * @return array Configuration array with the following structure:
 *               - db: Database configuration
 *                 - host: Database server hostname
 *                 - name: Database name
 *                 - username: Database username
 *                 - password: Database password
 *               - cache: Cache configuration
 *                 - enabled: Whether caching is enabled (1 or 0)
 *                 - exp: Cache expiration time in seconds
 *                 - dir: Cache directory path
 */
return [
    'db' => [
        'host' => 'localhost',
        'name' => 'iran',
        'username' => 'root',
        'password' => '',
    ],
    'cache' => [
        'enabled' => 1,
        'exp' => 3600, // seconds
        'dir' => __DIR__ . '/../../cache/',
    ],
];
