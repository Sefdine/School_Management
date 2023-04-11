
<?php ob_start() ?>
<div class="container">
    <div class="row">
        <h2>Une étape avant de consulter vos notes</h2>
        <div class="col-md-4">
            <p>"Pendant les études, la réussite ne dépend que de soi, dans la vie professionnelle, la réussite dépend aussi des autres."<br>
            <label style="font-size: medium">Edine-le-sage</label></p>
        </div>
        <br>
        <div class="col-md-8 landing_form">
            <form action="<?= URL_ROOT ?>rate" method="post">
                <label for="year">Année</label>
                <select name="year" class="form-control" required>
                    <?php foreach($years as $year): ?>
                        <option value="<?= $year ?>"><?= $year ?></option>
                    <?php endforeach ?>
                </select>
                <label for="type_exam">Types d'examens</label>
                <select name="type_exam" class="form-control" required>
                    <?php foreach($types_exams as $item): ?>
                        <option value="<?= $item ?>"><?= $item ?></option>
                    <?php endforeach ?>
                </select>
                <label for="exam">Examens</label>
                <select name="exam" class="form-control" required>
                    <?php foreach($exams as $exam): ?>
                        <option value="<?= $exam ?>"><?= $exam ?></option>
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