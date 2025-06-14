<?php
// weather-api.php

function getWeatherData($city = "Colombo") {
    $apiKey = "fec640d3091341e4807175233251206";
    $apiUrl = "https://api.weatherapi.com/v1/current.json?key=$apiKey&q=" . urlencode($city);
    
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
                return ['error' => true, 'message' => 'City not found. Please try another location.'];
            }
        }
        
        // Check for valid response
        if ($response === FALSE) {
            return ['error' => true, 'message' => 'Unable to fetch weather data.'];
        }
        
        $data = json_decode($response, true);
        if (json_last_error() !== JSON_ERROR_NONE) {
            return ['error' => true, 'message' => 'Invalid response from weather service.'];
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
