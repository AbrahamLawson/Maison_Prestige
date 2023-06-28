<?php
    function connexion_BDD () {
        $pdo =  new PDO("mysql:host=localhost:3306;dbname=groupe4","root","");
        return $pdo;
}