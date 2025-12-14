<?php

if (!function_exists('formatar_moeda')) {
    function formatar_moeda(float $valor): string
    {
        $valor = (float)$valor; 
        return 'R$ ' . number_format($valor, 2, ',', '.');
    }
}


if (!function_exists('set_csrf')) {
    function set_csrf()
    {
        if (empty($_SESSION['csrf_token'])) {
            $_SESSION['csrf_token'] = bin2hex(random_bytes(32)); 
        }
        echo '<input type="hidden" name="csrf_token" value="' . htmlspecialchars($_SESSION['csrf_token']) . '">';
    }
}

if (!function_exists('validate_csrf')) {
    function validate_csrf(string $token): bool
    {
        $is_valid = isset($_SESSION['csrf_token']) && hash_equals($_SESSION['csrf_token'], $token);
        
        return $is_valid;
    }
}

if (!function_exists('get_category_icon')) {
    function get_category_icon($categoria, $tipo)
    {
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