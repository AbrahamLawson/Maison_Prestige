<?php
   $methode = filter_input(INPUT_SERVER, "REQUEST_METHOD");
   require '../../session_start.php';
   require '../../bdd_connect.php';
   require "../../recuperer_Requete.php";
   session_start_prim ();
   if ($methode==="GET") {
    $id= filter_input(INPUT_GET,'id');
    $nom= filter_input(INPUT_GET,'nom');
    require "../verification_token.php";
    if (isset($_SESSION['individu_connecte']['role']) && ($_SESSION['individu_connecte']['role'] == "admin" || $_SESSION['individu_connecte']['role']== "sudo")) {
        $pdo = connexion_BDD ();

        $requete1 = $pdo->prepare(recuperer_requete ("../..","Suppression d'un compte utilisateur","Suppression de ses informations dans testimonies"));
        $requete1->execute([
            ":id" => $id
        ]);

        $requete2 = $pdo->prepare(recuperer_requete ("../..","Suppression d'un compte utilisateur","Suppression de ses informations dans booking"));
        $requete2->execute([
            ":id" => $id
        ]);

        $requete3 = $pdo->prepare(recuperer_requete ("../..","Suppression d'un compte utilisateur","Suppression de ses informations dans tokens"));
        $requete3->execute([
            ":id" => $id
        ]);

        $requete4 = $pdo->prepare(recuperer_requete ("../..","Suppression d'un compte utilisateur","Suppression de ses informations dans users"));
        $requete4->execute([
            ":id" => $id
        ]);
        return header("location:../accounts.php?sup_name=$nom");
} else {
    reconnexion_ou_non ("../login.php","./suppression.php?id=$id&nom=$nom");
   }
   }  