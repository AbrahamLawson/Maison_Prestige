<?php
function recuperer_requete ($relative_ext,$groupe,$requete) {
 
    $requetes = json_decode(file_get_contents("$relative_ext/requetesSQL.json"));
    return $requetes->{$groupe}->{$requete};
}