<?php
   require '../bdd_connect.php';
   require "../recuperer_Requete.php";
   require '../session_start.php';
   session_start_prim ();
   require "../users/verification_token.php";

   $pdo = connexion_BDD ();
function recupereteurMessages($booking_id,$pdo) {
    $showMessage = $pdo->prepare(recuperer_requete ("..","Messages","Récuperer les 10 derniers messages"));
$showMessage->execute([
    ":booking_id" => "$booking_id"
]);
$resultats = $showMessage ->fetchAll(PDO::FETCH_ASSOC);
?>
<link rel="stylesheet" href="./style.css">
<?php
if (count($resultats) == 0) {
    echo '<div class="msg"> Aucun Message à afficher </div><br>';
} else {
   foreach ($resultats as $key => $message) {
    if ($message['id']==$_SESSION['individu_connecte']['id']) {
        ?>
        <div class="message Expediteur">
            <h4>Vous:</h4>
            
        <?=$message['content']?><hr>
        Le <strong><?=date('d/m/Y',strtotime($message['date']))?></strong> à <strong><?= date('H:i:s',strtotime($message['date']))?></strong>
        </div>
            <?php
    } else {
        ?>
        <div class="message Destinataire">
            <h4><?=$message['first_name']." ".$message['last_name']." (".$message['role'].")"?>:</h4>
            
            <?=$message['content']?> <hr>
            Le <strong><?=date('d/m/Y',strtotime($message['date']))?></strong> à <strong><?= date('H:i:s',strtotime($message['date']))?></strong>
        
          
        </div>
            <?php
    }

    }
}

}

$booking_id = filter_input(INPUT_GET,'booking_id');

recupereteurMessages($booking_id,$pdo);
?>
