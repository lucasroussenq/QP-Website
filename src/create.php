<?php

require 'db.php';

$errors     = [];
$busCompany = [];

function validateBusCompanyForm(array $formData): array
{
    $errors = [];

    if (empty(trim($formData['name']))) {
        $errors[] = 'O nome da viação é obrigatório.';
    }

    if (empty(trim($formData['url']))) {
        $errors[] = 'A URL é obrigatória.';
    } elseif (!filter_var($formData['url'], FILTER_VALIDATE_URL)) {
        $errors[] = 'A URL informada não é válida.';
    }

    if (empty(trim($formData['city']))) {
        $errors[] = 'A cidade é obrigatória.';
    }

    if (!in_array($formData['status'], ['active', 'inactive'])) {
        $errors[] = 'Status inválido.';
    }

    return $errors;
}

function saveBusCompany(PDO $connection, array $formData): void
{
    $statement = $connection->prepare("
        INSERT INTO bus_companies (name, url, city, status)
        VALUES (:name, :url, :city, :status)
    ");

    $statement->execute([
        ':name'   => $formData['name'],
        ':url'    => $formData['url'],
        ':city'   => $formData['city'],
        ':status' => $formData['status'],
    ]);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $formData = [
        'name'   => trim($_POST['name']   ?? ''),
        'url'    => trim($_POST['url']    ?? ''),
        'city'   => trim($_POST['city']   ?? ''),
        'status' => trim($_POST['status'] ?? 'active'),
    ];

    $errors = validateBusCompanyForm($formData);

    if (empty($errors)) {
        saveBusCompany($connection, $formData);
        header('Location: index.php');
        exit;
    }

    $busCompany = $formData;
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Nova Viação</title>

    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f5f5f5;
            margin: 0;
        }

        /* HEADER */
        .header {
            width: 90%;
            margin: 30px auto 15px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        /* BOTÕES */
        .btn {
            background: #1a2e6e;
            color: white;
            padding: 10px 16px;
            text-decoration: none;
            border-radius: 6px;
            border: none;
            cursor: pointer;
            display: inline-block;
            font-weight: bold;
            transition: all 0.25s ease;
        }

        .btn:hover {
            background: #2d5bff;
            transform: translateY(-2px) scale(1.03);
            box-shadow: 0 4px 10px rgba(0,0,0,0.15);
        }

        .btn:active {
            transform: scale(0.97);
            box-shadow: 0 2px 4px rgba(0,0,0,0.2);
        }

        .btn-cancel {
            background: gray;
        }

        .btn-cancel:hover {
            background: #555;
        }

        /* CONTAINER */
        .container {
            width: 90%;
            max-width: 650px;
            margin: auto;
        }

        /* CARD */
        .form-card {
            background: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 2px 12px rgba(0,0,0,0.07);
        }

        /* FORM */
        .form-group {
            margin-bottom: 15px;
        }

        label {
            display: block;
            margin-bottom: 5px;
            font-size: 13px;
        }

        input, select {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;

            transition: 0.2s;
        }

        input:focus, select:focus {
            border-color: #1a2e6e;
            box-shadow: 0 0 5px rgba(26,46,110,0.3);
            outline: none;
        }

        /* ACTIONS */
        .form-actions {
            margin-top: 20px;
            display: flex;
            gap: 10px;
        }

        /* ERROS */
        .error-list {
            background: #ffe5e5;
            border: 1px solid red;
            padding: 10px;
            margin-bottom: 15px;
            border-radius: 5px;
        }
    </style>
</head>

<body>

<div class="header">
    <h1>Nova Viação</h1>
    <a href="index.php" class="btn">Voltar</a>
</div>

<div class="container">

    <?php if (!empty($errors)): ?>
        <div class="error-list">
            <?php foreach ($errors as $error): ?>
                <div><?= htmlspecialchars($error) ?></div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>

    <form method="POST" class="form-card">

        <?php require 'partials/form.php'; ?>

        <div class="form-actions">
            <button type="submit" class="btn">Salvar</button>
            <a href="index.php" class="btn btn-cancel">Cancelar</a>
        </div>

    </form>

</div>

</body>
</html>