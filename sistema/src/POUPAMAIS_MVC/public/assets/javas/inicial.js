var loginModal = document.getElementById("loginModal");
var btnEntrar = document.getElementById("btn-entrar"); 
var closeLogin = document.getElementsByClassName("close-button")[0];
var cadastroModal = document.getElementById("cadastroModal");
var btnCadastro = document.getElementById("btn-cadastro"); 
var closeCadastro = document.querySelector("#cadastroModal .close-cadastro");
var linkLoginNoCadastro = document.getElementById("link-login-no-cadastro");


if (btnEntrar) {
    btnEntrar.onclick = function(event) {
        event.preventDefault(); 
        loginModal.style.display = "flex";
    }
}
if (closeLogin) {
    closeLogin.onclick = function() {
        loginModal.style.display = "none";
    }
}


if (btnCadastro) {
    btnCadastro.onclick = function(event) {
        event.preventDefault(); 
        cadastroModal.style.display = "flex"; 
    }
}

if (closeCadastro) {
    closeCadastro.onclick = function() {
        console.log("Botão de fechar do Cadastro clicado!"); 
        cadastroModal.style.display = "none"; 
    }
}

if (linkLoginNoCadastro) {
    linkLoginNoCadastro.onclick = function(event) {
        event.preventDefault(); 
        cadastroModal.style.display = "none"; 
        loginModal.style.display = "flex"; 
    }
}



window.onclick = function(event) {
    if (event.target == loginModal) {
        loginModal.style.display = "none";
    }
    if (event.target == cadastroModal) {
        cadastroModal.style.display = "none";
    }
}


