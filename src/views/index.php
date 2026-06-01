<?php
/** @var string $title */
/** @var list<\App\Models\BusCompany> $companies */
/** @var array $pagination */
/** @var string $filterName */
/** @var string $filterStatus */
/** @var string $busCompanyNamesJson */
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="/app.css">
    <link href="https://fonts.googleapis.com/css2?family=Sora:wght@400;500;600;700&display=swap" rel="stylesheet">
</head>
<body>

<div class="modal-overlay" id="deleteModal">
    <div class="modal">
        <h2>Excluir Viação</h2>
        <p>O registro ficará como <strong>deletado</strong> e poderá ser restaurado depois.</p>
        <div class="modal-actions">
            <button class="modal-btn-cancel" onclick="closeDeleteModal()">Cancelar</button>
            <form id="deleteConfirmForm" method="POST" action="">
                <button type="submit" class="modal-btn-confirm">Sim, excluir</button>
            </form>
        </div>
    </div>
</div>

<div class="header">
    <h1><?= htmlspecialchars($title) ?></h1>
    <div class="header-actions">
        <a href="/users" class="btn">Usuários</a>
        <a href="/bus-companies/logs" class="btn">Histórico</a>
        <a href="/bus-companies/create" class="btn">+ Nova Viação</a>
        <a href="/" class="btn">Home</a>
    </div>
</div>

<div class="container">

    <form method="GET" action="/bus-companies" class="filters">
        <div class="filter-group">
            <label for="filter-name">Nome</label>
            <input type="text" id="filter-name" name="name"
                   value="<?= htmlspecialchars($filterName) ?>"
                   placeholder="Buscar por nome..." autocomplete="off">
            <div class="autocomplete-list" id="autocompleteList"></div>
        </div>

        <div class="filter-group">
            <label for="filter-status">Status</label>
            <select id="filter-status" name="status">
                <option value="">Todos (exceto deletados)</option>
                <option value="active"   <?= $filterStatus === 'active'   ? 'selected' : '' ?>>Ativo</option>
                <option value="inactive" <?= $filterStatus === 'inactive' ? 'selected' : '' ?>>Inativo</option>
            </select>
        </div>

        <button type="submit" class="btn-filter">Filtrar</button>

        <?php if (!empty($filterName) || !empty($filterStatus)): ?>
            <a href="/bus-companies" class="btn-clear">Limpar</a>
        <?php endif; ?>
    </form>

    <div class="table-card">
        <div class="table-card-header">
            <h3>Lista de Viações</h3>
            <span><?= count($companies) ?> registro(s)</span>
        </div>

        <?php if (empty($companies)): ?>
            <div class="empty">Nenhuma viação encontrada.</div>
        <?php else: ?>
            <table>
                <thead>
                <tr>
                    <th>ID</th>
                    <th>Logo</th>
                    <th>Nome</th>
                    <th>Cidade</th>
                    <th>Status</th>
                    <th>Criado em</th>
                    <th>Ações</th>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($companies as $company): ?>
                    <tr>

                        <td><?= $company->id ?></td>
                        <td>
                            <?php if (!empty($company->logo)): ?>
                                <?php $finalSrc = (strpos(ltrim($company->logo, '/'), 'uploads/') === 0)
                                        ? ltrim($company->logo, '/') : 'uploads/' . $company->logo; ?>
                                <img src="/<?= htmlspecialchars($finalSrc) ?>"
                                     style="width:50px;height:50px;object-fit:contain;border-radius:6px;border:1px solid #eee;">
                            <?php endif; ?>
                        </td>
                        <td>
                            <a href="/bus-companies/<?= $company->id ?>"><?= htmlspecialchars($company->name) ?></a>
                        </td>
                        <td><?= htmlspecialchars($company->city) ?></td>
                        <td>
                            <span class="badge badge-<?= $company->status ?>">
                                <?= match($company->status) {
                                    'active'   => 'Ativo',
                                    'inactive' => 'Inativo',
                                    default    => $company->status,
                                } ?>
                            </span>
                        </td>
                        <td><?= date('d/m/Y H:i', strtotime($company->createdAt)) ?></td>
                        <td>
                            <div class="action-buttons">
                                <?php if (isset($company->deletedAt) && $company->deletedAt !== ''): ?>
                                    <form method="POST" action="/bus-companies/<?= $company->id ?>/restore"
                                          style="display:inline">
                                        <button type="submit" class="edit" style="background:#28a745;color:white;border:none;cursor:pointer;padding:4px 10px;border-radius:4px;">
                                            Restaurar
                                        </button>
                                    </form>
                                <?php else: ?>
                                    <a href="/bus-companies/<?= $company->id ?>/edit" class="edit">Editar</a>
                                    <a href="/bus-companies/<?= $company->id ?>/view" class="edit">Veja</a>
                                    <button type="button" class="delete-btn"
                                            onclick="openDeleteModalCustom('/bus-companies/<?= $company->id ?>/delete')">Excluir</button>

                                <?php endif; ?>
                            </div>
                        </td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>

            <?php
            $baseUrl     = '/bus-companies';
            $queryParams = ['name' => $filterName, 'status' => $filterStatus];
            include __DIR__ . '/partials/pagination.php';
            ?>
        <?php endif; ?>
    </div>
</div>

<script>
    window.allNames = <?= $busCompanyNamesJson ?? '[]' ?>;

    function openDeleteModalCustom(url) {
        const modal = document.getElementById('deleteModal');
        const form  = document.getElementById('deleteConfirmForm');
        form.action = url;
        modal.classList.add('active');
    }

    function closeDeleteModal() {
        document.getElementById('deleteModal').classList.remove('active');
    }
</script>

<script src="/script.js"></script>
</body>