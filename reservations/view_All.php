<?php
    require '../session_start.php';
    require '../bdd_connect.php';
    require "../recuperer_Requete.php";

    session_start_prim ();
   require "../users/verification_token.php";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <script src="https://kit.fontawesome.com/c4254e24a8.js" crossorigin="anonymous"></script>
    <title>Les réservations</title>
    <style>
<?php
            require "./style/header_style.css";
            require "./style/autre_style.css";
            require '../footer.css';
?>
    </style>
</head>
<body>
    <div class="les_reservations_en_cours_ou_futures">
<?php
   include('header2.php');
   ?>
   <br>
   <div class="banner">
        <h1>LISTE DES RESERVATIONS EN COURS ET FUTURES</h1>
      </div><?php

if (isset($_SESSION['individu_connecte']['id']) && ($_SESSION['individu_connecte']['role'] == "management" || $_SESSION['individu_connecte']['role']== "sudo")) {
    $pdo = connexion_BDD ();
    require "../miseAjour_statut_booking.php";
    MiseAJourReservation ("..",$pdo);
    $requete = $pdo->prepare(recuperer_requete ("..","Réservation","Afficher toutes les réservations futures ou en cours"));
   $requete->execute();
   $resultat = $requete->fetchAll(PDO::FETCH_ASSOC);

    foreach ( $resultat as $reservation) {
        ?>
        <a href="./view.php?id=<?=$reservation["id"]?>">
        <br>
        <div class="containerr">
            <div class="reservation">
                <p> logement : <strong><?=$reservation["name"]?></strong></p>
                <p>Client: <strong><?=$reservation["first_name"]." ".$reservation["last_name"]?></strong></p>
                <p>Du: <span style ="background:#FFBD99;padding:4px; border-radius:4px; color:white;"><?=date('d/m/Y',strtotime($resultat[0]["start_date"]))?></span> au <span style ="background:#8F3D4C;padding:4px; border-radius:4px; color:white;"><?=date('d/m/Y',strtotime($resultat[0]["end_date"]))?></span></p>
                <p>Statut:
                    <?php
                    if ($reservation["status"] == "cancelled") {
                        ?>
                        <span style ="background:red;padding:4px; border-radius:4px; color:white;"><?=$reservation["status"]?></span>
                        <?php
                    } else {
                        ?>
                        <span style ="background:yellowgreen;padding:4px; border-radius:4px; color:white;"><?=$reservation["status"]?></span>
                        <?php
                    } ?>
                </p>
            </div>
            </div>
        </a>
            

    <?php }
?>

</div>

<br>
<a href="../users/dashboard.php"><button>Retour au profile</button></a>

    <div class="footer">
          <a href="https://facebook.com/"><i class="fab fa-facebook-f"></i></a>
          <a href="https://youtube.com/"><i class="fab fa-youtube"></i></a>
          <a href="https://twitter.com/"><i class="fab fa-twitter"></i></a>
          <a href="https://linkedin.com/"><i class="fab fa-linkedin-in"></i></a>
          <a href="https://instagram.com/"><i class="fab fa-instagram"></i></a>
          <hr>
      </div>
</body>
</html>
<?php
    } else {
        reconnexion_ou_non ("../users/login.php","./viewAll.php");
   }