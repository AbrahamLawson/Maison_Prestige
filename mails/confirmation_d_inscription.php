<?php
function confirmation_inscription ($ext,$adresse_mail) {
    require "$ext/envoie_email.php";

$contenu = "<div style='color:black;background:yellowgreen'><h1>Confirmation d'Inscription</h1>\
<p>Bonjour! Merci de vous être inscrit chez <strong>MAISON PRESTIGE PARIS </strong>. Nous sommes ravis de vous accueillir dans notre communauté. Nous vous enverrons des mises à jour régulières sur les offres et les promotions à venir. Merci encore pour votre inscription!</p></div>";

echo envoie_de_Mail($adresse_mail,"Confirmation d'inscription",$contenu);
}
