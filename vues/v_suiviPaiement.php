<div id="contenu">
    <h3>Fiche de frais en attente de paiement </h3>
   <form action="index.php?uc=suiviPaiement&action=suivreLePaiement" method="POST">
   
    <div>
        <table class="suivie">
            
            <tr>
                <th>  </th>
                <th>Nom</th>
                <th>Prenom</th>
                <th>Mois</th>
                <th>Nombre de justificatif(s)</th>
                <th>Montant à valider</th>
                <th>Date de modification</th>
                <th>Fiche de frais</th>
                <th></th>
                <th></th>
            </tr>
          
            <?php
                $i = 0;
                foreach ($lesFiches as $uneFiche) {
                $i += 1;
                $nom = $uneFiche['nom'];
                $prenom = $uneFiche['prenom'];
                $mois = $uneFiche['mois'];
                $nbJustificatifs =$uneFiche['nbJustificatifs'];
                $montant = $uneFiche['montantValide'];
                $dateModif =$uneFiche['dateModif'];
                $idVisiteur =$idV= $uneFiche['idVisiteur']
            ?>
            <tr>
                <!--checkbox premet d'avoir des case a cocher-->
                <td><input type="checkbox" class="checkthis" id="<?php echo($idVisiteur."-".$mois) ?>" name="id[]" value="<?php echo($idVisiteur."-".$mois) ?>" /></td> 
                <td><?php echo($nom)?></td>
                <td><?php echo($prenom)?></td>
                <td><?php echo moisAnglaisVersFrancais($mois)?></td>
                <td><?php echo($nbJustificatifs)?></td>
                <td><?php echo($montant)?></td>
                <td><?php echo dateAnglaisVersFrancais($dateModif)?></td>
                
                
                <form action="index.php?uc=suiviPaiement&action=suivreLePaiement" method="POST">
                    <input type="hidden" name="idV" value="<?php echo $idV ?>" />
                    <input type="hidden" name="mois" value="<?php echo $mois ?>" />
                    <td><a target="_blank" href="index.php?uc=suiviPaiement&action=genererPDF&i=<?php echo($idVisiteur) ?>&m=<?php echo($mois) ?>"></span></button><img src='./images/PDF_icon.jpg'></a></td>
                    <td><input type="submit" value="Suivre" /></td> 
                </form>
                
                
           

            <?php
                }
            ?>
        </table>
   
    </div>
</div>