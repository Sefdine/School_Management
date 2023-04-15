<?php ob_start(); ?>

<div class="aamin_update">
    <form action="#" method="post" class="form-group">
        <input type="text" name="firstname" id="firstname" class="form-control" placeholder="Entrer un nom">
        <input type="text" name="lastname" id="lastname" class="form-control" placeholder="Entrer un prénom">
        <input type="text" name="place_birth" id="place_birth" class="form-control" placeholder="Lieu de naissance">
        <input type="date" name="birthday" id="birthday" class="form-control" placeholder="Date de naissance">
    </form>
</div>

<?php 
$insert_student = ob_get_clean(); 
require_once('templates/admin/dashboard.php');
?>