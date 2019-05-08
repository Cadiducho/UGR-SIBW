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

function showEditComentarioModal(comentarioid, mensaje) {
    let modal = document.getElementById('editComentarioPopUp');
    let inputMensaje = modal.querySelector("#inputMensaje");
    inputMensaje.value = mensaje;
    let inputComentario = modal.querySelector("#inputComentario");
    inputComentario.value = comentarioid;
    let titulo = modal.querySelector("#tituloEditarComentario");
    titulo.innerHTML = "Editar Comentario #" + comentarioid;

    modal.style.display='block'
}

function closeEditComentarioModal() {
    let modal = document.getElementById('editComentarioPopUp');
    modal.style.display = "none";
}

function tryEditComentario(event) {
    event.preventDefault();

    let editComentarioModal = document.getElementById('editComentarioPopUp');
    let form = editComentarioModal.querySelector("#formEditComentario");
    let mensaje = form.mensaje.value;
    let comentarioid = form.comentario.value;

    // Intentar iniciar sesión mediante AJAX
    let url = "/core/post/admin/postEditComentario.php";
    let params = 'comentario=' + comentarioid + '&mensaje=' + mensaje;
    let xhr = new XMLHttpRequest();
    xhr.onload = function () {
      	if (xhr.status >= 200 && xhr.status < 300) {
        		if (xhr.response === "error") {
                showMessage(editComentarioModal, "error", "Ha ocurrido algún error");
            } else if (xhr.response === "unauthorized") {
                showMessage(editComentarioModal, "error", "No autorizado");
            } else if (xhr.response === "ok") {
                showMessage(editComentarioModal, "info", "Comentario editado correctamente");
                setTimeout(function(){
                    window.location.reload(1);
                }, 1500);
            }
      	} else {
        		showMessage(editComentarioModal, "error", "No se ha podido editar el comentario");
      	}
    };

    xhr.open('POST', url);
    xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
    xhr.send(params);

    return false;
}

function deleteComentario(comentarioid) {
    let modal = document.getElementById('deleteComentarioModal');
    let inputComentario = modal.querySelector("#inputComentarioBorrar");
    inputComentario.value = comentarioid;
    let titulo = modal.querySelector("#tituloBorrarComentario");
    titulo.innerHTML = "¿Borrar Comentario #" + comentarioid + "?";

    modal.style.display='block'
}

function closeDeleteComentarioModal() {
    let modal = document.getElementById('deleteComentarioModal');
    modal.style.display = "none";
}

function tryDeleteComentario(event) {
    event.preventDefault();

    let borrarComentarioModal = document.getElementById('deleteComentarioModal');
    let form = borrarComentarioModal.querySelector("#formDeleteComentario");
    let comentario = form.comentario.value;

    let url = "/core/post/admin/postDeleteComentario.php";
    let params = 'comentario=' + comentario;
    let xhr = new XMLHttpRequest();
    xhr.onload = function () {
      	if (xhr.status >= 200 && xhr.status < 300) {
        		if (xhr.response === "error") {
                showMessage(borrarComentarioModal, "error", "Ha ocurrido algún error");
            } else if (xhr.response === "unauthorized") {
                showMessage(borrarComentarioModal, "error", "No autorizado");
            } else if (xhr.response === "ok") {
                showMessage(borrarComentarioModal, "info", "Comentario editado correctamente");
                setTimeout(function(){
                    window.location.reload(1);
                }, 1500);
            }
      	} else {
        		showMessage(borrarComentarioModal, "error", "No se ha podido editar el comentario");
      	}
    };

    xhr.open('POST', url);
    xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
    xhr.send(params);

    return false;
}
