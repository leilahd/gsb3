<div id="contenu">
<h3>Fiche de frais de <?php echo($prenom)?> <?php echo($nom)?> du mois <?php echo moisAnglaisVersFrancais($mois) ?> : </h3>

<div class="encadre"> 
    <p class="p">Etat : Validée depuis le <?php echo $dateModif?> <br></p>
        <!-- tableau des frais forfait -->
  	<table class="suivi">
            
            
            <!-- entete du tableau -->
            <tr>
        <?php
                foreach ( $lesFraisForfait as $FraisForfait ) 
                {
                    $libelle = $FraisForfait['libelle'];
        ?>	
                    <th> <?php echo $libelle?></th>
        <?php
                }
        ?>
            </tr>
        
        
            <tr>
        <?php
                foreach (  $lesFraisForfait as $FraisForfait  ) 
                {
                    $quantiteForfait = $FraisForfait['quantite'];
	?>
                    <td class="qteForfait"><?php echo $quantiteForfait?> </td>
	<?php
                }
	?>
            </tr>
        </table></br>
        <!-- tableau des frais hors forfait -->
  	<table class="listeLegere">
            <caption class="caption">Descriptif des éléments hors forfait -<?php echo $nbJustificatifs ?> justificatifs reçus -</caption>
            <tr>
                <th class="date">Date</th>
                <th class="libelle">Libellé</th>
                <th class='montant'>Montant</th>
             
            </tr>
        <?php      
            foreach ( $lesFraisHorsForfait as $FraisHorsForfait ) 
            {
                    $idFrais = $FraisHorsForfait['id'];
                    $date = $FraisHorsForfait['date'];
                    $libelle = $FraisHorsForfait['libelle'];
                    $montant = $FraisHorsForfait['montant'];
          ?>          
                    
                <!-- formulaire pour recuperer les informations sur le forfait hors frais -->
            <tr>
                <td><?php echo $date ?></td>
                <td><?php echo $libelle ?></td>
                <td><?php echo $montant ?></td>
                
            <?php
            }
	?>
        </table>
        
        
        
        
    
        <form action="index.php?uc=suiviPaiement&action=miseEnPaiement" method="POST">
            <input type="hidden" name="idVisiteur" value="<?php echo $idVisiteur ?>" />
            <input type="hidden" name="mois" value="<?php echo $mois ?>" />
            <input type="submit" value="Mise en paiement" />
        </form> 
    </div>
</div>