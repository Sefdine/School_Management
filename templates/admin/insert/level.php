<?php ob_start(); ?>

<?php 
$insert_level = ob_get_clean(); 
require_once('templates/admin/dashboard.php');
?>