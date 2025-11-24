<?php

/**
 * 
 * @param string 
 * @return PDO 
 */
function getPdoConnection(string $dbName): PDO {
    $host = 'localhost'; 
    $user = 'root';      
    $pass = '';        
    $charset = 'utf8mb4';

    $dsn = "mysql:host=$host;dbname=$dbName;charset=$charset";
    $options = [
        PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES   => false,
    ];

    try {
        return new PDO($dsn, $user, $pass, $options);
    } catch (\PDOException $e) {
        die("Error de conexión a la base de datos $dbName: " . $e->getMessage());
    }
}