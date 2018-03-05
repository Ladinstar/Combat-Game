<?php
require_once "Class/Personnage.class.php";
require_once "Class/PersonnageManager.class.php";

$dsn = 'mysql:dbname=POO;host=localhost';
$user = 'root';
$password ='';

try{
	$db = new PDO($dsn, $user, $password);
	$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING); // On émet une alerte à chaque fois qu'une requête a échoué.
}
catch(Exception $e){
	echo "Message : ".$e->getMessage();
}
$manager = New PersonnagesManager($db);

$perso = New Personnage(array("nom"=>"Avaika","degats"=>40));
$perso2 = New Personnage(array("nom"=>"Serge","degats"=>60));

$manager->add($perso);
$manager->add($perso);

var_dump($manager->getList($perso->nom()));

?>