
<nav class="navbar navbar-expand-lg navbar-light" id="nav">
  <div class="container-fluid">
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation" style="margin-left: 90%">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarCollapse">
      <div id="bloc">
        <div id="bloc1">
          <ul class="navbar-nav me-auto mb-2 mb-md-0">
            <li class="nav-item">
              <a class="nav-link active" href="<?= URL_ROOT ?>home/<?= $user->id?>" style="color: white"><strong>Home</strong></a>
            </li>
            <li class="nav-item">
              <a class="nav-link active" href="<?= URL_ROOT ?>landing/<?= $user->id ?>" style="color: white"><strong>Note</strong></a>
            </li>
          </ul>
        </div>
        <div id="bloc2">
          <div class="nav-item dropdown" id="dropdown">
            <a class="nav-link dropdown-toggle" data-bs-toggle="dropdown" href="#" role="button" aria-expanded="false"><img src="<?= URL_ROOT ?>public/images/logo_login.png" alt="Votre pseudo" title="Votre compte" width=30px height=30px></a>
            <ul class="dropdown-menu text-small shadow">
              <li>
                <a class="dropdown-item" href="<?= URL_ROOT ?>updatePassword/<?= $user->id ?>">Changer mon mot de passe</a>
              </li>
              <li>
                <hr class="dropdown-divider">
              </li>
              <li>
                <a href="index.php?action=disconnect" class="dropdown-item">Déconnexion</a>
              </li>
            </ul>
          </div>  
        </div>
      </div>
    </div>
  </div>
</nav>

