<?php

class NavigationController {

// --- Controlle de l'utilisateur avant accès à la page
    static function Controller($sessionUser) {

        $user = true;
        if (!empty($sessionUser)) {
            if ($sessionUser['statut'] != "10") {
                $user = false;
            }
        } else {
            $user = false;
        }

        if ($user == false) {
            header("Location: ./../Controllers/UserController.php?action=Accueil");
            return;
        }
// --- Fin de controle
    }

}
