
<?php ob_start() ?>

<div class="container">
    <h1>Encore une étape</h1>
    <p>Veuillez choisir un module pour continuer.</p>
    <p>Seule les modules auxquels vous êtes affiliées pour la filière, le groupe et le niveau choisis seront affichées.<br> 
    En cas d'absence d'un ou de plusieurs modules dont vous êtes responsables, veuillez le rapporter à l'administration de l'école.<br>
    <em style="font-size: medium">Merci de votre compréhension.</em></p>
    <div class="modules">
        <div class="module_teacher">
            <?php foreach($modules as $module): ?>
                <a href="<?= URL_ROOT ?>rate/<?= $user->id ?>/<?= $module->slug ?><?php $_SESSION['sessionData'] = 1 ?>"><?= $module->name ?></a>
            <?php endforeach; ?>
        </div>
    </div>
</div>

<?php $content = ob_get_clean() ?>
<?php require_once('templates/layout.php'); ?>