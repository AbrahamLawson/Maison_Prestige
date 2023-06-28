<?php
  
  require '../session_start.php';
  require '../bdd_connect.php';
  require "../recuperer_Requete.php";
  session_start_prim ();
  require "../users/verification_token.php";
  $pdo = connexion_BDD ();
  require "../miseAjour_statut_booking.php";
  MiseAJourReservation ("..",$pdo);
  ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <script src="https://kit.fontawesome.com/c4254e24a8.js" crossorigin="anonymous"></script>
    <title>DashBoard</title>
    <style>
<?php
require "./style/autre_style.css";
require "./style/header_style.css";
            require '../footer.css';
?>
    </style>
</head>
<body>
<?php
    if (isset($_SESSION['individu_connecte']['id'])) {
    include('header2.php');
   ?>
<div class="banner">
        <h1>MON COMPTE</h1>
</div>
<div class="conteneur">
      <div class="photo">
        <img src="../medias/images/profil2.jpg" alt="">
    </div>
<div class="dash">
  
    <a href="./modification_profile.php"><button id="but">Modifier le Profil</button></a>  


    <?php


if ($_SESSION['individu_connecte']['role']== "admin" || $_SESSION['individu_connecte']['role']== "sudo") {
    ?>   
    <a href="./accounts.php"><button id="but"> Les comptes </button></a>  
    <?php
}

    if ($_SESSION['individu_connecte']['role']== "management" || $_SESSION['individu_connecte']['role']== "sudo") {
        
        ?>
    <a href="../logements/dashboard.php"><button id="but"> Les logements </button></a>
   
    <a href="../reservations/view_All.php"><button id="but"> Les réservations </button></a>
     


    <?php
}
    if ($_SESSION['individu_connecte']['role']== "logistic" || $_SESSION['individu_connecte']['role']== "sudo") {
        ?>
 
    <a href="./logistic_account_actions/index.php"><button id="but"> Tableau de Maintenance </button></a>
        <?php
    }

?>
    <br> 

    <a href="./logout.php"><button id="butDeco">Se déconnecter</button></a>

</div>
</div>
 
<th>
<div class="les_reservations">
    <div class="reservations_passees">
        <h2>Vos réservations passées</h2>
        <?php
        $requete1 = $pdo->prepare(recuperer_requete ("..","Réservation","Afficher les réservations passés d'un client spécifique"));
        $requete1->execute([
            ":client_id" => $_SESSION['individu_connecte']['id']
        ]);
        $resultat1 = $requete1->fetchAll(PDO::FETCH_ASSOC);
        if (count($resultat1) > 0) {

            foreach ( $resultat1 as $reservation) {
            ?>
            <a href="../reservations/view.php?id=<?=$reservation["id"]?>">
                <div class="reservation">
                    <p> logement : <strong><?=$reservation["name"]?></strong></p>
                    <p>Du: <span style ="color:black; text-decoration:underline;"><?=date('d/m/Y',strtotime($reservation["start_date"]))?></span> au <span style ="color:black; text-decoration:underline;"><?=date('d/m/Y',strtotime($reservation["end_date"]))?></span></p>
                </div>
            </a>
        <?php }
        } else {
            ?>
            <div class="AucuneReservation">
             <img src="../medias/images/aucune_reservation.png" alt="Aucune Réservation">
             </div>
            <?php
        }
 ?>
    </div>
    <div class="reservations_en_cours">
    <h2>Vos réservations en cours</h2>
    <?php
        $requete2 = $pdo->prepare(recuperer_requete ("..","Réservation","Afficher les réservations en cours d'un client spécifique"));
        $requete2->execute([
            ":client_id" => $_SESSION['individu_connecte']['id']
        ]);
        $resultat2 = $requete2->fetchAll(PDO::FETCH_ASSOC);
        if (count($resultat2) > 0) {

            foreach ( $resultat2 as $reservation) {
            ?>
            <a href="../reservations/view.php?id=<?=$reservation["id"]?>">
                <div class="reservation">
                    <p> logement : <strong><?=$reservation["name"]?></strong></p>
                    <p>Du: <span style =" color:black; text-decoration:underline; "><?=date('d/m/Y',strtotime($reservation["start_date"]))?></span> au <span style ="color:black; text-decoration:underline;"><?=date('d/m/Y',strtotime($reservation["end_date"]))?></span></p>
                </div>
            </a>
        <?php }
        } else {
            ?>
            <div class="AucuneReservation">
             <img src="../medias/images/aucune_reservation.png" alt="Aucune Réservation">
             </div>
            <?php
        }
 ?>
    </div>
    <div class="reservations_futures">
    <h2>Vos réservations futures</h2>
    <?php
        $requete3 = $pdo->prepare(recuperer_requete ("..","Réservation","Afficher les réservations futures d'un client spécifique"));
        $requete3->execute([
            ":client_id" => $_SESSION['individu_connecte']['id']
        ]);
        $resultat3 = $requete3->fetchAll(PDO::FETCH_ASSOC);
        if (count($resultat3) > 0) {

            foreach ( $resultat3 as $reservation) {
            ?>
            <a href="../reservations/view.php?id=<?=$reservation["id"]?>">
                <div class="reservation">
                    <p> logement : <strong><?=$reservation["name"]?></strong></p>
                    <p>Du: <span style ="color:black; text-decoration:underline;"><?=date('d/m/Y',strtotime($reservation["start_date"]))?></span> au <span style ="color:black; text-decoration:underline;"><?=date('d/m/Y',strtotime($reservation["end_date"]))?></span></p>
                </div>
            </a>
        <?php }
        } else {
            
            ?>
            <div class="AucuneReservation">
             <img src="../medias/images/aucune_reservation.png" alt="Aucune Réservation">
             </div>
            <?php
         }

 
 ?>
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

<?php
    } else {
        reconnexion_ou_non ("./login.php","./dashboard.php");
       }

       ?>
  </body>
  </html>