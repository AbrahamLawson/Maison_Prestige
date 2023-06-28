<?php
function MiseAJourReservation ($ext_chemin_relatif,$pdo) {
    $requete_1 = $pdo->prepare(recuperer_requete ($ext_chemin_relatif,"Réservation","1er Mise à jour des status des résevations"));
    $requete_1->execute();

    $requete_2 = $pdo->prepare(recuperer_requete ($ext_chemin_relatif,"Réservation","2ème Mise à jour des status des résevations"));
    $requete_2->execute();
}