<?php

// --- A passer en MVC


// Récupération des variables nécessaires à l'activation
$pseudo = $_GET['pseudo'];
$email_check = $_GET['email_check'];


try {
    $bdd = new PDO('mysql:host=localhost;dbname=' . 'paris_resto', "root", "");
} catch (Exception $e) {
    die('Erreur : ' . $e->getMessage());
}
$bdd->exec("SET CHARACTER SET utf8");

// Récupération de la clé correspondant au $login dans la base de données
$stmt = $bdd->prepare("SELECT email_check, actif FROM users WHERE pseudo like :pseudo ");
if ($stmt->execute(array(':pseudo' => $pseudo)) && $row = $stmt->fetch()) {
    $clebdd = $row['email_check']; // Récupération de la clé
    $actif = $row['actif']; // $actif contiendra alors 0 ou 1
}


// On teste la valeur de la variable $actif récupéré dans la BDD
if ($actif == '1') { // Si le compte est déjà actif on prévient
    echo "Votre compte est déjà actif !";
} else { // Si ce n'est pas le cas on passe aux comparaisons
    if ($email_check == $clebdd) { // On compare nos deux clés	
        // Si elles correspondent on active le compte !	
        echo "Votre compte a bien été activé !";

        // La requête qui va passer notre champ actif de 0 à 1
        $stmt = $bdd->prepare("UPDATE users SET actif = 1 WHERE pseudo like :pseudo ");
        $stmt->bindParam(':pseudo', $pseudo);
        $stmt->execute();
    } else { // Si les deux clés sont différentes on provoque une erreur...
        echo "Erreur ! Votre compte ne peut être activé...";
    }
}
?>
