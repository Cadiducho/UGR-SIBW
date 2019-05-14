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

function showEditUsuarioModal(usuarioid, rango) {
    let modal = document.getElementById('editUsuarioPopUp');
    let inputRango = modal.querySelector("#inputRango");
    inputRango.value = rango;
    let inputUsuario = modal.querySelector("#inputUsuario");
    inputUsuario.value = usuarioid;
    let titulo = modal.querySelector("#tituloEditarUsuario");
    titulo.innerHTML = "Editar Usuario #" + usuarioid;

    modal.style.display='block'
}

function closeEditUsuarioModal() {
    let modal = document.getElementById('editUsuarioPopUp');
    modal.style.display = "none";
}

function tryEditUsuario(event) {
    event.preventDefault();

    let editUsuarioModal = document.getElementById('editUsuarioPopUp');
    let form = editUsuarioModal.querySelector("#formEditUsuario");
    let rango = form.rango.value;
    let usuario = form.usuario.value;

    // Intentar iniciar sesión mediante AJAX
    let url = "/core/post/admin/postEditUsuario.php";
    let params = 'usuario=' + usuario + '&rango=' + rango;
    let xhr = new XMLHttpRequest();
    xhr.onload = function () {
      	if (xhr.status >= 200 && xhr.status < 300) {
        		if (xhr.response === "error") {
                showMessage(editUsuarioModal, "error", "Ha ocurrido algún error");
            } else if (xhr.response === "unauthorized") {
                showMessage(editUsuarioModal, "error", "No autorizado");
            } else if (xhr.response === "ok") {
                showMessage(editUsuarioModal, "info", "Usuario editado correctamente");
                setTimeout(function(){
                    window.location.reload(1);
                }, 1500);
            }
      	} else {
        		showMessage(editUsuarioModal, "error", "No se ha podido editar el usuario");
      	}
    };

    xhr.open('POST', url);
    xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
    xhr.send(params);

    return false;
}

function buscarEventos() {
    let input = document.getElementById("inputBuscarEventos");
    let filter = input.value.toUpperCase();
    let table = document.getElementById("tablaEventos");
    let tr = table.getElementsByTagName("tr");
    let eventName, eventOrganizator, eventDate;
    for (i = 0; i < tr.length; i++) {
        eventName = tr[i].getElementsByTagName("td")[0];
        eventOrganizator = tr[i].getElementsByTagName("td")[2];
        eventDate = tr[i].getElementsByTagName("td")[3];

        if (eventName || eventOrganizator || eventDate) {
            eventValue = eventName.textContent || eventName.innerText;
            organizatorText = eventOrganizator.textContent || eventOrganizator.innerText;
            dateText = eventDate.textContent || eventDate.innerText;
            if ((eventValue.toUpperCase().indexOf(filter) > -1)
                  || (organizatorText.toUpperCase().indexOf(filter) > -1)
                  || (dateText.toUpperCase().indexOf(filter) > -1)) {

                tr[i].style.display = "";
            } else {
                tr[i].style.display = "none";
            }
        }
    }
}

function tryAddEvento() {
      event.preventDefault();

      let crearEventoModal = document.getElementById('addEventPopUp');
      let form = crearEventoModal.querySelector("#formAddEvent");
      let nombre = form.nombre.value;
      let imagen = form.imagen.value;
      let organizador = form.organizador.value;
      let fecha = form.fecha.value;
      let descripcion = form.descripcion.value;
      let imagen_lateral_1 = form.imagen_lateral_1.value;
      let imagen_lateral_1_descripcion = form.imagen_lateral_1_descripcion.value;
      let imagen_lateral_2 = form.imagen_lateral_2.value;
      let imagen_lateral_2_descripcion = form.imagen_lateral_2_descripcion.value;

      let url = "/core/post/admin/postAddEvento.php";
      let params = 'nombre=' + nombre + '&imagen=' + imagen + '&organizador=' + organizador + '&fecha=' + fecha + '&descripcion=' + descripcion +
                   '&imagen_lateral_1=' + imagen_lateral_1 + '&imagen_lateral_1_descripcion=' + imagen_lateral_1_descripcion +
                   '&imagen_lateral_2=' + imagen_lateral_2 + '&imagen_lateral_2_descripcion=' + imagen_lateral_2_descripcion ;
      let xhr = new XMLHttpRequest();
      xhr.onload = function () {
        	if (xhr.status >= 200 && xhr.status < 300) {
          		if (xhr.response === "error") {
                  showMessage(crearEventoModal, "error", "Se ha producido un error");
              } else if (xhr.response === "ok"){
                  showMessage(crearEventoModal, "info", "Se ha creado el evento correctamente");
                  setTimeout(function(){
                      window.location.reload(1);
                  }, 1500);
              }
              else {
                showMessage()
              }
        	} else {
          		showMessage(crearEventoModal, "error", "No se ha podido crear el evento");
        	}
      };

      xhr.open('POST', url);
      xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
      xhr.send(params);

      return false;
  }

  function closeAddEventoModal() {
      let modal = document.getElementById('addEventPopUp');
      modal.style.display = "none";
  }

  function showAddEventPopUp() {
      let modal = document.getElementById('addEventPopUp');
      modal.style.display='block'
  }

  function showEditEventoModal(eventoid, nombre, imagen, organizador, fecha, descripcion, imagen_lateral_1, imagen_lateral_1_descripcion, imagen_lateral_2, imagen_lateral_2_descripcion) {
      let modal = document.getElementById('editEventoPopUp');
      let inputNombre = modal.querySelector("#inputNombre");
      inputNombre.value = nombre;
      let inputEvento = modal.querySelector("#inputEvento");
      inputEvento.value = eventoid;
      let inputImagen = modal.querySelector("#inputImagen");
      inputImagen.value = imagen;
      let inputOrganizador = modal.querySelector("#inputOrganizador");
      inputOrganizador.value = organizador;
      let inputFecha = modal.querySelector("#inputFecha");
      inputFecha.value = fecha;
      let inputDescripcion = modal.querySelector("#inputDescripcion");
      inputDescripcion.value = descripcion;
      let inputImg1 = modal.querySelector("#inputImg1");
      inputImg1.value = imagen_lateral_1;
      let inputImg1Desc = modal.querySelector("#inputImg1Desc");
      inputImg1Desc.value = imagen_lateral_1_descripcion;
      let inputImg2 = modal.querySelector("#inputImg2");
      inputImg2.value = imagen_lateral_2;
      let inputImg2Desc = modal.querySelector("#inputImg2Desc");
      inputImg2Desc.value = imagen_lateral_2_descripcion;

      let btnEditEtiquetas = modal.querySelector('#btnEditEtiquetas');
      let btnEditGaleria = modal.querySelector('#btnEditGaleria');
      btnEditEtiquetas.onclick = function () { window.location = "panel.php?editEtiquetas=" + eventoid; };
      btnEditGaleria.onclick = function () { window.location = "panel.php?editGaleria=" + eventoid; };

      let titulo = modal.querySelector("#tituloEditarEvento");
      titulo.innerHTML = "Editar Evento #" + eventoid;

      modal.style.display='block'
  }

  function tryEditEvento(event) {
      event.preventDefault();

      let editEventoModal = document.getElementById('editEventoPopUp');
      let form = editEventoModal.querySelector("#formEditEvento");
      let nombre = form.nombre.value;
      let imagen = form.imagen.value;
      let organizador = form.organizador.value;
      let fecha = form.fecha.value;
      let descripcion = form.descripcion.value;
      let imagen_lateral_1 = form.imagen_lateral_1.value;
      let imagen_lateral_1_descripcion = form.imagen_lateral_1_descripcion.value;
      let imagen_lateral_2 = form.imagen_lateral_2.value;
      let imagen_lateral_2_descripcion = form.imagen_lateral_2_descripcion.value;
      let eventoid = form.evento.value;

      let url = "/core/post/admin/postEditEvento.php";
      let params = 'evento=' +  eventoid + '&nombre=' + nombre + '&imagen=' + imagen + '&organizador=' + organizador + '&fecha=' + fecha + '&descripcion=' + descripcion +
                   '&imagen_lateral_1=' + imagen_lateral_1 + '&imagen_lateral_1_descripcion=' + imagen_lateral_1_descripcion +
                   '&imagen_lateral_2=' + imagen_lateral_2 + '&imagen_lateral_2_descripcion=' + imagen_lateral_2_descripcion ;
      let xhr = new XMLHttpRequest();
      xhr.onload = function () {
        	if (xhr.status >= 200 && xhr.status < 300) {
          		if (xhr.response === "error") {
                  showMessage(editEventoModal, "error", "Ha ocurrido algún error");
              } else if (xhr.response === "ok") {
                  showMessage(editEventoModal, "info", "Evento editado correctamente");
                  setTimeout(function(){
                      window.location.reload(1);
                  }, 1500);
              }
        	} else {
          		showMessage(editEventoModal, "error", "No se ha podido editar el evento");
        	}
      };

      xhr.open('POST', url);
      xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
      xhr.send(params);

      return false;
  }

  function closeEditEventoModal() {
      let modal = document.getElementById('editEventoPopUp');
      modal.style.display = "none";
  }

  function deleteEvento(eventoid) {
      let modal = document.getElementById('deleteEventoModal');
      let inputEvento = modal.querySelector("#inputEventoBorrar");
      inputEvento.value = eventoid;
      let titulo = modal.querySelector("#tituloBorrarEvento");
      titulo.innerHTML = "¿Borrar Evento #" + eventoid + "?";

      modal.style.display='block'
  }

  function closeDeleteEventoModal() {
      let modal = document.getElementById('deleteEventoModal');
      modal.style.display = "none";
  }

  function tryDeleteEvento(event) {
      event.preventDefault();

      let borrarEventoModal = document.getElementById('deleteEventoModal');
      let form = borrarEventoModal.querySelector("#formDeleteEvento");
      let evento = form.evento.value;

      let url = "/core/post/admin/postDeleteEvento.php";
      let params = 'evento=' + evento;
      let xhr = new XMLHttpRequest();
      xhr.onload = function () {
        	if (xhr.status >= 200 && xhr.status < 300) {
          		if (xhr.response === "error") {
                  showMessage(borrarEventoModal, "error", "Ha ocurrido algún error");
              } else if (xhr.response === "unauthorized") {
                  showMessage(borrarEventoModal, "error", "No autorizado");
              } else if (xhr.response === "ok") {
                  showMessage(borrarEventoModal, "info", "Evento borrado correctamente");
                  setTimeout(function(){
                      window.location.reload(1);
                  }, 1500);
              }
        	} else {
          		showMessage(borrarEventoModal, "error", "No se ha podido borrar el evento");
        	}
      };

      xhr.open('POST', url);
      xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
      xhr.send(params);

      return false;
  }

  function showAddEtiquetaPopUp(eventid, eventname) {
      let modal = document.getElementById('addEtiquetaModal');
      let inputEvento = modal.querySelector("#inputEvento");
      inputEvento.value = eventid;
      let titulo = modal.querySelector("#tituloAddEtiqueta");
      titulo.innerHTML = "Agregar etiqueta a " + eventname;

      modal.style.display='block'
  }

  function closeAddEtiquetaPopUp() {
      let modal = document.getElementById('addEtiquetaModal');
      modal.style.display = "none";
  }

  function deleteEtiqueta(eventoid, tag) {
      let modal = document.getElementById('deleteEtiquetaModal');
      let inputEvento = modal.querySelector("#inputEvento");
      inputEvento.value = eventoid;
      let inputEtiqueta = modal.querySelector("#inputEtiqueta");
      inputEtiqueta.value = tag;
      let titulo = modal.querySelector("#tituloBorrarEtiqueta");
      titulo.innerHTML = "¿Borrar etiqueta " + tag + "?";

      modal.style.display='block'
  }

  function closeDeleteEtiquetaModal() {
      let modal = document.getElementById('deleteEtiquetaModal');
      modal.style.display = "none";
  }

  function tryDeleteEtiqueta(event) {
      event.preventDefault();

      let borrarEtiquetaModal = document.getElementById('deleteEtiquetaModal');
      let form = borrarEtiquetaModal.querySelector("#formDeleteEtiqueta");
      let evento = form.evento.value;
      let etiqueta = form.etiqueta.value;

      let url = "/core/post/admin/postBorrarEtiquetaFromEvento.php";
      let params = 'evento=' + evento + '&etiqueta=' + etiqueta;
      let xhr = new XMLHttpRequest();
      xhr.onload = function () {
        	if (xhr.status >= 200 && xhr.status < 300) {
          		if (xhr.response === "error") {
                  showMessage(borrarEtiquetaModal, "error", "Ha ocurrido algún error");
              } else if (xhr.response === "unauthorized") {
                  showMessage(borrarEtiquetaModal, "error", "No autorizado");
              } else if (xhr.response === "ok") {
                  showMessage(borrarEtiquetaModal, "info", "Etiqueta borrada correctamente");
                  setTimeout(function(){
                      window.location.reload(1);
                  }, 1500);
              }
        	} else {
          		showMessage(borrarEtiquetaModal, "error", "No se ha podido borrar la etiqueta");
        	}
      };

      xhr.open('POST', url);
      xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
      xhr.send(params);

      return false;
  }

  function tryAddEtiqueta(event) {
      event.preventDefault();

      let addEtiquetaModal = document.getElementById('addEtiquetaModal');
      let form = addEtiquetaModal.querySelector("#formAddEtiqueta");
      let evento = form.evento.value;
      let etiqueta = form.etiqueta.value;

      console.log("Añadidneod" + etiqueta + " a " + evento);

      let url = "/core/post/admin/postAddEtiquetaToEvento.php";
      let params = 'evento=' + evento + '&etiqueta=' + etiqueta;
      let xhr = new XMLHttpRequest();
      xhr.onload = function () {
        	if (xhr.status >= 200 && xhr.status < 300) {
              console.log(xhr.response);
          		if (xhr.response === "error") {
                  showMessage(addEtiquetaModal, "error", "Ha ocurrido algún error");
              } else if (xhr.response === "unauthorized") {
                  showMessage(addEtiquetaModal, "error", "No autorizado");
              } else if (xhr.response === "ok") {
                  showMessage(addEtiquetaModal, "info", "Etiqueta añadida correctamente");
                  setTimeout(function(){
                      window.location.reload(1);
                  }, 1500);
              }
        	} else {
          		showMessage(addEtiquetaModal, "error", "No se ha podido añadir la etiqueta");
        	}
      };

      xhr.open('POST', url);
      xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
      xhr.send(params);

      return false;
  }


  function buscarUsuarios() {
      let input = document.getElementById("inputBuscarUsuarios");
      let filter = input.value.toUpperCase();
      let table = document.getElementById("tablaUsuarios");
      let tr = table.getElementsByTagName("tr");
      let username, userMail, userRank;
      for (i = 0; i < tr.length; i++) {
          username = tr[i].getElementsByTagName("td")[0];
          userMail = tr[i].getElementsByTagName("td")[2];
          userRank = tr[i].getElementsByTagName("td")[3];

          if (username || userMail || userRank) {
              username = username.textContent || username.innerText;
              userMail = userMail.textContent || userMail.innerText;
              userRank = userRank.textContent || userRank.innerText;
              if ((username.toUpperCase().indexOf(filter) > -1)
                    || (userMail.toUpperCase().indexOf(filter) > -1)
                    || (userRank.toUpperCase().indexOf(filter) > -1)) {

                  tr[i].style.display = "";
              } else {
                  tr[i].style.display = "none";
              }
          }
      }
  }
