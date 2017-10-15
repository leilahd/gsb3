<?php
include("vues/v_sommaireComptable.php");
$action = $_REQUEST['action'];

switch($action){
                case 'selectionnerMois':{
                    $lesMois = $pdo->getLesMoisEnAttente();
                    include 'vues/v_listeMois.php';
                break;
}}