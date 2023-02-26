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
    <link rel="stylesheet" href="public/css/teacher/home.css">
    <link rel="stylesheet" href="public/css/teacher/rate.css">
    <link rel="stylesheet" href="public/css/student/display_rate.css">

    <!-- site icons -->
    <link rel="shortcut icon" href="fav.ico" type="image/x-icon">

    <title><?= $title ?? 'IPEM' ?></title>
  </head>
  <body class="d-flex flex-column min-vh-100">
  
    <?= $content; ?>

    <?php require_once('templates/footer.php'); ?>
    <!-- JavaScript Bundle with Popper -->
    <script src="vendor\twbs\bootstrap\dist\js\bootstrap.bundle.min.js"></script>
  </body>
</html>