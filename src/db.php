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

function fetchActiveBusCompanies(PDO $pdo): array
{
    $cacheDir = __DIR__ . '/cache';
    $cacheFile = $cacheDir . '/companies.json';

    // cria pasta se não existir
    if (!is_dir($cacheDir)) {
        mkdir($cacheDir, 0777, true);
    }

    if (file_exists($cacheFile) && time() - filemtime($cacheFile) < 30) {
        return json_decode(file_get_contents($cacheFile), true);
    }
    // busca no banco
    $stmt = $pdo->query("
        SELECT name, logo 
        FROM bus_companies
        WHERE status = 'active'
        ORDER BY name ASC
    ");

    $data = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // salva cache
    file_put_contents($cacheFile, json_encode($data));

    return $data;
}