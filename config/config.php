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

$nav_left = $_POST['nav_left'] ?? false;

if ($nav_left) {
    $_SESSION['nav_left'] = $nav_left;
}

if (isset($_POST['year'])) {
    $_SESSION['data_average']['year'] = $_POST['year'];
}
if (isset($_POST['study'])) {
    $_SESSION['data_average']['study'] = $_POST['study'];
}
if (isset($_POST['group'])) {
    $_SESSION['data_average']['group'] = $_POST['group'];
}
if (isset($_POST['level'])) {
    $_SESSION['data_average']['level'] = $_POST['level'];
}
if (isset($_POST['current_page'])) {
    $_SESSION['average_page'] = $_POST['current_page'];
}
if (isset($_POST['current_module'])) {
    $_SESSION['current_module'] = $_POST['current_module'];
}
