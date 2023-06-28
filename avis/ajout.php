<?php
    $methode = filter_input(INPUT_SERVER, "REQUEST_METHOD");
    require '../session_start.php';
    require '../bdd_connect.php';
    require "../recuperer_Requete.php";
    session_start_prim ();
    require "../users/verification_token.php";
          if (isset($_SESSION['individu_connecte']['id'])) {
             if ($methode==="POST") {
                 $avis = filter_input(INPUT_POST,'avis');
                 $id_logement = filter_input(INPUT_POST,'id_logement');

                 $pdo = connexion_BDD();
                 $requete = $pdo->prepare(recuperer_requete ("..","Avis","Est-t-il autorisé à ajouter un avis sur ce logement?"));
                             $requete->execute([
                                 ":housing_id" =>$id_logement,
                                 ":client_id" => $_SESSION['individu_connecte']['id']
                             ]);

                             $resultat = $requete->fetchAll(PDO::FETCH_ASSOC);

                 if ((strlen( $avis) > 3) && (count($resultat) >= 1 || $_SESSION['individu_connecte']['role']== "sudo")) {
                 $pdo = connexion_BDD();
                 $requete_0 = $pdo->prepare(recuperer_requete ("..","Avis","Ajouter d'avis"));
                             $requete_0->execute([
                                 ":content" => $avis ,
                                 ":housing_id" => $id_logement,
                                 ":client_id" => $_SESSION['individu_connecte']['id']
                             ]);
 
                             return header("location:../logements/view_logement.php?id=$id_logement");
             } 
            }
        } else {
             reconnexion_ou_non ("../users/login.php","../logements/view_logement.php?id=$id_logement");
            }