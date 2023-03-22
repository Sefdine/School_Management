<?php ob_start(); ?>

<?php 
$update_study = ob_get_clean(); 
require_once('templates/admin/dashboard.php');
?>