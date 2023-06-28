<?php
function enregistrementMessage( $sender_id, $booking_id,$pdo ) {
    $methode = filter_input(INPUT_SERVER, "REQUEST_METHOD");
    if ($methode==="POST") {
        $contenu = filter_input(INPUT_POST,'contenu');
        if(strlen($contenu)>0){
            $insertContenu = $pdo->prepare("INSERT INTO `messages` (booking_id,sender_id,content) VALUES (:bk_id,:sd_id,:content)");
            $insertContenu->execute([
                ":bk_id" => "$booking_id",
                ":sd_id" => "$sender_id" ,
                ":content" => "$contenu"
            ]);  
        }
    }
}


