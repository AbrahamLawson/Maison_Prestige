<?php
function reconnexion_ou_non ($lien_connexion,$endpoint_courant) {
    $jeton = filter_input(INPUT_COOKIE, "token");
    if(!isset($_SESSION['individu_connecte']['id']))
    {
        if (strlen($jeton)=== 0) {
           return  header("location:$lien_connexion");
        } else {
            $pdo = connexion_BDD();
            $requete = $pdo->prepare(recuperer_requete ("..","Reconnexion d'un compte utilisateur","Vérification de son token et récupération des informations"));
            $requete->execute ([
                    ":token" => $jeton
                    ]);
                    
                    $resultats = $requete->fetchAll(PDO::FETCH_ASSOC);

            if (count($resultats) > 0) {
                $_SESSION["donnees_justes"] = true;
                $_SESSION["individu_connecte"] = [
                    "id" => $resultats[0]['user_id'],
                    "mail" => $resultats[0]['mail'],
                    "token" => $jeton,
                    "role" => $resultats[0]['role'],
                    "pseudo" => $resultats[0]['first_name'].' '.$resultats[0]['last_name']
                ]; 
               return  header("location:$endpoint_courant");

            } else {
                return header("location:$lien_connexion");
            }
        }
    } else {
        header("location:$endpoint_courant");
    }
}
?>
