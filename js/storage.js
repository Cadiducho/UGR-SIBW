function guardarMensaje(event) {
  event.preventDefault();

  let form = document.getElementById("formMensaje");
  let mensaje = form.formMensajeInput.value;
  localStorage.setItem("mensaje", mensaje);
  updatedom();
}

function eliminarMensaje() {
  localStorage.removeItem("mensaje");
  updatedom();
}

function updatedom() {
  document.getElementById("mensaje").innerHTML = localStorage.mensaje;
}
