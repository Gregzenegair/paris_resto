<?php

abstract class CNX {

// --- Connexion active à la base
    protected $_bdd;

// --- Methode de connexion à la base
    public function __construct($base, $user, $pwd) {
        try {
            $bdd = new PDO('mysql:host=localhost;dbname=' . $base, $user, $pwd);
        } catch (Exception $e) {
            die('Erreur : ' . $e->getMessage());
        }
        $bdd->exec("SET CHARACTER SET utf8");

        $this->_bdd = $bdd;
    }
}

?>
