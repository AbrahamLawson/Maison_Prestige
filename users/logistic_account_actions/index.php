
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard logistique</title>
    <link rel="stylesheet" href="./styles/calendar.css">
    <link rel="stylesheet" href="./styles/logistic.css">
    <link rel="stylesheet" href="../style/header_style.css">
</head>

<body>
<?php
    require_once "_logistic.php";
    require '../../session_start.php';
   session_start_prim ();
   require "../verification_token.php";
   require "../../recuperer_Requete.php";
   require "../../miseAjour_statut_booking.php";
   MiseAJourReservation ("../..",$pdo);

if (isset($_SESSION['individu_connecte']['role']) && ($_SESSION['individu_connecte']['role'] == "logistic") || $_SESSION['individu_connecte']['role']== "sudo") {
 
?>

<div style = "background-color: #8F3D4C; color: #FFBD99; padding: 10px; text-align: center; margin-top: 0px; border-radius: 5px;">
       <h1>TABLEAU DE MAINTENANCE</h1>
</div>
     <br>
    <div class="maintenance-dashboard">
        <div class="dashboard-left">
            <div class="column-container">
                <div class="small-container alert">
                    <h3>Alertes</h3>
                    <?php if (count($maintenanceList["alerts"]) === 0) : ?>
                        <p>Aucune alerte</p>
                    <?php else : ?>
                        <?php foreach($maintenanceList["alerts"] as $maintenance) : ?>
                            <a href="#" onclick="openMaintenanceInfos(<?= $maintenance['id'] ?>)">
                                <div class="card">
                                    <div class="card-tag">
                                       <h4>Entretien <?= $maintenance["id"] ?></h4> 
                                    </div>
                                    <div class = "card-content">
                                        <p><strong>Identifiant du logement :</strong> <?= $maintenance["housing_id"] ?></p>
                                        <p><strong>Date de la location :</strong> <?= $maintenance["team_id"] ?></p>
                                        <p>Date prévue pour l'entretien : <?= $maintenance["maintenance_date"] ?></p>
                                        <p>Équipe en charge : <?= $maintenance["team_id"] ?></p>
                                    </div>
                                </div>
                            </a>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
                <div class="medium-container">
                    <h3>Listes des entretiens à organiser</h3>
                    <?php if (count($maintenanceList["to define"]) === 0) : ?>
                        <p>Aucune entretien à plannifier</p>
                    <?php else : ?>
                        <?php foreach($maintenanceList["to define"] as $maintenance) : ?>
                            <a href="#" onclick="openMaintenanceInfos(<?= $maintenance['id'] ?>)">
                                <div class="card">
                                    <div class="card-tag">
                                       <h4>Entretien <?= $maintenance["id"] ?></h4> 
                                    </div>
                                    <div class = "card-content">
                                        <p><strong>Identifiant du logement :</strong> <?= $maintenance["housing_id"] ?></p>
                                        <p><strong>Date de la location :</strong> <?= $maintenance["team_id"] ?></p>
                                        <p>Date prévue pour l'entretien : <?= $maintenance["maintenance_date"] ?></p>
                                        <p>Équipe en charge : <?= $maintenance["team_id"] ?></p>
                                    </div>
                                </div>
                            </a>
                        <?php endforeach; ?>
                    <?php endif; ?>
                    <h3>Listes des entretiens à venir</h3>
                    <?php if (count($maintenanceList["defined"]) === 0) : ?>
                        <p>Aucune entretien plannifié</p>
                    <?php else : ?>
                        <?php foreach($maintenanceList["defined"] as $maintenance) : ?>
                            <a href="#" onclick="openMaintenanceInfos(<?= $maintenance['id'] ?>)">
                                <div class="card">
                                    <div class="card-tag">
                                       <h4>Entretien <?= $maintenance["id"] ?></h4> 
                                    </div>
                                    <div class = "card-content">
                                        <p><strong>Identifiant du logement :</strong> <?= $maintenance["housing_id"] ?></p>
                                        <p><strong>Date de la location :</strong> <?= $maintenance["team_id"] ?></p>
                                        <p>Date prévue pour l'entretien : <?= $maintenance["maintenance_date"] ?></p>
                                        <p>Équipe en charge : <?= $maintenance["team_id"] ?></p>
                                    </div>
                                </div>
                            </a>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
                <div class="large-container">
                    <h3>Listes des logements</h3>
                    <?php foreach($housingList as $housing) : ?>
                        <a href="#" onclick="openHousingInfos(<?= $housing['id'] ?>)">
                            <div class="card">
                                <div class="card-tag">
                                    <h4>Logement <?= $housing["id"] ?></h4> 
                                </div>
                                <div class = "card-content">
                                    <h4><?= $housing["name"] ?>, <em><?= $housing["position"] ?></em></h4>
                                    <p><em><?= $housing["address"] ?></em></p>
                                </div>
                            </div>
                        </a>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
        <div class="dashboard-right">
            <div class="column-container">
                <div class="large-container">
                    <h3>Listes des équipes d'entretien</h3>
                    <?php foreach($teamList as $team) : ?>
                        <div class="team-container">
                            <table class="team-table">
                                <thead>
                                    <tr>
                                        <th colspan="2">Équipe <?= $team["id"]?></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if (count($team["members"]) === 0) : ?>
                                        <tr>
                                            <td>Aucun membre</td>
                                        </tr>
                                    <?php else : ?>
                                        <?php foreach($team["members"] as $member) : ?>
                                            <tr>
                                                <td><?= $member["id"] ?></td>
                                                <td><?= $member["first_name"] . " " . strtoupper($member["last_name"]) ?></td>
                                            </tr>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                    
                                </tbody>
                            </table>
                            <button onclick="deleteTeam(<?= $team['id']?>)">
                                Supprimer l'Équipe
                            </button>
                        </div>
                    <?php endforeach; ?>

                    <button class="form-submit" onclick="addTeam()">
                        Ajouter une nouvelle Équipe
                    </button>
                </div>
                <div class="large-container">
                    <input class="search-bar" type="text" id="searchInput" name="searchInput" placeholder="Rechercher quelqu'un..." onkeyup="doSearch()" />
                </div>
            </div>
        </div>
    </div>
    <br>
    <a href="../dashboard.php"><button style="margin: 0px 1vw; background-color:#FFBD99; color: #8F3D4C; font-weight: bold; font-family: 'Californian FB'; border-radius: 5px; font-size: medium; padding: 5px;">Retour au profile</button></a>
    
    <script src="./script/calendar.js"></script>
    <script src="./script/logistic.js"></script>

</body>

</html>
<?php
   } else {
    reconnexion_ou_non ("../login.php","./index.php");
   }
?>