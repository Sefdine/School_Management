
<?php ob_start() ?>
<div class="container">  
    <h2 class="hello">Bonjour M. <?= $user->firstname; ?> !</h2>
    <div class="row landing">
        <div class="col-md-5">
            <h1>Quelques étapes</h1>
            <p>Choisissez attentivement les champs suivantes en tenant compte que l'année correspond à celle dont vous voulez soumettre les notes mais pas celle en cours.</p>
        </div>
        <div class="col-md-6">
            <form action="<?= URL_ROOT ?>module" method="POST" enctype="multipart/form-data">
                <label for="year" class="form-label">Année</label>
                <select class="form-select" id="year_single" name="year" required>
                    <?php foreach($years as $year): ?>
                        <option value="<?= $year ?>"><?= $year ?></option>
                    <?php endforeach ?>
                </select>
                <label for="study" class="form-label">Filière</label>
                <select class="form-select" id="study_single" name="study" required>
                    <?php foreach($studies as $study): ?>
                        <option value="<?= $study ?>"><?= $study ?></option>
                    <?php endforeach ?>
                </select>
                <label for="group" class="form-label">Groupe</label>
                <select class="form-select" id="group_single" name="group" required>
                    <?php foreach($groups as $group): ?>
                        <option value="<?= $group ?>"><?= ($group == 1) ? '1ère année' : '2ème année' ?></option>
                    <?php endforeach ?>
                </select>
                <label for="exam_type" class="form-label">Types d'examens</label>
                <select class="form-select" id="exam_type_single" name="exam_type" required>
                    <?php foreach($exams_types as $item): ?>
                        <option value="<?= $item ?>"><?= $item ?></option>
                    <?php endforeach ?>
                </select>
                <label for="exam_name" class="form-label">Examens</label>
                <select class="form-select" id="exam_single" name="exam_name" required>
                    <?php foreach($exams as $exam): ?>
                        <option value="<?= $exam ?>"><?= $exam ?></option>
                    <?php endforeach ?>
                </select>
                <br>
                <button type="submit" class="btn btn-primary">Confirmer</button>
            </form>
        </div>
    </div> 
</div>

<?php $content = ob_get_clean() ?>
<?php require_once 'templates/layout.php'; ?>

