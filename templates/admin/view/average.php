<?php ob_start(); ?>

<?php 
$update_average = ob_get_clean(); 
require_once('templates/admin/dashboard.php');
?>