
<?php ob_start() ?>

<div class="container">
    <h1>Une étape de plus</h1>
    <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Veritatis illo, ea cum quo iusto iste ad consequuntur qui soluta voluptatum ratione, accusantium ex velit nemo magnam dolores quasi aliquid nesciunt.</p>
    <div class="modules">
        <div class="module_teacher">
            <?php foreach($modules as $module): ?>
                <a href="index.php?action=rate&id=<?= $user->id ?>&module=<?= urldecode($module) ?>&sessionData=<?= 1 ?>"><?= $module ?></a>
            <?php endforeach; ?>
        </div>
    </div>
</div>

<?php $content = ob_get_clean() ?>
<?php require_once('templates/layout.php'); ?>