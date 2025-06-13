<?php include('config.php');?>

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

<section id="homeHero">
    <img src="assets/images/bg-img.jpeg" alt="Background Image" class="d-none d-lg-block">
    <img src="assets/images/bg-img-small.jpg" alt="Background Image" class="d-md-block d-lg-none">
    <div class="homehero-content container">
        <div class="row">
            <div class="col-6 col-md-4 col-lg-2">
                <div class="card">
                    <div class="card-body">
                        <i class="fa-solid fa-cloud fa-xl"></i>
                        <b>Weather</b>                    
                    </div>
                </div>
            </div>
            <div class="col-md-2 col-lg-4 d-none d-md-flex">
            </div>
            <div class="col-6 col-md-6 col-lg-6">
                <div class="card">
                    <div class="card-body">
                        <form class="d-flex" role="search">
                            <input class="form-control p-0" type="search" placeholder="Search" aria-label="Search">
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="row my-3">
            <div class="col">
                <div class="mt-3 overview">
                    <h1>Today's Overview at 7.54 PM</h1>
                </div>
            </div>
        </div>
        <div class="row g-4">
            <div class="col-12 col-md-3 col-lg-3">
                <div class="card main-weather-card">
                    <div class="card-body">
                        <div class="d-block d-lg-none">
                            <i class="fa-solid fa-cloud-sun fa-xl"></i>
                        </div>                  
                        <div class="d-none d-lg-block">
                            <i class="fa-solid fa-cloud-sun fa-2xl"></i>
                        </div>                  
                        <div>
                            <h2>28.6 . C</h2>
                            <h3>Clear Sky</h3>
                        </div>
                        <hr>
                        <div class="mb-3 mb-lg-0 weather-detail">
                            <i class="fa-solid fa-location-dot fa-lg"></i> <p>Colombo</p> <br>
                        </div>                 
                        <div class="weather-detail">
                            <i class="fa-solid fa-calendar-days fa-lg"></i> <p>12 - 6 - 2025  </p>                      
                        </div>                 
                    </div>
                </div>
            </div>            
            <?php
                $weatherDetails = [
                    [
                        'icon' => 'fa-wind',
                        'title' => 'Wind Speed',
                        'value' => '28km/h'
                    ],
                    [
                        'icon' => 'fa-temperature-three-quarters',
                        'title' => 'Temperature',
                        'value' => '28°C'
                    ],
                    [
                        'icon' => 'fa-droplet',
                        'title' => 'Humidity',
                        'value' => '65%'
                    ],
                    [
                        'icon' => 'fa-sun',
                        'title' => 'UV Index',
                        'value' => '6.5'
                    ],
                    [
                        'icon' => 'fa-temperature-high',
                        'title' => 'Heat Index',
                        'value' => '30°C'
                    ],
                    [
                        'icon' => 'fa-person-shelter',
                        'title' => 'Feels Like',
                        'value' => '29°C'
                    ]
                ];

                // Split the array into chunks of 3 for two columns
                $chunks = array_chunk($weatherDetails, 3);
                foreach ($chunks as $chunk):
            ?>
            <div class="col-12 col-md-3 col-lg-2">
                <?php foreach ($chunk as $detail): ?>
                <div class="card wind-detail-card">
                    <div class="card-body">
                        <div class="wind-details">
                            <i class="fa-solid <?php echo $detail['icon']; ?>"></i> <?php echo $detail['title']; ?>
                        </div>
                        <h3><?php echo $detail['value']; ?></h3>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
            <?php endforeach; ?>
            <div class="col-12 col-md-3 col-lg-5">
                <div class="card">
                    <div class="card-body">
                        <div>
                            <h4>Monday</h4>
                            <p>6.00 : 28 . C</p>
                            <h4>Monday</h4>
                            <p>6.00 : 28 . C</p>
                            <h4>Monday</h4>
                            <p>6.00 : 28 . C</p>
                            <h4>Monday</h4>
                            <p>6.00 : 28 . C</p>
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
<!-- Custom JS -->
<script src="assets/js/script.js"></script>
</body>
</html>