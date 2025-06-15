<?php

require 'vendor/autoload.php';
require 'php/functions.php';

// Load environment variables from the .env file
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

$dotenv->required(['WEATHER_API_KEY', 'DEFAULT_CITY'])->notEmpty();

// Define website settings
define('WEBSITE_NAME', 'Weather Reporter');
define('WEBSITE_DESCRIPTION', 'Website Reporter provides accurate, real-time weather updates, forecasts, and climate data for your location and around the world.');
define('WEBSITE_KEYWORDS', 'weather, weather forecast, climate, temperature, humidity, weather updates, live weather, hourly forecast, daily forecast, Website Reporter');

// Define Weather API settings
define('WEATHER_API_KEY', $_ENV['WEATHER_API_KEY']);
define('DEFAULT_CITY', $_ENV['DEFAULT_CITY']);
