
<?php ob_start() ?>
<div class="container">
    <div class="alert alert-success">
        <h2 class="p-3">Bonjour M. <?= $user->firstname; ?> !</h2>
    </div>
    <form action="index.php?action=module&id=<?= $user->id ?>" method="POST" enctype="multipart/form-data">
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
                <option value="<?= $group ?>"><?= $group ?></option>
            <?php endforeach ?>
        </select>
        <label for="level" class="form-label">Niveau</label>
        <select class="form-select" name="level" required>
            <?php foreach($levels as $level): ?>
                <option value="<?= $level ?>"><?= $level ?></option>
            <?php endforeach ?>
        </select>
        <label for="control" class="form-label">Contrôle</label>
        <select class="form-select" name="control" required>
            <?php foreach($controls as $control): ?>
                <option value="<?= $control ?>"><?= $control ?></option>
            <?php endforeach ?>
        </select>
        <br>
        <button type="submit" class="btn btn-primary">Confirmer</button>
    </form>
</div>
<div class="nav-item dropdown" id="dropdown" style="position: absolute;">
            <a class="nav-link dropdown-toggle" data-bs-toggle="dropdown" href="#" role="button" aria-expanded="false"><img src="public/images/logo_login.png" alt="Votre pseudo" title="Votre compte" width=30px height=30px></a>
            <ul class="dropdown-menu text-small shadow">
              <li>
                <h5 class="dropdown-item"><?php echo ($user->lastname . "\t" . $user->firstname); ?></h5>
              </li>
              <li>
                <hr class="dropdown-divider">
              </li>
              <li>
                <a href="index.php?action=disconnect" class="dropdown-item">Déconnexion</a>
              </li>
              <li>
                <a class="dropdown-item" href="index.php?action=updatePassword&id=<?= $user->id ?>">Changer mon mot de passe</a>
              </li>
            </ul>
          </div>
<?php $content = ob_get_clean() ?>
<?php require_once 'templates/layout.php'; ?>

