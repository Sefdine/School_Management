
<?php ob_start() ?>
<div class="container">
    <p>Choississez l'année et le contrôle pour consulter vos notes</p>
    <form action="index.php?action=rate&id=<?= $user->id ?>" method="post">
        <label for="year">Année</label>
        <select name="year" class="form-control" required>
            <?php foreach($years as $year): ?>
                <option value="<?= $year ?>"><?= $year ?></option>
            <?php endforeach ?>
        </select>
        <label for="control">Contrôle</label>
        <select name="control" class="form-control" required>
            <?php foreach($controls as $control): ?>
                <option value="<?= $control ?>"><?= $control ?></option>
            <?php endforeach ?>
        </select>
        <br>
        <button type="submit" class="btn btn-primary">Consulter mes notes</button>
    </form>
</div>
<?php $content = ob_get_clean() ?>
<?php require_once('templates/layout.php'); ?>