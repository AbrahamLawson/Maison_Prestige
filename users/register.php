<?php
   $methode = filter_input(INPUT_SERVER, "REQUEST_METHOD");
   require '../session_start.php';
   require '../bdd_connect.php';
   require "../recuperer_Requete.php";
   require "../mails/confirmation_d_inscription.php";
   session_start_prim ();
?>

<!DOCTYPE html>
<html>
<head>
  <title>Login Page</title>
  <link rel="stylesheet" type="text/css" href="./style/Projrt.css">
</head>
<body>
<?php
    if ($methode === "GET") { ?>
    <div class="container">
        
        <div class="login-container">
            <img src="../medias/images/Logo.png" alt="Les diamants de paris Logo" class="logo">
            <h2>Sign in to Projet</h2>
            <form id="loginForm" method="post" action="./register.php">
            <?php 
                if (isset($_SESSION["donnees_justes"]) && $_SESSION["donnees_justes"] ===false) {
                    ?>
                    <pre style="background:#FAA; color:red; padding:1vh">OUPS!!!!!!!! <?= $_SESSION["Error_message"] ?></pre>
                    <?php
                }
    ?>
       
                <input type="email" id="email" name="email" placeholder="Email address" required>
                <input type="password" id="password" name="password" placeholder="Password" required>
                <input type="checkbox" onclick="visualiser_mdp()" id="shower"><label for="shower">👁️</label>
                <button type="submit">Sign In</button>
            </form>
            <div class="divider">
                <hr class="line">
                <span class="or">or</span>
                <hr class="line">
            </div>
            <button class="google-btn">Sign in with Google</button>
            <p class="register-link">Have an account? <a href="./login.php">Log in</a></p>
        </div>
    </div>
    <?php
        $_SESSION["donnees_justes"] = true;
        ?>

  <script>
    function visualiser_mdp() {
  var champ_mdp = document.querySelector("input#password");
  if (champ_mdp.type === "password") {
    champ_mdp.type = "text";
  } else {
    champ_mdp.type = "password";
  }
}
  </script>


    <?php 
    }     elseif ($methode === "POST") {

        $email = filter_input(INPUT_POST,'email');
        $password = filter_input(INPUT_POST,'password');

        if((!filter_var($email, FILTER_VALIDATE_EMAIL)) || (strlen($password) <= 5)){
            $_SESSION["donnees_justes"] = false;
            $_SESSION["Error_message"] = "Désolé, une erreur s'est produite \nMot de passe trop faible ou email incorrect.";
           return header("location:./register.php");
          } else {
            $pdo = connexion_BDD();
            $requete_0 = $pdo->prepare(recuperer_requete ("..","Inscription client","Cet utilisateur n'existe-t-il pas déjà?"));
            $requete_0->execute ([
                ":mail" => $email 
                ]);
                
                $resultat = $requete_0->fetchAll(PDO::FETCH_ASSOC);
    
            if (count($resultat) !== 0) {
                $_SESSION["donnees_justes"] = false;
                $_SESSION["Error_message"] = "Ce compte existe déjà.\nConnectez-vous pour pousuivre votre navigation.";
               return header("location:./register.php");
            } else {
                $requete = $pdo->prepare(recuperer_requete ("..","Inscription client","enregistrement des informatons dans la table users"));
                $requete ->execute ([
                    ":mail" => $email,
                    ":password" => password_hash($password,PASSWORD_DEFAULT),
                    ":first_name" => '',
                    ":last_name" => preg_replace("/@\\S+\\.\\S+$/i", "", $email) #Lui donner son petit pseudo d'email comme prénoms en entendant.
                    ]);
                    confirmation_inscription("../mails",$email);
                    ?>
                    <script> alert("inscription réussie")</script>
                    <?php
                    return header("location:./login.php");
            }

    }
}

?>
</body>
</html>