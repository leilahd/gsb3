<?php
include("vues/v_sommaireComptable.php");
$action = $_REQUEST['action'];
$idComptable = $_SESSION['idComptable'];
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
                    $_SESSION['unMois']=$_REQUEST['lstMois'];
                    $moisASelectionner=$_SESSION['unMois'];
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
                    $_SESSION['unVisiteur']=$_REQUEST['lstVisiteurs'];
                    $visiteurASelectionner=$_SESSION['unVisiteur'];
                    $moisASelectionner=$_SESSION['unMois'];


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
                    $moisASelectionner = $_SESSION['unMois'];
                    $visiteurASelectionner = $_SESSION['unVisiteur']; 
                    $numAnnee = substr($moisASelectionner, 0, 4); 
                    $numMois = substr($moisASelectionner, 4, 2);
                    $pdo->majEtatFicheFrais($visiteurASelectionner,$moisASelectionner,'VA'); 
                    
                    
                break;
}
                case 'validerLaFiche' :{
                    include 'vues/v_confirmationValid.php';

                break;
}

                case 'modifier' :{
                    //recuperation unMois et unVisiteur
                    $moisASelectionner = $_SESSION['unMois'];
                    $visiteurASelectionner = $_SESSION['unVisiteur']; 

                    //recuperation du nombre de justificatifs
                    $nbJustificatifs = $pdo->getNbJustificatifs($visiteurASelectionner,$moisASelectionner);
                    //recuperation des frais forfait
                    $lesFraisForfait = $pdo->getLesFraisForfait($visiteurASelectionner,$moisASelectionner);
                    include 'vues/v_modification.php';
                break;
                }
                
                //modifie les quantites de frais forfait et retourne sur l'affichage des fiches NOUVEAU CONTROLEUR
                case 'validerModification':{
                    
                   
                    $moisASelectionner = $_SESSION['unMois'];
                    $visiteurASelectionner = $_SESSION['unVisiteur']; 
                    
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

                    //recuperation des variables session
                    $moisASelectionner = $_REQUEST['unMois'];
                    $visiteurASelectionner = $_REQUEST['unVisiteur']; 
                    $lesFrais = $_REQUEST['lesFrais'];

                    //verification de valeur valide puis ajout
                    if(lesQteFraisValides($lesFrais)){
                        $pdo->majFraisForfait($visiteurASelectionner,$moisASelectionner,$lesFrais);
                    }
                    //liste des en-têtes de réponse du script courant
                   //var_dump(headers_list());
                    //redirection
                    include("vues/v_etatFraisC.php");
              //     header('Location:index.php?uc=validerFrais&action=voirEtatFrais');
                 //   exit();
                break;}
                
                //reporte le frais hors forfait au mois suivant
    case 'reporter':
        
        //recuperation des variables post
        $idFraisHorsForfait = $_REQUEST['idFraisHorsForfait'];
        $moisASelectionner = $_SESSION['unMois'];
        $visiteurASelectionner = $_SESSION['idVisiteur'];
        
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
        header('Location: index.php?uc=validerFrais&action=voirEtatFrais&lstVisiteur='.$visiteurASelectionner.'&mois='.$moisASelectionner);
        break;
                
}

?>