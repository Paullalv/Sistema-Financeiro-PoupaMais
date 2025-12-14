<?php

namespace App\Core;

abstract class Controller
{
    /**
     * @param string 
     * @param array 
     */
    protected function view(string $view, array $data = [])
    {
        extract($data); 

        $view_path = __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'Views' . DIRECTORY_SEPARATOR . $view . '.php';

        if (file_exists($view_path)) {
            require $view_path;
        } else {
            die("Erro crítico: View '$view' não encontrada em $view_path");
        }
    }


        protected function checkAuth()
    {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
        
        $caminho_base = BASE_PATH; 
        
        $url_redirecionamento = $caminho_base . '?alerta=acesso_restrito'; 

        if (!isset($_SESSION['user_id']) || empty($_SESSION['user_id'])) {
            
            header('Location: ' . $url_redirecionamento);
            exit;
        }
    }
}