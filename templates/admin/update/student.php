<?php ob_start(); ?>

<?php 
$update_student = ob_get_clean(); 
require_once('templates/admin/dashboard.php');
?>