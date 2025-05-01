<?php

require_once __DIR__ . '/vendor/autoload.php';
$config = require __DIR__ . '/app/core/config.php';

define('DB_HOST', $config['db']['host']);
define('DB_NAME', $config['db']['name']);
define('DB_USERNAME', $config['db']['username']);
define('DB_PASSWORD', $config['db']['password']);

define('CACHE_ENABLED', $config['cache']['enabled']);
define('CACHE_EXPIRE_TIME', $config['cache']['exp']);
define('CACHE_DIR', $config['cache']['dir']);
