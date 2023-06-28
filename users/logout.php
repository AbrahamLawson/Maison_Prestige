<?php
   require '../session_start.php';
   require '../bdd_connect.php';
   require "../recuperer_Requete.php";
   session_start_prim ();
   require "./verification_token.php";

    if (isset($_SESSION['individu_connecte']['id'])) {
    $pdo = connexion_BDD ();
    #suppression token
    $requete = $pdo->prepare(recuperer_requete ("..","Déconnexion","Suppression de son/de ces jeton.s dans tokens"));
    $requete->execute ([
        ":id" => $_SESSION['individu_connecte']['id']
        ]);

    # Déconnexion :
    setcookie("token");           
    session_destroy();

    return header("location:../index.php");
} else {
    reconnexion_ou_non ("./login.php","./logout.php");
   }