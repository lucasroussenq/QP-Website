<?php
require 'db.php';

function fetchAllBusCompanies(PDO $connection): array
{
    $query = $connection->query("SELECT * FROM bus_companies ORDER BY created_at DESC");
    return $query->fetchAll();
}

$busCompanies = fetchAllBusCompanies($connection);
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Cadastro de Viações</title>

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

        .btn {
            background: #1a2e6e;
            color: white;
            padding: 10px 16px;
            text-decoration: none;
            border-radius: 6px;
            display: inline-block;
            font-weight: bold;
            transition: all 0.25s ease;
        }

        /* HOVER */
        .btn:hover {
            background: #2d5bff;
            transform: translateY(-2px) scale(1.03);
            box-shadow: 0 4px 10px rgba(0,0,0,0.15);
        }

        /* CLICK (efeito pressionar) */
        .btn:active {
            transform: scale(0.97);
            box-shadow: 0 2px 4px rgba(0,0,0,0.2);
        }

        /* CONTAINER */
        .container {
            width: 90%;
            margin: auto;
        }

        /* CARD */
        .table-card {
            background: #fff;
            border-radius: 12px;
            box-shadow: 0 2px 12px rgba(0,0,0,0.07);
            overflow: hidden;
        }

        .table-card-header {
            padding: 15px 20px;
            border-bottom: 1px solid #eee;
            display: flex;
            justify-content: space-between;
        }

        /* TABLE */
        table {
            width: 100%;
            border-collapse: collapse;
        }

        th {
            padding: 10px;
            background: #f8f9ff;
            font-size: 15px;
            text-align: left;
            border: 1px solid #eee;
        }

        td {
            padding: 10px;
            border-bottom: 1px solid #eee;
            border: 1px solid #eee;
        }

        tr:hover {
            background: #fafbff;
        }

        .company-name {
            font-weight: bold;
        }

        .company-url {
            color: blue;
            text-decoration: none;
        }

        /* STATUS */
        .badge {
            padding: 4px 10px;
            border-radius: 20px;
            font-size: 12px;
        }

        .badge-active {
            background: #dcfce7;
            color: green;
            font-weight: bold;
        }

        .badge-inactive {
            background: red;
            font-weight: bold;
            color: white;
        }

        /* ACTIONS */
        .action-buttons {
            display: flex;
            gap: 8px;
        }

        .edit {
            color: #1a2e6e;
        }

        .delete {
            color: red;
        }

        /* EMPTY */
        .empty {
            padding: 20px;
            text-align: center;
        }
    </style>
</head>

<body>

<div class="header">
    <h1>Cadastro de Viações</h1>
    <a href="create.php" class="btn">+ Nova Viação</a>
</div>

<div class="container">

    <div class="table-card">

        <div class="table-card-header">
            <h3>Lista</h3>
            <span><?= count($busCompanies) ?> registro(s)</span>
        </div>

        <?php if (empty($busCompanies)): ?>
            <div class="empty">
                Nenhuma viação cadastrada
            </div>
        <?php else: ?>

            <table>
                <tr>
                    <th>ID</th>
                    <th>Nome</th>
                    <th>URL</th>
                    <th>Cidade</th>
                    <th>Status</th>
                    <th>Criado em</th>
                    <th>Atualizado em</th>
                    <th>Ações</th>
                </tr>

                <?php foreach ($busCompanies as $busCompany): ?>
                    <tr>
                        <td><?= $busCompany['id'] ?></td>

                        <td class="company-name">
                            <?= htmlspecialchars($busCompany['name']) ?>
                        </td>

                        <td>
                            <a class="company-url"
                               href="<?= htmlspecialchars($busCompany['url']) ?>"
                               target="_blank">
                                <?= htmlspecialchars($busCompany['url']) ?>
                            </a>
                        </td>

                        <td><?= htmlspecialchars($busCompany['city']) ?></td>

                        <td>
        <span class="badge badge-<?= $busCompany['status'] ?>">
            <?= $busCompany['status'] === 'active' ? 'Ativo' : 'Inativo' ?>
        </span>
                        </td>

                        <td>
                            <?= date('d/m/Y H:i', strtotime($busCompany['created_at'])) ?>
                        </td>

                        <td>
                            <?= date('d/m/Y H:i', strtotime($busCompany['updated_at'])) ?>
                        </td>

                        <td>
                            <div class="action-buttons">
                                <a href="edit.php?id=<?= $busCompany['id'] ?>" class="edit">Editar</a>
                                <a href="delete.php?id=<?= $busCompany['id'] ?>" class="delete"
                                   onclick="return confirm('Tem certeza que deseja excluir?')">
                                    Excluir
                                </a>
                            </div>
                        </td>
                    </tr>
                <?php endforeach; ?>

            </table>

        <?php endif; ?>

    </div>

</div>

</body>
</html>