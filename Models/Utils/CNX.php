<?php

class CNX {

// --- Connexion active à la base
    protected $_bdd;
    private static $instances = array();

// --- Methode de connexion à la base
    public function __construct($base, $user, $pwd, $tAttributes = null) {
        try {
            $bdd = new PDO('mysql:host=localhost;dbname=' . $base, $user, $pwd, $tAttributes);
        } catch (Exception $e) {
            die('Erreur : ' . $e->getMessage());
        }
        $bdd->exec("SET CHARACTER SET utf8");

        $this->_bdd = $bdd;
    }

    public function get_bdd() {
        return $this->_bdd;
    }

    public function set_bdd($_bdd) {
        $this->_bdd = $_bdd;
    }

    public function beginTransaction() {
        $this->_bdd->beginTransaction();
    }

    public function commit() {
        $this->_bdd->commit();
    }

    public function rollback() {
        $this->_bdd->rollback();
    }

    public function cleanArgForBdd($value) {
            $value = strip_tags(htmlspecialchars(trim($value)));
            return $value;
    }
}

?>
