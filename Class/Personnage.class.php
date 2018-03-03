<?php
    /**
     * @Class Personnage
     * Permet d'implémenter les actions d'un personnage d'un jeu de combat
     */
    class Personnage{

        /**
         * @var int Attribut qui garde la valeur de l'identifiant du personnage
         */
        private $_id;

        /**
         * @var string Nom du personnage
         */
        private $_nom;

        /**
         * @var int Dégats du personnage
         */
        private $_degats;

        /**
         * Définition des constantes de classe
         */
        const TUE = -1;
        const MOI = 0;
        const FRAPPE = 1;

        /**
         * @param Personnage $perso Personnage à frapper
         * @return int La valeur permettant de savoir ce qui s'est passé sur le personnage
         * Permet de frapper un autre personnage
         */
        public function frapper(Personnage $perso){
            /** On vérifie qu'on ne se frappe pas soit même */
            if($perso->id() != $this->id()){
                return $perso->recevoirDegats();
            }
            else{
                return self::MOI;
            }
        }

        /**
         * @return int Renvoi TUE si le personnage est mort et FRAPPE lorsqu'il n'est pas mort
         * Permet de recevoir les degats lorsqu'on est frappé
         */
        public function recevoirDegats(){
            
            $this->_degats += 5;
            return ($this->_degats >= 100)? self::TUE : self::FRAPPE;

        }

        /**
         * @return int L'identifiant du personnage
         * Retourne l'identifiant du personnage
         */
        public function id(){
            return $this->_id;
        }

        /**
         * @return string Nom du personnage
         * Retourne le nom du personnage
         */
        public function nom(){
            return $this->_nom;
        }

        /**
         * @return int Dégats du personnage
         * Retourne les dégats du personnage
         */
        public function degats(){
            return $this->_degats;
        }

        /**
         * @param int $id Définit l'identifiant du personnage
         * Modifie la valeur de l'identifiant
         */
        public function setId($id){
            $this->_id = (int) $id;
        }

        /**
         * @param string $nom Définit le nom du personnage
         * Modifie le nom du personnage
         */
        public function setNom($nom){
            if (is_string($nom))
                $this->_nom = $nom;
        }

        /**
         * @param int $degats Définit les degats du personnage
         * Modifie les degats du personnage
         */
        public function setDegats($degats){
            $this->_degats = (int) $degats;
        }

        /**
         * @param array $donnees Ensemble d'élements à hydrater
         * Permet de repmlir les différents attributs la classe (hydrater)
         */
        public function hydrater($donnees=array()){

            foreach($donnees as $key=> $value){

                $method = "set".ucfirst($key);

                if(method_exists($this,$method)){
                    $this->$method($value);
                }
            }
        }

        /**
         * @param array $donnees Ensemble des donnees a hydrater
         * On passe les données à manipuler en paramètre
         */
        public function __construct($donnees){
            $this->hydrater($donnees);
        }
        
    }
?>