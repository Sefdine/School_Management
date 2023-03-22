<?php ob_start(); ?>

<?php 
$delete_group = ob_get_clean(); 
require_once('templates/admin/dashboard.php');
?>