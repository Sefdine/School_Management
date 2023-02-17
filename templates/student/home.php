
<?php ob_start(); ?>

<h2 class="hello">Bonjour <?= $user->firstname; ?> !</h2>               
<div class="row">
  <div id="part1">
    <div id="note">
      <p>Vous pouvez désormais consulter vos notes<br>
      <em>Attetion</em>: Si vous rencontrez un problème technique, ou si vous avez une reclammation, Veuillez le signalé auprès de l'administarion.</p>
      <a href="<?= URL_ROOT ?>landing/<?= $user->id ?>"><strong>Mes notes</strong></a>
    </div>
  </div>
  <div id="part2">
    <div id="about_us">
      <h2>IPEM ?</h2>
      <p>INSTITUT PARCOURS ET MÉTIERS par abréviation IPEM vous offre l'opportunité d'intégrer un cycle des formations professionnelles...</p>
      <button id="button_more" onclick="window.location.href = 'https://www.ipemfp.net/about';" title="Accedez au site officiel de IPEM">Savoir plus</button> 
    </div>
  </div>
</div>

<?php $content = ob_get_clean(); ?>

<?php require('templates/layout.php') ?>




