<?php

namespace App\Models;

use PDO;
use PDOException;

class User
{
    public function findByEmail(string $email): ?array
    {
        try {
            $pdo = BD::connect(); 
            $sql = "SELECT id, primeiro_nome, ultimo_nome, email, senha_hash FROM usuarios WHERE email = :email"; 
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(':email', $email, PDO::PARAM_STR);
            $stmt->execute();
            
            $user = $stmt->fetch(PDO::FETCH_ASSOC);
            
            if ($user) {
                $user['nome_completo'] = trim($user['primeiro_nome'] . ' ' . $user['ultimo_nome']);
            }
            
            return $user ?: null;

        } catch (PDOException $e) {
            error_log("Erro no Model User::findByEmail: " . $e->getMessage());
            return null;
        }
    }
    
    public function insert(string $primeiro_nome, string $ultimo_nome, string $email, string $senha, ?string $nascimento, ?string $genero): ?int
    {
        $pdo = BD::connect();
        $senha_hash = password_hash($senha, PASSWORD_DEFAULT); 
        
        $sql = "INSERT INTO usuarios (primeiro_nome, ultimo_nome, email, senha_hash";
        $values = "VALUES (:primeiro_nome, :ultimo_nome, :email, :senha_hash";
        
        if (!empty($genero)) {
            $sql .= ", genero";
            $values .= ", :genero";
        }
        
        if (!empty($nascimento)) {
            $sql .= ", data_nascimento";
            $values .= ", :data_nascimento";
        }
        
        $sql .= ") " . $values . ")";

        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':primeiro_nome', $primeiro_nome, PDO::PARAM_STR);
        $stmt->bindParam(':ultimo_nome', $ultimo_nome, PDO::PARAM_STR);
        $stmt->bindParam(':email', $email, PDO::PARAM_STR);
        $stmt->bindParam(':senha_hash', $senha_hash, PDO::PARAM_STR);
        
        if (!empty($genero)) {
            $stmt->bindParam(':genero', $genero, PDO::PARAM_STR);
        }
        
        if (!empty($nascimento)) {
            $stmt->bindParam(':data_nascimento', $nascimento, PDO::PARAM_STR);
        }

        if ($stmt->execute()) {
            return $pdo->lastInsertId();
        }
        return null;
        
    }
}