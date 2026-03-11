<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="theme-style-mode" content="1">
    <?php echo App::getInstance()->renderMetaTags() ?>

    <title><?php echo App()->title; ?></title>
    <!-- Favicon -->
    <link rel="shortcut icon" type="image/x-icon" href="<?= img("assets/images/favicon.png") ?>">
    <!-- CSS ============================================ -->

    <!-- google fonts -->
    <!-- <link rel="preconnect" href="https://fonts.googleapis.com/">
    <link rel="preconnect" href="https://fonts.gstatic.com/" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:ital,wght@0,200..800;1,200..800&amp;display=swap" rel="stylesheet"> -->
    <!-- google fonts end-->

    <link href="<?= assetlink("assets/css/vendor/bootstrap.min.css") ?>" rel="stylesheet">
    <link href="<?= assetlink("assets/css/plugins/animation.css") ?>" rel="stylesheet">
    <link href="<?= assetlink("assets/css/plugins/feature.css") ?>" rel="stylesheet">
    <link href="<?= assetlink("assets/css/plugins/magnify.min.css") ?>" rel="stylesheet">
    <link href="<?= assetlink("assets/css/plugins/slick.css") ?>" rel="stylesheet">
    <link href="<?= assetlink("assets/css/plugins/slick-theme.css") ?>" rel="stylesheet">
    <link href="<?= assetlink("assets/css/plugins/lightbox.css") ?>" rel="stylesheet">
    <link href="<?= assetlink("assets/css/plugins/odometer.css") ?>" rel="stylesheet">
    <link rel="stylesheet" href="<?= assetlink("assets/css/style16eb.css?v=4.3.1") ?>">
    <link rel="stylesheet" href="<?= assetlink("assets/css/mystyle.css") ?>">
</head>
<body class="active-light-mode">
    <main class="page-wrapper">
        <?php include (path("menu.php")); ?>
