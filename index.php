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

<!-- Section one starts -->
<section id="sectionOne" class="py-3 bg-warning">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <h2 class="text-center">Section One</h2>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <p class="text-center">Lorem, ipsum dolor sit amet consectetur adipisicing elit. Est, ex modi ut voluptatum veniam quod.</p>
            </div>
        </div>
    </div>
</section>
<!-- Section one ends -->

<!-- Section two starts -->
<section id="sectionTwo" class="py-3 bg-primary">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <h2 class="text-center">Section Two</h2>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <p class="text-center">Lorem, ipsum dolor sit amet consectetur adipisicing elit. Est, ex modi ut voluptatum veniam quod.</p>
            </div>
        </div>
    </div>
</section>
<!-- Section two ends -->

<!-- Footer starts -->
<?php include('parts/footer.php'); ?>
<!-- Footer ends -->

<!-- Bootstrap -->
<script src="node_modules/bootstrap/dist/js/bootstrap.min.js"></script>
<!-- Custom JS -->
<script src="assets/js/script.js"></script>
</body>
</html>