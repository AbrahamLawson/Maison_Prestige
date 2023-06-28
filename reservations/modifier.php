<?php
    $methode = filter_input(INPUT_SERVER, "REQUEST_METHOD");
    require '../session_start.php';
    require '../bdd_connect.php';
    require "../recuperer_Requete.php";
    require "../petite_alert.php";
    session_start_prim ();
   require "../users/verification_token.php";

   function estCeValide($date, $format = 'Y-m-d'){ # Pour valider la date envoyée
    $dt = DateTime::createFromFormat($format, $date);
    return $dt && $dt->format($format) === $date;
  }
   if($methode === "POST") {
    $id_booking = filter_input(INPUT_POST,'id_reservation');
    $pdo = connexion_BDD();
    $requete_1 = $pdo->prepare(recuperer_requete ("..","Réservation","Obtenir les données d'une réservation"));
    $requete_1->execute([
        ":id" => $id_booking
    ]);
    $resultat =  $requete_1 ->fetchAll(PDO::FETCH_ASSOC);
    if (isset($_SESSION['individu_connecte']['id']) ) {
        if ( $_SESSION['individu_connecte']['id']==$resultat[0]['client_id'] || $_SESSION['individu_connecte']['role']== "management" || $_SESSION['individu_connecte']['role']== "sudo") {
            
            $date_de_debut = filter_input(INPUT_POST,'start_date');
            $date_de_fin = filter_input(INPUT_POST,'end_date');            
            $date_aujourdhui_init = new DateTime('Now');
            $date_aujourdhui =  $date_aujourdhui_init->format('Y-m-d') ;
            if (!estCeValide($date_de_debut) || !estCeValide($date_de_fin) || $date_de_fin <= $date_de_debut || $date_de_debut < $date_aujourdhui) {
                return alert("..","red","Champs Mal Remplis", "Les données issus de vos champs sont fausses", "./view.php?id=$id_booking");
            } else {
                $requete_0 = $pdo->prepare(recuperer_requete ("..","Réservation","Est-ce que le logement est disponible pour une modification d'abord ?"));
                $requete_0->execute([
                    ":fin" => $date_de_fin ,
                    ":debut" => $date_de_debut,
                    ":id" => $id_booking
                ]);
                $resultat_0 = $requete_1 ->fetchAll(PDO::FETCH_ASSOC);
                if (count($resultat_0) == 0 ) {
                $requete_2 = $pdo->prepare(recuperer_requete ("..","Réservation","Modification de réservation"));
                $requete_2->execute([
                    ":id" => $id_booking,
                    ":start_date" => $date_de_debut,
                    ":end_date" => $date_de_fin ,
                ]);
        
                return alert("..","green","Modification Validée:", "1 seconde! Nous informons nos équipes.", "./view.php?id=$id_booking");
            } else {
                alert("..","yellowgreen","Indisponibilité du Logement:", "Le logement n'est pas disponible pour le séjour voulu\nVeuillez sélectionner d'autres dates", "./view.php?id=$id_booking");
            }
            }

        } else {
            
        }

} else {
    alert("..","yellowgreen","Oups TOKEN expiré:", "Votre action n'a pas été prise en compte. Redirection dans 1 seconde.", "./view.php?id=$id_booking");
}
}