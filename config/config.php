<?php

//Base root
define('URL_ROOT', '/ipem/');

define('DB_HOST', 'localhost');
define('DB_NAME', 'ipem');
define('DB_USER', 'root');
define('DB_PASS', 'root');


function issetSesionUser() {
    if (!isset($_SESSION['user'])) {
        header('Location: index.php');
    }
}