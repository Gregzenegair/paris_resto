<?php

$_FILES['icone']['name'];     //Le nom original du fichier, comme sur le disque du visiteur (exemple : mon_icone.png).
$_FILES['icone']['type'];     //Le type du fichier. Par exemple, cela peut être « image/png ».
$_FILES['icone']['size'];     //La taille du fichier en octets.
$_FILES['icone']['tmp_name']; //L'adresse vers le fichier uploadé dans le répertoire temporaire.
$_FILES['icone']['error'];    //Le code d'erreur, qui permet de savoir si le fichier a bien été uploadé.
?>

<?php

if ($_FILES['icone']['error'] > 0)
    $erreur = "Erreur lors du transfert";
?>
<?php

if ($_FILES['icone']['size'] > $maxsize)
    $erreur = "Le fichier est trop gros";
?>
<?php

$extensions_valides = array('jpg', 'jpeg', 'gif', 'png');
//1. strrchr renvoie l'extension avec le point (« . »).
//2. substr(chaine,1) ignore le premier caractère de chaine.
//3. strtolower met l'extension en minuscules.
$extension_upload = strtolower(substr(strrchr($_FILES['icone']['name'], '.'), 1));
if (in_array($extension_upload, $extensions_valides))
    echo "Extension correcte";
?>
<?php

//Créer un dossier 'fichiers/1/'
mkdir('fichier/1/', 0777, true);

//Créer un identifiant difficile à deviner
$nom = md5(uniqid(rand(), true));
?>
<?php

$nom = "avatars/{$id_membre}.{$extension_upload}";
$resultat = move_uploaded_file($_FILES['icone']['tmp_name'], $nom);
if ($resultat)
    echo "Transfert réussi";
?>