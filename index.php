<?php 
    $methode = filter_input(INPUT_SERVER, "REQUEST_METHOD");
    require './session_start.php';
    require './bdd_connect.php';
    require "./recuperer_Requete.php";

    session_start_prim ();
    require "./users/verification_token.php";
    $pdo = connexion_BDD ();
    require "./miseAjour_statut_booking.php";
    MiseAJourReservation (".",$pdo);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Maison Prestige Paris</title>
    <style>
        <?php 
  
        require "./style.css";
        ?>
        .logements {
            display : flex;
           
        }
        ::-webkit-calendar-picker-indicator{
        background-color: #8F3D4C;
        padding: 5px;
        cursor: pointer;
        border-radius: 3px;
    }
                        /* Firefox */
                        input[type=number] {
                -moz-appearance: textfield;
            }
            
            /* Chrome */
            input::-webkit-inner-spin-button,
            input::-webkit-outer-spin-button { 
                -webkit-appearance: none;
                margin:0;
            }
            
            /* Opéra*/
            input::-o-inner-spin-button,
            input::-o-outer-spin-button { 
                -o-appearance: none;
                margin:0
            }
            
      

        ::-webkit-scrollbar {
            width: 10px;
        }
        ::-webkit-scrollbar-track {
            background: transparent;
        }
        ::-webkit-scrollbar-thumb {
            background-color: #ddd;
            border-radius: 10px;
        }
        ::-webkit-scrollbar-thumb:hover {
            background-color: #ccc;
        }
        select {
            border : #8F3D4C solid 2px;
        }
    </style>
    <script src="https://kit.fontawesome.com/c4254e24a8.js" crossorigin="anonymous"></script>
</head>
<body>
<div class="header">
      <nav id="navBar">
        <a href="index.php">
            <img src="./medias/images/Logo.png" class="logo">
        </a>
        <?php
if (isset($_SESSION['individu_connecte']['id'])) 
{

?>
    <a href="./users/dashboard.php" class="register-btn"> Mon Profil </a> 
    <?php
} else {
    ?>
    <a href="./users/login.php"  class="register-btn" > Se connecter </a> 
    <a href="./users/register.php"  class="register-btn" > S'inscrire </a>
    <i class="fas fa-bars" onclick="togglebtn()"></i>
    <?php  
}

?>
      </nav>
      <div class="container">
          <h1>Trouvez votre prochain séjour</h1>
          <div class="search-bar">
          <form action="./index.php" method="POST">
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
                <button type="submit"><img src="./medias/images/search.png"></button>
              </form>
          </div>
      </div>
  </div>

 
  <?php
 if ($methode==="GET")
 {
    ?>
     <div class="container">

<br>

  <div class="search-result"><?php
    $requete = $pdo->prepare(recuperer_requete (".","les logements","tous les logements enregistres")." LIMIT 18");//On ne va pas afficher tous nos logements, les filtres sont là pour trouver ce qu'on cherche
    $requete->execute();
    $resultat = $requete->fetchAll(PDO::FETCH_ASSOC);

    foreach ( $resultat as $logement) {
        $image = explode(',',$logement["Images"])[0] # On prend juste la première image comme miniature
        ?>

        <a href="./logements/view_logement.php?id=<?= $logement['id']; ?>">
      <div>
          <img src="./logements/images_logements/<?=$image?>">
      </div>
      <div class="result-infos">
              <h3><?=$logement['name'];?></h3>
              <p>PARIS (Arrondissement n°<?=$logement['position'] ;?>)</p>
              <p>A partir de <strong><?=$logement['price'];?> €</strong></p>
      </div>
       </a>
      <?php
    }
    ?>
</div>
 

<?php 
} elseif ($methode == "POST") {
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
            $getLogementFiltre = $pdo-> prepare (recuperer_requete (".","les logements","tous les logements enregistres")." LIMIT 18");
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
     echo $resultat[0];
        //On verifie si la requete à des resultats
        if (count($resultats) == 0) {
            echo "<div class='search-result'><p style='text-align:center;'><img src='./medias/images/aucune_reservation.png' alt='not found' style='width:200px; height:auto;'></p></div>";
            
        } else {
            ?>

            <br>
            
              <div class="search-result">
                <?php
                    foreach ( $resultats as $logement) {
                        $image = explode(',',$logement["Images"])[0] # On prend juste la première image comme miniature
                        ?>
                
                        <a href="./logements/view_logement.php?id=<?= $logement['id']; ?>">
                      <div>
                          <img src="./logements/images_logements/<?=$image?>">
                      </div>
                      <div class="result-infos">
                              <h3><?=$logement['name'];?></h3>
                              <p>PARIS (Arrondissement n°<?=$logement['position'] ;?>)</p>
                              <p>A partir de <strong><?=$logement['price'];?> €</strong></p>
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

<h2 class="sub-title" id="news">Exclusives</h2>
        <div class="exclusives">
            <div>
                <a href="./logements/view_logement.php?id=33"><img src="./logements/images_logements/33/1_apartment-7349942_1920.jpg"></a>
                <span>
                    <h3>La Défence</h3>
                    <p>A partir de 10000€</p>
                </span>
            </div>
            <div>
                <a href="./logements/view_logement.php?id=29"><img src="./logements/images_logements/29/1_living-room-2732939_1920.jpg"></a>
                <span>
                    <h3>Tour Eiffel</h3>
                    <p>A partir de 16800€</p>
                </span>
            </div>
            
            <div>
                <a href="./logements/view_logement.php?id=20"><img src="./logements/images_logements/20/1_interior-design-7217386_1280.jpg"></a>
                <span>
                    <h3>Champs Elysées</h3>
                    <p>A partir de 2500€</p>
                </span>
            </div>
        </div>
     
      <h2 class="sub-title">Les Bons Moments De notre Histoire</h2>
      <div class="stories">
        <div>
            <img src="./medias/images/bons_moments/1.jpg">
            
        </div>
        <div>
            <img src="./medias/images/bons_moments/2.jpg">
            
        </div>
        <div>
            <img src="./medias/images/bons_moments/3.jpg">
             
        </div>
        <div>
            <img src="./medias/images/bons_moments/4.jpg">
            
        </div>
                <div>
            <img src="./medias/images/bons_moments/5.jpg">
           
        </div>
        <div>
            <img src="./medias/images/bons_moments/6.jpg">
           
        </div>
        <div>
            <img src="./medias/images/bons_moments/7.jpg">
           
        </div>
        <div>
            <img src="./medias/images/bons_moments/8.jpg">
           
        </div>
        <div>
            <img src="./medias/images/bons_moments/10.jpg">
           
        </div>
    </div>
      <a href="./index.php" class="start-btn">Trouver un Logement</a>

      <div class="about-msg" id="A-propos">
          <h2>A PROPOS DE MAISON PRESTIGE PARIS</h2>
          <p style="text-align:left;">Maison Prestige Paris est une entreprise spécialisée dans la location de logements haut de gamme à Paris. Elle a été fondée il y a plus de 20 ans par un groupe d'amis passionnés par l'immobilier et la ville de Paris. Leur objectif était de proposer des logements de qualité supérieure à des clients exigeants qui cherchaient à vivre une expérience unique dans la ville des lumières.

Au fil des ans, Maison Prestige Paris a bâti une solide réputation en proposant des logements exceptionnels, allant des appartements de luxe aux maisons de ville somptueuses. Chaque propriété est soigneusement sélectionnée pour répondre aux normes les plus élevées de qualité et de confort. Les clients peuvent s'attendre à trouver des logements spacieux, élégants et équipés de tout le confort moderne.
La société est fière de son équipe de professionnels dévoués qui sont à l'écoute des besoins de chaque client. Ils travaillent en étroite collaboration avec les propriétaires pour s'assurer que chaque logement est entretenu avec soin et qu'il répond aux normes les plus élevées de qualité. Les clients peuvent être sûrs que leur séjour sera confortable et sans soucis, grâce à l'efficacité et au professionnalisme de l'équipe de Maison Prestige Paris.</p>
<br>
<p style="text-align:left;">Maison Prestige Paris est fière de proposer des logements dans certains des quartiers les plus prestigieux de Paris, tels que le Marais, Saint-Germain-des-Prés, les Champs-Élysées et Montmartre. Chaque quartier a son propre charme et ses propres caractéristiques, et les clients peuvent choisir le quartier qui correspond le mieux à leurs goûts et à leurs besoins.</p>

      </div>



  </div>
  <div class="footer">
          <a href="https://facebook.com/"><i class="fab fa-facebook-f"></i></a>
          <a href="https://youtube.com/"><i class="fab fa-youtube"></i></a>
          <a href="https://twitter.com/"><i class="fab fa-twitter"></i></a>
          <a href="https://linkedin.com/"><i class="fab fa-linkedin-in"></i></a>
          <a href="https://instagram.com/"><i class="fab fa-instagram"></i></a>
          <hr>
      </div>
<script>
    var navBar = document.getElementById("navBar");
    function togglebtn(){
        navBar.classList.toggle("hidemenu");
    }
</script>
    
</body>
</html>