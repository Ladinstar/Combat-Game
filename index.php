<?php
    require_once "Class/Personnage.class.php";

    $perso = new Personnage(array("nom"=>"Avaika"));
    var_dump($perso->nom());
    
?>