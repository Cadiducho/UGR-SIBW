
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
  let mensaje = form.mensaje.value;
  form.reset(); // Limpiar los campos del formulario una vez se ha insertado un nuevo comentario

  // Validar que los campos del comentario son correctos

  //----

  addComentario(autor, mensaje);

  return false; // No recargar página tras procesar formulario
}

function addComentario(autor, mensaje) {
  let lista = document.getElementById("listaComentarios");
  let nuevoComentario = '' +
  '<article class="comentario">' +
    '<div class="comentario-autor">' +
      autor +
    '</div>' +
    '<div class="comentario-mensaje">' +
    '<p>' + mensaje + '</p>' +
    '</div>' +
  '</article>';
  lista.insertAdjacentHTML('beforeend', nuevoComentario);
}
