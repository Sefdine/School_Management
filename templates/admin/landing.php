
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
                <select class="form-select" name="year" required>
                    <?php foreach($years as $year): ?>
                        <option value="<?= $year ?>"><?= $year ?></option>
                    <?php endforeach ?>
                </select>
                <label for="study" class="form-label">Filière</label>
                <select class="form-select" name="study" required>
                    <?php foreach($studies as $study): ?>
                        <option value="<?= $study ?>"><?= $study ?></option>
                    <?php endforeach ?>
                </select>
                <label for="group" class="form-label">Groupe</label>
                <select class="form-select" name="group" required>
                    <?php foreach($groups as $group): ?>
                        <option value="<?= $group->slug ?>"><?= $group->name ?></option>
                    <?php endforeach ?>
                </select>
                <label for="level" class="form-label">Niveau</label>
                <select class="form-select" name="level" required>
                    <?php foreach($levels as $level): ?>
                        <option value="<?= $level ?>"><?= ($level === 1) ? '1ère année' : '2ème année'; ?></option>
                    <?php endforeach ?>
                </select>
                <label for="control" class="form-label">Contrôle</label>
                <select class="form-select" name="control" required>
                    <?php foreach($controls as $control): ?>
                        <option value="<?= $control ?>"><?= 'contrôle n°'.$control ?></option>
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

