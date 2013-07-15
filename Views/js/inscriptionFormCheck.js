var form = document.getElementById("mainForm");
var pseudo = document.getElementById("pseudo");
var pseudoMessage = document.getElementById("pseudoMessage");
var email = document.getElementById("email");
var emailMessage = document.getElementById("emailMessage");
var mdp = document.getElementById("mdp");
var mdpMessage = document.getElementById("mdpMessage");
var mdp_check = document.getElementById("mdp_check");
var mdp_checkMessage = document.getElementById("mdp_checkMessage");
var valider = document.getElementById("valider");

function invalidateInput(elem) {
    elem.className = "inputInvalid";
}

function validateInput(elem) {
    elem.className = "inputValid";
}

function formChecker() {
    var pseudoTest = pseudoTester();
    makeRequest();
    var emailTest = emailTester();
    var mdpTest = mdpTester();
    var mdp_checkTest = mdp_checkTester();
    if (pseudoTest & emailTest & mdpTest & mdp_checkTest) {
        return true;
    } else {
        return false;
    }
}

pseudo.onblur = blured;
email.onblur = blured;
mdp.onblur = blured;
mdp_check.onblur = blured;

email.onchange = function() {
    emailBoolean = false;
};

function blured(elem) {
    if (elem.target.id == "pseudo") {
        pseudoTester();
    } else if (elem.target.id == "email") {
        emailTester();
    } else if (elem.target.id == "mdp") {
        mdpTester();
    } else if (elem.target.id == "mdp_check") {
        mdp_checkTester();
    }
}

function pseudoTester() {
    if (pseudo.value.length <= 4) {
        pseudoMessage.innerText = "Merci de choisir un pseudonyme de plus de 4 caratères";
        invalidateInput(pseudo);
        return false;
    } else {
        pseudoMessage.innerText = "";
        validateInput(pseudo);
        return true;
    }
}

function emailTester() {
    if (email.value == "") {
        emailMessage.innerText = "Ce champ ne peut rester vide";
        invalidateInput(email);
        return false;
    } else {
        if (emailBoolean == true) {
            validateInput(email);
            mdpMessage.innerText = "";
            return true;
        } else {
            return false;
        }
    }
}

function mdpTester() {
    if (mdp.value == "") {
        mdpMessage.innerText = "Ce champ ne peut rester vide";
        invalidateInput(mdp);
        return false;
    } else {
        mdpMessage.innerText = "";
        validateInput(mdp);
        return true;
    }
}

function mdp_checkTester() {
    if (mdp_check.value != mdp.value) {
        mdp_checkMessage.innerText = "Les mots de passe saisis sont différents";
        invalidateInput(mdp_check);
    } else {
        mdp_checkMessage.innerText = "";
        validateInput(mdp_check);
        return true;
    }
}




// -- Partie Ajax

var emailBoolean = false;

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

email.onblur = makeRequest;

function makeRequest() {
    request(readData);
}

function request(callback) {
    var xhr = getXMLHttpRequest();

    xhr.onreadystatechange = function() {
        if (xhr.readyState == 4 && (xhr.status == 200 || xhr.status == 0)) {
            callback(xhr.responseText);
        }
    };
    var emailAjax = email.value;
    xhr.open("GET", "js/emailCheck.php?email=" + emailAjax, true);
    xhr.send(null);
}

function readData(oData) {
    emailMessage = document.getElementById("emailMessage");
    if (oData == "false") {
        emailMessage.innerText = "L'email saisi existe déjà, veuillez en choisir un autre";
        invalidateInput(email);
        emailBoolean = false;
    } else {
        emailMessage.innerText = "";
        validateInput(email);
        emailBoolean = true;
    }
}