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
                $perso->recevoirDegats($this->degats());
                return ( $perso->degats() == 0 ) ? self::FRAPPE : self::TUE;
            }
            else{
                return self::MOI;
            }
        }

        /**
         * Permet de recevoir les degats lorsqu'on est frappé
         */
        public function recevoirDegats(){
            $this->_degats ++;
        }

        /**
         * @return int L'identifiant du personnage
         */
        public function id(){
            return $this->_id;
        }

        /**
         * @return string Nom du personnage
         */
        public function nom(){
            return $this->_nom;
        }

        /**
         * @return int Dégats du personnage
         */
        public function degats(){
            return $this->_degats;
        }

        /**
         * @param int $id Définit l'identifiant du personnage
         */
        public function setId($id){
            $this->_id = (int) $id;
        }

        /**
         * @param string $nom Définit le nom du personnage
         */
        public function setNom($nom){
            if (is_string($nom))
                $this->_nom = $nom;
        }

        /**
         * @param int $degats Définit les degats du personnage
         */
        public function setDegats($degats){
            $this->_degats = (int) $degats;
        }

        /**
         * @param array $donnees Ensemble d'élements à hydrater
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
         */
        public function __construct($donnees){
            $this->hydrater($donnees);
        }
        
    }
?>