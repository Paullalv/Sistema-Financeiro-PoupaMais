<?php

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

require_once __DIR__ . '/../vendor/autoload.php';

require_once __DIR__ . '/../app/Helpers/helpers.php';

$caminho_base = '/';
define('BASE_PATH', $caminho_base); 

if (!function_exists('formatar_moeda')) {
     function formatar_moeda($valor) {
         return 'R$ ' . number_format($valor, 2, ',', '.');
     }
}
if (!function_exists('get_category_icon')) {
     function get_category_icon($categoria, $tipo) {
         $icons = [
            'alimentacao' => 'fas fa-hamburger',
            'transporte' => 'fas fa-bus',
            'salario' => 'fas fa-money-bill-wave',
            'investimento' => 'fas fa-chart-line',
            'outros' => ($tipo == 'receita' ? 'fas fa-plus' : 'fas fa-question-circle'),
        ];
        return $icons[strtolower($categoria)] ?? $icons['outros'];
     }
}

$uri = $_GET['url'] ?? '';
$uri_parts = explode('/', trim($uri, '/'));

$controllerName = $uri_parts[0] ?? ''; 

use App\Controllers\PainelController;
use App\Controllers\UserController;
use App\Controllers\TransactionController;
use App\Controllers\LoginController;

$uri = $_GET['url'] ?? '';

if ($controllerName === 'painel') {
    $controller = new PainelController();
    $controller->index();
} 
elseif ($controllerName === 'login_submit') {
    $controller = new LoginController();
    $controller->submit();
} 
elseif ($controllerName === 'cadastro_submit') {
    $controller = new UserController();
    $controller->handleCadastro();
}
elseif ($controllerName === 'logout') {
    $controller = new UserController();
    $controller->handleLogout();
}
elseif ($controllerName === 'receitas') {
    $controller = new TransactionController();
    $controller->handleReceitas();
}
elseif ($controllerName === 'receitas_submit') {
    $controller = new TransactionController();
    $controller->handleSubmitReceita();
}
elseif ($controllerName === 'despesas') {
    $controller = new TransactionController();
    $controller->handleDespesas();
}
elseif ($controllerName === 'despesas_submit') {
    $controller = new TransactionController();
    $controller->handleSubmitDespesa();
}

else {
    $view_file = __DIR__ . '/../app/Views/home/index.php'; 

    if (file_exists($view_file)) {
        require $view_file; 
    } else {
        die("ERRO CRÍTICO: Não foi possível encontrar a View Inicial. O caminho esperado era: " . $view_file);
    }
}