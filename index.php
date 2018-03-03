<?php
    require_once "Class/Personnage.class.php";
    require_once "Class/PersonnageManager.class.php";

    $perso = new Personnage(array("id"=>1,"nom"=>"Avaika","degats"=>40));
    var_dump($perso);
    
?>