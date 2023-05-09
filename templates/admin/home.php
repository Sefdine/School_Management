<?php ob_start(); ?>
<div class="card">
</div>
<?php 
$home = ob_get_clean(); 
require_once('templates/admin/dashboard.php');
?>