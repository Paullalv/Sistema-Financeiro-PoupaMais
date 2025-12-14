<?php

namespace App\Controllers;

use App\Models\User;

class UserController
{
   public function handleLogin()
    {
        $caminho_base = BASE_PATH; 

        $email = filter_var($_POST['email'] ?? '', FILTER_SANITIZE_EMAIL);
        $senha_digitada = $_POST['senha'] ?? '';
        
        $login_successful = false; 
        $user_data = [];

        if (!empty($email) && !empty($senha_digitada)) {
            $userModel = new User();
            $user_data = $userModel->findByEmail($email);

            if ($user_data && password_verify($senha_digitada, $user_data['senha_hash'])) {
                $login_successful = true;
            }
        }
        
        if ($login_successful) { 
            $_SESSION['logged_in'] = TRUE;
            $_SESSION['user_id'] = $user_data['id']; 
            $_SESSION['user_name'] = $user_data['primeiro_nome']; 
            $_SESSION['user_email'] = $user_data['email'];

            header('Location: ' . $caminho_base . 'painel'); 
            exit; 
        
        } else {
            header('Location: ' . $caminho_base . '?alerta=login_falhou'); 
            exit;
        }
    }

    public function handleCadastro()
    {
        $primeiro_nome = $_POST['primeiro_nome'] ?? '';
        $ultimo_nome = $_POST['ultimo_nome'] ?? '';
        $email = $_POST['email'] ?? '';
        $senha = $_POST['senha'] ?? '';
        $confirmar_senha = $_POST['confirmar_senha'] ?? ''; 
        $nascimento = $_POST['nascimento'] ?? null;
        $genero = $_POST['genero'] ?? null;
        
        $caminho_base = BASE_PATH;

        if ($senha !== $confirmar_senha || empty($senha)) {
            header("Location: " . $caminho_base . "?erro=senhas_nao_conferem"); 
            exit();
        }
        
        $userModel = new User();
        
        try {
             $id = $userModel->insert($primeiro_nome, $ultimo_nome, $email, $senha, $nascimento, $genero);

            if ($id) {
                header("Location: " . $caminho_base . "?sucesso=cadastro"); 
                exit();
            } else {
                header("Location: " . $caminho_base . "?erro=cadastro_falhou"); 
                exit();
            }
        } catch (\PDOException $e) {
            echo "<h1>ERRO CRÍTICO IRRECUPERÁVEL</h1>";
            echo "<h2>FALHA NO BANCO DE DADOS DURANTE O CADASTRO.</h2>";
            echo "<h3>DETALHES DO ERRO PDO:</h3>";
            echo "<p>" . $e->getMessage() . "</p>";
            exit(); 
        } catch (\Error $e) {
            die("ERRO FATAL DE PHP: " . $e->getMessage());
        }

    }

            public function handleLogout()
        {
            if (session_status() == PHP_SESSION_NONE) {
                session_start();
            }

            $_SESSION = array();

            session_destroy();


            $caminho_base = BASE_PATH; 
            header('Location: ' . $caminho_base . '?sucesso=logout');
            exit;
        }

    }
