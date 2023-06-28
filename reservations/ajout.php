
<?php
    $methode = filter_input(INPUT_SERVER, "REQUEST_METHOD");
    require '../session_start.php';
    require '../bdd_connect.php';
    require "../recuperer_Requete.php";
    require "../petite_alert.php";
    require "../mails/confirmation_de_reservation.php";
    session_start_prim ();
   require "../users/verification_token.php";
   
   function estCeValide($date, $format = 'Y-m-d'){ # Pour valider la date envoyée
    $dt = DateTime::createFromFormat($format, $date);
    return $dt && $dt->format($format) === $date;
  }

   if (isset($_SESSION['individu_connecte']['id'])) { # Genre est-ce qu'il est connecté d'abord ?
        if($methode === "POST") {
        $id_house = filter_input(INPUT_POST,'id_logement');
        $date_de_debut = filter_input(INPUT_POST,'start_date');
        $date_de_fin = filter_input(INPUT_POST,'end_date');
            $date_aujourdhui_init = new DateTime('Now');
            $date_aujourdhui =  $date_aujourdhui_init->format('Y-m-d') ;
        if (!estCeValide($date_de_debut) || !estCeValide($date_de_fin) || $date_de_fin <= $date_de_debut || $date_de_debut < $date_aujourdhui) {
            return alert("..","red","Champ Mal Rempli", "Les données issus de votre champs sont fausses", "../logements/view_logement.php?id=$id_house");
        } else {
 # Après est-ce que le logement est disponible d'abord?
 $pdo = connexion_BDD();
        
 $requete_1 = $pdo->prepare(recuperer_requete ("..","Réservation","Est-ce que le logement est disponible pour un ajout d'abord ?"));
 $requete_1->execute([
     ":fin" => $date_de_fin ,
     ":debut" => $date_de_debut
 ]);
 $resultat_1 = $requete_1 ->fetchAll(PDO::FETCH_ASSOC);
 if (count($resultat_1) == 0 ) {
     #il y a une disponibilité, on prend en compte sa réservation.
     $requete_2 = $pdo->prepare(recuperer_requete ("..","Réservation","Réservation de logement"));
     $requete_2->execute([
         ":housing_id" => $id_house,
         ":client_id" => $_SESSION['individu_connecte']['id'],
         ":start_date" => $date_de_debut,
         ":end_date" => $date_de_fin ,
         ":status" => "reserved"
     ]);
     $requete_3 = $pdo->prepare(recuperer_requete ("..","Réservation","Ouverture d'une action de maintenace"));
     $requete_3->execute([
         ":housing_id" => $id_house ,
         ":due_date" => $date_de_debut
     ]);

     $requete_4 = $pdo->prepare(recuperer_requete ("..","les logements","afficher un logement particulier"));
     $requete_4->execute([
         ":id" => $id_house 
     ]);
     $resultat_4 = $requete_4 ->fetchAll(PDO::FETCH_ASSOC);
    confirmation_de_reservation("../mails",$_SESSION['individu_connecte']['mail'],$date_de_debut,$date_de_fin,$resultat_4[0]["name"]);#Un petit mail de confirmation
    alert("..","green","Réservation Validée:", "Votre réservation sur notre site a été effectué avec succès\n1s pour la mettre sur votre profile", "../users/dashboard.php");
 } else {
    alert("..","yellowgreen","Indisponibilité du Logement:", "Le logement n'est pas disponible pour le séjour voulu\nVeuillez sélectionner d'autres dates", "../logements/view_logement.php?id=$id_house");
 }
        }
       
        }

   } else {
    return header("location:../users/login.php");
   }