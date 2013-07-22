<?php

class DAO {

    // --- $tValeur doit contenir les deux point lorsque traité
    // --- Exemple d'utilisation depuis une autre classe par exemple : 
    // --- Penser à mettre les : devant les valeurs à inserer s'il ne s'agit pas d'une instruction sql
    // --- 
    // ---      $tNomChampTable = ["pseudo", "email", "mdp", "statut", "date_inscription", "email_check"];
    // ---      $tValeurs = [":$pseudo", ":$email", ":$mdp", ":$statut", "now()", ":$email_check"];
    // ---      $result = DAO::insert($this->_bdd, "users", $tNomChampTable, $tValeurs);
    // --- Retourne true si l'insertion a fonctionnée

    static function insert($bdd, $table, $tNomChampTable, $tValeurs) {

        $sPrepare = "INSERT INTO " . $table;

        $sPrepare .= " (";
        foreach ($tNomChampTable as $value) {
            $sPrepare .= $value . ", ";
        }
        $sPrepare = substr($sPrepare, 0, (strlen($sPrepare) - 2));
        $sPrepare .= ") VALUES(";

        foreach ($tValeurs as $key => $value) {
            if (substr($value, 0, 1) == ":") {
                $sPrepare .= ":" . $tNomChampTable[$key] . ", ";
            } else {
                $sPrepare .= $value . ", ";
            }
        }
        $sPrepare = substr($sPrepare, 0, (strlen($sPrepare) - 2));
        $sPrepare .= ")";

        $req = $bdd->prepare($sPrepare);

        $tParams = array();
        foreach ($tValeurs as $key => $value) {
            if (substr($value, 0, 1) == ":") {
                $PDOParam = ":" . $tNomChampTable[$key];
                $PDOValeur = (substr($value, 1, strlen($value)));
                $tParams[$PDOParam] = $PDOValeur;
            }
        }
        $result = $req->execute($tParams);
        $req->closeCursor();
        if ($result) {
            return true;
        } else {
            return false;
        }
    }

    // --- $tValeur doit contenir les deux point lorsque traité
    // --- Exemple d'utilisation depuis une autre classe par exemple : 
    // --- Penser à mettre les : devant les valeurs à inserer s'il ne s'agit pas d'une instruction sql
    // --- 
    // ---              $tNomChampTable = ["pseudo", "email", "date_inscription", "statut", "actif"];
    // ---              $tValeurs = [":$pseudo", ":$email", ":$date_inscription", ":$statut", ":$actif"];
    // ---              $twhere['id'] = $id;
    // --- Retourne true si l'insertion a fonctionnée
    
    static function update($bdd, $table, $tNomChampTable, $tValeurs, $twhere = null) {
        $sPrepare = "UPDATE " . $table;

        $sPrepare .= " SET ";
        foreach ($tValeurs as $key => $value) {
            $sPrepare .= $tNomChampTable[$key] . " = ";
            if (substr($value, 0, 1) == ":") {
                $sPrepare .= ":" . $tNomChampTable[$key] . ", ";
            } else {
                $sPrepare .= $value . ", ";
            }
        }
        $sPrepare = substr($sPrepare, 0, (strlen($sPrepare) - 2));

        $tParams = array();
        foreach ($tValeurs as $key => $value) {
            if (substr($value, 0, 1) == ":") {
                $PDOParam = ":" . $tNomChampTable[$key];
                $PDOValeur = (substr($value, 1, strlen($value)));
                $tParams[$PDOParam] = $PDOValeur;
            }
        }

        if (!empty($twhere)) {
            $sPrepare .= " WHERE ";
            foreach ($twhere as $key => $value) {
                $sPrepare .= $key . " = " . ":" . $key . " AND ";
                $tParams[":$key"] = $value;
            }
            $sPrepare = substr($sPrepare, 0, (strlen($sPrepare) - 5));
        }

        $req = $bdd->prepare($sPrepare);
        $result = $req->execute($tParams);
        $req->closeCursor();
        if ($result) {
            return true;
        } else {
            return false;
        }
    }

    // --- Fonction non encore terminée, mais y a t'il vraiment un interet à celle-ci  vu le nombre de tableau à lui fournir ?
    static function show($bdd, $tTables, $tSelect, $tJointures = null, $twhere = null) {

        $sPrepare = "SELECT ";

        foreach ($tSelect as $value) {
            $sPrepare .= "$value, ";
        }
        $sPrepare = substr($sPrepare, 0, (strlen($sPrepare) - 2));

        $sPrepare .= " FROM ";

        // --- While Jointures, si necessaire
        $i = 0;
        while ($tTables[$i]) {
            if ($i > 0) {
                $sPrepare .= " JOIN ";
            }
            $sPrepare .= $tTables[$i] . " ";
            if ($i > 0) {
                $sPrepare .= " ON ";
                $sPrepare .= $tJointures[$i - 1];
            }
            $i++;
        } // --- Fin while

        $tParams = array();
        if (!empty($twhere)) {
            $sPrepare .= " WHERE ";
            foreach ($twhere as $key => $value) {
                $sPrepare .= $key . " = " . ":" . $key . " AND ";
                $tParams[":$key"] = $value;
            }
            $sPrepare = substr($sPrepare, 0, (strlen($sPrepare) - 5));
        }

        $req = $bdd->prepare($sPrepare);

        // --- Execution de la requete parametrée, s'il y a une condition WHERE
        if (!empty($twhere)) {
            $req->execute($twhere);
        } else {
            $req->execute();
        }

        $resultAfficherUsers = $req->fetchAll();
        $req->closeCursor();
        return $resultAfficherUsers;
    }

}