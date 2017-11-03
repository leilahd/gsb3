    <!-- Division pour le sommaire -->
<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
    </head>
    <body>﻿
        <div id="sommaire">
            <p> Bienvenue <?php echo $_SESSION['prenom']."  ".$_SESSION['nom']  ?></br>
            Vous êtes connecté en tant que Visiteur.</p>
            <ul class="som">
                 <li>
              <a href="index.php?uc=gererFrais&action=saisirFrais" title="Saisie fiche de frais ">Saisie fiche de frais</a>
                </li></br>
                <li>
              <a href="index.php?uc=etatFrais&action=selectionnerMois" title="Consultation de mes fiches de frais">Mes fiches de frais</a>
                </li></br>
                <li>
                   <a href="index.php?uc=connexion&action=deconnexion" title="Se déconnecter">Déconnexion</a>
                </li>
            </ul>
        </div>
    </body>
</html>