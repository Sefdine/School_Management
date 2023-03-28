<?php

//Base root
define('URL_ROOT', '/ipem/');

define('DB_HOST', 'localhost');
define('DB_NAME', 'ipem');
define('DB_USER', 'root');
define('DB_PASS', 'root');

session_start();

function session() {
    if (isset($_SESSION['user']) && !empty($_SESSION['user'])) {
        return true;
    } else {
        return false;
    }
}

$value = $_POST['value'] ?? false;

if ($value) {
    $_SESSION['insert'] = [];
}

