<?php
   $methode = filter_input(INPUT_SERVER, "REQUEST_METHOD");
   require '../session_start.php';
   require '../bdd_connect.php';
   require "../recuperer_Requete.php";
   session_start_prim ();
   if ($methode==="GET") {
    $id= filter_input(INPUT_GET,'id');
    $titre = filter_input(INPUT_GET,'titre');
    require "../users/verification_token.php";
    if (isset($_SESSION['individu_connecte']['role']) && ($_SESSION['individu_connecte']['role'] == "management" || $_SESSION['individu_connecte']['role']== "sudo") ) {


    $pdo = connexion_BDD ();
    $requete_1 = $pdo->prepare(recuperer_requete ("..","supression logement","suppression des infos de logement dans housing_benefits"));
    $requete_1 ->execute([
        ":housing_id" => $id
    ]);
    $requete_2 = $pdo->prepare(recuperer_requete ("..","supression logement","suppression des infos de logement dans housing_pictures"));
    $requete_2 ->execute([
        ":housing_id" => $id
    ]);
    $requete_3 = $pdo->prepare(recuperer_requete ("..","supression logement","suppression des infos de logement dans housing_unavailabilities"));
    $requete_3 ->execute([
        ":housing_id" => $id
    ]);
    $requete_4 = $pdo->prepare(recuperer_requete ("..","supression logement","suppression des infos de logement dans housing"));
    $requete_4 ->execute([
        ":id" => $id
    ]);

    return header("location:./dashboard.php?sup_titre=$titre");
} else {
    reconnexion_ou_non ("../users/login.php","./suppression.php?titre=$titre&id=$id");
   }
   }  
?>