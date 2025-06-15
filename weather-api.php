<?php
defined('WEATHER_API_KEY') || require_once 'config.php';

function getWeatherData($city = null) {
    $errorResponse = fn($msg, $log = '') => [
        'error' => true, 
        'message' => $msg,
        'logged' => $log && error_log("Weather API Error: $log")
    ];

    try {
        $response = file_get_contents(
            "https://api.weatherapi.com/v1/forecast.json?key=" . WEATHER_API_KEY . 
            "&q=" . urlencode($city ?? DEFAULT_CITY) . "&days=6",
            false,
            stream_context_create(['http' => ['ignore_errors' => true]])
        );

        // Check HTTP status
        if (isset($http_response_header[0])) {
            preg_match('{HTTP\/\S*\s(\d{3})}', $http_response_header[0], $match);
            if (($match[1] ?? '') !== "200") {
                return $errorResponse('City not found. Please try another location.', $response);
            }
        }

        // Validate response
        if ($response === FALSE) {
            return $errorResponse('Unable to fetch weather data.', 'Failed to get response');
        }

        $data = json_decode($response, true);
        if (json_last_error() !== JSON_ERROR_NONE) {
            return $errorResponse('Invalid response from weather service.', 'Invalid JSON - ' . json_last_error_msg());
        }

        if (!isset($data['forecast']['forecastday'])) {
            return $errorResponse('Invalid forecast data received.', 'Missing forecast data: ' . print_r($data, true));
        }

        return $data;
    } catch (Exception $e) {
        return $errorResponse('An error occurred while fetching weather data.');
    }
}

// Direct access handling
if (basename($_SERVER['PHP_SELF']) === basename(__FILE__)) {
    header('Content-Type: application/json');
    echo json_encode(getWeatherData($_GET['city'] ?? 'Colombo'));
}
?>
