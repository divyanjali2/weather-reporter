<?php

require 'vendor/autoload.php';
require 'php/functions.php';

// Load environment variables from the .env file
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

// Define website settings
define('WEBSITE_NAME', 'Website name here');
define('WEBSITE_DESCRIPTION', 'Meta description here');
define('WEBSITE_KEYWORDS', 'Meta keywords here');

// Define email Configuration
define('MAIL_MAILER', $_ENV['MAIL_MAILER']);
define('SMTP_HOST', $_ENV['SMTP_HOST']);
define('SMTP_USERNAME', $_ENV['SMTP_USERNAME']);
define('SMTP_PASSWORD', $_ENV['SMTP_PASSWORD']);
define('SMTP_PORT', $_ENV['SMTP_PORT']);
define('SMTP_FROM_EMAIL', $_ENV['SMTP_FROM_EMAIL']);
define('MAIL_ENCRYPTION', $_ENV['MAIL_ENCRYPTION']);
define('SMTP_FROM_NAME', $_ENV['SMTP_FROM_NAME']);

// Timezone
date_default_timezone_set('Asia/Colombo');

// Maximum allowed file size (in bytes)
define('MAX_FILE_SIZE', 3 * 1024 * 1024); // 3MB

// Define Google reCAPTCHA keys for form verification
define('GOOGLE_RECAPTCHA_SITE_KEY', $_ENV['GOOGLE_RECAPTCHA_SITE_KEY']);
define('GOOGLE_RECAPTCHA_SECRET_KEY', $_ENV['GOOGLE_RECAPTCHA_SECRET_KEY']);