<?php

$host     = 'db';
$database = 'viacoes';
$username = 'app';
$password = 'app123';

try {
    $connection = new PDO(
        "mysql:host=$host;dbname=$database;charset=utf8",
        $username,
        $password
    );

    $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $connection->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);

} catch (PDOException $error) {
    die("Erro ao conectar com o banco de dados: " . $error->getMessage());
}