<div id="contenu">
    <h2>Modifier la fiche de frais</h2>
    
    <!-- formulaire pour recuperer les quantites -->
    <form method="POST"  action="index.php?uc=validerFrais&action=validerModification">
        <!--unMois et idVisiteur -->
        <input type="hidden" value="<?php echo $moisASelectionner?>" name="unMois" />
        <input type="hidden" value="<?php echo $visiteurASelectionner?>" name="idVisiteur" />
        
        <h3>Eléments forfaitisés</h3>
        <div class="modif">
                 
        <?php
                foreach ($lesFraisForfait as $Frais)
                {
                    $idFrais = $Frais['idfrais'];
                    $libelle = $Frais['libelle'];
                    $quantiteForfait = $Frais['quantite'];
	?>
                <p>
                    <label class="lab" for="idFrais"><?php echo $libelle ?></label>
                    <input type="text" id="idFrais" name="lesFrais[<?php echo $idFrais?>]" size="10" maxlength="5" value="<?php echo $quantiteForfait?>" >
		</p>
	<?php
		}
	?>
            
        </div>
          
        <div class="modif2">
            <p>
                <input id="ok" type="submit" value="Valider" size="20" />
                <input id="annuler" type="reset" value="Effacer" size="20" />
            </p> 
        </div>
        
</form>
