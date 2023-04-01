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



if (isset($_POST['value'])) {
    $_SESSION['insert'] = [];
}
if (isset($_POST['nav_top'])) {
    $_SESSION['nav_top'] = $_POST['nav_top'];
}
if (isset($_POST['nav_left'])) {
    $_SESSION['nav_left'] = $_POST['nav_left'];
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
if (isset($_POST['exam'])) {
    $_SESSION['data_average']['exam'] = $_POST['exam'];
}
if (isset($_POST['current_page'])) {
    $_SESSION['average_page'] = $_POST['current_page'];
}
if (isset($_POST['current_module'])) {
    $_SESSION['current_module'] = $_POST['current_module'];
}
