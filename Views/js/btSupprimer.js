/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */


var btSupprimer = document.getElementById("btSupprimer");
var btSupprimerNon = document.getElementById("btSupprimerNon");


btSupprimer.onclick = function() {
    document.getElementById("modale").style.visibility = "visible";
    document.getElementById("masqueGris").style.visibility = "visible";
};

btSupprimerNon.onclick = function() {
    document.getElementById("modale").style.visibility = "hidden";
    document.getElementById("masqueGris").style.visibility = "hidden";
};

