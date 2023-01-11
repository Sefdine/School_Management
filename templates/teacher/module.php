
<?php ob_start() ?>

<div class="container">
    
    <p>Choisissez un module pour remplir les notes</p>
    <div class="module_teacher">
        <?php foreach($modules as $module): ?>
            <a href="index.php?action=rate&id=<?= $user->id ?>&module=<?= urldecode($module) ?>&sessionData=<?= 1 ?>"><?= $module ?></a>
        <?php endforeach; ?>
    </div>
</div>

<?php $content = ob_get_clean() ?>
<?php require_once('templates/layout.php'); ?>