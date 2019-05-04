/*
  Scripts para el registro y el inicio de sesión de usuarios
*/


// Mostrar el modal de login
function showLoginPopUp() {
    let modal = document.getElementById('loginPopUp');
    modal.style.display='block'
}

// Mostrar el modal de registro
function showRegisterPopUp() {
    let modal = document.getElementById('registerPopUp');
    modal.style.display='block'
}

// Cerrar el modal de login
function closeLoginModalPopUp() {
    let modal = document.getElementById('loginPopUp');
    modal.style.display = "none";
}

// Cerrar el modal de registro
function closeRegisterModalPopUp() {
    let modal = document.getElementById('registerPopUp');
    modal.style.display = "none";
}

// Mostrar un mensaje en un modal. Tipos: info o error
function showMessage(modal, type, message) {
    let css = (type == "info" ? "message_box_info" : "message_box_error");
    let messageBox = modal.querySelector('#messageBox');
    messageBox.classList = "";
    messageBox.classList.add(css);
    messageBox.innerText = message;
}

function tryLogin(event) {
    event.preventDefault();

    let modalLogin = document.getElementById('loginPopUp');
    let form = modalLogin.querySelector("#formLogin");
    let email = form.email.value;
    let password = form.password.value;

    // Intentar iniciar sesión mediante AJAX
    let url = "/core/post/postLogin.php";
    let params = 'password=' + password + '&email=' + email;
    let xhr = new XMLHttpRequest();
    xhr.onload = function () {
      	if (xhr.status >= 200 && xhr.status < 300) {
        		if (!(xhr.response === "error")) {
                showMessage(modalLogin, "info", "Se ha iniciado sesión correctamente");

                setTimeout(function(){
                    window.location.reload(1);
                }, 1500);
            } else {
                showMessage(modalLogin, "error", "Los datos de inicio de sesión no son válidos");
            }
      	} else {
        		showMessage(modalLogin, "error", "No se ha podido iniciar sesión");
      	}
    };

    xhr.open('POST', url);
    xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
    xhr.send(params);

    return false;
}

function tryRegister(event) {
    event.preventDefault();

    let modalRegister = document.getElementById('registerPopUp');
    let form = modalRegister.querySelector("#formRegister");
    let email = form.email.value;
    let nickname = form.nickname.value;
    let password = form.password.value;
    let passwordConfirm = form.passwordConfirm.value;

    if (password != passwordConfirm) {
        showMessage(modalRegister, "error", "Las contraseñas no coinciden");
        return;
    }

    // Intentar iniciar sesión mediante AJAX
    let url = "/core/post/postRegister.php";
    let params = 'password=' + password + '&email=' + email + '&nickname=' + nickname;
    let xhr = new XMLHttpRequest();
    xhr.onload = function () {
      	if (xhr.status >= 200 && xhr.status < 300) {
        		if (xhr.response === "error") {
                showMessage(modalRegister, "error", "Se ha producido un error");
            } else if (xhr.response === "email") {
                showMessage(modalRegister, "error", "Ya existe un usuario con ese email");
            } else {
                showMessage(modalRegister, "info", "Te has registrado correctamente");
                setTimeout(function() {
                    let modalLogin = document.getElementById('loginPopUp');
                    let emailInput = modalLogin.querySelector('input[name="email"]');
                    emailInput.value = email;
                    closeRegisterModalPopUp();
                    showLoginPopUp();
                }, 1100);
            }
      	} else {
        		showMessage(modalRegister, "error", "No se ha podido registrar");
      	}
    };

    xhr.open('POST', url);
    xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
    xhr.send(params);

    return false;
}

function closeSession() {
    let url = "/core/post/postCloseSession.php";
    let xhr = new XMLHttpRequest();
    let params = '';
    xhr.onload = function () {
        console.log(xhr.status);
        if (xhr.status >= 200 && xhr.status < 300) {
            console.log(xhr.response);
            if (xhr.response === "closed") {
                console.log("Sessión destruida");

                setTimeout(function(){
                    window.location.reload(1);
                }, 500);
            }
        }
    };

    xhr.open('POST', url);
    xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
    xhr.send(params);
    return false;
}

// When the user clicks anywhere outside of the modal, close it
window.onclick = function(event) {
    let modalLogin = document.getElementById('loginPopUp');
    if (event.target == modalLogin) {
        closeLoginModalPopUp();
    }
    let modalRegister = document.getElementById('registerPopUp');
    if (event.target == modalRegister) {
        closeRegisterModalPopUp();
    }
}
