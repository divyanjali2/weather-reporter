<?php

require 'vendor/autoload.php';
require 'php/functions.php';

// Load environment variables from the .env file
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

$dotenv->required(['WEATHER_API_KEY', 'DEFAULT_CITY'])->notEmpty();

// Define website settings
define('WEBSITE_NAME', 'Website Reporter');
define('WEBSITE_DESCRIPTION', 'Meta description here');
define('WEBSITE_KEYWORDS', 'Meta keywords here');

// Define Weather API settings
define('WEATHER_API_KEY', $_ENV['WEATHER_API_KEY']);
define('DEFAULT_CITY', $_ENV['DEFAULT_CITY']);
