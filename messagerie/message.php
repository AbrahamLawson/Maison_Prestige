<?php
   require '../bdd_connect.php';
   require "../recuperer_Requete.php";
   require '../session_start.php';
      session_start_prim ();
   require "../users/verification_token.php";

   ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Messagerie</title>
    <script src="https://kit.fontawesome.com/c4254e24a8.js" crossorigin="anonymous"></script>
    <style>
        <?php 
            require "./style/style.css";
            require "./style/header_style.css";
            require '../footer.css';
            ?>
    </style>
</head>
<body>
<?php 
if ($_SESSION['individu_connecte']['id'])
   {$pdo = connexion_BDD ();
    require("insertdata.php");
    enregistrementMessage( $_SESSION['individu_connecte']['id'], $_SESSION['reservation_id'],$pdo );
?>
    <?php
include('header2.php')
       ?>
       <br>
      <div class="banner">
       <h1>MESSAGERIE</h1>
     </div>
     <br>
                <div class="afficheMessage">
            
                </div>
                <br>
            <div class="containerr">
                <div class="formulaire">
                    <form class="donnees" action="" method="post">
                        <textarea name="contenu" id="content" cols="60" rows="4" placeholder="Editer votre message"></textarea>
                    <button class="send">Envoyer</button>
                    </form>
</div>
                </div>
                <br>
            <a href="../reservations/view.php?id=<?=$_SESSION['reservation_id']?>"><button style="color :#FFBD99;background:#8F3D4C;">Retour à la réservation</button></a>
    <script src="jquery3.7.0.js" ></script>
    <script>
        $(document).ready(function(){
    $(".send").click(function(){
        $.ajax({
            type: "post",
            url: "insertdata.php",
            data: $(".donnees").serialize(),
            success: function(retour){
            }
        });
    });
    setInterval(function() { maFonction("<?=$_SESSION['reservation_id']?>") },1000);
    function maFonction(booking_id){
        $(".afficheMessage").load("showMessage.php?booking_id="+booking_id)
    }
});
    </script>
    <?php
   } else {
    reconnexion_ou_non ("../users/login.php","./message.php");
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
</body>

</html>