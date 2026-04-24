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

// Busca todos os nomes para o autocomplete
function fetchAllBusCompanyNames(PDO $pdo): array
{
    $query = $pdo->query("SELECT name FROM bus_companies ORDER BY name ASC");
    return array_column($query->fetchAll(), 'name');
}

$filterName   = trim($_GET['name']   ?? '');
$filterStatus = trim($_GET['status'] ?? '');

$busCompanies        = fetchAllBusCompanies($pdo, $filterName, $filterStatus);
$busCompanyNames     = fetchAllBusCompanyNames($pdo);
$busCompanyNamesJson = json_encode($busCompanyNames);
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Cadastro de Viações</title>

    <style>
        @keyframes shake {
            0%   { transform: translateX(0); }
            20%  { transform: translateX(-6px); }
            40%  { transform: translateX(6px); }
            60%  { transform: translateX(-4px); }
            80%  { transform: translateX(4px); }
            100% { transform: translateX(0); }
        }
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
            position: relative;
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
            min-width: 220px;
        }

        .filter-group input:focus,
        .filter-group select:focus {
            border-color: #1a2e6e;
            box-shadow: 0 0 5px rgba(26,46,110,0.2);
            outline: none;
        }

        /* AUTOCOMPLETE */
        .autocomplete-list {
            position: absolute;
            top: 100%;
            left: 0;
            right: 0;
            background: white;
            border: 1px solid #ddd;
            border-top: none;
            border-radius: 0 0 8px 8px;
            box-shadow: 0 6px 16px rgba(0,0,0,0.1);
            z-index: 100;
            max-height: 200px;
            overflow-y: auto;
            display: none;
        }

        .autocomplete-item {
            padding: 9px 14px;
            font-size: 13px;
            cursor: pointer;
            color: #333;
            border-bottom: 1px solid #f5f5f5;
        }

        .autocomplete-item:last-child {
            border-bottom: none;
        }

        .autocomplete-item:hover,
        .autocomplete-item.highlighted {
            background: #e8eeff;
            color: #1a2e6e;
            font-weight: bold;
        }

        .btn-filter {
            background: #1a2e6e;
            color: white;
            padding: 10px 16px;
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
            color: #888;
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

        .delete-btn {
            color: red;
            background: none;
            border: none;
            cursor: pointer;
            font-weight: bold;
            font-size: 13px;
            padding: 0;
            font-family: Arial, sans-serif;
        }

        .delete-btn:hover {
            text-decoration: underline;
        }

        /* EMPTY */
        .empty {
            padding: 30px;
            text-align: center;
            color: #888;
        }

        /* ── MODAL DE CONFIRMAÇÃO ── */
        .modal-overlay {
            display: none;
            position: fixed;
            inset: 0;
            background: rgba(0, 0, 0, 0.45);
            z-index: 999;
            align-items: center;
            justify-content: center;
        }

        .modal-overlay.active {
            display: flex;
        }

        .modal {
            background: white;
            border-radius: 14px;
            padding: 36px 32px 28px;
            width: 100%;
            max-width: 400px;
            box-shadow: 0 20px 60px rgba(0,0,0,0.2);
            text-align: center;
            animation: modalIn 0.2s ease, shake 0.3s ease;
        }

        @keyframes modalIn {
            from { transform: scale(0.9); opacity: 0; }
            to   { transform: scale(1);   opacity: 1; }
        }

        .modal-icon {
            width: 56px;
            height: 56px;
            background: #fee2e2;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 18px;
            font-size: 26px;
        }

        .modal h2 {
            font-size: 18px;
            color: #1a1a1a;
            margin-bottom: 8px;
        }

        .modal p {
            font-size: 14px;
            color: #6b7280;
            margin-bottom: 28px;
            line-height: 1.5;
        }

        .modal-actions {
            display: flex;
            gap: 12px;
            justify-content: center;
        }

        .modal-btn-cancel {
            padding: 10px 24px;
            border-radius: 8px;
            border: 1.5px solid #e5e7eb;
            background: white;
            color: #555;
            font-size: 14px;
            font-weight: bold;
            cursor: pointer;
            transition: 0.2s;
        }

        .modal-btn-cancel:hover {
            background: #f5f5f5;
        }

        .modal-btn-confirm {
            padding: 10px 24px;
            border-radius: 8px;
            background: #ef4444;
            color: white;
            font-size: 14px;
            font-weight: bold;
            cursor: pointer;
            transition: all 0.25s ease;
        }

        .modal-btn-confirm:hover {
            background: #dc2626;
            transform: translateY(-1px);
            box-shadow: 0 4px 10px rgba(239,68,68,0.3);
        }
    </style>
</head>

<body>

<!-- MODAL DE CONFIRMAÇÃO DE EXCLUSÃO -->
<div class="modal-overlay" id="deleteModal">
    <div class="modal">
        <h2>Excluir Viação</h2>
        <p>Tem certeza que deseja excluir esta viação?<br>Esta ação não pode ser desfeita.</p>
        <div class="modal-actions">
            <button class="modal-btn-cancel" onclick="closeDeleteModal()">Cancelar</button>
            <a id="deleteConfirmLink" href="#" class="modal-btn-confirm">Sim, excluir</a>
        </div>
    </div>
</div>

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
                    autocomplete="off"
            >
            <div class="autocomplete-list" id="autocompleteList"></div>
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
                                <button
                                        class="delete-btn"
                                        onclick="openDeleteModal('delete.php?id=<?= $busCompany['id'] ?>')">
                                    Excluir
                                </button>
                            </div>
                        </td>
                    </tr>
                <?php endforeach; ?>

                </tbody>
            </table>

        <?php endif; ?>

    </div>

    <script>
        window.allNames = <?= $busCompanyNamesJson ?>;
    </script>
    <script src="script.js"></script>

</div>

</body>
</html>