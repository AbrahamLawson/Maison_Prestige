<?php
   require '../session_start.php';
   require '../bdd_connect.php';
   require "../recuperer_Requete.php";
   session_start_prim ();
   require "./verification_token.php";

    if (isset($_SESSION['individu_connecte']['id'])) {
        
   $methode = filter_input(INPUT_SERVER, "REQUEST_METHOD");

   if ($methode=== "GET") {
    $pdo = connexion_BDD ();
   
    $requete = $pdo->prepare(recuperer_requete ("..","Comptes utilisateurs","Récuperer des informations de compte"));
    $requete ->execute([
        ":id" => $_SESSION['individu_connecte']['id']
    ]);
 
    $resultat = $requete->fetchAll(PDO::FETCH_ASSOC);
    ?>
    <!DOCTYPE html>
    <html lang="en">
    <head>
     <meta charset="UTF-8">
     <meta name="viewport" content="width=device-width, initial-scale=1.0">
     <title>Modification de profile</title>    
     <script src="https://kit.fontawesome.com/c4254e24a8.js" crossorigin="anonymous"></script>
     <link rel="stylesheet" href="">
     <style>
      <?php
             require '../footer.css';
            require "./style/header_style.css";
            require "./style/modifi.css";
?>
     </style>
    </head>
    <body>
    <?php
    include('./header2.php')
    ?>
    <div class="banner">
        <h1>MON COMPTE</h1>
      </div>
      <br>
    <div class="formulaire">
     <form action="modification_profile.php" method="post">
        <h2 style="text-align:center">Modification du profil</h2>
            <?php 
                if ($_SESSION["donnees_justes"] ===false) {
                    ?>
                    <pre style="background:#FAA; color:red; padding:1vh">OUPS!!!!!!!! <?= $_SESSION["Error_message"] ?></pre>
                    <?php
                }
            ?>
         <label for="first_name">Nom :</label>
         <input type="text" name="first_name" id="first_name" value="<?=$resultat[0]["first_name"]?>">
         <br><br>
         <label for="last_name">Prénom :</label>
         <input type="text" name="last_name" id="last_name" value="<?=$resultat[0]["last_name"]?>">
         <br><br>
         <label for="email">Email :</label>
         <input type="email" name="email" id="email" value="<?=$resultat[0]["mail"]?>">
         <br><br>
         <div class="newMDP"></div>
        <input type="button" class="MDP_Prise_enCompte" style="display:none" value="">
         <input type="button" class="change_mdp" value="Changer le Mot de Passe">
         <br><br>
         <input type="submit" value="Valider" class="BtnValider">
         <br>
     </form>
</div>

    <script>
      let changeMDP = document.querySelector('input.change_mdp')
      let validationFormulaire = document.querySelector('input.BtnValider')
      let nouvelleValeurMDP = "AUCUN ChanGEmEnT --- jzkzczjkn122§$*zzedzdedazdadazdadaez@" //Si cette valeur indevinable se retrouve en POST, c'est qu'il y a pas changement 🥲.
 
      changeMDP.addEventListener('click', () => {
         changeMDP.setAttribute ('style','display:none')
         validationFormulaire.setAttribute ('style','display:none')
         
         let conteneur = document.createElement('div')
         conteneur.setAttribute('class','conteneur_NewMDP')
         conteneur.innerHTML ="<div class='conteneur_NewMDP' ></div>"
 
         let ecriture = document.createElement('input:password')
         let confirmation = document.createElement('input:password')
         let labelEcriture = document.createElement('label')
         let labelconfirmation = document.createElement('label')
         let p1 = document.createElement('p')
         let p2 = document.createElement('p')
         labelEcriture.innerHTML = "<label>Renseigner le nouveau Mot de Passe: </label>"
         labelconfirmation.innerHTML = "<label>Confirmer le nouveau Mot de Passe: </label>"
 
         ecriture.setAttribute('class','ecriture_changeMDP')
         confirmation.setAttribute('class','confirmation_changeMDP')
         ecriture.innerHTML = '<input type="password" class = "ecriture_changeMDP" name="ecriture_changeMDP">'
         confirmation.innerHTML = '<input type="password" class = "confirmation_changeMDP" name="confirmation_changeMDP">'
         
         p1.append(labelEcriture)
         p1.append(ecriture)

         p2.append(labelconfirmation)
         p2.append(confirmation)
       
         let menu = document.createElement('menu')
          menu.innerHTML = "<menu style='margin:auto;'></menu>"
 
         let buttonAnnulation = document.createElement('input:button')
         buttonAnnulation.innerHTML = '<input type="button" value="Annuler" style="margin:auto;">'
         buttonAnnulation.setAttribute('class',"annulation")
         let buttonValidation = document.createElement('input:button')
         buttonValidation.innerHTML = '<input type="button" value="Valider" style="margin:auto;">'
         buttonValidation.setAttribute('class',"validation")
         menu.append(buttonAnnulation)
         menu.append(buttonValidation)
 
         conteneur.appendChild(p1)
         conteneur.appendChild(p2)
         conteneur.appendChild(menu)
         document.querySelector ('.newMDP').setAttribute("style",'border:solid 2px;padding:2VW;background:#FFBD99;') 
         document.querySelector ('.newMDP').append(conteneur)
         let champ_n_ecreture = document.querySelector ('input.ecriture_changeMDP')
         let champ_n_confirmation = document.querySelector ('input.confirmation_changeMDP')
         let formNewMDP =  document.querySelector ('.conteneur_NewMDP')
         let confirmationn = document.querySelector ('.validation')
         let ennulation = document.querySelector ('.annulation')
         confirmationn.addEventListener('click',() => {
                 if (champ_n_ecreture.value.length > 5) {
                     if (champ_n_confirmation.value === champ_n_ecreture.value) {
                        nouvelleValeurMDP = champ_n_confirmation.value
                         let confirm = document.querySelector("input.MDP_Prise_enCompte")
                         confirm.setAttribute("style","display:block;color:white;background:yellowgreen; border:none; padding:4px;height:13vh")
                         confirm.value = "Valider Pour Mettre à Jour.\nVous serez redirigé.e vers la page de\nConnexion pour une reconnexion."

                         changeMDP.remove()
                         formNewMDP.remove()
                         validationFormulaire.setAttribute ('style','display:block')
                         document.querySelector ('.newMDP').setAttribute("style",'border:none 0px;padding:0VW;') 
                     } else {
                        champ_n_confirmation.setAttribute("style","border-color:red;")
                        champ_n_ecreture.setAttribute("style","border-color:green;")
                     }
 
                 } else {
                    champ_n_ecreture.setAttribute("style","border-color:red;")
                 }
             })
 
             ennulation.addEventListener('click',() => {
                document.querySelector ('.newMDP').setAttribute("style",'border:none 0px;padding:0VW;background-color:white;') 
                 changeMDP.setAttribute ('style','display:block')
                 validationFormulaire.setAttribute ('style','display:block')
                 formNewMDP.remove()
             })
      });

      validationFormulaire.onclick = () => {
        let MDP_Prise_enCompte = document.querySelector("input.MDP_Prise_enCompte")
        if (MDP_Prise_enCompte.value === "Valider Pour Mettre à Jour.\nVous serez redirigé.e vers la page de\nConnexion pour une reconnexion.")
        {
        let confirm = document.createElement("input:password")
                        confirm.innerHTML = `<input type="password" style="display:none;" value=${nouvelleValeurMDP} name="newMDPasse">`
                        document.querySelector ('.newMDP').append(confirm)
        }
      };
    </script>
    <?php
    $_SESSION["donnees_justes"] = true;
   } elseif($methode === "POST") {
    $new_MotDePasse = filter_input(INPUT_POST,'newMDPasse');
    $first_name = filter_input(INPUT_POST,'first_name');
    $last_name = filter_input(INPUT_POST,'last_name');
    $email = filter_input(INPUT_POST,'email');

    $pdo = connexion_BDD ();

    if (strlen($first_name)< 3 || strlen($last_name)< 3 ||  (!filter_var($email, FILTER_VALIDATE_EMAIL)) ) {
        $_SESSION["donnees_justes"] = false;
        $_SESSION["Error_message"] = "Veuillez entrer des informations valides.";
       return header("location:./modification_profile.php");
    } else {
        $requete = $pdo->prepare(recuperer_requete ("..","Modification d'un compte client","Modification des infos du profil par l'utilisateur"));
        $requete ->execute([
            ":id" => $_SESSION['individu_connecte']['id'],
            ":first_name" => $first_name,
            ":last_name" => $last_name,
            ":mail" => $email
        ]);

        $_SESSION['individu_connecte']["pseudo"]= $first_name.' '.$last_name;
    }


   if (($new_MotDePasse != "AUCUN ChanGEmEnT --- jzkzczjkn122§$*zzedzdedazdadazdadaez@") && ($new_MotDePasse != "")) {

    $requete = $pdo->prepare(recuperer_requete ("..","Modification d'un compte client","Modification du mot de passe de l'utilisateur"));
    $requete ->execute([
        ":id" => $_SESSION['individu_connecte']['id'],
        ":password" => password_hash($new_MotDePasse,PASSWORD_DEFAULT)
    ]);
    #suppression token
    $requete = $pdo->prepare(recuperer_requete ("..","Déconnexion","Suppression du jeton dans tokens"));
    $requete->execute ([
        ":id" => $_SESSION['individu_connecte']['id']
        ]);

    # Déconnexion :
    setcookie("token");           
    session_destroy();

 return header("location:./login.php");
   }

   return header("location:./dashboard.php");
   }
} else {
    reconnexion_ou_non ("./login.php","./modification_profile.php");
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