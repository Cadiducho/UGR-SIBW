function mostrarComentarios() {
  let botonMostrar = document.getElementById("mostrarModificarDatos");
  let botonOcultar = document.getElementById("ocultarModificarDatos");

  //Se establece lo que ocurre al pulsar ocultar/mostrar comentarios
  botonOcultar.style.display = "block";

  let cajaDatosPersonales = document.getElementById("cajaDatosPersonales");
  if (cajaDatosPersonales.style.display === "" || cajaDatosPersonales.style.display === "none") {
    cajaDatosPersonales.style.display = "block";
    botonOcultar.style.display = "block";
    botonMostrar.style.display = "none";
  } else {
    cajaDatosPersonales.style.display = "none";
    botonOcultar.style.display = "none";
    botonMostrar.style.display = "block";
  }
}
