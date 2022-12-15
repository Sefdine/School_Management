
<?php ob_start() ?>

<div class="container">
    <div class="alert alert-success">
        <h2 class="p-3">Bonjour M. <?= $user->firstname; ?> !</h2>
    </div>
    <p>Choisissez un module pour remplir les notes</p>
    <div class="module_teacher">
        <?php foreach($modules as $module): ?>
            <a href="index.php?action=rate&id=<?= $user->id ?>&module=<?= urldecode($module) ?>"><?= $module ?></a>
        <?php endforeach; ?>
    </div>
</div>

<?php $content = ob_get_clean() ?>
<?php require_once('templates/layout.php'); ?>