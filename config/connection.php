<?php
require_once("config.php");
date_default_timezone_set('America/Sao_Paulo');

try {
    $pdo = new PDO(
        "mysql:host=$host;port=$port;dbname=$database;charset=utf8",
        $user,
        $password,
        [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, // Mostra exceções (boa pra debug)
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC, // Retorna arrays associativos por padrão
            PDO::ATTR_EMULATE_PREPARES => false // Usa prepared statements nativos do MySQL (mais seguros)
        ]
    );
} catch (PDOException $e) {
    die("Erro ao conectar ao banco de dados: " . $e->getMessage());
}
