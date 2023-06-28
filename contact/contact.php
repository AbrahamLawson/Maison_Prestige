<?php
   require '../session_start.php';
   session_start_prim ();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Logement
    </title>
    <link rel="stylesheet" href="./style/contact.css">

    <style>
      <?php
        require './style/header_style.css';
      ?>
    </style>
</head>
<body>
<?php
    include("header.php")
    ?>
    
    <div class="banner">
        <h1>Nous Contacter</h1>
      </div>

      <div class="container">
        <label for="subject">Objet :</label>
        <input type="text" id="subject" placeholder="Entrez le sujet de l'e-mail" required>

        <label for="message">Message :</label>
        <textarea id="message" placeholder="Entrez votre message" required></textarea>

        <button onclick="sendEmail()">Envoyer</button>

        <div class="status-message" id="statusMessage"></div>
    </div>

    <div class="localise">

    <img src="../medias/images/localisation.jpg" alt="">

    </div>

    <div class="desc">
    <h2 style="text-align:center;">Coordonné</h2> 

    <p> <img src="../medias/images/immeuble.png" alt=""> 1 rue Général de Gaulle Fontenay <br>sous bois</p>
            <p> <img src="../medias/images/portable.png" alt=""> +1 (223) 04 69 87 74 302</p>
            <p> <img src="../medias/images/mail.png" alt=""> Contact@maison_prestige.com</p>




    </div>
</body>
<script>
    function sendEmail() {
            const to = "Contact@maison_prestige.com";
            const subject = document.getElementById('subject').value;
            const message = document.getElementById('message').value;

            const mailtoLink = `mailto:${to}?subject=${encodeURIComponent(subject)}&body=${encodeURIComponent(message)}`;

            window.location.href = mailtoLink;

            document.getElementById('statusMessage').innerHTML = 'E-mail envoyé avec succès !';
            document.getElementById('statusMessage').classList.add('success');
            document.getElementById('statusMessage').style.display = 'block';
        }
    </script>
</script>
</html>