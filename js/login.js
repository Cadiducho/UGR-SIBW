function showLoginPopUp() {
    let modal = document.getElementById('loginPopUp');
    modal.style.display='block'
}

function closeModalPopUp() {
    let modal = document.getElementById('loginPopUp');
    modal.style.display = "none";
}

function showMessage(type, message) {
    let css = (type == "info" ? "message_box_info" : "message_box_error");
    let messageBox = document.getElementById('messageBoxLogin');
    messageBox.classList = "";
    messageBox.classList.add(css);
    messageBox.innerText = message;
}

function tryLogin(event) {
    event.preventDefault();

    let form = document.getElementById("formLogin");
    let email = form.email.value;
    let password = form.password.value;

    // Intentar iniciar sesión mediante AJAX
    let url = "/core/post/postLogin.php";
    let params = 'password=' + password + '&email=' + email;
    let xhr = new XMLHttpRequest();
    xhr.onload = function () {
      	if (xhr.status >= 200 && xhr.status < 300) {
        		if (!(xhr.response === "error")) {
                showMessage("info", "Se ha iniciado sesión correctamente");

                setTimeout(function(){
                    window.location.reload(1);
                }, 1500);
            } else {
                showMessage("error", "Los datos de inicio de sesión no son válidos");
            }
      	} else {
        		showMessage("error", "No se ha podido iniciar sesión");
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
    let modal = document.getElementById('loginPopUp');
    if (event.target == modal) {
        closeModalPopUp();
    }
}
