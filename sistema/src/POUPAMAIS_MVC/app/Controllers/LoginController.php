<?php

namespace App\Controllers;

use App\Models\BD; 
use PDO;

class LoginController
{
    public function submit()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST' || empty($_POST['email']) || empty($_POST['senha'])) {
            header('Location: /POUPAMAIS_MVC/public/?erro=login_invalido');
            exit;
        }

        $email = trim($_POST['email']);
        $senha = trim($_POST['senha']);
        
        try {
            $pdo = BD::connect();
            
            $sql = "SELECT id, primeiro_nome, senha_hash FROM usuarios WHERE email = :email";
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(':email', $email);
            $stmt->execute();
            
            $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($usuario && password_verify($senha, $usuario['senha_hash'])) {
                
                if (session_status() === PHP_SESSION_NONE) {
                    session_start();
                }
                
                $_SESSION['logged_in'] = true;
                $_SESSION['user_id'] = $usuario['id'];
                $_SESSION['user_name'] = $usuario['primeiro_nome'];
                
                header('Location: /painel');
                exit;

            } else {
                header('Location: /?alerta=login_falhou');
                exit;
            }

        } catch (\PDOException $e) {
            header('Location: /?alerta=login_falhou');
            exit;
        }
    }
}