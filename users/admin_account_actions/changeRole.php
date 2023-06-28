<?php
   $methode = filter_input(INPUT_SERVER, "REQUEST_METHOD");
   require '../../session_start.php';
   require '../../bdd_connect.php';
   require "../../recuperer_Requete.php";
   session_start_prim ();
   if ($methode==="GET") {
    $id= filter_input(INPUT_GET,'id');
    $role= filter_input(INPUT_GET,'role');
    $nom= filter_input(INPUT_GET,'nom');
    require "../verification_token.php";
    if (isset($_SESSION['individu_connecte']['role']) && ($_SESSION['individu_connecte']['role'] == "admin" || $_SESSION['individu_connecte']['role']== "sudo")) {

        $pdo = connexion_BDD ();
        
        $requete = $pdo->prepare(recuperer_requete ("../..","Changer le role d'un compte utilisateur","On lui file le role souhaité"));
        $requete->execute([
            ":id" => $id,
            ":role" => "$role"
        ]);

        return header("location:../accounts.php?name=$nom&role=$role");

} else {
    reconnexion_ou_non ("../login.php","./changeRole.php?id=$id&role=$role");
   }
   }  