
<!doctype html>
<html lang="fr">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

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

    <title><?= $title ?? 'IPEM' ?></title>
  </head>
  <body class="d-flex flex-column min-vh-100">
  
    <?= $content; ?>

    <?php require_once('templates/footer.php'); ?>
    <!-- JavaScript Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
  </body>
</html>