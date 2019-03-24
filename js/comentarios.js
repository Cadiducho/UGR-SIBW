
function mostrarComentarios() {
  let botonComentario = document.getElementById("mostrarComentarios");
  let botonOcultar = document.getElementById("ocultarComentarios");
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

function filtrarContenido(event)
{
  //event.preventDefault();
  let textarea = document.getElementById("areaMensaje");
  let mensaje = textarea.value;

  //Se eliminan las palabras que hemos determinado como prohibidas
  let palabrasProhibidas = ["futbol", "baloncesto", "sonic", "bolos", "natacion", "surf", "patinaje", "snowboard", "tiro", "skate"];
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

function validar(email, autor, mensaje) {
  let regex = new RegExp("[a-z0-9!#$%&'*+/=?^_`{|}~-]+(?:\.[a-z0-9!#$%&'*+/=?^_`{|}~-]+)*@(?:[a-z0-9](?:[a-z0-9-]*[a-z0-9])?\.)+(?:[A-Z]{2}|com|org|net|io|es|uk|co|fr|it)");
  let emailValid = regex.test(email);

  let emailInput = document.getElementById("emailInput");
  let emailLabel = document.getElementById("emailLabel");

  let autorInput = document.getElementById("autorInput");
  let autorLabel = document.getElementById("autorLabel");

  let areaMensaje = document.getElementById("areaMensaje");
  let mensajeLabel = document.getElementById("mensajeLabel");

  if (!emailValid) {
    emailInput.classList.add("invalid-input");
    emailLabel.classList.add("invalid-label");
  } else {
    emailInput.classList.remove("invalid-input");
    emailLabel.classList.remove("invalid-label");
  }

  let autorValid = (autor.length >= 3);
  if (!autorValid) {
    autorInput.classList.add("invalid-input");
    autorLabel.classList.add("invalid-label");
  } else {
    autorInput.classList.remove("invalid-input");
    autorLabel.classList.remove("invalid-label");
  }

  let mensajeValid = (mensaje.length >= 3);
  if (!mensajeValid) {
    areaMensaje.classList.add("invalid-input");
    mensajeLabel.classList.add("invalid-label");
  } else {
    areaMensaje.classList.remove("invalid-input");
    mensajeLabel.classList.remove("invalid-label");
  }

  return (emailValid && mensajeValid && autorValid);
}

function enviarComentario(event) {
  event.preventDefault();
  let form = document.getElementById("formEnviarComentario");
  let autor = form.nombre.value;
  let email = form.email.value;
  let fecha = new Date();
  let mensaje = form.mensaje.value;

  // Validar que los campos del comentario son correctos
  if (!validar(email, autor, mensaje)) {
    return false; // Cortar aquí la función para no agregar comentarios ni borrar el formulario (para que sea corregido)
  }

  form.reset(); // Limpiar los campos del formulario una vez se ha insertado un nuevo comentario
  let mensajeLabel = document.getElementById("mensajeLabel");
  let emailLabel = document.getElementById("emailLabel");


  addComentario(autor, email, mensaje, fecha);

  return false; // No recargar página tras procesar formulario
}

function addComentario(autor, email, mensaje, fecha) {
  let lista = document.getElementById("listaComentarios");
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
  lista.insertAdjacentHTML('beforeend', nuevoComentario);
}
