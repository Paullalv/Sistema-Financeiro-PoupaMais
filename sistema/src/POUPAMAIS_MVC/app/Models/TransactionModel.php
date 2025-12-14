<?php

namespace App\Models;

use App\Models\BD; 

class TransactionModel 
{
    public function getSummary(int $user_id): array
    {
        $pdo = BD::connect();

        try {
            $sql_receitas = "SELECT SUM(valor) FROM transacoes WHERE user_id = :user_id AND tipo = 'receita'";
            $stmt_receitas = $pdo->prepare($sql_receitas);
            $stmt_receitas->bindParam(':user_id', $user_id, \PDO::PARAM_INT);
            $stmt_receitas->execute();
            $receitas = (float)$stmt_receitas->fetchColumn() ?: 0.00;

            $sql_despesas = "SELECT SUM(valor) FROM transacoes WHERE user_id = :user_id AND tipo = 'despesa'";
            $stmt_despesas = $pdo->prepare($sql_despesas);
            $stmt_despesas->bindParam(':user_id', $user_id, \PDO::PARAM_INT);
            $stmt_despesas->execute();
            $despesas = (float)$stmt_despesas->fetchColumn() ?: 0.00;

            return [
                'receitas' => $receitas,
                'despesas' => $despesas,
                'saldo' => $receitas - $despesas,
            ];

        } catch (\PDOException $e) {
            error_log("Erro ao buscar resumo financeiro: " . $e->getMessage());
            return ['receitas' => 0.00, 'despesas' => 0.00, 'saldo' => 0.00];
        }
    }
    
    public function getExpenseSummaryByCategory(int $user_id): array
    {
        $pdo = BD::connect();
        try {
            $startOfMonth = date('Y-m-01');
            $endOfMonth = date('Y-m-t');
            $sql = "
                SELECT categoria, SUM(valor) as valor
                FROM transacoes
                WHERE user_id = :user_id AND tipo = 'despesa'
                    AND data_transacao BETWEEN :start_date AND :end_date
                GROUP BY categoria ORDER BY valor DESC
            ";
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(':user_id', $user_id, \PDO::PARAM_INT);
            $stmt->bindParam(':start_date', $startOfMonth);
            $stmt->bindParam(':end_date', $endOfMonth);
            $stmt->execute();
            return $stmt->fetchAll(\PDO::FETCH_ASSOC);
        } catch (\PDOException $e) {
            error_log("Erro no getExpenseSummaryByCategory: " . $e->getMessage());
            return [];
        }
    }
    
    public function getRecentTransactions(int $user_id, int $limit = 5): array
    {
        $pdo = BD::connect();

        try {
            $sql = "
                SELECT 
                    descricao, valor, tipo, categoria, data_transacao 
                FROM 
                    transacoes 
                WHERE 
                    user_id = :user_id 
                ORDER BY 
                    data_transacao DESC, id DESC 
                LIMIT :limite
            ";

            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(':user_id', $user_id, \PDO::PARAM_INT);
            $stmt->bindValue(':limite', $limit, \PDO::PARAM_INT); 
            $stmt->execute();

            return $stmt->fetchAll(\PDO::FETCH_ASSOC);

        } catch (\PDOException $e) {
            error_log("Erro ao buscar transações recentes: " . $e->getMessage());
            return [];
        }
    }


    public function insertTransaction(array $data): bool
    {
        $pdo = BD::connect();

        if (!isset($data['descricao'], $data['valor'], $data['tipo'], $data['categoria'], $data['data_transacao'], $data['user_id'])) {
            error_log("Dados incompletos para inserção de transação.");
            return false;
        }

        try {
            $sql = "
                INSERT INTO transacoes 
                    (user_id, tipo, valor, descricao, categoria, data_transacao)
                VALUES 
                    (:user_id, :tipo, :valor, :descricao, :categoria, :data_transacao)
            ";

            $stmt = $pdo->prepare($sql);

            $stmt->bindParam(':user_id', $data['user_id'], \PDO::PARAM_INT);
            $stmt->bindParam(':tipo', $data['tipo']);
            $stmt->bindParam(':valor', $data['valor']);
            $stmt->bindParam(':descricao', $data['descricao']);
            $stmt->bindParam(':categoria', $data['categoria']);
            $stmt->bindParam(':data_transacao', $data['data_transacao']);

            return $stmt->execute();
            
        } catch (\PDOException $e) {
            error_log("Erro ao inserir transação: " . $e->getMessage());
            return false;
        }
    }
} 
