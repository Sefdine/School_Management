
<?php ob_start(); ?>

<div class="container" id="container">
  <div class="alert alert-success">
    <h2 class="p-3">Bonjour <?= $user->firstname; ?> !</h2>               
  </div>
  <div class="row">
    <div id="part1">
      <div id="note">
        <p>Vous pouvez désormais consulter vos notes<br>
        <em>Attetion</em>: Si vous rencontrez un problème technique, ou si vous avez une reclammation, Veuillez le signalé auprès de l'administarion.</p>
        <a href="index.php?action=rate&id=<?= urldecode($user->id) ?>"><strong>Mes notes</strong></a>
      </div>
      <div id="paiement">
        <p>Suivez attentivement l'état de votre paiement. <br>Adressez vous à l'administration en cas d'ambiguité.</p>
        <a href="#"><strong>Mon Paiement</strong></a>
      </div>
    </div>
    <div id="part2">
      <div id="about_us">
        <h2>IPEM ?</h2>
        <p>INSTITUT PARCOURS ET MÉTIERS par abréviation IPEM vous offre l'opportunité d'intégrer un cycle des formations professionnelles...</p>
        <button id="button_more" onclick="window.location.href = 'https://www.ipemfp.com/about';" title="Accedez au site officiel de IPEM">Savoir plus</button> 
      </div>
    </div>
  </div>
</div>

<?php $content = ob_get_clean(); ?>

<?php require('templates/layout.php') ?>




