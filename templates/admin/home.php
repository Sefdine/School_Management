<?php ob_start(); ?>
<div class="card">
    <p>Lorem, ipsum dolor sit amet consectetur adipisicing elit. Sequi illo, officiis neque, aperiam cupiditate aliquam quam ratione doloribus corporis at voluptate fugit non quaerat eius odit, minima ipsa. Culpa, atque.</p>
</div>
<?php 
$home = ob_get_clean(); 
require_once('templates/admin/dashboard.php');
?>