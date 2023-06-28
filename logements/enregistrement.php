<?php
    $methode = filter_input(INPUT_SERVER, "REQUEST_METHOD");
    require '../session_start.php';
    require '../bdd_connect.php';
    require "../recuperer_Requete.php";

    session_start_prim ();
   require "../users/verification_token.php";
       if (isset($_SESSION['individu_connecte']['role']) && ($_SESSION['individu_connecte']['role'] == "management")|| $_SESSION['individu_connecte']['role']== "sudo") {
    ?>
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://kit.fontawesome.com/c4254e24a8.js" crossorigin="anonymous"></script>
        <title>Enregistrement de logement</title>
        <style>
            <?php
              require "./style/header_style.css";
            require "./style/style_commun.css";
            require "./style/autre_style.css";
                        require '../footer.css';
            ?>
            
        </style>

    </head>
    <body>
        <?php
        include('header2.php');
        ?>
<br>
        <?php
            if ($methode==="GET")
            {?>
            <form action="./enregistrement.php" method="post" class="formulaire_enregistrement_logement" enctype="multipart/form-data">
                        <?php 
                if (isset($_SESSION["donnees_justes"]) && $_SESSION["donnees_justes"] ===false) {
                    ?>
                    <pre style="background:#FAA; color:red; padding:1vh">OUPS!!!!!!!! <?= $_SESSION["Error_message"] ?></pre>
                    <?php
                }
    ?>

        <div class="containerr">
       <div class="banner">
       <h1>ENREGISTREMENT D'UN LOGEMENT</h1>
     </div>
    <div class="image-container">
           <ul id="images-list">
               
           </ul>
         </div>
         <input  style = " display:block;width:290px;color:#8F3D4C;font-weight:bold; border-radius:5px;height:40px; font-size:17px;background:#FFBD99;" type="button" id="buttonAjouterImage" onclick="document.querySelector('#ajout_images').click()" value="Importer une ou plusieurs photos">
         <input type="file" name="images[]" multiple accept="image/*" onchange="previewImages(event)" id="ajout_images" style="display:none" required>
         <div class = "br"></div>
         <div class = "bb">
         <label  for="titre">Titre :</label>
         <div class = "br"></div>
         <input type="text" name="titre" id="titre" required>
         <div class = "br"></div>
         <label for="description">Description :</label>
         <div class = "br"></div>
         <textarea name="description" id="description" class="description"  required ></textarea>
         <div class = "br"></div>
         <label for="localisation">Adresse :</label>
         <div class = "br"></div>
         <input type="text" name="localisation" id="localisation" required>
        <div class = "br"></div>
         <label for="arrondissement">Arrondissement :</label>
         <div class = "br"></div>
         <select name="arrondissement" id="arrondissement" required>
           <option value="">- Choisissez l'arrondissement -</option>
           <option value="1">1er Arrondissement</option>
           <option value="2">2eme Arrondissement</option>
           <option value="3">3eme Arrondissement</option>
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
        <div class = "br"></div>
         <label for="capacity">Capacité (nombre de personnes) :</label>
         <div class = "br"></div>
         <input type="number" name="capacity" id="capacity">
        <div class = "br"></div>
         <label for="price">Prix :</label>
         <div class = "br"></div>
         <input class="price" type="number" name="price" id="price" required>
       <div class = "br"></div>
         <label for="remise">Remise :</label>
         <div class = "br"></div>
         <input class="remise" type="text" name="remise" id="remise" value="0">
        <div class = "br"></div>
         <h2>Avantages :</h2>
         <ul class="liste_avantages">
         <li>
             <label for="piscine">Piscine </label>   
             <input type="checkbox" name="Piscine" id="piscine"> 
         </li>
         <li>
             <label for="ascenseur">Ascenseur </label>   
             <input type="checkbox" name="Ascenseur" id="ascenseur"> 
         </li>
         <li>
             <label for="terrace">Terrace </label>   
             <input type="checkbox" name="Terrace" id="terrace"> 
         </li>
         <li>
             <label for="jardin">Jardin </label>   
             <input type="checkbox" name="Jardin" id="jardin"> 
         </li>
         </ul>
         <div class="formulaire_avantages"></div>
         <input type="button" class="ajout_avantages_button" value="Ajouter">
         <br>
         <input type="submit" value="Envoyer" class="EnvoyerFormulaire">
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
        $_SESSION["donnees_justes"] = true;
        ?>
        <script>
            let fichiers_non_conserves_finalement = {}
                function previewImages(event)
        {   try {
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
                           
            
                        });
                        
                        let previewName = document.createElement('p');
                        previewName.innerText =fichier.name;

                        let previewNameOverlay = document.createElement('span');
                        previewNameOverlay.classList.add('preview-name-overlay');

                        let previewNamecontainer = document.createElement('div');
                        previewNamecontainer.classList.add('preview-name-container');
                        previewNamecontainer.appendChild(previewName);
                        previewNamecontainer.appendChild(previewNameOverlay);

                        let previewHeader = document.createElement('header');
                        previewHeader.appendChild(previewNamecontainer);
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
        let outputdata = document.querySelector('output')
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
            })

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
       fichiers_non_conserves_finalement.forEach(element => {
        listeDeFichiersNegliges.push(element['A_negliger'])
       });
       let avantages_cochees = document.createElement('input:text')
       avantages_cochees.innerHTML = '<input type:"text" name="lesAvantages" value="'+lesAvantages+'" style="display:none;">'
       document.querySelector(".formulaire_enregistrement_logement").append(avantages_cochees)
       
       let fichiers_non_maintenus = document.createElement('input:text')
       fichiers_non_maintenus.innerHTML = '<input type:"text" name="fichiers_non_maintenus" value="'+listeDeFichiersNegliges+'" style="display:none;">'
       document.querySelector(".formulaire_enregistrement_logement").append(fichiers_non_maintenus)
       
        })
    </script>
        <?php }
    elseif ($methode === "POST") {
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
           return header("location:./enregistrement.php");
        }

        $arrondissement = (int) filter_input(INPUT_POST,'arrondissement');

        $lesAvantages = filter_input(INPUT_POST,'lesAvantages');
        $noms_de_fichiers_non_maintenus = explode(',',filter_input(INPUT_POST,'fichiers_non_maintenus'));
        if ($arrondissement===0 || strlen($titre)< 3 || strlen($localisation)< 3 ||  sizeof($lesImages_logements)===0) {
            $_SESSION["donnees_justes"] = false;
            $_SESSION["Error_message"] = "Désolé, une erreur s'est produite \nVeuillez remplir à nouveau et soigneusement le formulaire.";
           return header("location:./enregistrement.php");
        } else {
            $pdo = connexion_BDD();

            # Les détails
            $requete_1 = $pdo->prepare(recuperer_requete ("..","enregistrement de logement","enregistrement details"));
            $requete_1->execute([
                ":name" => $titre ,
                ":position" => $arrondissement,
                ":address" => $localisation,
                ":capacity" => $capacity,
                ":price" => $price,
                ":discount" => $remise,
                ":description" => $description
            ]);
            $requete_0 = $pdo->prepare(recuperer_requete ("..","les logements","nombre de logements enregistres"));
            $requete_0->execute();
            $resultat_0 = $requete_0 ->fetchAll(PDO::FETCH_ASSOC);
            $id = $resultat_0[0]['nbr_logement'];
            # Les images 
            foreach ($lesImages_logements['name'] as $key => $value) {
                if (! in_array($value,$noms_de_fichiers_non_maintenus))
                {
                $tmpName = $lesImages_logements['tmp_name'][$key];
                $name = $id.'/'.($key+1).'_'.$lesImages_logements['name'][$key];
                $size = $lesImages_logements['size'][$key];
                $error = $_lesImages_logements['error'][$key];
                if (!is_dir('./images_logements/'.$id)) {
                    mkdir('./images_logements/'.$id,0777);
                }
                move_uploaded_file($tmpName, './images_logements/'.$name);

                $requete_2 = $pdo->prepare(recuperer_requete ("..","enregistrement de logement","enregistrement images"));
                $requete_2->execute([
                    ":housing_id" => $id ,
                    ":url" => $name
                ]);

                }
            }

            # les avantages 
            $requete_3 = $pdo->prepare(recuperer_requete ("..","enregistrement de logement","enregistrement avantages"));
            $requete_3->execute([
                ":housing_id" => $id ,
                ":content" => $lesAvantages
            ]);

            return header("location:./dashboard.php?new_titre=$titre");
        }


        ?>
        <?php }   } else {
    reconnexion_ou_non ("../users/login.php","./dashboard.php?sup_titre=$sup_titre");
   }
    ?>
    </body>

    </html>