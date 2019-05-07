function buscarComentario() {
    let input = document.getElementById("inputBuscarComentario");
    let filter = input.value.toUpperCase();
    let table = document.getElementById("tablaComentarios");
    let tr = table.getElementsByTagName("tr");
    let eventName, username, comment;
    for (i = 0; i < tr.length; i++) {
        eventName = tr[i].getElementsByTagName("td")[0];
        username = tr[i].getElementsByTagName("td")[1];
        comment = tr[i].getElementsByTagName("td")[2];

        if (eventName || username || comment) {
            eventValue = eventName.textContent || eventName.innerText;
            commentUser = username.textContent || username.innerText;
            commentValue = comment.textContent || comment.innerText;
            if ((eventValue.toUpperCase().indexOf(filter) > -1)
                  || (commentUser.toUpperCase().indexOf(filter) > -1)
                  || (commentValue.toUpperCase().indexOf(filter) > -1)) {

                tr[i].style.display = "";
            } else {
                tr[i].style.display = "none";
            }
        }
    }
}
