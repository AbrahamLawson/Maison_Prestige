<?php
function confirmation_de_reservation ($ext,$adresse_mail,$dateEntre,$dateSortie,$nomLogement) {
    require "$ext/envoie_email.php";

$contenu = "<div style='color:black;background:yellowgreen'><h1>Confirmation d'Inscription</h1>\
<p>Bonjour! Nous sommes ravis de confirmer votre réservation à <strong>$nomLogement</strong> chez <strong>MAISON PRESTIGE PARIS </strong>. Votre réservation est confirmée pour les dates suivantes: $dateEntre  à $dateSortie. Nous vous remercions de votre confiance et avons hâte de vous accueillir. Si vous avez des questions ou des préoccupations, n'hésitez pas à nous contacter. Merci encore pour votre réservation!</p></div>";

echo envoie_de_Mail($adresse_mail,"Confirmation de Réservation",$contenu);
}
