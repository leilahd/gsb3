
<?php
include("vues/v_sommaireComptable2.php");
$idComptable = $_SESSION['idComptable'];
$mois = getMois(date("d/m/Y"));
$numAnnee =substr( $mois,0,4);
$numMois =substr( $mois,4,2);
$action = $_REQUEST['action'];
switch($action){
		case 'selectionnerMois':{
                    $lesMois=$pdo->getLesMoisEnAttente();
                    // Afin de sélectionner par défaut le dernier mois dans la zone de liste
                    // on demande toutes les clés, et on prend la première,
                    // les mois étant triés décroissants
                    $lesCles = array_keys( $lesMois );
                    $moisASelectionner = $lesCles[0];
                    include("vues/v_listeMoisC.php");
		break;
                }
                       
                case 'selectionnerVisiteurs':{
                    $unMois=$_REQUEST['lstMois'];
                    $moisASelectionner=$unMois;
                    $lesMois=$pdo->getLesMoisEnAttente();
                    include ("vues/v_listeMoisC.php");
                    $lesVisiteurs=$pdo->getLesVisiteurs($moisASelectionner);
                    include ("vues/v_listeVisiteur.php");
                    // Afin de sélectionner par défaut le dernier mois dans la zone de liste
                    // on demande toutes les clés, et on prend la première,
                    // les mois étant triés décroissants
		
		break;
                }
                case 'voirEtatFrais':{
                    $moisASelectionner = $_REQUEST['unMois'];
                    $visiteurASelectionner = $_REQUEST['lstVisiteur'];


                    $lesMois=$pdo->getLesMoisEnAttente();
                    include ("vues/v_listeMoisC.php");

                    $lesVisiteurs=$pdo->getLesVisiteurs($moisASelectionner);
                    include("vues/v_listeVisiteur.php");


                    $lesFraisHorsForfait = $pdo->getLesFraisHorsForfait($visiteurASelectionner,$moisASelectionner);
                    $lesFraisForfait= $pdo->getLesFraisForfait($visiteurASelectionner,$moisASelectionner);
                    $lesInfosFicheFrais = $pdo->getLesInfosFicheFrais($visiteurASelectionner,$moisASelectionner);
                    $numAnnee =substr( $moisASelectionner,0,4);
                    $numMois =substr( $moisASelectionner,4,2);
                    $libEtat = $lesInfosFicheFrais['libEtat'];
                    $montantValide = $lesInfosFicheFrais['montantValide'];
                    $nbJustificatifs = $lesInfosFicheFrais['nbJustificatifs'];
                    $dateModif =  $lesInfosFicheFrais['dateModif'];
                    $dateModif =  dateAnglaisVersFrancais($dateModif);
                    include("vues/v_etatFraisC.php");
                break;
            
                }
                case 'validerFicheFrais': { 
                    $moisASelectionner = $_REQUEST['unMois'];
                    $visiteurASelectionner = $_REQUEST['idVisiteur']; 
                    $numAnnee = substr($moisASelectionner, 0, 4); 
                    $numMois = substr($moisASelectionner, 4, 2);
                    $pdo->majEtatFicheFrais($visiteurASelectionner,$moisASelectionner,'VA'); 
                    
                    include 'vues/v_confirmationValid.php';
                break;
}

                case 'modifier' :{
                    //recuperation unMois et unVisiteur
                    $moisASelectionner = $_REQUEST['unMois'];
                    $visiteurASelectionner = $_REQUEST['idVisiteur']; 

                    //recuperation du nombre de justificatifs
                    $nbJustificatifs = $pdo->getNbJustificatifs($visiteurASelectionner,$moisASelectionner);
                    //recuperation des frais forfait
                    $lesFraisForfait = $pdo->getLesFraisForfait($visiteurASelectionner,$moisASelectionner);
                    include 'vues/v_modification.php';
                break;
                }
                
                //modifie les quantites de frais forfait et retourne sur l'affichage des fiches NOUVEAU CONTROLEUR
                case 'validerModification':{
                    
                   
                    $moisASelectionner = $_REQUEST['unMois'];
                    $visiteurASelectionner = $_REQUEST['idVisiteur']; 
                    $lesFrais = $_REQUEST['lesFrais'];

                    $lesMois=$pdo->getLesMoisEnAttente();
                    include ("vues/v_listeMoisC.php");

                    $lesVisiteurs=$pdo->getLesVisiteurs($moisASelectionner);
                    include("vues/v_listeVisiteur.php");


                    $lesFraisHorsForfait = $pdo->getLesFraisHorsForfait($visiteurASelectionner,$moisASelectionner);
                    $lesFraisForfait= $pdo->getLesFraisForfait($visiteurASelectionner,$moisASelectionner);
                    $lesInfosFicheFrais = $pdo->getLesInfosFicheFrais($visiteurASelectionner,$moisASelectionner);
                    $numAnnee =substr( $moisASelectionner,0,4);
                    $numMois =substr( $moisASelectionner,4,2);
                    $libEtat = $lesInfosFicheFrais['libEtat'];
                    $montantValide = $lesInfosFicheFrais['montantValide'];
                    $nbJustificatifs = $lesInfosFicheFrais['nbJustificatifs'];
                    $dateModif =  $lesInfosFicheFrais['dateModif'];
                    $dateModif =  dateAnglaisVersFrancais($dateModif);

                    //verification de valeur valide puis ajout
                    if(lesQteFraisValides($lesFrais)){
                        $pdo->majFraisForfait($visiteurASelectionner,$moisASelectionner,$lesFrais);
                    }
                    
                    //redirection
                    include("vues/v_etatFraisC.php");
                    
                   
                   
                break;}
                
                //reporte le frais hors forfait au mois suivant
                case 'reporter':{

                    //recuperation des variables post
                    $idFraisHorsForfait = $_REQUEST['idFraisHorsForfait'];
                    $moisASelectionner = $_REQUEST['unMois'];
                    $visiteurASelectionner = $_REQUEST['idVisiteur'];

                    $lesMois=$pdo->getLesMoisEnAttente();
                    include ("vues/v_listeMoisC.php");

                    $lesVisiteurs=$pdo->getLesVisiteurs($moisASelectionner);
                    include("vues/v_listeVisiteur.php");


                    $lesFraisHorsForfait = $pdo->getLesFraisHorsForfait($visiteurASelectionner,$moisASelectionner);
                    $lesFraisForfait= $pdo->getLesFraisForfait($visiteurASelectionner,$moisASelectionner);
                    $lesInfosFicheFrais = $pdo->getLesInfosFicheFrais($visiteurASelectionner,$moisASelectionner);
                    $numAnnee =substr( $moisASelectionner,0,4);
                    $numMois =substr( $moisASelectionner,4,2);
                    $libEtat = $lesInfosFicheFrais['libEtat'];
                    $montantValide = $lesInfosFicheFrais['montantValide'];
                    $nbJustificatifs = $lesInfosFicheFrais['nbJustificatifs'];
                    $dateModif =  $lesInfosFicheFrais['dateModif'];
                    $dateModif =  dateAnglaisVersFrancais($dateModif);


                    //recuperation date du dernier mois saisi
                    $dernierMois = $pdo->dernierMoisSaisi($visiteurASelectionner);

                    //verification que le frais est dans le dernier mois de saisi
                    if($moisASelectionner == $dernierMois)
                    {
                        $dernierMois = incrementerMois($moisASelectionner);
                        $pdo->creeNouvellesLignesFrais($visiteurASelectionner, $dernierMois);
                        $pdo->reportDFraisHorsForfait($idFraisHorsForfait,$dernierMois);
                    }
                    else
                    {
                        $pdo->reportDFraisHorsForfait($idFraisHorsForfait,$dernierMois);
                    }

                    //redirection
                    include("vues/v_etatFraisC.php");
                break;
}

                case 'supprimer':{
                    $idFraisHorsForfait = $_REQUEST['idFraisHorsForfait'];
                    $moisASelectionner = $_REQUEST['unMois'];
                    $visiteurASelectionner = $_REQUEST['idVisiteur'];

                    $lesMois=$pdo->getLesMoisEnAttente();
                    include ("vues/v_listeMoisC.php");

                    $lesVisiteurs=$pdo->getLesVisiteurs($moisASelectionner);
                    include("vues/v_listeVisiteur.php");


                    $lesFraisHorsForfait = $pdo->getLesFraisHorsForfait($visiteurASelectionner,$moisASelectionner);
                    $lesFraisForfait= $pdo->getLesFraisForfait($visiteurASelectionner,$moisASelectionner);
                    $lesInfosFicheFrais = $pdo->getLesInfosFicheFrais($visiteurASelectionner,$moisASelectionner);
                    $numAnnee =substr( $moisASelectionner,0,4);
                    $numMois =substr( $moisASelectionner,4,2);
                    $libEtat = $lesInfosFicheFrais['libEtat'];
                    $montantValide = $lesInfosFicheFrais['montantValide'];
                    $nbJustificatifs = $lesInfosFicheFrais['nbJustificatifs'];
                    $dateModif =  $lesInfosFicheFrais['dateModif'];
                    $dateModif =  dateAnglaisVersFrancais($dateModif);
                    
                    $pdo->supprimerFraisHorsForfait($idFraisHorsForfait);
                    
                    //redirection
                    include("vues/v_etatFraisC.php");
                }
                
                
}

?>