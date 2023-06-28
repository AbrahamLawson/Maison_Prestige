<?php

   $methode = filter_input(INPUT_SERVER, "REQUEST_METHOD");
   require '../session_start.php';
   require '../bdd_connect.php';
   require "../recuperer_Requete.php";
   session_start_prim ();
   require "../users/verification_token.php";
         if (isset($_SESSION['individu_connecte']['id'])) {
            if ($methode==="POST") {
                $avis_modifie = filter_input(INPUT_POST,'avis_modifie');
                $ids = filter_input(INPUT_POST,'id_avis_id_logement');
                $ids = explode(" ",$ids);
                $id_avis = $ids[0];
                $id_logement = $ids[1];

                $pdo = connexion_BDD();
                $requete_0 = $pdo->prepare(recuperer_requete ("..","Avis","Modifier l'avis"));
                            $requete_0->execute([
                                ":content" => $avis_modifie,
                                ":id" => $id_avis
                            ]);

                            return header("location:../logements/view_logement.php?id=$id_logement");
            }
        } else {
            reconnexion_ou_non ("../users/login.php","../logements/view_logement.php?id=$id_logement");
           }