<?php
// weather-api.php

function getWeatherData($city = "Colombo") {
    $apiKey = "fec640d3091341e4807175233251206";
    $apiUrl = "https://api.weatherapi.com/v1/current.json?key=$apiKey&q=" . urlencode($city);
    
    // Fetch data
    $response = file_get_contents($apiUrl);
    
    // Check for valid response
    if ($response === FALSE) {
        return ['error' => 'Unable to fetch weather data.'];
    }
    
    return json_decode($response, true);
}

// If called directly via API
if (basename($_SERVER['PHP_SELF']) == basename(__FILE__)) {
    $city = isset($_GET['city']) ? $_GET['city'] : "Colombo";
    header('Content-Type: application/json');
    echo json_encode(getWeatherData($city));
}
?>
