<?php ob_start(); ?>

<?php 
$delete_teacher = ob_get_clean(); 
require_once('templates/admin/dashboard.php');
?>