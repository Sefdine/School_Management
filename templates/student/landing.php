
<?php ob_start() ?>
<div class="container">
    <div class="row">
        <h2>Une étape avant de consulter vos notes</h2>
        <div class="col-md-4">
            <p>Lorem ipsum dolor, sit amet consectetur adipisicing elit. Exercitationem aliquid doloremque iure, sapiente alias blanditiis nemo iste animi illo possimus minus, quaerat odit beatae atque eius molestias unde eaque nulla.</p>
        </div>
        <div class="col-md-8">
            <form action="<?= URL_ROOT ?>rate/<?= $user->id ?>" method="post">
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
    </div>
</div>
<?php $content = ob_get_clean() ?>
<?php require_once('templates/layout.php'); ?>