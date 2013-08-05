<div id="mainFrame">

    <?php
    spl_autoload_register(function ($nomClasse) {
                require_once "../Utils/Form/$nomClasse.php";
            });

    if (isset($erreurMsg)) {
        ?>
        <span class="errorMessage"><?PHP echo $erreurMsg; ?></span>
        <?PHP
    }

    $inputRecherche = new Input("rechercher", null, "rechercher", "text", "", "placeholder='laisser vide pour tout afficher'", 5, "rechercher");
    $elements = array($inputRecherche);
    $formulaire = new Form("mainForm", "POST", "/RechercherResto", $elements);
    echo $formulaire->genererForm();


    if (!empty($afficherRestos)) {
        ?>
        <div>
            <?PHP
            $part = floor($RestosCount / $pagination) + 2;
            if ($pagination == 1) {
                $part = $part - 1;
            }


            $i = 1;
            while ($i < $part) {
                $tranche = $i * $pagination;
                if ($i == 1) {
                    $echoA = 0;
                } else {
                    $echoA = ($tranche - $pagination);
                }
                ?>
                <a class="aGreenVille" href="/GererRestos__Page__<?PHP echo $echoA; ?>"><?PHP echo $i; ?></a>
                <?PHP
                $i++;
            }
            ?>
        </div>
        <?PHP
        foreach ($afficherRestos as $value) {
            $categories = $value['categories'];
            $categories = str_replace(",", " | ", $categories);
            ?>
            <a class="aRestaurant" href="/DetailsResto__<?PHP echo $value['id']; ?>">
                <div class="restaurant">
                    <h4><?PHP echo $value['nom']; ?></h4>
                    <p><?PHP echo $value['nom_ville']; ?></p>
                    <?PHP
                    if ($value['nom_fichier'] != "") {
                        $photosResto = explode(",", $value['nom_fichier']);
                        $nomFichierPhotoResto = explode(".", $photosResto[0]);
                        $nomFichierSmall = $nomFichierPhotoResto[0] . "_small." . $nomFichierPhotoResto[1];
                        ?>
                        <img class="imgAccueil" src="/Views/img/restos/<?PHP echo $value['id'] . "/" . $nomFichierSmall; ?>">
                        <?PHP
                        /*
                        $i = 0;
                        while ($photosResto[$i] != null) {
                            $nomFichierPhotoResto = explode(".", $photosResto[$i]);
                            $nomFichierSmall = $nomFichierPhotoResto[0] . "_small." . $nomFichierPhotoResto[1];
                            ?>
                            <img class="imgAccueil" src="/Views/img/restos/<?PHP echo $value['id'] . "/" . $nomFichierSmall; ?>">
                            <?PHP
                            $i++;
                        }
                         */
                    }
                    ?>
                </div>
            </a>
            <?PHP
        }
    }
    ?>
</div>
