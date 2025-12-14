<?php

namespace App\Controllers;

use App\Core\Controller; 
use App\Models\BD; 
use App\Models\TransactionModel; 
use PDO; 
use PDOException; 

class PainelController extends Controller
{
    private $transactionModel;

    public function __construct()
    {
        $this->transactionModel = new TransactionModel();
        
    }

    public function index()
    {
        $this->checkAuth(); 

        $caminho_base = BASE_PATH; 
        $user_id = $_SESSION['user_id'] ?? 0;
        $nome_usuario = $_SESSION['user_name'] ?? 'Usuário'; 
        $titulo_pagina = "PoupaMais - Dashboard";
        
        $summary = $this->transactionModel->getSummary($user_id); 
        
        $transacoes_recentes = $this->transactionModel->getRecentTransactions($user_id, 5);

        $dados_grafico = $this->transactionModel->getExpenseSummaryByCategory($user_id);

        $json_categorias = json_encode(array_column($dados_grafico, 'categoria'));
        $json_valores = json_encode(array_column($dados_grafico, 'valor'));
        
        
        $data = [
            'titulo_pagina' => $titulo_pagina,
            'caminho_base' => $caminho_base,
            'nome_usuario' => $nome_usuario,

            'receitas_totais' => $summary['receitas'] ?? 0.00,
            'despesas_totais' => $summary['despesas'] ?? 0.00,
            'saldo_total' => $summary['saldo'] ?? 0.00,
            
            'transacoes_recentes' => $transacoes_recentes,

            'dados_grafico' => $dados_grafico, 
            'json_categorias' => $json_categorias,
            'json_valores' => $json_valores,
        ];
        
        $this->view('panel/painel', $data);
    }
}