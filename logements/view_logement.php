<?php
   $methode = filter_input(INPUT_SERVER, "REQUEST_METHOD");
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
    <title>Modification de logement</title>
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
     integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY="
     crossorigin=""/>
    <link rel="stylesheet" href="../users/logistic_account_actions/styles/calendar.css"/>
    <script src="https://kit.fontawesome.com/c4254e24a8.js" crossorigin="anonymous"></script>

    <style>
            <?php
            require "./style/style_commun.css";
            require "./style/style_view.css";
            require "./style/header_style.css";
            require '../footer.css';
            ?>
    </style>
</head>
<body>
    <?php
include('header2.php')
       ?>
       <div class="banner">
       <h1>LOGEMENT</h1>
     </div>
     <br>
    <div class="zoneLogement">

    <?php
    $id= filter_input(INPUT_GET,'id');
     
    $pdo = connexion_BDD ();
    $requete1 = $pdo->prepare(recuperer_requete ("..","les logements","afficher un logement particulier"));
    $requete1->execute([
        ":id" => $id
    ]);
    $resultat1 = $requete1->fetchAll(PDO::FETCH_ASSOC);

    $requete2 = $pdo->prepare(recuperer_requete ("..","Avis","Afficher les avis d'un logement particulier"));
    $requete2->execute([
        ":housing_id" => $id
    ]);
    $resultat2 = $requete2->fetchAll(PDO::FETCH_ASSOC);
    ?>

        <div class="compartimentDeReservation">
        <div id="map">

        </div>
        
<br>
<button class ="disponibilite" onclick= "disponibilite(<?= $id?>)">Disponibilité</button>
<div class="calendrier">

</div>
<br>
            <button class ="button_Reservation" onclick= "formulaireOUpas(<?= $id?>)">Réserver</button>
            <div class="formulaire_de_reservation">

            </div>

         
        </div>

        <div class="compartiment_affichargeLogement">
            <h1><?=$resultat1[0]["name"]?></h1>
 
            <!-- On affiche juste 5 images max du logement -->
            <div class="slider">
        <div class="slider-viewport">
        <div id="img1">
            <div id="img2">
            <div id="img3">
                <div id="img4">
                <div id="img5">
                    <div class="slider-content">
                        <?php
                        $nbr_image= 0;
                    foreach (explode(',',$resultat1[0]["Images"]) as $key => $value) {
                        $nbr_image=$nbr_image+1;
                        if ($nbr_image <=5){ ?>
                        <img src="./images_logements/<?=$value?>">
                        <?php }
                    }
                        ?>
                    </div>
                </div>
                </div>
            </div>
            </div>
        </div>
        </div>
        <div class="slider-nav">
            <?php
            if ($nbr_image!=1) {
                for ($i=1; $i<=$nbr_image; $i++) {
                    ?>
                    <a href="#img<?=$i?>"></a>
                        <?php } 
            }
 ?>
        </div>
    </div>


            <h2>Description :</h2>
            <p><?=$resultat1[0]["description"]?></p>
            <p>Adresse : <?=$resultat1[0]["address"]?></p>
            <h2>Arrondissement n°<?=$resultat1[0]["position"]?> de <strong>Paris</strong></h2>
            <p>Capacité : <?=$resultat1[0]["capacity"]?> personnes max</p>           
                        <p>Prix : <?=$resultat1[0]["price"]?></p>
                        <p>Remise : <?=$resultat1[0]["discount"]?></p>
                        <p></p>
  
            <h2 >Avantages :</h2> 
            <ul class = "liste_avantages" >
            <?php 
                    foreach (explode(',',$resultat1[0]["content"]) as $key => $value) {
                   ?>
                   <li> <?=preg_replace("/_/", " ", $value)?></li>
                    <?php } ?>         
            </ul>
            <br>
            <?php

            $requete = $pdo->prepare(recuperer_requete ("..","Avis","Est-t-il autorisé à ajouter un avis sur ce logement?"));
                        $requete->execute([
                            ":housing_id" => $id,
                            ":client_id" => $_SESSION['individu_connecte']['id']
                        ]);

                        $resultat = $requete->fetchAll(PDO::FETCH_ASSOC);

                        if (count($resultat) >= 1 || $_SESSION['individu_connecte']['role']== "sudo") { # Il y a le cas où il aurait réservé plusieurs fois le meme appart
                            ?>
                            <form action="../avis/ajout.php" method="post">
                                <input type="text" name="id_logement" id="id_logement_" value="<?=$id?>" style="display:none">
                                <textarea style="position: relative; margin : 3px 5vw; border-radius : 0px 15px 15px 15px;resize: none;" name="avis" id="avis" cols="60" rows="7">Editer un avis</textarea>
                                <input type="submit" value="Publier" style=" margin-top: 60px;background-color:#8F3D4C ;font-size: 25px;border-radius: 4px;color: #FFBD99;font-family: 'Footlight MT Light';position: absolute;" >
                            </form>
                            <br>
                            <?php
                        }

            ?>  
<?php
#Un petit indicateur pour ne pas afficher d'avis sur un logement qui n'en a pas
    $le_petit_indicateur = 0;
foreach ( $resultat2 as $avis) {
    if ($le_petit_indicateur == 0)
    {?>
            <h2>Avis : </h2>
    <?php }
    $le_petit_indicateur = "Je change sa valeur 😁, on affiche AVIS qu'une seule fois 🤓";
    ?>
    <div class="conteneur_avis<?=$avis["id_avis"]?>" style = "display:flex; border-radius : 20px; border: 1px solid black; padding:10px 20px;position: relative;margin : 3px 5vw; background-color:white; " onmouseout= 'dis_option(<?=$avis["id_avis"]?>,<?=$avis["client_id"]?>,<?=$avis["housing_id"]?>)'>
    <div class="avis<?=$avis["id_avis"]?>">
    <p>
        <strong><?=$avis["first_name"] . " " . $avis["last_name"]?>:</strong>
    </p>
    <p class="contenu_avisD_id_<?=$avis["id_avis"]?>"><?=$avis["content"]?></p>
    <pre> Le <strong><?=date('d/m/Y',strtotime($avis["date"]))?></strong> à <strong><?= date('H:i:s',strtotime($avis["date"]))?></strong></pre>
    </div>
    <?php 
                        if ((isset($_SESSION['individu_connecte']['id']) && ($_SESSION['individu_connecte']['role']=="management" || $_SESSION['individu_connecte']['role']== "sudo")) || (isset($_SESSION['individu_connecte']['id']) && $_SESSION['individu_connecte']['id']==$avis["client_id"]))
                    {
                        ?>
    <textarea class="lancient_avis<?=$avis["id_avis"]?>" name="ancient__content" style = "display:none;" ><?=$avis["content"]?></textarea>
    <div class="options_avis<?=$avis["id_avis"]?>" style="">
        <input type="button" style="border: radius 15px; padding:1px 2px; border:none; font-size:30px;" value="..." class="option<?=$avis["id_avis"]?>" onmouseover= 'on_fait_quoi(<?=$avis["id_avis"]?>,<?=$avis["client_id"]?>,<?=$avis["housing_id"]?>)'>
    </div>
    <br>
    <?php }
    ?>
    </div>
  <br>
    <?php
};
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
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"
     integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo="
     crossorigin=""></script>
        <script>
                function annulationFormulairedeLaReservation (idLogement) {
                    if (document.querySelector('button.button_Reservation')=== null)
                {
                    let nouveau_button = document.createElement("button")
                    nouveau_button.setAttribute ("class","button_Reservation")
                    nouveau_button.setAttribute ("onclick","formulaireOUpas("+idLogement+")")
                    nouveau_button.innerText = "Réserver"
                    document.querySelector(`div.compartimentDeReservation`).append(nouveau_button)
                    document.querySelector(`div.formulaire_de_reservation`).replaceChildren("")
                }}

        function formulaireOUpas(idLogement) {
            <?php
            if (isset($_SESSION['individu_connecte']['id'])) {
                ?>
                document.querySelector(`button.button_Reservation`).remove()
                
              let formulaireDeReservation = document.createElement('form:post')
              formulaireDeReservation.setAttribute("class","formulaireReservation")
              formulaireDeReservation.innerHTML = "<form class='formulaireReservation' action='../reservations/ajout.php' method='post'>\
              <input type='text' name='id_logement' style='display:none;' class='id_logemement'> \
              <label for='date_debut'>Date d'Entré :</label> \
              <input type='date' name='start_date' id='date_debut' required> \
              <br> \
              <label for='date_fin'>Date de Sortie :</label> \
              <input type='date' name='end_date' id='date_fin' required> \
              <br> \
              <input class='envoieFormReservation' style='display:none;' type='submit' value='Valider'> \
              </form>"

                let buttonAnnulation = document.createElement('input:button')
                buttonAnnulation.setAttribute("class","annulation")
                buttonAnnulation.innerHTML = '<input type="button" value="Annuler" class="annulation" onclick="annulationFormulairedeLaReservation ()" style=" margin-bottom: 40px; margin-right: 40px; background-color:#8F3D4C ;font-size: 25px;border-radius: 4px;color: #FFBD99; font-family:Footlight MT Light; position: absolute;">'

                let buttonValidation = document.createElement('input:submit')
                buttonValidation.setAttribute('class',"validation")
                buttonValidation.innerHTML = '<input type="submit" value="Valider" class="validation"  style=" margin-bottom: 40px; margin-left: 100px;background-color:#8F3D4C ;font-size: 25px;border-radius: 4px;color: #FFBD99; font-family:Footlight MT Light; position: absolute;">'
                let menu = document.createElement('menu')

                menu.append(buttonAnnulation)
                menu.append(buttonValidation)
                         
                formulaireDeReservation.append (menu)
              document.querySelector ('div.formulaire_de_reservation').append(formulaireDeReservation)
                let id_logement = document.querySelector("input.id_logemement")
                id_logement.value = idLogement
              let butTonEnnuler = document.querySelector ('input.annulation')
              butTonEnnuler.setAttribute('onclick',"annulationFormulairedeLaReservation ("+idLogement+")")

              let buttonValidationn = document.querySelector("input.validation")
                buttonValidation.setAttribute('onclick',"document.querySelector(`input.envoieFormReservation`).click()") 


                <?php
            } else {
                ?>
                window.location="../users/login.php"
                <?php
            }
            ?>
        }


             function are_you_sure(url,action) {
                    if (confirm("Vous êtes sûr de vouloir "+ action +"?")) {
                        window.location=url
                    }
                }

                function dis_option_Action (id_avis,id_client,id_logement) {

                    let content = document.querySelector(".lancient_avis"+id_avis).value
                    let pararagraphAvisAncien = document.querySelector(".contenu_avisD_id_"+id_avis)
                    let formulaireReEditionAvis = document.querySelector(".formulaire_modification")
                    if (formulaireReEditionAvis!== null) {
                        formulaireReEditionAvis.remove()
                    }
                    pararagraphAvisAncien.replaceChildren(content)


                    let conteneurDes_options = document.querySelector(".options_avis"+id_avis)
                            conteneurDes_options.replaceChildren("")
                            let optionsButton = document.createElement('input:button')
                            optionsButton.setAttribute("class","option"+id_avis)
                            optionsButton.setAttribute("onmouseover","")
                            optionsButton.innerHTML = '<input type="button" class="option'+id_avis+'" value="..."  style="border-radius:3px; padding:1px 2px;border:none;font-size:30px;" onmouseover= "on_fait_quoi('+id_avis+','+id_client+','+id_logement+')">'
                            conteneurDes_options.append(optionsButton)
                }

                function dis_option (id_avis,id_client,id_logement) {
                    onmouseover = (elem) =>{
                        if (document.querySelector(".lancient_avis"+id_avis).value)
        if ((elem.srcElement.tagName == "BODY")) {
            dis_option_Action (id_avis,id_client,id_logement)
        } else if ((elem.srcElement.tagName == "DIV")) {
            if ((elem.srcElement.className  != "conteneur_avis"+id_avis ) && (elem.srcElement.className  != "avis"+id_avis )) {
                dis_option_Action (id_avis,id_client,id_logement)
            }
        }}
                }

                
                function ennulation(id_avis) {
                    document.querySelector("input.modification").removeAttribute("disabled")
                    let content = document.querySelector(".lancient_avis"+id_avis).value
                    let pararagraphAvisAncien = document.querySelector(".contenu_avisD_id_"+id_avis)
                    let formulaireReEditionAvis = document.querySelector(".formulaire_modification")
                    pararagraphAvisAncien.replaceChildren(content)
                    formulaireReEditionAvis.remove()
                            }


                function on_fait_quoi (id_avis,id_client,id_logement) {
                    <?php

            # Actions que peut faire ceux qui sont connectés (en fonction de ce qu'ils sont.)
                        if (isset($_SESSION['individu_connecte']['id']))
                    {?>

                        let content = document.querySelector(".lancient_avis"+id_avis).value
                    // Modification de l'avis
                    if (id_client == <?=$_SESSION['individu_connecte']['id']?>) {
                        let optionsButton = document.querySelector(".option"+id_avis)

                        let br = document.createElement('br')
                        let modifierAvisButton = document.createElement('input:button')
                        modifierAvisButton.setAttribute("class","modification")
                        modifierAvisButton.innerHTML = "<input type='button' class='modification' value='Modifier' style='width:130px;background-color:#8F3D4C ;font-size: 25px;border-radius: 4px;color: #FFBD99; font-family:Footlight MT Light; 'let menu = document.createElement('menu')'> <br>"
                        document.querySelector(".options_avis"+id_avis).append(modifierAvisButton)

                        let modification = document.querySelector("input.modification")
                        modification.addEventListener("click",() =>{
                            modification.setAttribute ("disabled","")
                            let pararagraphAvisAncien = document.querySelector(".contenu_avisD_id_"+id_avis)
                            let formulaireReEditionAvis = document.createElement('form:post')

                            formulaireReEditionAvis.setAttribute("class","formulaire_modification")
                            formulaireReEditionAvis.innerHTML= "<form action='../avis/modification.php' method='post' class='formulaire_modification' ><h3>Modification d'avis en cours </h3><br> <input type='text' class='id_avis_courant' style='display:none;' name='id_avis_id_logement' > <textarea class='champ_modification' name='avis_modifie'></textarea> <input type='submit' style='display:none;' class='envoieForm'> </form>"                        
 
                            let menu = document.createElement('menu')

                            let buttonAnnulation = document.createElement('input:button')
                            buttonAnnulation.setAttribute("class","annulation")
                            buttonAnnulation.innerHTML = '<input type="button" value="Annuler" class="annulation" onclick="ennulation('+id_avis+')">'

                            let buttonValidation = document.createElement('input:submit')
                            buttonValidation.setAttribute('class',"validation")
                            buttonValidation.innerHTML = '<input type="submit" value="Valider" class="validation">'
                            
                            

                            menu.append(buttonAnnulation)
                            menu.append(buttonValidation)
                            
                           
                            formulaireReEditionAvis.append(br)
                            formulaireReEditionAvis.append(menu)

                            pararagraphAvisAncien.replaceChildren(formulaireReEditionAvis)

                            let champDeReEditionAvis = document.querySelector("textarea.champ_modification")
                            let id_necessaires = document.querySelector("input.id_avis_courant")
                            id_necessaires.value = id_avis + " " + id_logement
                            champDeReEditionAvis.setAttribute('cols',"60")
                            champDeReEditionAvis.setAttribute('rows',"10") 
                            champDeReEditionAvis.value = content
    

                            let buttonValidationn = document.querySelector("input.validation")
                            buttonValidation.setAttribute('onclick',"document.querySelector(`.envoieForm`).click()") // Petit contournement de contraintes, ça fait toujours du bien 🤣

                                        });

                     
                    }


                    // Suppression de l'avis
                    let optionsButton = document.querySelector(".option"+id_avis)
                        let supprimerAvisButton = document.createElement('input:button')
                        supprimerAvisButton.setAttribute("class","suppression")
                        supprimerAvisButton.innerHTML = "<input type='button' class='suppression' value='Supprimer' style=' margin-top=100px; width:130px;background-color:#8F3D4C ;font-size: 25px;border-radius: 4px;color: #FFBD99; font-family:Footlight MT Light;'let menu = document.createElement('menu')'> <br>"
                        document.querySelector(".options_avis"+id_avis).append(supprimerAvisButton)
                     
                        let suppression = document.querySelector("input.suppression")
                        suppression.addEventListener("click",() =>{
                            are_you_sure("../avis/suppression.php?id="+id_avis+"&id_logement="+id_logement,"supprimer "+ (id_client==<?=$_SESSION['individu_connecte']['id']?>?"votre":"cet") + " avis" )
                });
                        optionsButton.remove()
                                

                    <?php
                    }?>
                }

var map = L.map('map').setView([48.866667, 2.333333], 12);

//Ajout de la map
var Stadia_OSMBright = L.tileLayer('https://tiles.stadiamaps.com/tiles/osm_bright/{z}/{x}/{y}{r}.png', {
	maxZoom: 20,
	attribution: '&copy; <a href="https://stadiamaps.com/">Stadia Maps</a>, &copy; <a href="https://openmaptiles.org/">OpenMapTiles</a> &copy; <a href="http://openstreetmap.org">OpenStreetMap</a> contributors'
});

Stadia_OSMBright.addTo(map)
//Ajout des marker sur la map
var marker = L.marker([48.8303648, 2.3277728]).addTo(map);
var markers = L.marker([48.840874916089916, 2.142052877079119]).addTo(map);
//Ajout des popup sur les marker
marker.bindPopup("<b><?=$resultat1[0]["address"]?></b>").openPopup();



function disponibilite(id_du_logement) {
    let element = document.querySelector ("div.calendrier")
    generateLogisticCalendar(element, id_du_logement+"./users/logistic_account_actions");
    document.querySelector("button.disponibilite").remove()
}
    </script>
    <script src="../users/logistic_account_actions/script/calendar.js"></script>

    </body>

</html>