// -- Inputs adresse

var numero_voie = document.getElementById("numero_voie");
var type_voieInput = document.getElementById("type_voieInput");
var nom_voie = document.getElementById("nom_voie");

numero_voie.onkeypress = numVoie;
type_voieInput.onkeypress = typeVoie;

function numVoie(event) {
    if(event.keyCode==32){
        type_voieInput.focus();
    }
}

function typeVoie(event) {
    if(event.keyCode==32){
        nom_voie.focus();
    }
}





// -- Partie Ajax pour ville et cp

var nom_ville = document.getElementById("nom_villeInput");
var cp = document.getElementById("cp");
nom_ville.onblur = makeRequest;


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


function makeRequest() {
    if (allTrim(nom_ville.value) != "") {
        request(readData);
    }
}


function request(callback) {
    var xhr = getXMLHttpRequest();
    cp.className = "ajaxcCheck";
    xhr.onreadystatechange = function() {
        if (xhr.readyState == 4 && (xhr.status == 200 || xhr.status == 0)) {
            callback(xhr.responseText);
        }
    };
    var nom_villeAjax = nom_ville.value;
    xhr.open("GET", "../Models/AjaxModel.php?action=ajouterRestoVilleCp&nom=" + nom_villeAjax, true);
    xhr.send(null);
}

function readData(oData) {
    if (oData == "false") {
        cp.className = "";
        cp.value = "";
        cp.placeholder = "Merci de renseigner le CP";
    } else {
        cp.className = "";
        cp.value = oData;
    }

}

function allTrim(myString) {
    return myString.replace(/^\s+/g, '').replace(/\s+$/g, '');
} 