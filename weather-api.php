<?php
// weather-api.php

// Include configuration file if not already included
if (!defined('WEATHER_API_KEY')) {
    require_once 'config.php';
}

function getWeatherData($city = null) {
    // Use default city from config if none provided
    $city = $city ?? DEFAULT_CITY;
    $apiUrl = "https://api.weatherapi.com/v1/forecast.json?key=" . WEATHER_API_KEY . "&q=" . urlencode($city) . "&days=6";
    
    // Use try-catch to handle any errors
    try {
        // Set error handling options
        $context = stream_context_create([
            'http' => [
                'ignore_errors' => true
            ]
        ]);
        
        // Fetch data with context
        $response = file_get_contents($apiUrl, false, $context);
        
        // Check for HTTP response headers
        if (isset($http_response_header)) {
            $status_line = $http_response_header[0];
            preg_match('{HTTP\/\S*\s(\d{3})}', $status_line, $match);
            $status = $match[1];
            
            if ($status !== "200") {
                error_log("Weather API Error: " . $response);
                return ['error' => true, 'message' => 'City not found. Please try another location.'];
            }
        }
        
        // Check for valid response
        if ($response === FALSE) {
            error_log("Weather API Error: Failed to get response");
            return ['error' => true, 'message' => 'Unable to fetch weather data.'];
        }
        
        $data = json_decode($response, true);
        if (json_last_error() !== JSON_ERROR_NONE) {
            error_log("Weather API Error: Invalid JSON - " . json_last_error_msg());
            return ['error' => true, 'message' => 'Invalid response from weather service.'];
        }
        
        // Validate forecast data
        if (!isset($data['forecast']) || !isset($data['forecast']['forecastday'])) {
            error_log("Weather API Error: Missing forecast data");
            error_log("Response: " . print_r($data, true));
            return ['error' => true, 'message' => 'Invalid forecast data received.'];
        }
        
        return $data;
        
    } catch (Exception $e) {
        return ['error' => true, 'message' => 'An error occurred while fetching weather data.'];
    }
}

// If called directly via API
if (basename($_SERVER['PHP_SELF']) == basename(__FILE__)) {
    header('Content-Type: application/json');
    $city = isset($_GET['city']) ? $_GET['city'] : "Colombo";
    echo json_encode(getWeatherData($city));
}
?>
