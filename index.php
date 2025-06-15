<?php 
include('config.php');
include('weather-api.php');

// Get initial weather data
$defaultCity = "Colombo";
$weatherData = getWeatherData($defaultCity);
$current = $weatherData['current'] ?? null;
$location = $weatherData['location'] ?? null;

// Format current date
$currentDate = date('d - m - Y');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Meta Tags -->
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="<?= WEBSITE_DESCRIPTION ?>">
    <meta name="keywords" content="<?= WEBSITE_KEYWORDS ?>">
    <meta name="author" content="Pixzarloop">
    <meta name="robots" content="index, follow">

    <!-- Page Title -->
    <title><?= WEBSITE_NAME ?></title>
    <!-- Favicon -->
    <link rel="icon" href="assets/images/favicon.ico" type="image/x-icon">
    <!-- Canonical URL -->
    <link rel="canonical" href="">
    <!-- Fontawesome -->
    <link rel="stylesheet" href="node_modules/@fortawesome/fontawesome-free/css/all.min.css">
    <!-- Bootstrap -->
    <link rel="stylesheet" href="node_modules/bootstrap/dist/css/bootstrap.min.css">
    <!-- Stylesheets -->
    <link rel="stylesheet" href="assets/css/main.css">
</head>
<body>

<!-- Preloader starts -->
<?php include 'parts/preloader.php'; ?>
<!-- Preloader ends -->

<!-- Header starts -->
<?php include('parts/header.php'); ?>
<!-- Header ends -->

<!-- Toast container -->
<div class="toast-container position-fixed top-0 end-0 p-3">
    <div id="weatherToast" class="toast align-items-center text-white border-0" role="alert" aria-live="assertive" aria-atomic="true">
        <div class="d-flex">
            <div class="toast-body">
                <i class="fa-solid fa-circle-exclamation me-2"></i>
                <span id="toastMessage"></span>
            </div>
            <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
        </div>
    </div>
</div>

<section id="homeHero">
    <img src="assets/images/bg-img.jpeg" alt="Background Image" class="d-none d-lg-block">
    <img src="assets/images/bg-img-small.jpg" alt="Background Image" class="d-md-block d-lg-none">
    <div class="homehero-content container">
        <div class="row">
            <div class="col-md-6 d-none d-md-flex">
            </div>
            <div class="col-12 col-md-6">
                <div class="card">
                    <div class="card-body">                        
                        <form class="d-flex position-relative search-form" role="search" onsubmit="return false;">
                            <input id="citySearch" class="form-control p-2" type="search" placeholder="Search for a city..." aria-label="Search">
                            <button type="button" class="btn btn-link position-absolute end-0 top-50 translate-middle-y border-0 text-dark pe-2">
                                <i class="fa-solid fa-magnifying-glass"></i>
                            </button>
                            <div id="searchSpinner" class="position-absolute end-0 top-50 translate-middle-y pe-2 d-none">
                                <div class="spinner-border spinner-border-sm text-primary" role="status">
                                    <span class="visually-hidden">Loading...</span>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="row my-3">
            <div class="col">
                <div class="mt-3 overview">
                    <h1>Today's Overview at <span id="currentTime"></span></h1>
                </div>
            </div>
        </div>
        <div class="row g-4">
            <div class="col-12 col-md-4 col-xl-3">
                <div class="card main-weather-card">
                    <div class="card-body">                        
                        <div class="d-block d-lg-none">
                            <img src="<?= $current ? 'https:' . $current['condition']['icon'] : ''; ?>" alt="Weather Icon" class="weather-icon-small">
                        </div>                  
                        <div class="d-none d-lg-block">
                            <img src="<?=  $current ? 'https:' . $current['condition']['icon'] : ''; ?>" alt="Weather Icon" class="weather-icon-large">
                        </div>   
                        <div>
                            <h2><?= $current ? "{$current['temp_c']}° C" : "--° C"; ?></h2>
                            <h3><?= $current ? $current['condition']['text'] : "--"; ?></h3>
                        </div>
                        <hr>
                        <div class="mb-3 mb-lg-0 weather-detail">
                            <i class="fa-solid fa-location-dot fa-lg"></i> <p><?=  $location ? $location['name'] : $defaultCity; ?></p> <br>
                        </div>                 
                        <div class="weather-detail">
                            <i class="fa-solid fa-calendar-days fa-lg"></i> <p><?= $currentDate; ?></p>                      
                        </div>  
                    </div>
                </div>
            </div>            
            <?php                
                $weatherDetails = [
                    [
                        'icon' => 'fa-wind',
                        'title' => 'Wind Speed',
                        'value' => $current ? "{$current['wind_kph']} km/h" : "--"
                    ],
                    [
                        'icon' => 'fa-temperature-three-quarters',
                        'title' => 'Temperature',
                        'value' => $current ? "{$current['temp_c']}°C" : "--"
                    ],
                    [
                        'icon' => 'fa-droplet',
                        'title' => 'Humidity',
                        'value' => $current ? "{$current['humidity']}%" : "--"
                    ],
                    [
                        'icon' => 'fa-sun',
                        'title' => 'UV Index',
                        'value' => $current ? $current['uv'] : "--"
                    ],
                    [
                        'icon' => 'fa-temperature-high',
                        'title' => 'Heat Index',
                        'value' => $current ? "{$current['feelslike_c']}°C" : "--"
                    ],
                    [
                        'icon' => 'fa-person-shelter',
                        'title' => 'Feels Like',
                        'value' => $current ? "{$current['feelslike_c']}°C" : "--"
                    ]
                ];

                // Split the array into chunks of 3 for two columns
                $chunks = array_chunk($weatherDetails, 3);
                foreach ($chunks as $chunk):
            ?>
            <div class="col-12 col-md-4 col-xl-2">
                <?php foreach ($chunk as $detail): ?>
                <div class="card wind-detail-card">
                    <div class="card-body">
                        <div class="wind-details">
                            <i class="fa-solid <?= $detail['icon']; ?>"></i> <?= $detail['title']; ?>
                        </div>
                        <h3><?= $detail['value']; ?></h3>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
            <?php endforeach; ?>            
            <div class="col-12 col-md-6 col-xl-5">
                <div class="card location-details-card">
                    <div class="card-body">
                        <div class="location-info">                            
                            <div class="info-item">
                                <div>
                                    <h4><i class="fa-solid fa-earth-asia"></i> Region</h4>
                                    <p><?= $location ? "{$location['region']}, {$location['country']}" : "--"; ?></p>
                                </div>
                            </div>
                            <div class="info-item">
                                <div>
                                    <h4><i class="fa-solid fa-location-crosshairs"></i> Coordinates</h4>
                                    <p><?= $location ? "Latitude: {$location['lat']}, Longitude	: {$location['lon']}" : "--"; ?></p>
                                </div>
                            </div>
                            <div class="info-item">
                                <div>
                                    <h4><i class="fa-solid fa-clock"></i> Time Zone</h4>
                                    <p><?= $location ? $location['tz_id'] : "--"; ?></p>
                                </div>
                            </div>
                            <div class="info-item">
                                <div>
                                    <h4><i class="fa-solid fa-calendar-clock"></i> Local Time</h4>
                                    <p><?= $location ? $location['localtime'] : "--"; ?></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Hourly Forecast Table -->
        <div class="row mt-4">
            <div class="col-12">
                <div class="card forecast-card hourly-forecast-card">
                    <div class="card-body">
                        <h3 class="text-white mb-4"><i class="fa-solid fa-clock"></i> Weather Forecast for next 3 hours..</h3>
                        <div class="table-responsive">
                            <table class="table table-dark table-hover forecast-table hourly-forecast-table">
                                <thead>
                                    <tr>
                                        <th>Time</th>
                                        <th>Temperature</th>
                                        <th>Rain Chance</th>
                                        <th>Humidity</th>
                                    </tr>
                                </thead>
                                <tbody id="hourlyForecastTableBody">
                                    <!-- Hourly forecast data will be populated here by JavaScript -->
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Daily Forecast Table -->
        <div class="row mt-4">
            <div class="col-12">
                <div class="card forecast-card">
                    <div class="card-body">
                        <h3 class="text-white mb-4"><i class="fa-solid fa-calendar-days"></i> Weather Forecast for next 5 days..</h3>
                        <div class="table-responsive">
                            <table class="table table-dark table-hover forecast-table">
                                <thead>
                                    <tr>
                                        <th>Date</th>
                                        <th>Max Temp</th>
                                        <th>Min Temp</th>
                                        <th>Rain Chance</th>
                                        <th>Humidity</th>
                                        <th>Wind</th>
                                    </tr>
                                </thead>
                                <tbody id="forecastTableBody">
                                    <!-- Daily forecast data will be populated here by JavaScript -->
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Footer starts -->
<?php include('parts/footer.php'); ?>
<!-- Footer ends -->

<!-- Bootstrap -->
<script src="node_modules/bootstrap/dist/js/bootstrap.min.js"></script>
<script>
    const defaultCity = "<?= DEFAULT_CITY; ?>";
</script>

<!-- Custom JS -->
<script src="assets/js/script.js"></script>
</body>
</html>