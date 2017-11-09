<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
include("vues/v_sommaireComptable2.php");
$idComptable = $_SESSION['idComptable'];
$mois = getMois(date("d/m/Y"));
$action = $_REQUEST['action'];
switch($action){
    
    case'suiviPaiement':{
        //montre les fiche qui ont été validés: etat='VA'
        $lesFiches=$pdo->getLesFichesFrais();
        include ('vues/v_suiviPaiement.php');
    break;
    }
    
    case'suivreLePaiement':{
        foreach ($_REQUEST['id'] as $idVisiteur) {
        $id = substr($idVisiteur, 0, strpos($idVisiteur, '-'));
        $mois = substr(strstr($idVisiteur, '-'), strlen('-'));}
        $lesFraisHorsForfait = $pdo->getLesFraisHorsForfait($id,$mois);
        $lesFraisForfait= $pdo->getLesFraisForfait($id,$mois);
        $uneFiche = $pdo->getLesInfosFicheFrais($id,$mois);
        $nom = $uneFiche['nom'];
        $prenom = $uneFiche['prenom'];
        $libEtat = $uneFiche['libEtat'];
        $montantValide = $uneFiche['montantValide'];
        $nbJustificatifs = $uneFiche['nbJustificatifs'];
        $dateModif =  $uneFiche['dateModif'];
        $dateModif =  dateAnglaisVersFrancais($dateModif);
        include("vues/v_suivrePaiement.php");
    break;
    }
    
    case'miseEnPaiement':{
       
        $leVisiteur=$_REQUEST['idV'];
        $leMois=$_REQUEST['mois'];
        $pdo->majEtatFicheFraisSuivi($leVisiteur,$leMois,'RB');
        include("vues/v_rembourser.php");
    }
}
?>
