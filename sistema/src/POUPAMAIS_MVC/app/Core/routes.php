<?php

use App\Controllers\HomeController;
use App\Controllers\UserController;
get('/', function () {
    $controller = new \App\Controllers\HomeController();
    $controller->index();
});

post('/login/submit', function () {
    $controller = new \App\Controllers\UserController();
    $controller->handleLogin();
});
post('/cadastro/submit', function () {
    $controller = new \App\Controllers\UserController();
    $controller->handleCadastro();
});

get('/logout', function () {
    $controller = new \App\Controllers\UserController();
    $controller->logout();
});

get('/painel', function () {
    
    if (!isset($_SESSION['user_id']) || empty($_SESSION['user_id'])) {
        header("Location: /POUPAMAIS_MVC/public/?alerta=acesso_restrito");
        exit();
    }
    
    $controller = new \App\Controllers\PainelController();
    $controller->index();
});


