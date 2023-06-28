<?php
   $methode = filter_input(INPUT_SERVER, "REQUEST_METHOD");
   require '../session_start.php';
   require '../bdd_connect.php';
   require "../recuperer_Requete.php";
   session_start_prim ();
   require "../users/verification_token.php";
        ?>
        <br>
    <?php
    if ($methode === "GET") {
    $id= filter_input(INPUT_GET,'id');
    if (isset($_SESSION['individu_connecte']['role']) && ($_SESSION['individu_connecte']['role'] == "management" || $_SESSION['individu_connecte']['role']== "sudo")) {

        ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modification de logement</title>

    <script src="https://kit.fontawesome.com/c4254e24a8.js" crossorigin="anonymous"></script>
    <style>
            <?php
                         require "./style/header_style.css";
                         require "./style/style_commun.css";
                         require "./style/modif_style.css";
                         require "./style/autre_style.css";
                         require '../footer.css';
            ?>
       
    </style>
</head>
<body>
<?php

        include('header2.php');
    $pdo = connexion_BDD ();
    $requete = $pdo->prepare(recuperer_requete ("..","les logements","afficher un logement particulier"));
    $requete->execute([
        ":id" => $id
    ]);
    $resultat = $requete->fetchAll(PDO::FETCH_ASSOC);
    ?>
                <form action="./modification.php" method="post" class="formulaire_enregistrement_logement" enctype="multipart/form-data">
                        <?php 
                if (isset($_SESSION["donnees_justes"]) && $_SESSION["donnees_justes"] ===false) {
                    ?>
                    <pre style="background:#FAA; color:red; padding:1vh">OUPS!!!!!!!! <?= $_SESSION["Error_message"] ?></pre>
                    <?php
                }
    ?>
    <div class="container">
    <div class="banner">
       <h1>MODIFICATION D'UN LOGEMENT</h1>
     </div>
            <div class="image-container">
                <ul id="images-list">
                    <?php 

                    $_SESSION["anciennes_images"] = $resultat[0]["Images"];
                    $_SESSION["position?"] = $resultat[0]["position"];
                    $_SESSION["id_logement"] = $id;
                    foreach (explode(',',$resultat[0]["Images"]) as $key => $value) {
                   ?>
                    <img style="height: 200px;;border-radius: 4px;border:2px double;"src="./images_logements/<?=$value?>" />
                    <?php } ?>
                </ul>
            </div>
            
            <input type="button" style=" display:block;width:290px;color:#8F3D4C;font-weight:bold; border-radius:5px;height:40px; font-size:17px;background:#FFBD99;" id ="buttonAjouterImage" onclick = "document.querySelector('#ajout_images').click()" value="Changer les images">
            <input type="file" name="images[]" multiple accept="image/*" onchange="previewImages(event)"  id="ajout_images" style="display:none">
            <div class = "bb"></div>
            <label for="titre">Titre :</label>
            <div class = "bb"></div>
            <input type="text" name="titre" id="titre" value="<?=$resultat[0]["name"]?>" required >
            <div class = "bb"></div>
            <label for="description">Description :</label>
            <div class = "bb"></div>
            <textarea name="description" id="description"  class="description"><?=$resultat[0]["description"]?></textarea>
            <div class = "bb"></div>
            <label for="localisation">Adresse :</label>
            <div class = "bb"></div>
            <input type="text" name="localisation" id="localisation" value="<?=$resultat[0]["address"]?>" required>
            <div class = "bb"></div>
            <label for="arrondissement">Arondissement :</label>
            <div class = "bb"></div>
            <select type="text" name="arrondissement" id="arrondissement">
                <option value="">Arrondissement n°<?=$resultat[0]["position"]?></option>
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
            <div class = "bb"></div>         
            <label for="capacity">Capacité (nombre de personnes) :</label>
            <div class = "bb"></div>
            <input type="number" name="capacity" id="capacity" value="<?=$resultat[0]["capacity"]?>">
            <div class = "bb"></div>
            <label for="price">Prix :</label>
            <div class = "bb"></div>
            <input class="price" type="number" name="price" id="price" value="<?=$resultat[0]["price"]?>" required>
            <div class = "bb"></div>
            <label for="remise">Remise :</label>
            <div class = "bb"></div>
            <input class="remise" type="text" name="remise" id="remise" value="<?=$resultat[0]["discount"]?>">
            <div class = "bb"></div>    
            <h2 for="avantages">Avantages :</h2> 
            <ul class = "liste_avantages" >
            <?php 
                    foreach (explode(',',$resultat[0]["content"]) as $key => $value) {
                   ?>
                   <li>
                   <label for="<?=strtolower($value)?>"> <?=$value?></label>   
                   <input type="checkbox" name="<?=preg_replace("/_/", " ", $value)?>" id="<?=strtolower($value)?>" checked> 
                   </li>
                   <br>
                    <?php } ?>         
            </ul>          
            <div class="formulaire_avantages"></div>
            <input type="button" class="ajout_avantages_button" value="Ajouter">
            <br>
        <input type="submit" value="Envoyer" class= 'EnvoyerFormulaire'>                                                  
        </form>
        </div>
        <?php
        $_SESSION["donnees_justes"] = true;
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
            let fichiers_non_conserves_finalement = {}
                function previewImages(event)
        {
               try {
            document.querySelector(".alert_fichier_trop_gros").remove()
        } catch (error) {
            
        }
            let domaineDePrevisualisation = document.getElementById('images-list');
            domaineDePrevisualisation.replaceChildren('') // remplacer des images prévisualisées à l'ancienne pour que l'utilisateur n'ait pas l'impression qu'il ajoute une image mais plutot qu'il change son ancienne action.
            fichiers = event.target.files 
            fichiers_non_conserves_finalement = [...event.target.files]
            for (let i = 0; i < fichiers.length; i++) {
                (
                    
                (i) => {
                    let fichier = fichiers[i];
                    if (fichier.size > 3145728) {
                        let erreur = document.createElement('p')
                        erreur.setAttribute("class","alert_fichier_trop_gros")
                        erreur.innerHTML = '<p style="background:#FAA;border-radius:12px; color:red; padding:1vh"> Fichier trop gros détecté et supprimé</p>'
                        fichiers_non_conserves_finalement.splice(i,1) // On supprime le fichier volumineux
                        return document.querySelector('.image-container').append(erreur)
                    }
                    let lecteur = new FileReader();

                    lecteur.onload = function(event) {
                        let image = document.createElement('img');
                        image.src = event.target.result;

                        let preview = document.createElement('li');
                        preview.classList.add('image-preview');

                        let deleteButton = document.createElement('button');
                        deleteButton.classList.add('delete-button');
                        deleteButton.innerHTML = `
                            <img style="height: 30px; width: 30px;" src="../medias/images/delete-icon.svg" />
                        `;
                        deleteButton.addEventListener('click', function() {
                            fichiers_non_conserves_finalement[i]["A_negliger"] = fichiers_non_conserves_finalement[i].name; // netoyer le fichier supprimé pour ne pas le mettre dans la bdd
                            domaineDePrevisualisation.removeChild(preview);
                            console.log(fichiers_non_conserves_finalement)
                        });
                        
                        let previewName = document.createElement('p');
                        previewName.innerText =fichier.name;

                        let previewNameOverlay = document.createElement('span');
                        previewNameOverlay.classList.add('preview-name-overlay');

                        let previewNameContainer = document.createElement('div');
                        previewNameContainer.classList.add('preview-name-container');
                        previewNameContainer.appendChild(previewName);
                        previewNameContainer.appendChild(previewNameOverlay);

                        let previewHeader = document.createElement('header');
                        previewHeader.appendChild(previewNameContainer);
                        previewHeader.appendChild(deleteButton);

                        preview.appendChild(previewHeader);
                        preview.appendChild(image);

                        domaineDePrevisualisation.appendChild(preview);
                    }

                    lecteur.readAsDataURL(fichier);
                }
                )(i);
            }
        }

        let ajoutButton = document.querySelector('.ajout_avantages_button')
        let listeavantages = document.querySelector('.liste_avantages')

        ajoutButton.addEventListener('click', () => {
        let formulaire_ajout = document.createElement('legend')
        formulaire_ajout.setAttribute('class','formulaire_ajout')
        formulaire_ajout.innerHTML = '<legend style ="color:white;background:#8F3D4C;padding:5px;font-size:15px;">Formulaire d\'ajout d\'avantages </legend><br>'
        let menu = document.createElement('menu')
        let paragraph = document.createElement('span')
        paragraph.innerHTML = '<span><label for="libelle">Libellé :</label></span>'
        let checkBox = document.createElement('input')
        checkBox.innerHTML ='<input type="text" name="libelle_avantage">'
        checkBox.setAttribute('id',"libelle")
        paragraph.append(checkBox)
        let buttonAnnulation = document.createElement('input:button')
        buttonAnnulation.innerHTML = '<input type="button" value="Annuler">'
        buttonAnnulation.setAttribute('class',"annulation")
        let buttonValidation = document.createElement('input:button')
        buttonValidation.innerHTML = '<input type="button" value="Valider">'
        buttonValidation.setAttribute('class',"validation")
        menu.append(buttonAnnulation)
        menu.append(buttonValidation)
        formulaire_ajout.append(paragraph)
        formulaire_ajout.append(menu)
        document.querySelector(".formulaire_avantages").setAttribute('style',"border:solid 1px;")
        document.querySelector(".formulaire_avantages").append(formulaire_ajout)
        ajoutButton.setAttribute ('style','display:none')
        let newCaracteristique = document.querySelector('input#libelle')
        let confirmation = document.querySelector('.validation')
        let ennulation = document.querySelector('.annulation')
        let formAjout = document.querySelector('.formulaire_ajout')
            
            confirmation.addEventListener('click',() => {
                if (newCaracteristique.value.length > 0) {
                    ajoutButton.setAttribute ('style','display:block')
                    let newCaracteristiqueElement = document.createElement('li')
                    newCaracteristiqueElement.innerHTML = '<li><label for="'+newCaracteristique.value+'">'+newCaracteristique.value+'</label> <input type="checkbox" name="'+newCaracteristique.value.replace(' ','_')+'" id="'+newCaracteristique.value+'" checked> </li> <br>'
                    document.querySelector('.liste_avantages').append(newCaracteristiqueElement)
                    document.querySelector(".formulaire_avantages").setAttribute('style',"border:none;")
                    formAjout.remove()
                }
            }
            )
                        
            ennulation.addEventListener('click',() => {
                document.querySelector(".formulaire_avantages").setAttribute('style',"border:none;")
                ajoutButton.setAttribute ('style','display:block')
                formAjout.remove()
            })
            
        });
       document.querySelector('.EnvoyerFormulaire').addEventListener('click',() => {
            let lesAvantages = []
            let listeDeFichiersNegliges = []
            document.querySelectorAll('.liste_avantages input').forEach(element => {
                if (element['checked']) {
        lesAvantages.push(element['name'])}
       }); 
       try {
        fichiers_non_conserves_finalement.forEach(element => {
        listeDeFichiersNegliges.push(element['A_negliger'])
       });
       let fichiers_non_maintenus = document.createElement('input:text')
       fichiers_non_maintenus.innerHTML = '<input type:"text" name="fichiers_non_maintenus" value="'+listeDeFichiersNegliges+'" style="display:none;">'
       document.querySelector(".formulaire_enregistrement_logement").append(fichiers_non_maintenus)

       } catch (error) {
        
       }

       let avantages_cochees = document.createElement('input:text')
       avantages_cochees.innerHTML = '<input type:"text" name="lesAvantages" value="'+lesAvantages+'" style="display:none;">'
       document.querySelector(".formulaire_enregistrement_logement").append(avantages_cochees)

        })
    </script>
</body>
</html>
        <?php 
        } else {
            reconnexion_ou_non ("../users/login.php","./modification.php?id=$id");
           }
    }     elseif ($methode === "POST") {
        
            $id = $_SESSION["id_logement"];
            $lesImages_logements = $_FILES['images'];
        $titre = filter_input(INPUT_POST,'titre');
        $description = filter_input(INPUT_POST,'description');
        $localisation = filter_input(INPUT_POST,'localisation');
        try {
            $capacity = (int) filter_input(INPUT_POST,'capacity');
            $price = (int) filter_input(INPUT_POST,'price');
            $remise = (double) filter_input(INPUT_POST,'remise');
            
        } catch (\Throwable $th) {
            $_SESSION["donnees_justes"] = false;
            $_SESSION["Error_message"] = "Désolé, une erreur s'est produite \nVeuillez remplir à nouveau et soigneusement le formulaire.";
           return header("location:./modification.php?id=$id");
        }

        $arrondissement = (int) filter_input(INPUT_POST,'arrondissement');

        $lesAvantages = filter_input(INPUT_POST,'lesAvantages');
        $noms_de_fichiers_non_maintenus = explode(',',filter_input(INPUT_POST,'fichiers_non_maintenus'));
        if (strlen($titre)< 3 || strlen($localisation)< 3 ||  sizeof($lesImages_logements)===0) {
            $_SESSION["donnees_justes"] = false;
            $_SESSION["Error_message"] = "Désolé, une erreur s'est produite \nVeuillez remplir à nouveau et soigneusement le formulaire.";
           return header("location:./modification.php?id=$id");
        } else {
            $pdo = connexion_BDD();

            # Les détails
            $requete_1 = $pdo->prepare(recuperer_requete ("..","modification de logement","Mise à jour des details du logement modifie"));

            if ($arrondissement === 0) {
                $arrondissement = $_SESSION["position?"];
            }

            $requete_1 ->execute([
                ":name" => $titre ,
                ":id" => $id ,
                ":position" => $arrondissement,
                ":address" => $localisation,
                ":capacity" => $capacity,
                ":price" => $price,
                ":discount" => $remise,
                ":description" => $description
            ]);

            // var_dump($lesImages_logements["name"][0]);
            # Les images 
            if ($lesImages_logements["name"][0]!== "")
            {

                foreach (explode(',',$_SESSION["anciennes_images"]) as $key => $value) {
                    unlink("./images_logements/$value") ;
                }
                $requete_0 =  $pdo->prepare(recuperer_requete ("..","modification de logement","Suppression des anciennes images du logement modifie"));
                $requete_0 ->execute([
                    ":housing_id" => $id
                ]);

                 foreach ($lesImages_logements['name'] as $key => $value) {
                if (! in_array($value,$noms_de_fichiers_non_maintenus))
                {
                    
                $tmpName = $lesImages_logements['tmp_name'][$key];
                $name = $id.'/'.($key+1).'_'.$lesImages_logements['name'][$key];
                $size = $lesImages_logements['size'][$key];
                $error = $lesImages_logements['error'][$key];
                if (!is_dir('./images_logements/'.$id)) {
                    mkdir('./images_logements/'.$id,777);
                }
                                
                move_uploaded_file($tmpName, './images_logements/'.$name);
                $requete_2 = $pdo->prepare(recuperer_requete ("..","modification de logement","Enregistrement des nouvelles images du logement modifie"));
                $requete_2 ->execute([
                    ":housing_id" => $id ,
                    ":url" => $name
                ]);
                }}
            }

            # les avantages 
            $requete_3 = $pdo->prepare(recuperer_requete ("..","modification de logement","Mise à jour des avantages du logement modifie"));
            $requete_3->execute([
                ":housing_id" => $id ,
                ":content" => $lesAvantages
            ]);
            return header("location:./dashboard.php?update_titre=$titre");
        }
    }   
