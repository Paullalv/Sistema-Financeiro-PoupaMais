<?php

namespace App\Models;

use PDO;
use PDOException;

class BD
{
    private const HOST = 'db';
    private const DB_NAME = 'poupamais'; 
    private const USER = 'root';        
    private const PASSWORD = 'root';       
    private const CHARSET = 'utf8mb4';

    private static ?PDO $instance = null;

    public static function connect(): PDO
    {
        if (self::$instance === null) {
            $dsn = "mysql:host=" . self::HOST . ";dbname=" . self::DB_NAME . ";charset=" . self::CHARSET;
            $options = [
                PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES   => false,
            ];

            try {
                self::$instance = new PDO($dsn, self::USER, self::PASSWORD, $options);
            } catch (PDOException $e) {
                throw new PDOException("Erro de conexão ao BD. Credenciais incorretas ou BD 'POUPAMAIS' não existe: " . $e->getMessage());
            }
        }
        return self::$instance;
    }
}