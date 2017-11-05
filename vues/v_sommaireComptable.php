    <!-- Division pour le sommaire -->
<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
    </head>
    <body>﻿
        <div id="sommaire">
            <p> Bienvenue <?php echo $_SESSION['prenom']."  ".$_SESSION['nom']  ?></br>
            Vous êtes connecté en tant que Comptable.</p>
            <ul class="som">
                <li>
                   <a href="index.php?uc=validerFrais&action=selectionnerMois" title="Consultation des fiches de frais des visiteurs">Valider les fiches de frais</a>
                </li></br>
                 <li class="smenu">
                   <a href="index.php?uc=suiviPaiement&action=suiviPaiement" title="Suivre le paiement des fiche de frais">Suivre le paiement des fiche de frais</a>
                 </li></br>
                <li>
                   <a href="index.php?uc=connexion&action=deconnexion" title="Se déconnecter">Déconnexion</a>
                </li>
            </ul>
        </div>
    </body>
</html>
        
  
    