var nom_ville = document.getElementById("nom_villeinput");
var cp = document.getElementById("cp");

nom_ville.onblur = makeRequest;

// -- Partie Ajax

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
    if (oData != "") {
        cp.className = "";
        cp.value = oData;
    }

}

function allTrim(myString) {
    return myString.replace(/^\s+/g, '').replace(/\s+$/g, '');
} 