<?PHP

include_once '../Models/CNX.php';

$action = $_GET['action'];

switch ($action) {
    case "checkEmail":
        $cnx = new CNX("paris_resto", "root", "");

        $bdd = $cnx->get_bdd();

        $req = $bdd->prepare('SELECT count(*) as count FROM users where email = :email');
        $req->bindParam(':email', $_GET['email'], PDO::PARAM_STR);
        $req->execute();

        while ($donnees = $req->fetch()) {
            if ($donnees['count'] == 0) {
                echo "true";
            } else {
                echo "false";
            }
        }
        break;

    default:
        break;
}
?>