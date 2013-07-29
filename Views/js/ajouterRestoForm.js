// -- Inputs adresse

var numero_voie = document.getElementById("numero_voie");
var type_voieInput = document.getElementById("type_voieInput");
var nom_voie = document.getElementById("nom_voie");

numero_voie.onkeypress = numVoie;
type_voieInput.onkeypress = typeVoie;

function numVoie(event) {
    if (event.keyCode == 32) {
        type_voieInput.focus();
    }
}

function typeVoie(event) {
    if (event.keyCode == 32) {
        nom_voie.focus();
    }
}





// -- Partie Ajax pour ville et cp

var nom_ville = document.getElementById("nom_villeInput");
var nom_villeDataList = document.getElementById("nom_ville");
var cp = document.getElementById("cp");

nom_ville.addEventListener("blur", makeRequestCp, false);
nom_ville.addEventListener("keyup", makeRequestNomVille, false);




// -- fonction d'initialisation de l'objet xhr
function getXMLHttpRequest() {
    var xhr = null;

    if (window.XMLHttpRequest || window.ActiveXObject) {
        if (window.ActiveXObject) {
            try {
                xhr = new ActiveXObject("Msxml2.XMLHTTP");
            } catch (e) {
                xhr = new ActiveXObject("Microsoft.XMLHTTP");
            }
        } else {
            xhr = new XMLHttpRequest();
        }
    } else {
        alert("Votre navigateur ne supporte pas l'objet XMLHTTPRequest...");
        return null;
    }

    return xhr;
}

// -- fonction pour aller trouver le cp en fonction du nom de la ville
function makeRequestCp() {
    if (allTrim(nom_ville.value) != "") {
        requestCp(readDataCp);
    }
}


// -- Fonction pour alimenter la datalist
function makeRequestNomVille() {
    if (allTrim(nom_ville.value).length >= 1 && allTrim(nom_ville.value).length <= 3) {
        requestNomVille(readDataNomVille);
    }
}


// -- requete pour retrouver le cp en fonction du nom de la ville
function requestCp(callback) {
    var xhr = getXMLHttpRequest();
    cp.className = "ajaxcCheck";
    xhr.onreadystatechange = function() {
        if (xhr.readyState == 4 && (xhr.status == 200 || xhr.status == 0)) {
            callback(xhr.responseText);
        }
    };
    var nom_villeAjax = nom_ville.value;
    xhr.open("GET", "../Models/Utils/AjaxModel.php?action=ajouterRestoVilleCp&nom=" + nom_villeAjax, true);
    xhr.send(null);
}


//-- requete pour retrouver le nom d'un ville par rapport au premières lettres saisies
function requestNomVille(callback) {
    var xhr = getXMLHttpRequest();
    nom_ville.className = "ajaxcCheck";
    xhr.onreadystatechange = function() {
        if (xhr.readyState == 4 && (xhr.status == 200 || xhr.status == 0)) {
            callback(xhr.responseText);
        }
    };
    var nom_villeAjax = nom_ville.value;
    xhr.open("GET", "../Models/Utils/AjaxModel.php?action=afficherVilles&nom=" + nom_villeAjax, true);
    xhr.send(null);
}

// -- fonction traitant du resultat de la requete ajax concernant le CP
function readDataCp(oData) {
    if (oData == "false") {
        cp.className = "";
        cp.value = "";
        cp.placeholder = "Merci de renseigner le CP";
    } else {
        cp.className = "";
        cp.value = oData;
    }
}


// -- fonction traitant du resultat de la requete ajax concernant la liste de villes
function readDataNomVille(oData) {

    nom_ville.className = "";
    var tData = oData.split(';');
    var options = "";

    for (var i = 0; i < tData.length; i++) {
        options += "<option value=\"" + tData[i] + "\"></option>";
    }
    nom_villeDataList.innerHTML = options;
}

function allTrim(myString) {
    return myString.replace(/^\s+/g, '').replace(/\s+$/g, '');
}
