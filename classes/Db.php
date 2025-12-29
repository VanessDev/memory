<?php

class DB
{
    public static function getConnection(): PDO
    {
        $host = 'localhost';
        $dbname = 'memory';
        $user = 'root';
        $password = '';

        $dsn = "mysql:host=$host;dbname=$dbname;charset=utf8mb4";
        $pdo = new PDO($dsn, $user, $password, [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
        ]);

        return $pdo;
    }
}
