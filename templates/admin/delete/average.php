<?php ob_start(); ?>

<?php 
$delete_average = ob_get_clean(); 
require_once('templates/admin/dashboard.php');
?>