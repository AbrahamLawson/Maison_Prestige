<?php
   $methode = filter_input(INPUT_SERVER, "REQUEST_METHOD");
   require '../session_start.php';
   require '../bdd_connect.php';
   require "../recuperer_Requete.php";
   session_start_prim ();

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://kit.fontawesome.com/c4254e24a8.js" crossorigin="anonymous"></script>
    <title>Les comptes</title>
    <style>
        <?php
            require "./style/style_accounts.css";
            require "./style/header_style.css";
            require '../footer.css';
?>
    </style>
</head>
<body>
<?php
    include('header2.php');

   if ($methode==="GET") {
    $sup_name = filter_input(INPUT_GET,'sup_name');
    $react_name = filter_input(INPUT_GET,'react_name');
    $des_name = filter_input(INPUT_GET,'des_name');
    $role = filter_input(INPUT_GET,'role');
    $name = filter_input(INPUT_GET,'name');
    require "./verification_token.php";
    if (isset($_SESSION['individu_connecte']['role']) && ($_SESSION['individu_connecte']['role'] == "admin" || $_SESSION['individu_connecte']['role']== "sudo")) {

        if (strlen($sup_name)>0) {
            ?>
    <pre style="background:black; color:white; padding:1vh"><?="Le compte de << $sup_name >> supprimé avec succes."?></pre>
            
            <?php
        }

        if (strlen($react_name)>0) {
            ?>
    <pre style="background:black; color:white; padding:1vh"><?="Le compte de << $react_name >> reactivé avec succes."?></pre>
            
            <?php
        }

        if (strlen($des_name)>0) {
            ?>
    <pre style="background:black; color:white; padding:1vh"><?="Le compte de << $des_name >> désactivé avec succes."?></pre>
            
            <?php
        }

        if (strlen($role)>0 && strlen($name)>0) {
            ?>
    <pre style="background:black; color:white; padding:1vh"><?="Le role << $role >> vient d'être attribué au compte de << $name >>."?></pre>
            
            <?php
        }
        ?>
        <div class="banner">
        <h1>GESTION DES COMPTES DE BAS NIVEAUX</h1>
        </div>
        <br>
        <?php
        $pdo = connexion_BDD ();
        $requete = $pdo->prepare(recuperer_requete ("..","Comptes utilisateurs","Tous les comptes sauf le sudos"));
        $requete->execute();
        $resultat = $requete->fetchAll(PDO::FETCH_ASSOC);
        foreach ( $resultat as $comptes) {
            $nom = $comptes['first_name'].' '.$comptes['last_name'];

            if ($comptes['role'] != "admin" && $comptes['role']!= "sudo") {
            ?>
            <div class="containerr">
             <fieldset style="background-color: #ffffff;border: 1px solid #000;padding: 10px;position: relative;margin : 1vh  ;" class="field_compte<?=$comptes['id'];?>" onmouseout="dis_options(<?=$comptes['id'];?>)">
                <legend style="background-color: #000;color: #fff;padding: 3px 6px;" ><?=$nom?></legend>
                            
                <p>Role : <span style="background:yellow;color:black;padding:5px; border-radius:3px; font-size:20px;"><?=$comptes['role'];?> </span> </p>
                <span class="option_compte_id<?=$comptes['id'];?>" onmouseover="options(<?=$comptes['id'];?>,'<?=$comptes['role'];?>','<?=$nom?>',<?=$comptes['active'];?>)" >
                    <input type="button" class="option<?=$comptes['id'];?>" value="..."  style="border-radius:3px; padding:1px 2px;border:none;font-size:30px;" >
                </span>
                <?php
                if ($comptes['active']===1){
                    ?>
                    <br><br>
                    <span style="background-color: yellowgreen;color: #fff;padding: 3px 6px;padding:5px; border-radius:3px; font-size:20px;" >Compte Actif</span>
                    <?php
                } else {
                    ?>
                    <br><br>
                    <span style="background-color: red ;color: white;padding: 3px 6px;padding:5px; border-radius:3px; font-size:20px;" >Compte Inactif</span>
                    <?php
                }
?>
              
            </fieldset>
            </div>
                <br>
            <?php
        } else {
            if ($_SESSION['individu_connecte']['role']=="sudo" && $comptes['role'] == "admin") {
                ?>
                <div class="containerr">
                 <fieldset style="background-color: #ffffff;border: 1px solid #000;padding: 10px;position: relative;margin : 1vh  ;" class="field_compte<?=$comptes['id'];?>" onmouseout="dis_options(<?=$comptes['id'];?>)">
                    <legend style="background-color: #000;color: #fff;padding: 3px 6px;" ><?=$nom?></legend>
                                
                    <p>Role : <span style="background:yellow;color:black;padding:5px; border-radius:3px; font-size:20px;"><?=$comptes['role'];?> </span> </p>
                    <span class="option_compte_id<?=$comptes['id'];?>" onmouseover="options(<?=$comptes['id'];?>,'<?=$comptes['role'];?>','<?=$nom?>',<?=$comptes['active'];?>)" >
                        <input type="button" class="option<?=$comptes['id'];?>" value="..."  style="border-radius:3px; padding:1px 2px;border:none;font-size:30px;" >
                    </span>
                    <?php
                    if ($comptes['active']===1){
                        ?>
                        <br><br>
                        <span style="background-color: yellowgreen;color: #fff;padding: 3px 6px;padding:5px; border-radius:3px; font-size:20px;" >Compte Actif</span>
                        <?php
                    } else {
                        ?>
                        <br><br>
                        <span style="background-color: red ;color: white;padding: 3px 6px;padding:5px; border-radius:3px; font-size:20px;" >Compte Inactif</span>
                        <?php
                    }
    ?>
                  
                </fieldset>
                </div>
                    <br>
                <?php
      
            }

        }
    }

        ?>
            <a href="./dashboard.php"><button>Retour</button></a>

                <div class="footer">
          <a href="https://facebook.com/"><i class="fab fa-facebook-f"></i></a>
          <a href="https://youtube.com/"><i class="fab fa-youtube"></i></a>
          <a href="https://twitter.com/"><i class="fab fa-twitter"></i></a>
          <a href="https://linkedin.com/"><i class="fab fa-linkedin-in"></i></a>
          <a href="https://instagram.com/"><i class="fab fa-instagram"></i></a>
          <hr>
      </div>
    </body>

    <script>
                function are_you_sure(url,action) {
                    if (confirm("Vous êtes sûr de vouloir "+ action +"?")) {
                        window.location=url
                    }
                }

                function dis_options_ACTION (id) {
                    let conteneurDes_options = document.querySelector(".option_compte_id"+id)
                            conteneurDes_options.setAttribute("style","border:0px none")
                            conteneurDes_options.replaceChildren("")
                            let optionButton = document.createElement('input:button')
                            optionButton.setAttribute("class","option"+id)
                            optionButton.innerHTML = '<input type="button" class="option'+id+'" value="..."  style="border-radius:3px; padding:1px 2px;border:none;font-size:30px;">'
                            conteneurDes_options.append(optionButton)
                }

                function dis_options(id) {
                    onmouseover = (elem) =>{
        if ((elem.srcElement.tagName == "BODY")) {
            dis_options_ACTION (id)
        } else if ((elem.srcElement.tagName == "FIELDSET")) {
            if (elem.srcElement.className != "field_compte"+id) {
                dis_options_ACTION (id)
            }
        }}
    }
         
            

                function options(id,role_user,nom,activite) {
                    
                if (document.querySelector("input.changerRole")===null) 

                   { let conteneurDes_options = document.querySelector(".option_compte_id"+id)
                    conteneurDes_options.setAttribute("style","padding:3px;")
                   
                    let pp =  document.createElement('p')

                    let optionButton = document.querySelector(".option"+id)

                    let buttonChangerRole = document.createElement('input:button')
                    let buttonDesactiverCompte = document.createElement('input:button')
                    let buttonSupprimercompte = document.createElement('input:button')

                    buttonChangerRole.setAttribute("class","changerRole")
                    if (activite===1)
                    {
                        buttonDesactiverCompte.setAttribute("class","desactiverCompte")
                    }
                    else {
                        buttonDesactiverCompte.setAttribute("class","reactiverCompte")
                    }
                    buttonSupprimercompte.setAttribute("class","supprimerCompte")

                    buttonChangerRole.innerHTML = "<input type='button'  style='width:120px;' class='changerRole' value ='Changer le role' >"   
                    if (activite===1)
                    {
                       buttonDesactiverCompte.innerHTML = `<input type='button' style="width:120px;background:#8F3D4C;color:#FFBD99;" class='desactiverCompte' value ='Desactiver' onclick='are_you_sure("./admin_account_actions/desactivation.php?id=${id}&nom=${nom}","désactiver ce compte")'>`
                    }
                    else {
                        buttonDesactiverCompte.innerHTML = `<input type='button' style="width:120px;background:#8F3D4C;color:#FFBD99;" class='reactiverCompte' value ='Reactiver' onclick='are_you_sure("./admin_account_actions/reactivation.php?id=${id}&nom=${nom}","reactiver ce compte")'>`
                    }

                    buttonSupprimercompte.innerHTML = `<input type='button' style="width:120px;background:red;color:white;"  class='supprimerCompte' value ='Supprimer' onclick='are_you_sure("./admin_account_actions/suppression.php?id=${id}&nom=${nom}","supprimer ce compte")'>`
                    buttonChangerRole.setAttribute("onclick","")
                    pp.append(buttonChangerRole)
                    pp.append(buttonDesactiverCompte)
                    pp.append(buttonSupprimercompte)
                    conteneurDes_options.append(pp)
                    optionButton.remove()


                    let ChangerRole = document.querySelector("input.changerRole")
                    let DesactiverCompte = document.querySelector("input.desactiverCompte")
                    if (activite===1)
                    {
                        DesactiverCompte = document.querySelector("input.desactiverCompte")
                    }
                    else {
                        DesactiverCompte = document.querySelector("input.reactiverCompte")
                    }

                    let Supprimercompte = document.querySelector("input.supprimerCompte")
             
                    ChangerRole.addEventListener("click",() =>{
                        if (document.querySelector("span.identificateur")===null)
                        {
                            let span = document.createElement('span')
                        const roles = ["customer","management","maintenance","logistic","admin"]
                        
                        roles.map((role,index) => {
                            if (role_user != role) {
                                if (role != "admin" && role_user != "sudo") { // On n'affiche pas le compte de sudo à un admin ni des admins à un de leur collègue.
                                    let role_current = document.createElement('input:button')
                                role_current.setAttribute("class",`change_role${index}`) 
                                role_current.innerHTML = `<input type='button' style='width:120px;' class='change_role${index}' value ="${role}" >`
                                let p =  document.createElement('p')
                                p.setAttribute("class","pppppp")
                                p.append(role_current)
                                pp.append(p)
                                let action_role = document.querySelector("input.change_role"+index)
                                action_role.setAttribute("onclick",`are_you_sure("./admin_account_actions/changeRole.php?id=${id}&role=${role}&nom=${nom}","lui affecter le role: ${role}")`)
                                } else {
                                    const sudo = "sudo"
                                    if (sudo == <?=$_SESSION['individu_connecte']['role']?>) { //Par contre le sudo peut agir sur un compte admin et définir des admins
                                        let role_current = document.createElement('input:button')
                                        role_current.setAttribute("class",`change_role${index}`) 
                                        role_current.innerHTML = `<input type='button' style='width:120px;' class='change_role${index}' value ="${role}" >`
                                        let p =  document.createElement('p')
                                        p.setAttribute("class","pppppp")
                                        p.append(role_current)
                                        pp.append(p)
                                        let action_role = document.querySelector("input.change_role"+index)
                                        action_role.setAttribute("onclick",`are_you_sure("./admin_account_actions/changeRole.php?id=${id}&role=${role}&nom=${nom}","lui affecter le role: ${role}")`)

                                    }
                                    let identificateur = document.createElement('span')
                                identificateur.setAttribute("class",`identificateur`) 
                                identificateur.setAttribute("style",`display:none;`) 
                                let p =  document.createElement('p')
                                p.setAttribute("class","pppppp")
                                p.append(identificateur)
                                pp.append(p)
                                }} 
                        })  
                    }
                });

                    DesactiverCompte.addEventListener("mouseout",() =>{
                            document.querySelectorAll("p.pppppp").forEach ((element)=>{
                       element.remove()
                   }) })

                        Supprimercompte.addEventListener("mouseout",() =>{
                            document.querySelectorAll("p.pppppp").forEach ((element)=>{
                       element.remove()
                   }) })
 
                    }}

            </script>
            </html>
        <?php

} else {
    reconnexion_ou_non ("../users/login.php","./accounts.php?sup_name=$sup_name&react_name=$react_name&des_name=$des_name&role=$role&name=$name");
   }
   }  
?>