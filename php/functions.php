<?php

/**
 * Format date
 */
function formatDate($date, $format = 'd M Y') {
    return date($format, strtotime($date));
}

/**
 * Truncate text
 */
function truncate($text, $length = 100, $suffix = '...') {
    if (strlen($text) <= $length) {
        return $text;
    }
    return substr($text, 0, $length) . $suffix;
}

/**
 * Verify reCAPTCHA
 */
function verifyRecaptcha($recaptcha_response) {
    $recaptcha_secret = GOOGLE_RECAPTCHA_SECRET_KEY;
    $response = json_decode(file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=$recaptcha_secret&response=$recaptcha_response"), true);
    return !empty($response['success']) && $response['success'] && $response['score'] >= 0.5;
}

/**
 * Makes an HTTP request to an API
 */
function fetch(string $url, array $options = []): array
{
    // Set default options
    $method = strtoupper($options['method'] ?? 'GET');
    $headers = $options['headers'] ?? [];

    // Initialize cURL
    $ch = curl_init();

    // Configure cURL options
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $method);

    // Add custom headers if provided
    if (!empty($headers)) {
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    }

    // Execute request
    $response = curl_exec($ch);
    $statusCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);

    // Return structured response
    return [
        'status' => $statusCode,
        'data' => json_decode($response, true) ?? $response
    ];
}