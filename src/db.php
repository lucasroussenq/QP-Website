<?php

$host     = 'db';
$database = 'viacoes';
$username = 'app';
$password = 'app123';

try {
    $pdo = new PDO(
        "mysql:host=$host;dbname=$database;charset=utf8",
        $username,
        $password
    );

    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
    $pdo->exec("SET time_zone='-03:00'");

} catch (PDOException $error) {
    die("Erro ao conectar com o banco de dados: " . $error->getMessage());
}
