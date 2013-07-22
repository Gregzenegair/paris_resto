<?php

// La fonction __autoload risque d'être supprimée dans le futur
//function __autoload($nomClasse)
//{
//    require_once "./classes/$nomClasse.php";
//}

spl_autoload_register(function ($nomClasse) {
    
    $nomClasse = str_replace('\\', DIRECTORY_SEPARATOR, $nomClasse);
    
    require "./$nomClasse.php";
});