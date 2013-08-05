<?PHP
if (session_status() != PHP_SESSION_ACTIVE) {
    session_start();
}
// Ce controller capture les actions venant des différents liens, il est systématiquement appellé via le htaccess
// C'est par ce biais que se font toutes les redirections du site
    include_once $_SERVER["DOCUMENT_ROOT"] . '/Controllers/FrontController.php';
?>

<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">

        <link href="/Views/css/MainView.css" rel="stylesheet" type="text/css" >
        <link href="/Views/css/Accueil.css" rel="stylesheet" type="text/css" >
        <link href="/Views/css/Formulaires.css" rel="stylesheet" type="text/css" >
        <title></title>
    </head>
    <body>
        <div id="title">
            <?PHP
            include_once $_SERVER["DOCUMENT_ROOT"] . '/Views/MaintView/_HeaderFragment.php';
            ?>
        </div>
        <div id="bodyMain">
            <?php
            $includer = false;
            if (!isset($fragment)) {
                $fragment = "_AccueilFragment.php";
                $includer = true;
            }
            if (!file_exists($_SERVER["DOCUMENT_ROOT"] . "/Views/" . $fragment)) {
                $fragment = "_AccueilFragment.php";
            }
            ?>
            <header>
                <?PHP
                include_once $_SERVER["DOCUMENT_ROOT"] . '/Views/MaintView/_ConnexionFragment.php';
                ?>
            </header>
            <?PHP
            include_once $_SERVER["DOCUMENT_ROOT"] . '/Views/MaintView/_Menu.php';
            include_once $_SERVER["DOCUMENT_ROOT"] . '/Views/' . $fragment;
            ?>
            <div class="clear"></div>
            <?PHP
            include_once $_SERVER["DOCUMENT_ROOT"] . '/Views/MaintView/_FooterFragment.php';
            ?>
        </div>
    </body>
</html>