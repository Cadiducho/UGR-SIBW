
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

function enviarComentario(event) {
  event.preventDefault();
  let form = document.getElementById("formEnviarComentario");
  let autor = form.nombre.value;
  let email = form.email.value;
  let fecha = new Date();
  let mensaje = form.mensaje.value;

  form.reset(); // Limpiar los campos del formulario una vez se ha insertado un nuevo comentario

  //Se eliminan las palbras que hemos determinado como prohibidas
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

		     //Se sustituyen sus caracteres por "*"
         mensaje = mensaje.replace(new RegExp(palabrasProhibidas[numeroPalabrasProhibidas], "g"), mensajeModificado);
      }
  }

  // Validar que los campos del comentario son correctos

  //----

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
