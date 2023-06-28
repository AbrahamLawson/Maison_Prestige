<?php
    $methode = filter_input(INPUT_SERVER, "REQUEST_METHOD");
   require '../session_start.php';
   require '../bdd_connect.php';
   require "../recuperer_Requete.php";
   session_start_prim ();
   require "../users/verification_token.php";
   $pdo = connexion_BDD ();
   ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DashBoard</title>
    <script src="https://kit.fontawesome.com/c4254e24a8.js" crossorigin="anonymous"></script>
    <style>
        <?php
            require "./style/logement.css";
            require "./style/header_style.css";
            require "./style/autre_style.css";
            require '../footer.css';
        ?>
    </style>
</head>
<body>
<?php
include('header2.php');
?>
       <div class="banner">
       <h1>LOGEMENTS <a href="./enregistrement.php"><button class="Newlogement" >Nouveau</button></a></h1>
    
     </div>
     <div class="containerr">
          <div class="search-bar">
          <form action="./dashboard.php" method="POST">
                  <div class="location-input">
                      <label>Arrondissement</label>
                      <select type="text" name="position" id="position" >
                        <option value="">-Choisissez l'arrondissement-</option>
                        <option value="1"> 1er  Arrondissement</option>
                        <option value="2"> 2eme Arrondissement</option>
                        <option value="3"> 3eme Arrondissement</option>
                        <option value="4"> 4eme Arrondissement</option>
                        <option value="5"> 5eme Arrondissement</option>
                        <option value="6"> 6eme Arrondissement</option>
                        <option value="7"> 7eme Arrondissement</option>
                        <option value="8"> 8eme Arrondissement</option>
                        <option value="9"> 9eme Arrondissement</option>
                        <option value="10">10eme Arrondissement</option>
                        <option value="11">11eme Arrondissement</option>
                        <option value="12">12eme Arrondissement</option>
                        <option value="13">13eme Arrondissement</option>
                        <option value="14">14eme Arrondissement</option>
                        <option value="15">15eme Arrondissement</option>
                        <option value="16">16eme Arrondissement</option>
                        <option value="17">17eme Arrondissement</option>
                        <option value="18">18eme Arrondissement</option>
                        <option value="19">19eme Arrondissement</option>
                        <option value="20">20eme Arrondissement</option>
                      </select>
                </div>
                <div>
                <label for='date_debut'>Entrée</label> 
                <input class='date' type='date' name='start_date' id='date_debut' > 
                </div>
                <div>
                <label for='date_fin'> Sortie</label> 
                <input class='date' type='date' name='end_date' id='date_fin' > 
                </div>
                <div>
                <label for="min_price">Prix minimum</label>
                <input type="number" name="min_price" id="min_price" step="0.01" placeholder="0€">
                </div>
                <div>
                <label for="max_price">Prix maximum</label>
                <input type="number" name="max_price" id="max_price" step="0.01" placeholder="10000€">
                </div>
                <div>
                <label for="NombreDePersonne">Capacité</label>
                <input type="number" name="NombreDePersonne" id="NombreDePersonne" placeholder="Nbr de Personnes">
                </div>
                <button type="submit"><img src="../medias/images/search.png"></button>
              </form>
          </div>
      </div>
  </div>
<?php

if (isset($_SESSION['individu_connecte']['role']) && ($_SESSION['individu_connecte']['role'] == "management") || $_SESSION['individu_connecte']['role']== "sudo") {

   if ($methode==="GET")
 {
    $sup_titre= filter_input(INPUT_GET,'sup_titre');
    $new_titre= filter_input(INPUT_GET,'new_titre');
    $update_titre = filter_input(INPUT_GET,'update_titre');
    if (strlen($sup_titre)>0) {
     ?>
     <pre style="background:black; color:white; padding:1vh"><?="Le logement << $sup_titre >> supprimé avec succes."?></pre>
     <?php
    }
 
    if (strlen($update_titre)>0) {
     ?>
     <pre style="background:black; color:white; padding:1vh"><?="Le logement << $update_titre >> modifié avec succes."?></pre>
     <?php
    }
 
    if (strlen($new_titre)>0) {
     ?>
     <pre style="background:yellowgreen; color:black; padding:1vh"><?="Un nouveau logement du nom de :<< $new_titre >> a été ajouté."?></pre>
     <?php
    }
    ?>
     <div class="container">

<br>

  <div class="search-result"><?php

    $requete = $pdo->prepare(recuperer_requete ("..","les logements","tous les logements enregistres"));
    $requete->execute();
    $resultat = $requete->fetchAll(PDO::FETCH_ASSOC);

    foreach ( $resultat as $logement) {
        $image = explode(',',$logement["Images"])[0] # On prend juste la première image comme miniature
        ?>

        <a>
      <div>
          <img src="./images_logements/<?=$image?>">
      </div>
      <div class="result-infos">
              <h3><?=$logement['name'];?></h3>
              <p>PARIS (Arrondissement n°<?=$logement['position'] ;?>)</p>
              <p style="text-align:center;margin:10px 0px;"> 
              <button id="voir" onclick="voir_logement ('./view_logement.php?id=<?= $logement['id']; ?>')">Voir</button>
              <button id="modifie" onclick="modification ('./modification.php?id=<?=$logement['id']?>')">Modifier</button>
              <button onclick="are_you_sure ('./suppression.php?id=<?=$logement['id']?>&titre=<?= $logement['name']?>')" id="sup">Supprimer</button>
              </p>
      </div>
       </a>
      <?php
    }
    ?>
</div>
 

<?php 
} elseif ($methode === "POST") {
?>
          <div class="container">
<?php
    $data = (object)[

        "min_price" => filter_input(INPUT_POST, "min_price"),
        "max_price" => filter_input(INPUT_POST, "max_price"),
        "NombreDePersonne" => filter_input(INPUT_POST, "NombreDePersonne"),
        "position" => filter_input(INPUT_POST, "position"),
        "start_date"  => filter_input(INPUT_POST, "start_date"),
        "end_date" => filter_input(INPUT_POST, "end_date")
    ];
   
    
        // on convertie les valeurs en nombres pour eviter les injections sql
        $min_price = floatval($data->min_price);
        $max_price = floatval($data->max_price);
        $NombreDePersonne = intval($data->NombreDePersonne);
        $position = $data->position;
        $start_date = $data->start_date;
        $end_date = $data->end_date;

        //On prepare et execute la requete pour afficher les logement filtrer
        $max_prix_de_la_db = 10000000000000000000; // On donne comme prix max cette valeur par défaut.
        // Min price
        $min_price_condition = "h.price >= :minprice";
        if ($min_price != 0) {
         $min_price_condition = "h.price >= :minprice";
        };
        //Max price 
        $max_price_condition = "h.price >= :maxprice"; # Supérieur car max_price retourne 0 par défaut, faut pas qu'on soit dans la merde 🤣
        if ($max_price != 0)  {
         $max_price_condition = "h.price <= :maxprice";
        };
        //Capacity
        $capacity_condition = "h.capacity >= :capacity";
        if ($NombreDePersonne != 0)  {
         $capacity_condition = "h.capacity <= :capacity";
        };

        $positionLogement_condition = "h.position <> :position";
        if ($position != "")  {
         $positionLogement_condition = "h.position = :position";
        } else {
            $position= 0;
        };

        $disponibilite_condition = " AND (bk.start_date <> :start_date OR bk.end_date <> :end_date) "; 
        if ( $start_date!="" &&  $end_date !="") {
            $disponibilite_condition = " AND ((bk.start_date < :start_date AND bk.end_date > :end_date)) ";
        } else if ($end_date !="") {
            $disponibilite_condition = " AND (bk.end_date = :end_date OR bk.start_date <> :start_date) ";
    
        } else if ($start_date!="") {
            $disponibilite_condition = " AND (bk.start_date < :end_date OR bk.end_date > :start_date) ";
        }

        $requete = "Juste pour ne pas te définir dans une condition";
        if ($min_price == 0 && $max_price == 0 && $NombreDePersonne == 0 && $position ==0 && $start_date =='' && $end_date ==''  )
        {
            $getLogementFiltre = $pdo-> prepare (recuperer_requete ("..","les logements","tous les logements enregistres"));
            $getLogementFiltre->execute ();
           
        } else {
            if ($start_date== '') {
                $start_date = "2023-06-14";
        }
            if ($end_date=='') {
                $end_date = "3023-06-14";
        }

            $requete = "SELECT h.id,h.name,h.position,h.address,h.capacity,h.price,h.discount,h.description, GROUP_CONCAT(DISTINCT hp.url) AS Images FROM housing AS h INNER JOIN `housing_pictures` AS hp  INNER JOIN booking AS bk WHERE ".$min_price_condition . " AND ". $max_price_condition." AND ". $capacity_condition. " AND " . $positionLogement_condition . $disponibilite_condition . " AND hp.housing_id= h.id GROUP BY h.id";
      
            $getLogementFiltre = $pdo-> prepare ($requete);
            
            $getLogementFiltre->execute ([
            ":minprice" => $min_price,
            ":maxprice" => $max_price,
            ":capacity" => $NombreDePersonne,
            ":position" => $position,
            ":start_date" => $start_date,
            ":end_date" => $end_date
            ]);
           
        }


        $resultats = $getLogementFiltre->fetchAll(PDO::FETCH_ASSOC);
     
        //On verifie si la requete a des resultats
        if (count($resultats) == 0) {
            echo "<div class='search-result'><p style='text-align:center;'><img src='../medias/images/aucune_reservation.png' alt='not found' style='width:200px; height:auto;'></p></div>";
            
        } else {
            ?>

            <br>
            
              <div class="search-result">
                <?php
                    foreach ( $resultats as $logement) {
                        $image = explode(',',$logement["Images"])[0] # On prend juste la première image comme miniature
                        ?>
                <a>
                    <div>
                        <img src="./images_logements/<?=$image?>">
                    </div>
                    <div class="result-infos">
                            <h3><?=$logement['name'];?></h3>
                            <p>PARIS (Arrondissement n°<?=$logement['position'] ;?>)</p>
                            <p style="text-align:center;margin:10px 0px;"> 
                            <button id="voir" onclick="voir_logement ('./view_logement.php?id=<?= $logement['id']; ?>')">Voir</button>
                            <button id="modifie" onclick="modification ('./modification.php?id=<?=$logement['id']?>')">Modifier</button>
                            <button onclick="are_you_sure('./suppression.php?id=<?=$logement['id']?>&titre=<?= $logement['name']?>')" id="sup">Supprimer</button>
                            </p>
                    </div>
                </a>
                      <?php
                    }
                        ?>
            </div>
            <?php 
        }

    }

?>
    <?php
   } else {
    reconnexion_ou_non ("../users/login.php","./dashboard.php?sup_titre=$sup_titre&new_titre=$new_titre&update_titre=$update_titre");
   }
?>
    <div class="footer">
          <a href="https://facebook.com/"><i class="fab fa-facebook-f"></i></a>
          <a href="https://youtube.com/"><i class="fab fa-youtube"></i></a>
          <a href="https://twitter.com/"><i class="fab fa-twitter"></i></a>
          <a href="https://linkedin.com/"><i class="fab fa-linkedin-in"></i></a>
          <a href="https://instagram.com/"><i class="fab fa-instagram"></i></a>
          <hr>
      </div>
 <script>
            function are_you_sure(url) {
                if (confirm("Vous êtes sûr de vouloir supprimer ce logement ?")) {
                    window.location=url
                }
            }   
             function modification (url) {
                window.location=url
            }
            function voir_logement (url) {
                window.location=url
            }
        </script>
</body>
</html>
