<?php ob_start(); ?>

<?php 
$insert_student = ob_get_clean(); 
require_once('templates/admin/dashboard.php');
?>