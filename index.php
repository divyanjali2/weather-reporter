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
    <img src="assets/images/bg-image.jpg" alt="Background Image" class="img-fluid w-100 vh-100 object-cover d-none d-lg-block position-absolute top-0 start-0">
    <img src="assets/images/bg-img-small.jpg" alt="Background Image" class="img-fluid w-100 vh-100 object-cover d-md-block d-lg-none position-absolute top-0 start-0">
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