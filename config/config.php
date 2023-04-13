<?php

//Base root

use Ipem\Src\Model\User;

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

if (isset($_POST['nav_top'])) {
    $_SESSION['nav_top'] = $_POST['nav_top'];
}
if (isset($_POST['nav_left'])) {
    $_SESSION['nav_left'] = $_POST['nav_left'];
}

if (isset($_POST['current_page'])) {
    $_SESSION['average_page'] = $_POST['current_page'];
}
