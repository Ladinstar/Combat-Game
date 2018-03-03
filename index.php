<?php
    require_once "Class/Personnage.class.php";
    require_once "Class/PersonnageManager.class.php";

    define("host","mysql:host=localhost;dbname=POO");
    define("user","root");
    define("password","");


    $db = new PDO('mysql:host=localhost;dbname=POO', 'root', '');
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING); // On émet une alerte à chaque fois qu'une requête a échoué.


    $manager = New PersonnagesManager($db);

    $perso = New Personnage(array("nom"=>"Avaika","degats"=>40));
    $perso2 = New Personnage(array("nom"=>"Serge","degats"=>60));

    $manager->add($perso);
    $manager->add($perso);

    var_dump($manager->getList($perso->nom()));
    
?>