
<?php ob_start(); ?>

<h2 class="hello">Bonjour <?= $user->firstname; ?> !</h2>               
<div class="row">
  <div id="part1">
    <div id="note">
      <p>Suivez vos évaluations par le moyen le plus simple.</p>
      <p>Pour vous procurer un environnement moderne, IPEM met à votre disposition cette plate-forme vous permettant de consulter vos notes.</p>
      <a href="<?= URL_ROOT ?>landing"><strong>Consulter mes notes</strong></a>
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




