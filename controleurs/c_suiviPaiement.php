<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
include("vues/v_sommaireComptable2.php");
$idComptable = $_SESSION['idComptable'];
$mois = getMois(date("d/m/Y"));
$numAnnee =substr( $mois,0,4);
$numMois =substr( $mois,4,2);
$action = $_REQUEST['action'];
switch($action){
    
    case'suiviPaiement':{
        //etat='RB'
        $lesFiches=$pdo->getLesFichesFrais();
        include ('vues/v_suiviPaiement.php');
    }
    
    case'suivrePaiement':{
        $mois= $_REQUEST['moisChoisi'];
        $moisChoisi=$mois;
        $idVisiteur= $_REQUEST['idVisiteurChoisi'];
        $idVisiteurChoisi=$idVisiteur;
        $lesFraisHorsForfait = $pdo->getLesFraisHorsForfait($idVisiteur,$mois);
        $lesFraisForfait= $pdo->getLesFraisForfait($idVisiteur,$mois);
        $lesInfosFicheFrais = $pdo->getLesInfosFicheFrais($idVisiteur,$mois);
        $numAnnee =substr( $mois,0,4);
        $numMois =substr( $mois,4,2);
        $libEtat = $lesInfosFicheFrais['libEtat'];
        $montantValide = $lesInfosFicheFrais['montantValide'];
        $nbJustificatifs = $lesInfosFicheFrais['nbJustificatifs'];
        $dateModif =  $lesInfosFicheFrais['dateModif'];
        $dateModif =  dateAnglaisVersFrancais($dateModif);
        include("vues/v_suivrePaiement.php");
        
    }
    
}
?>
