<?php
    $methode = filter_input(INPUT_SERVER, "REQUEST_METHOD");
    require '../session_start.php';
    require '../bdd_connect.php';
    require "../recuperer_Requete.php";
    require "../petite_alert.php";

    session_start_prim ();
   require "../users/verification_token.php";
   if($methode === "GET") {
    $id_booking = filter_input(INPUT_GET,'id_booking');
    $pdo = connexion_BDD();
    $requete_1 = $pdo->prepare(recuperer_requete ("..","Réservation","Obtenir les données d'une réservation"));
    $requete_1->execute([
        ":id" => $id_booking
    ]);
    $resultat =  $requete_1 ->fetchAll(PDO::FETCH_ASSOC);
    $housing_id = $resultat[0]['housing_id']; 
    if (isset($_SESSION['individu_connecte']['id'])) {
        #S'assurer ici aussi que c'est le client en question meme ou quelqu'un qui a le porvoir qui fait l'action
        if ( $_SESSION['individu_connecte']['id']==$resultat[0]['client_id'] || $_SESSION['individu_connecte']['role']== "management" || $_SESSION['individu_connecte']['role']== "sudo") {
            $requete = $pdo->prepare(recuperer_requete ("..","Réservation","Annuler une réservation"));
            $requete->execute([
                ":id" => $id_booking
            ]);
    alert("..","yellowgreen","Annulation Effectué:", "1 seconde! Nous informons nos équipes.", "./view.php?id=$id_booking");
    } else {
        alert("..","red","Annulation Rejeté:", "Vous n'êtes pas autorisé à effectuer cette action.", "./view.php?id=$id_booking");
        }
} else {
return reconnexion_ou_non ("../users/login.php","./view.php?id=$id_booking");
}
}