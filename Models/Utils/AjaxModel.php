<?PHP

include_once 'CNX.php';

$action = $_GET['action'];

switch ($action) {
    case "checkEmail":
        $cnx = new CNX("paris_resto", "root", "");

        $bdd = $cnx->get_bdd();

        $req = $bdd->prepare('SELECT count(*) as count FROM users WHERE email = :email');
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
    case "ajouterRestoVilleCp":
        $cnx = new CNX("paris_resto", "root", "");

        $bdd = $cnx->get_bdd();

        $req = $bdd->prepare('SELECT cp FROM villes WHERE nom = :nom LIMIT 1');
        $req->bindParam(':nom', $_GET['nom'], PDO::PARAM_STR);
        $req->execute();
        $result = $req->fetchAll();

        if (empty($result[0])) {
            echo "false";
        } else {
            foreach ($result as $value) {
                echo $value['cp'];
            }
        }

        break;
    default:
        break;
}
?>