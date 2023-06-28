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
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="reservation.css">
    <title>Page Réservation</title>
        <script src="https://kit.fontawesome.com/c4254e24a8.js" crossorigin="anonymous"></script>
    <style>
      <?php
                  require "./style/header_style.css";
                  require "./style/autre_style.css";
            require '../footer.css';
      ?>
    </style>
</head>
<body>
<?php
 include('header2.php');
   $id= filter_input(INPUT_GET,'id');
   $_SESSION['reservation_id']=$id;
if (isset($_SESSION['individu_connecte']['id'])) {

    $requete = $pdo->prepare(recuperer_requete ("..","Réservation","Obtenir les données d'une réservation"));
    $requete->execute([
        ":id" => $id
    ]);
    $resultat = $requete->fetchAll(PDO::FETCH_ASSOC);
        ?>
        <br>
        <div class="banner">
       <h1>RESERVATION</h1>
     </div>
     <br>
      <div class="containerr">
        <div class="reservation">
            <p> logement : <strong><?=$resultat[0]["name"]?></strong></p>
            <p> Adresse : <strong><?=$resultat[0]["address"]?></strong></p>
            <p> Lieu : <strong>Paris <?=$resultat[0]["position"]?></strong></p>
            <p>Du: <span style ="background:#FFBD99;padding:4px; border-radius:4px; color:white;"><?=date('d/m/Y',strtotime($resultat[0]["start_date"]))?></span> au <span style ="background:#8F3D4C;padding:4px; border-radius:4px; color:white;"><?=date('d/m/Y',strtotime($resultat[0]["end_date"]))?></span></p>
            <p>Client: <strong><?=$resultat[0]["first_name"]." ".$resultat[0]["last_name"]?></strong></p>
            <p>Statut:
                    <?php
                    if ($resultat[0]["status"] == "cancelled") {
                        ?>
                        <span style ="background:red;padding:4px; border-radius:4px; color:white;"><?=$resultat[0]["status"]?></span>
                        <?php
                    } else {
                        ?>
                        <span style ="background:yellowgreen;padding:4px; border-radius:4px; color:white;"><?=$resultat[0]["status"]?></span>
                        <?php
                    } ?>
                </p>    
            </div>
        </div>
        <br>
        <div class="containerr">
            <div class="formulaire_de_modification_de_reservation"  style="text-align:center;">
           
            </div>
            <menu class="actions_Page_Modification_Reservation" style="text-align:center;">
                <?php
                if (isset($_SESSION['individu_connecte']['id']) && ($_SESSION['individu_connecte']['id']==$resultat[0]['client_id'] || $_SESSION['individu_connecte']['role']== "management" || $_SESSION['individu_connecte']['role']== "sudo"))
                {
                    ?>
                <button id="butt" class="modifierReservation" onclick="formulaireUPDATEreservation(<?=$id?>)">Modifier</button>
                <button id="butt" class="annulerReservation" onclick="are_you_sure('./annuler.php?id_booking=<?=$id?>')">Annuler</button>
                <a href="../messagerie/message.php"><button id="butt">Messagerie</button></a>
                <?php
                    }
                    ?>
            </menu>

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
             function are_you_sure(url) {
                    if (confirm("Vous êtes sûr de vouloir annuler cette réservation ?")) {
                        window.location=url
                    }
                }

                function annulationFormulaireDelaModification (idReservation) {
                    if (document.querySelector('button.modifierReservation')=== null)
                {
                    let nouveau_button = document.createElement("button")
                    nouveau_button.setAttribute ("class","modifierReservation")
                    nouveau_button.setAttribute ("id","butt")
                    nouveau_button.setAttribute ("onclick","formulaireUPDATEreservation("+idReservation+")")
                    nouveau_button.innerText = "Modifier"
                    let nouveau_button2 = document.createElement("button")
                    nouveau_button2.setAttribute ("class","annulerReservation")
                    nouveau_button2.setAttribute ("id","butt")
                    nouveau_button2.setAttribute ("onclick","are_you_sure('./annuler.php?id="+idReservation+"')")
                    nouveau_button2.innerText = "Annuler"
                    let nouveau_button3 =  document.createElement("a")
                    nouveau_button3.innerHTML = '<a href="../messagerie/message.php"><button id="butt">Messagerie</button></a>'
                    document.querySelector(`menu.actions_Page_Modification_Reservation`).append(nouveau_button)
                    document.querySelector(`menu.actions_Page_Modification_Reservation`).append(nouveau_button2)
                    document.querySelector(`menu.actions_Page_Modification_Reservation`).append(nouveau_button3)
                    document.querySelector(`div.formulaire_de_modification_de_reservation`).replaceChildren("")
                }}

                function formulaireUPDATEreservation(idReservation) {
            <?php
            if (isset($_SESSION['individu_connecte']['id'])) {
                ?>
                document.querySelector(`menu.actions_Page_Modification_Reservation`).replaceChildren()
                
              let formulaireDeReservation = document.createElement('form:post')
              formulaireDeReservation.setAttribute("class","formulaireModificationReservation")
              formulaireDeReservation.innerHTML = "<form class='formulaireModificationReservation' action='./modifier.php' method='post'>\
              <input type='text' name='id_reservation' style='display:none;' class='id_Reservevation'> \
              <label for='date_debut'>Date d'Entré :</label> \
              <input type='date' name='start_date' id='date_debut' required> \
              <br> \
              <label for='date_fin'>Date de Sortie :</label> \
              <input type='date' name='end_date' id='date_fin' required> \
              <br> \
              <input class='envoieFormulaireUPDATEreservation' style='display:none;' type='submit' value='Valider'> \
              </form>"

                let buttonAnnulation = document.createElement('input:button')
                buttonAnnulation.setAttribute("class","annulation")
                buttonAnnulation.innerHTML = '<input type="button" value="Annuler" class="annulation" onclick="annulationFormulaireDelaModification ()">'

                let buttonValidation = document.createElement('input:submit')
                buttonValidation.setAttribute('class',"validation")
                buttonValidation.innerHTML = '<input type="submit" value="Valider" class="validation">'
                let menu = document.createElement('menu')

                menu.append(buttonAnnulation)
                menu.append(buttonValidation)
                         
                formulaireDeReservation.append (menu)
              document.querySelector ('div.formulaire_de_modification_de_reservation').append(formulaireDeReservation)
                let id_reservation = document.querySelector("input.id_Reservevation")
                id_reservation.value = idReservation
              let butTonEnnuler = document.querySelector ('input.annulation')
              butTonEnnuler.setAttribute('onclick',"annulationFormulaireDelaModification ("+idReservation+")")

              let buttonValidationn = document.querySelector("input.validation")
                buttonValidation.setAttribute('onclick',"document.querySelector(`input.envoieFormulaireUPDATEreservation`).click()") 


                <?php
            } else {
                ?>
                window.location="../users/login.php"
                <?php
            }
            ?>
        }
        </script>
        
</body>
</html>
    <?php 
    } else {
        reconnexion_ou_non ("../users/login.php","./view.php?id=$id");
   }