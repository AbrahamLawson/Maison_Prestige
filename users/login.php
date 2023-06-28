<?php
   $methode = filter_input(INPUT_SERVER, "REQUEST_METHOD");
   require '../session_start.php';
   require '../bdd_connect.php';
   require "../recuperer_Requete.php";
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
            <h2>Log in to Projet</h2>
            <form id="loginForm" method="post" action="./login.php">
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
                <button type="submit">Log In</button>
            </form>
            <div class="divider">
                <hr class="line">
                <span class="or">or</span>
                <hr class="line">
            </div>
            <button class="google-btn">Log with Google</button>
            <p class="register-link">Don't have an account? <a href="./register.php">Sign up</a></p>
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

        $pdo = connexion_BDD();
        $requete = $pdo->prepare(recuperer_requete ("..","Connexion client","Vérification des informatons dans la table users"));

        $requete->execute ([
            ":mail" => $email 
            ]);
            
            $resultat = $requete->fetchAll(PDO::FETCH_ASSOC);

            if (count($resultat) === 0) {
                $_SESSION["donnees_justes"] = false;
                $_SESSION["Error_message"] = "Compte inexistant\nVeuillez revérifier vos infos.";
               return header("location:./login.php");
            } else {
                if (password_verify($password,$resultat[0]["password"])) {
                    if ($resultat[0]['active']===1) {

                        $enclenchementJeton = random_bytes(10);
                        $jeton =strtoupper(bin2hex($enclenchementJeton));
                        $requete = $pdo->prepare(recuperer_requete ("..","Connexion client","On lui file un token dans la table tokens"));
                        echo "ededed";
                        $requete->execute ([
                            ":token" => $jeton,
                            ":user_id" => $resultat[0]['id']
                            ]);   

                        $_SESSION["donnees_justes"] = true;

                        $_SESSION["individu_connecte"] = [
                            "id" => $resultat[0]['id'],
                            "token" => $jeton,
                            "role" => $resultat[0]['role'],
                            "mail" => $resultat[0]['mail'],
                            "pseudo" => $resultat[0]['first_name'].' '.$resultat[0]['last_name']
                        ];
                        setcookie("token", $jeton , time() + (3600 * 6));  

                        return header("location:../index.php");
                    } else {
                        $_SESSION["donnees_justes"] = false;
                        $_SESSION["Error_message"] = "Compte désactivé.\nRenvoyez un mail à l'administrateur du site.";
                       return header("location:./login.php");
                    }
                } else {

                    $_SESSION["donnees_justes"] = false;
                    $_SESSION["Error_message"] = "Mot de passe incorrect.";   
                    return header("location:./login.php");
                }
            }
}

?>
</body>
</html>