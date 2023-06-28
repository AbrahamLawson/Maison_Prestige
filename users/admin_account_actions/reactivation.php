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
        
        $requete = $pdo->prepare(recuperer_requete ("../..","Réactivation d'un compte utilisateur","On lui file une valeur 1 pour la colonne active"));
        $requete->execute([
            ":id" => $id
        ]);

        return header("location:../accounts.php?react_name=$nom");

} else {
    reconnexion_ou_non ("../login.php","./reactivation.php?id=$id");
   }
   }  