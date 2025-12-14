<?php

namespace App\Controllers;

use App\Core\Controller; 
use App\Models\TransactionModel;

class TransactionController extends Controller
{
    private $transactionModel;

    public function __construct()
    {
        $this->transactionModel = new TransactionModel();
    }


    public function handleReceitas()
    {
        $this->checkAuth();
        $caminho_base = BASE_PATH;
        
        $mensagem_raw = $_GET['alerta'] ?? null; 
        $mensagem = null;

        if ($mensagem_raw) {
            if (strpos($mensagem_raw, 'msg-sucesso=') === 0) {
                $mensagem = ['tipo' => 'sucesso', 'texto' => urldecode(str_replace('msg-sucesso=', '', $mensagem_raw))];
            } elseif (strpos($mensagem_raw, 'msg-erro=') === 0) {
                $mensagem = ['tipo' => 'erro', 'texto' => urldecode(str_replace('msg-erro=', '', $mensagem_raw))];
            }
        }
        
        $data = [
            'titulo_pagina' => 'Adicionar Nova Receita',
            'caminho_base' => $caminho_base,
            'mensagem' => $mensagem 
        ];
        $this->view('transacoes/receitas', $data);
    }

    public function handleSubmitReceita()
    {
        $this->checkAuth();
        $caminho_base = BASE_PATH;
        $tipo_transacao = 'receitas';

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            
            if (!isset($_POST['csrf_token']) || !validate_csrf($_POST['csrf_token'])) {
                $alerta = urlencode('msg-erro=Erro de segurança (CSRF). Tente novamente.');
                header('Location: ' . $caminho_base . $tipo_transacao . '?alerta=' . $alerta);
                exit;
            }

            $valor_raw = $_POST['valor'] ?? '';
            $descricao = $_POST['descricao'] ?? ''; 
            $data_transacao = $_POST['data_transacao'] ?? '';
            $categoria = $_POST['categoria'] ?? '';

            $valor_limpo = str_replace(',', '.', str_replace('.', '', $valor_raw));
            $valor = filter_var($valor_limpo, FILTER_VALIDATE_FLOAT);

            if ($valor === false || $valor === null || $valor <= 0 || empty($data_transacao) || empty($categoria)) {
                $alerta = urlencode('msg-erro=Por favor, preencha Categoria, Valor e Data corretamente. O valor deve ser maior que zero.');
                header('Location: ' . $caminho_base . $tipo_transacao . '?alerta=' . $alerta);
                exit;
            }

            $descricao = filter_var($descricao, FILTER_SANITIZE_SPECIAL_CHARS);
            $data_transacao = filter_var($data_transacao, FILTER_SANITIZE_SPECIAL_CHARS);
            $categoria = filter_var($categoria, FILTER_SANITIZE_SPECIAL_CHARS);

            $data = [
                'user_id' => $_SESSION['user_id'] ?? 0,
                'tipo' => 'receita',
                'valor' => $valor,
                'descricao' => $descricao, 
                'categoria' => $categoria,
                'data_transacao' => $data_transacao
            ];

            $success = $this->transactionModel->insertTransaction($data);

            if ($success) {
                $alerta = urlencode('msg-sucesso=Receita registrada com sucesso!');
                header('Location: ' . $caminho_base . $tipo_transacao . '?alerta=' . $alerta); 
                exit;
            } else {
                $alerta = urlencode('msg-erro=Erro ao registrar receita no banco de dados. Tente novamente.');
                header('Location: ' . $caminho_base . $tipo_transacao . '?alerta=' . $alerta);
                exit;
            }
        } else {
            header('Location: ' . $caminho_base . $tipo_transacao);
            exit;
        }
    }
    
    
    public function handleDespesas()
    {
        $this->checkAuth();
        $caminho_base = BASE_PATH;
        
        $mensagem_raw = $_GET['alerta'] ?? null; 
        $mensagem = null;

        if ($mensagem_raw) {
            if (strpos($mensagem_raw, 'msg-sucesso=') === 0) {
                $mensagem = ['tipo' => 'sucesso', 'texto' => urldecode(str_replace('msg-sucesso=', '', $mensagem_raw))];
            } elseif (strpos($mensagem_raw, 'msg-erro=') === 0) {
                $mensagem = ['tipo' => 'erro', 'texto' => urldecode(str_replace('msg-erro=', '', $mensagem_raw))];
            }
        }
        
        $data = [
            'titulo_pagina' => 'Adicionar Nova Despesa',
            'caminho_base' => $caminho_base,
            'mensagem' => $mensagem 
        ];

        $this->view('transacoes/despesas', $data);
    }
    
    public function handleSubmitDespesa()
    {
        $this->checkAuth();
        $caminho_base = BASE_PATH;
        $tipo_transacao = 'despesas'; 

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            
            if (!isset($_POST['csrf_token']) || !validate_csrf($_POST['csrf_token'])) {
                $alerta = urlencode('msg-erro=Erro de segurança (CSRF). Tente novamente.');
                header('Location: ' . $caminho_base . $tipo_transacao . '?alerta=' . $alerta);
                exit;
            }

            $valor_raw = $_POST['valor'] ?? '';
            $descricao = $_POST['descricao'] ?? ''; 
            $data_transacao = $_POST['data_transacao'] ?? '';
            $categoria = $_POST['categoria'] ?? '';
            
            $valor_limpo = str_replace(',', '.', str_replace('.', '', $valor_raw));
            $valor = filter_var($valor_limpo, FILTER_VALIDATE_FLOAT);

            if ($valor === false || $valor === null || $valor <= 0 || empty($data_transacao) || empty($categoria)) {
                $alerta = urlencode('msg-erro=Por favor, preencha Categoria, Valor e Data corretamente. O valor deve ser maior que zero.');
                header('Location: ' . $caminho_base . $tipo_transacao . '?alerta=' . $alerta);
                exit;
            }
            
            $descricao = filter_var($descricao, FILTER_SANITIZE_SPECIAL_CHARS);
            $data_transacao = filter_var($data_transacao, FILTER_SANITIZE_SPECIAL_CHARS);
            $categoria = filter_var($categoria, FILTER_SANITIZE_SPECIAL_CHARS);

            $data = [
                'user_id' => $_SESSION['user_id'] ?? 0,
                'tipo' => 'despesa', 
                'valor' => $valor,
                'descricao' => $descricao, 
                'categoria' => $categoria,
                'data_transacao' => $data_transacao
            ];

            $success = $this->transactionModel->insertTransaction($data);

            if ($success) {
                $alerta = urlencode('msg-sucesso=Despesa registrada com sucesso!');
                header('Location: ' . $caminho_base . $tipo_transacao . '?alerta=' . $alerta);
                exit;
            } else {
                $alerta = urlencode('msg-erro=Erro ao registrar despesa no banco de dados. Tente novamente.');
                header('Location: ' . $caminho_base . $tipo_transacao . '?alerta=' . $alerta);
                exit;
            }
        } else {
            header('Location: ' . $caminho_base . $tipo_transacao);
            exit;
        }
    } 
}