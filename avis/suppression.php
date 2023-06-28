<?php
   $methode = filter_input(INPUT_SERVER, "REQUEST_METHOD");
   require '../session_start.php';
   require '../bdd_connect.php';
   require "../recuperer_Requete.php";
   session_start_prim ();
   require "../users/verification_token.php";
         if (isset($_SESSION['individu_connecte']['id'])) {
            if ($methode==="GET") {

                $id_avis = filter_input(INPUT_GET,'id');

                $id_logement = filter_input(INPUT_GET,'id_logement');
              
                $pdo = connexion_BDD();

                $requete = $pdo->prepare(recuperer_requete ("..","Avis","Est-t-il autorisé à supprimer cet avis sur ce logement?"));

                            $requete->execute([
                                ":housing_id" =>$id_logement,
                                ":id_avis" => $id_avis
                            ]);

                            $resultat = $requete->fetchAll(PDO::FETCH_ASSOC);

                if (($_SESSION['individu_connecte']['role']== "management") || $_SESSION['individu_connecte']['role']== "sudo" || ($_SESSION['individu_connecte']['id'] == $resultat[0]["client_id"]))
                
                {
      
                    $requete_0 = $pdo->prepare(recuperer_requete ("..","Avis","Supprimer l'avis"));
                                $requete_0->execute([
                                    ":id" => $id_avis
                                ]);
    
                                return header("location:../logements/view_logement.php?id=$id_logement");
                }

            }
        } else {
            reconnexion_ou_non ("../users/login.php","../logements/view_logement.php?id=$id_logement");
           }