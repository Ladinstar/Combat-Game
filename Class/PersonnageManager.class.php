    <?php

    /**
     * Class PersonnageManager
     * Permet de créer le "manager" des personnages. En d'autres termes c'est celui qui gère tous les personnages
     */
    class PersonnagesManager{

    /**
     * @var PDO Cette variable permet d'instancier l'objet PDO
     */ 
    private $_db; // Instance de PDO

    /**
     * @param PDO $db Instance de PDO
     * @return void
     */
    public function __construct(PDO $db)
    {
        $this->setDb($db);
    }

    /**
     * Permet d'ajouter un personnage
     *
     * @param Personnage $perso
     */
    public function add(Personnage $perso)
    {
        $q = $this->_db->prepare('INSERT INTO personnages(nom) VALUES(:nom)');
        $q->bindValue(':nom', $perso->nom());
        $q->execute();
        
        $perso->hydrate([
        'id' => $this->_db->lastInsertId(),
        'degats' => 0,
        ]);
    }

    /**
     * Retourne de le nombre de personnage
     *
     * @return int
     */
    public function count()
    {
        return $this->_db->query('SELECT COUNT(*) FROM personnages')->fetchColumn();
    }

    /**
     * Supprime un personnage connaissant son id
     *
     * @param Personnage $perso
     * @return void
     */
    public function delete(Personnage $perso)
    {
        $this->_db->exec('DELETE FROM personnages WHERE id = '.$perso->id());
    }
    /**
     * Vérifie si un utilisateur existe dejà
     *
     * @param [string,int] $info
     * @return bool
     */
    public function exists($info)
    {
        if (is_int($info)) // On veut voir si tel personnage ayant pour id $info existe.
        {
        return (bool) $this->_db->query('SELECT COUNT(*) FROM personnages WHERE id = '.$info)->fetchColumn();
        }
        
        // Sinon, c'est qu'on veut vérifier que le nom existe ou pas.
        
        $q = $this->_db->prepare('SELECT COUNT(*) FROM personnages WHERE nom = :nom');
        $q->execute([':nom' => $info]);
        
        return (bool) $q->fetchColumn();
    }

    /**
     * Retourne le personnage ayant l'identifiant ou le nom mis en paramètre
     *
     * @param [int,string] $info Identifiant ou nom du personnage à retourner
     * @return Personnage
     */
    public function get($info)
    {
        if (is_int($info)){

            $q = $this->_db->query('SELECT id, nom, degats FROM personnages WHERE id = '.$info);
            $donnees = $q->fetch(PDO::FETCH_ASSOC);
            
            return new Personnage($donnees);
        }
        else{

            $q = $this->_db->prepare('SELECT id, nom, degats FROM personnages WHERE nom = :nom');
            $q->execute([':nom' => $info]);
            
            return new Personnage($q->fetch(PDO::FETCH_ASSOC));
        }
    }

    /**
     * Affiche la liste des personnage ayant le nom mis en paramètre
     *
     * @param string $nom Nom du personnage
     * @return array
     */
    public function getList($nom){

        $persos = [];
        
        $q = $this->_db->prepare('SELECT id, nom, degats FROM personnages WHERE nom <> :nom ORDER BY nom');
        $q->execute([':nom' => $nom]);
        
        while ($donnees = $q->fetch(PDO::FETCH_ASSOC))
        {
        $persos[] = new Personnage($donnees);
        }
        
        return $persos;
    }

    /**
     * Permet de modifier les degats d'un personnage
     *
     * @param Personnage $perso Personnage à modifier
     * @return void
     */
    public function update(Personnage $perso)
    {
        $q = $this->_db->prepare('UPDATE personnages SET degats = :degats WHERE id = :id');
        
        $q->bindValue(':degats', $perso->degats(), PDO::PARAM_INT);
        $q->bindValue(':id', $perso->id(), PDO::PARAM_INT);
        
        $q->execute();
    }

    /**
     * Modifie l'instance de PDO
     *
     * @param PDO $db Nouvelle instance de PDO
     * @return void
     */
    public function setDb(PDO $db)
    {
        $this->_db = $db;
    }
}