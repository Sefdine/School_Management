<?php 
    $title = 'Saisi des Notes';
    require_once('header.php');
?>

<?php ob_start(); ?>
<div class="container">
    <?php
    // submit_formSaisirNote.php
    if (isset($_POST['matricule']) || isset($_POST['name']) || isset($_POST['note'])) {
        echo "<h1>Il faut écrire quelque chose voyons !</h1>";
        return;
    }

    $matricule = $_POST['matricule'];
    $name = $_POST['name'];
    $module = $_POST['module'];
    $note = $_POST['note'];
    
    ?>
    <h1>Note de l'étudiant bien enregistré !</h1>
    <div class="card">
        <div class="card-body">
            <h5 class="card-title"><?= $name; ?></h5>
            <p class="card-text"><b>Numero d'Inscription</b> : <?= $matricule; ?></p>
            <p class="card-text"><b>Note</b> : <?php echo strip_tags($note); ?></p>
        </div>
    </div>
</div>
<?php $content = ob_get_clean(); ?>
<?php 
    require('template.php'); 
    require_once('footer.php');
?>