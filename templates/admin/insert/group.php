<?php ob_start(); ?>

<?php 
$insert_group = ob_get_clean(); 
require_once('templates/admin/dashboard.php');
?>