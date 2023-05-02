<!DOCTYPE html>
<html lang="fr">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <base href="<?= URL_ROOT ?>">

    <!-- Bootstrap CSS -->
    <!-- CSS only -->
    <link rel="stylesheet" href="vendor\twbs\bootstrap\dist\css\bootstrap.min.css">
    <!-- CSS -->
    <link rel="stylesheet" href="public/css/style.css">  
    <link rel="stylesheet" href="public/css/header.css">
    <link rel="stylesheet" href="public/css/student/home.css">
    <link rel="stylesheet" href="public/css/admin/home.css">
    <link rel="stylesheet" href="public/css/admin/rate.css">
    <link rel="stylesheet" href="public/css/admin/dashboard.css">
    <link rel="stylesheet" href="public/css/admin/insert/insert.css">
    <link rel="stylesheet" href="public/css/student/display_rate.css">

    <!-- site icons -->
    <link rel="icon" href="favicon.ico" type="image/gif" /> 

    <!-- Javascript -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://kit.fontawesome.com/a0150d2ccd.js" crossorigin="anonymous"></script>
    <script src="vendor\twbs\bootstrap\dist\js\bootstrap.bundle.min.js"></script>
    <title><?= $title ?? 'IPEM' ?></title>
  </head>
  <body class="d-flex flex-column min-vh-100">
  
    <?= $content; ?>

    <?php require_once('templates/footer.php'); ?>

  </body>
</html>