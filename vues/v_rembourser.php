<div id='contenu'>
<h3>Fiche de frais de <?php echo($prenom)?> <?php echo($nom)?> du mois <?php echo moisAnglaisVersFrancais($mois) ?> : </h3>
    <h3>Confirmation de la mise en paiement : </h3>
    <div class="encadre">
        <p class="p">Etat : Fiche <?php echo $libEtat ?> depuis le <?php echo $dateModif?> <br></p>
        </p>
   
        <a href="index.php?uc=suiviPaiement&action=suiviPaiement">Rembourser d'autre fiches</a>
    </div>
</div>

