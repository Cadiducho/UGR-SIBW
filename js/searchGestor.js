/*
  Script para la busqueda
*/


// Mostrar el modal de login
function showHintG(str) {
    if (str.length == 0) {
        document.getElementById("txtHintG").innerHTML = "";
        return;
    } else {
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                document.getElementById("txtHintG").innerHTML = xmlhttp.responseText;
            }
        };
        xmlhttp.open("GET", "searchEventsGestor.php?q=" + str, true);
        xmlhttp.send();
    }
}
