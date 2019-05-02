
function mostrarComentarios() {
  let botonComentario = document.getElementById("mostrarComentarios");
  let botonOcultar = document.getElementById("ocultarComentarios");

  //Se establece lo que ocurre al pulsar ocultar/mostrar comentarios
  botonOcultar.style.display = "block";

  let cajaComentarios = document.getElementById("cajaComentarios");
  if (cajaComentarios.style.display === "" || cajaComentarios.style.display === "none") {
    cajaComentarios.style.display = "block";
    botonOcultar.style.display = "block";
    botonComentario.style.display = "none";
  } else {
    cajaComentarios.style.display = "none";
    botonOcultar.style.display = "none";
    botonComentario.style.display = "block";
  }
}

function filtrarContenido(event, palabrasProhibidas)
{
  let textarea = document.getElementById("areaMensaje");
  let mensaje = textarea.value;

  //Se eliminan las palabras que hemos determinado como prohibidas
  var numeroPalabrasProhibidas = palabrasProhibidas.length;

  //Comprobamos si aparece cada una de las palabras prohibidas
  while(numeroPalabrasProhibidas--)
  {
	  //En el caso de que la palbra se encuentre en el mensaje
	  if(mensaje.indexOf(palabrasProhibidas[numeroPalabrasProhibidas])!=-1)
	  {
		 var mensajeModificado = "";

		 for(var i=0; i<palabrasProhibidas[numeroPalabrasProhibidas].length; i++)
			 mensajeModificado+="*";

		 //Se sustituyen sus caracteres
         textarea.value = textarea.value.replace(new RegExp(palabrasProhibidas[numeroPalabrasProhibidas], "gi"), mensajeModificado);
      }
  }
}

function validar(mensaje) {
    let areaMensaje = document.getElementById("areaMensaje");
  let mensajeLabel = document.getElementById("mensajeLabel");

	//Se valida el comentario
  let mensajeValid = (mensaje.length >= 3);
  if (!mensajeValid) {
    areaMensaje.classList.add("invalid-input");
    mensajeLabel.classList.add("invalid-label");
  } else {
    areaMensaje.classList.remove("invalid-input");
    mensajeLabel.classList.remove("invalid-label");
  }

  return (mensajeValid);
}

function enviarComentario(event) {
  event.preventDefault();
  let form = document.getElementById("formEnviarComentario");
  let userid = form.userid.value;
  let autor = form.nombre.value;
  let email = form.email.value;
  let fecha = new Date();
  let mensaje = form.mensaje.value;
  let eventid = form.eventid.value;

  // Validar que los campos del comentario son correctos
  if (!validar(mensaje)) {
    return false; // Cortar aquí la función para no agregar comentarios ni borrar el formulario (para que sea corregido)
  }

  form.reset(); // Limpiar los campos del formulario una vez se ha insertado un nuevo comentario
  let mensajeLabel = document.getElementById("mensajeLabel");
  let emailLabel = document.getElementById("emailLabel");


  addComentario(eventid, userid, autor, email, mensaje, fecha);

  return false; // No recargar página tras procesar formulario
}

function addComentario(eventid, userid, autor, email, mensaje, fecha) {
  let lista = document.getElementById("listaComentarios");

  // Insertarlo mediante AJAX y PHP
  let url = "/core/post/postComentario.php";
  let params = 'evento=' + eventid + '&userid=' + userid + '&texto=' + mensaje + '&fecha=' + fecha;
  let xhr = new XMLHttpRequest();
  xhr.onload = function () {
    	if (xhr.status >= 200 && xhr.status < 300) {
      		if (!(xhr.response === "error")) {
              console.log(xhr.response);
              // Mostrarlo en la web
              let nuevoComentario = '' +
              '<article class="comentario">' +
                '<div class="comentario-autor">' +
                  autor +
                  '<div class="comentario-datos">' +
                    '<span class="comentario-email">' + email + '</span>' +
                    '<span class="comentario-fecha">' + fecha.getDate() + '/' + (fecha.getMonth() + 1) + '/' + fecha.getFullYear() + ' ' + fecha.getHours() + ':' + fecha.getMinutes() + '</span>' +
                  '</div>'+
                '</div>' +
                '<div class="comentario-mensaje">' +
                '<p>' + mensaje + '</p>' +
                '</div>' +
              '</article>';

              //Se incorpora el nuevo comentario
              lista.insertAdjacentHTML('beforeend', nuevoComentario);
          } else {
            console.log("error");
            console.log(xhr.response);
          }
    	} else {
    		// This will run when it's not
    		console.log('The request failed!');
    	}
  };

  xhr.open('POST', url);
  xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
  xhr.send(params);
}
