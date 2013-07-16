<?PHP
session_start();
?>

<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <link href="css/MainView.css" rel="stylesheet" type="text/css" >
        <link href="css/Formulaires.css" rel="stylesheet" type="text/css" >
        <title></title>
    </head>
    <body>
        <?php
        if (isset($_GET['fragment']))
            $fragment = $_GET['fragment'];
        else
            $fragment = "_AccueilFragment.php";
        ?>
        <header>Header
            <?PHP
            include_once './MaintView/_HeaderFragment.php';
            include_once './../Views/_ConnexionFragment.php';
            ?>
        </header>
        <?PHP
        include_once './MaintView/_Menu.php';
        include_once $fragment;
                ?>
        <div class="clear"></div>
        <?PHP
        include_once './MaintView/_FooterFragment.php';
        ?>
    </body>
</html>
