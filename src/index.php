<?php

require 'db.php';
$pdo = $pdo ?? null;

// Busca viações com filtros opcionais de nome e status
function fetchAllBusCompanies(PDO $pdo, string $filterName = '', string $filterStatus = ''): array
{
    $conditions = [];
    $params     = [];

    if (!empty($filterName)) {
        $conditions[] = "name LIKE :name";
        $params[':name'] = '%' . $filterName . '%';
    }

    if ($filterStatus === 'active' || $filterStatus === 'inactive') {
        $conditions[] = "status = :status";
        $params[':status'] = $filterStatus;
    }

    $whereClause = !empty($conditions)
            ? 'WHERE ' . implode(' AND ', $conditions)
            : '';

    $query = $pdo->prepare("
        SELECT * FROM bus_companies
        $whereClause
        ORDER BY created_at DESC
    ");

    $query->execute($params);

    return $query->fetchAll();
}

$filterName   = trim($_GET['name']   ?? '');
$filterStatus = trim($_GET['status'] ?? '');

$busCompanies = fetchAllBusCompanies($pdo, $filterName, $filterStatus);
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

        .header-actions {
            display: flex;
            gap: 10px;
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

        .btn:hover {
            background: #2d5bff;
            transform: translateY(-2px) scale(1.03);
            box-shadow: 0 4px 10px rgba(0,0,0,0.15);
        }

        .btn:active {
            transform: scale(0.97);
            box-shadow: 0 2px 4px rgba(0,0,0,0.2);
        }

        /* CONTAINER */
        .container {
            width: 90%;
            margin: auto;
        }

        /* FILTROS */
        .filters {
            background: white;
            border-radius: 10px;
            padding: 16px 20px;
            margin-bottom: 16px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.06);
            display: flex;
            gap: 12px;
            align-items: flex-end;
            flex-wrap: wrap;
        }

        .filter-group {
            display: flex;
            flex-direction: column;
            gap: 5px;
        }

        .filter-group label {
            font-size: 12px;
            font-weight: bold;
            color: #555;
        }

        .filter-group input,
        .filter-group select {
            padding: 8px 12px;
            border: 1px solid #ddd;
            border-radius: 6px;
            font-size: 13px;
            transition: 0.2s;
            min-width: 180px;
        }

        .filter-group input:focus,
        .filter-group select:focus {
            border-color: #1a2e6e;
            box-shadow: 0 0 5px rgba(26,46,110,0.2);
            outline: none;
        }

        .btn-filter {
            background: #1a2e6e;
            color: white;
            padding: 8px 16px;
            border: none;
            border-radius: 6px;
            font-weight: bold;
            cursor: pointer;
            font-size: 13px;
            transition: all 0.25s ease;
        }

        .btn-filter:hover {
            background: #2d5bff;
            transform: translateY(-1px);
        }

        .btn-clear {
            background: #e4e6eb;
            color: #333;
            padding: 8px 14px;
            border: none;
            border-radius: 6px;
            font-size: 13px;
            cursor: pointer;
            text-decoration: none;
            display: inline-block;
            transition: 0.2s;
        }

        .btn-clear:hover {
            background: #d0d3da;
        }

        .filter-active-msg {
            font-size: 12px;
            color: #2d5bff;
            margin-left: auto;
            align-self: center;
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
            align-items: center;
        }

        .table-card-header h3 {
            font-size: 15px;
            color: #1a2e6e;
        }

        .table-card-header span {
            font-size: 13px;
            color: #888;
        }

        /* TABLE */
        table {
            width: 100%;
            border-collapse: collapse;
        }

        th {
            padding: 10px 14px;
            background: #f8f9ff;
            font-size: 12px;
            text-align: left;
            border-bottom: 1px solid #eee;
            color: #555;
            text-transform: uppercase;
            letter-spacing: 0.4px;
        }

        td {
            padding: 10px 14px;
            border-bottom: 1px solid #f0f0f0;
            font-size: 13px;
        }

        tr:hover td {
            background: #fafbff;
        }

        .company-name {
            font-weight: bold;
        }

        .company-url {
            color: #2d5bff;
            text-decoration: none;
        }

        .company-url:hover {
            text-decoration: underline;
        }

        /* BADGE STATUS */
        .badge {
            padding: 3px 10px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: bold;
        }

        .badge-active {
            background: #dcfce7;
            color: green;
        }

        .badge-inactive {
            background: #fee2e2;
            color: #991b1b;
        }

        /* ACTIONS */
        .action-buttons {
            display: flex;
            gap: 10px;
        }

        .edit {
            color: #1a2e6e;
            text-decoration: none;
            font-weight: bold;
            font-size: 13px;
        }

        .edit:hover {
            text-decoration: underline;
        }

        .delete {
            color: red;
            text-decoration: none;
            font-weight: bold;
            font-size: 13px;
        }

        .delete:hover {
            text-decoration: underline;
        }

        /* EMPTY */
        .empty {
            padding: 30px;
            text-align: center;
            color: #888;
        }
    </style>
</head>

<body>

<div class="header">
    <h1>Cadastro de Viações</h1>
    <div class="header-actions">
        <a href="logs.php" class="btn">Histórico de Alterações</a>
        <a href="create.php" class="btn">+ Nova Viação</a>
    </div>
</div>

<div class="container">

    <!-- FILTROS -->
    <form method="GET" action="index.php" class="filters">

        <div class="filter-group">
            <label for="filter-name">Nome</label>
            <input
                    type="text"
                    id="filter-name"
                    name="name"
                    value="<?= htmlspecialchars($filterName) ?>"
                    placeholder="Buscar por nome..."
            >
        </div>

        <div class="filter-group">
            <label for="filter-status">Status</label>
            <select id="filter-status" name="status">
                <option value="">Todos</option>
                <option value="active"   <?= $filterStatus === 'active'   ? 'selected' : '' ?>>Ativo</option>
                <option value="inactive" <?= $filterStatus === 'inactive' ? 'selected' : '' ?>>Inativo</option>
            </select>
        </div>

        <button type="submit" class="btn-filter">Filtrar</button>

        <?php if (!empty($filterName) || !empty($filterStatus)): ?>
            <a href="index.php" class="btn-clear">Limpar</a>
            <span class="filter-active-msg">Filtro ativo</span>
        <?php endif; ?>

    </form>

    <!-- TABELA -->
    <div class="table-card">

        <div class="table-card-header">
            <h3>Lista de Viações</h3>
            <span><?= count($busCompanies) ?> registro(s)</span>
        </div>

        <?php if (empty($busCompanies)): ?>
            <div class="empty">Nenhuma viação encontrada.</div>
        <?php else: ?>

            <table>
                <thead>
                <tr>
                    <th>ID</th>
                    <th>Logo</th>
                    <th>Nome</th>
                    <th>URL</th>
                    <th>Cidade</th>
                    <th>Status</th>
                    <th>Criado em</th>
                    <th>Atualizado em</th>
                    <th>Ações</th>
                </tr>
                </thead>
                <tbody>

                <?php foreach ($busCompanies as $busCompany): ?>
                    <tr>
                        <td><?= $busCompany['id'] ?></td>

                        <td>
                            <?php if (!empty($busCompany['logo'])): ?>
                                <img src="<?= htmlspecialchars($busCompany['logo']) ?>"
                                     style="width:50px;height:50px;object-fit:contain;border-radius:6px;border:1px solid #eee;">
                            <?php else: ?>
                                —
                            <?php endif; ?>
                        </td>

                        <td class="company-name"><?= htmlspecialchars($busCompany['name']) ?></td>

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

                        <td><?= date('d/m/Y H:i', strtotime($busCompany['created_at'])) ?></td>
                        <td><?= date('d/m/Y H:i', strtotime($busCompany['updated_at'])) ?></td>

                        <td>
                            <div class="action-buttons">
                                <a href="edit.php?id=<?= $busCompany['id'] ?>" class="edit">Editar</a>
                                <a href="delete.php?id=<?= $busCompany['id'] ?>"
                                   class="delete"
                                   onclick="return confirm('Tem certeza que deseja excluir?')">
                                    Excluir
                                </a>
                            </div>
                        </td>
                    </tr>
                <?php endforeach; ?>

                </tbody>
            </table>

        <?php endif; ?>

    </div>

</div>

</body>
</html>