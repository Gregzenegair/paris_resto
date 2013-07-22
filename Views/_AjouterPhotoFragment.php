Ajouter une photo

<form method="post" action="reception.php" enctype="multipart/form-data">
     <label for="icone">Icône du fichier (JPG, PNG ou GIF | max. 100 Ko) :</label><br />
     <input type="file" name="imageFile" id="imageFile" /><br />
     <label for="mon_fichier">Fichier (tous formats | max. 1 Mo) :</label><br />
     <input type="hidden" name="MAX_FILE_SIZE" value="102486" />
     <label for="titre">Titre du fichier (max. 50 caractères) :</label><br />
     <input type="text" name="titre" value="Titre du fichier" id="titre" /><br />
     <label for="description">Description de votre fichier (max. 255 caractères) :</label><br />
     <textarea name="description" id="description"></textarea><br />
     <input type="submit" name="submit" value="Envoyer" />
</form>