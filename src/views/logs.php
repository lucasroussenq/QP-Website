<?php
declare(strict_types=1);

/** @var array $logs */
/** @var array $filters */
?>

<link href="https://fonts.googleapis.com/css2?family=Sora:wght@400;700&display=swap" rel="stylesheet">

<style>
    * { font-family: 'Sora', sans-serif; }
    body { background: #f5f5f5; margin: 0; }
    h1 { font-weight: 700; color: #0D2240; }
    .header { width: 95%; margin: 30px auto 15px; display: flex; justify-content: space-between; align-items: center; }
    .btn { background: #1a2e6e; color: white; padding: 10px 16px; text-decoration: none; border-radius: 6px; font-weight: bold; }

    .filters { width: 95%; margin: 0 auto 20px; background: white; padding: 15px; border-radius: 8px; display: flex; gap: 8px; flex-wrap: wrap; align-items: flex-end; }
    .filter-group { display: flex; flex-direction: column; gap: 4px; }
    .filter-group input, .filter-group select { padding: 6px 8px; border: 1px solid #ddd; border-radius: 6px; font-size: 13px; }
    .filter-group label { font-size: 12px; font-weight: 600; color: #555; }
    .filters button { padding: 8px 16px; background: #1a2e6e; color: white; border: none; border-radius: 6px; font-weight: bold; cursor: pointer; }

    .container { width: 95%; margin: auto; }
    .card { background: white; border-radius: 12px; overflow: hidden; margin-bottom: 50px; }
    table { width: 100%; border-collapse: collapse; }
    th { background: #f8f9ff; padding: 12px; font-size: 12px; text-transform: uppercase; text-align: left; }
    td { padding: 10px; border-top: 1px solid #eee; font-size: 13px; vertical-align: top; }

    .badge { display: inline-block; padding: 2px 8px; border-radius: 20px; font-size: 11px; font-weight: bold; text-transform: uppercase; }
    .badge-create { background: #d1fae5; color: #065f46; }
    .badge-update { background: #dbeafe; color: #1e40af; }
    .badge-delete { background: #fee2e2; color: #991b1b; }
    .badge-restore { background: #fef3c7; color: #92400e; }

    .entity-user        { background: #ede9fe; color: #5b21b6; }
    .entity-bus_company { background: #e0f2fe; color: #075985; }

    .change-row { margin-bottom: 4px; line-height: 1.4; }
    .change-key { font-weight: 600; color: #555; }
    .json-full { font-size: 11px; color: #666; word-break: break-all; }
    .empty-dash { color: #aaa; }
</style>

<div class="header">
    <h1>Histórico de Alterações</h1>
    <a href="/bus-companies" class="btn">Voltar</a>
</div>

<div class="container">

    <form method="GET" action="/history" class="filters">

        <div class="filter-group">
            <label>Tipo de Entidade</label>
            <select name="entity_type">
                <option value="">Todas</option>
                <option value="user"        <?= ($filters['entity_type'] ?? '') === 'user'        ? 'selected' : '' ?>>Usuário</option>
                <option value="bus_company" <?= ($filters['entity_type'] ?? '') === 'bus_company' ? 'selected' : '' ?>>Viação</option>
                <option value="restore" <?= ($filters['entity_type'] ?? '') === 'restore' ? 'selected' : '' ?>>Restaurar</option>
            </select>
        </div>

        <div class="filter-group">
            <label>Nome da Entidade</label>
            <input type="text" name="entity_name" value="<?= htmlspecialchars((string)($filters['entity_name'] ?? '')) ?>">
        </div>

        <div class="filter-group">
            <label>ID da Entidade</label>
            <input type="number" name="entity_id" value="<?= htmlspecialchars((string)($filters['entity_id'] ?? '')) ?>">
        </div>

        <div class="filter-group">
            <label>ID do Usuário</label>
            <input type="number" name="user_id" value="<?= htmlspecialchars((string)($filters['user_id'] ?? '')) ?>">
        </div>

        <div class="filter-group">
            <label>Ação</label>
            <select name="action">
                <option value="">Todas</option>
                <option value="create"  <?= ($filters['action'] ?? '') === 'create'  ? 'selected' : '' ?>>CREATE</option>
                <option value="update"  <?= ($filters['action'] ?? '') === 'update'  ? 'selected' : '' ?>>UPDATE</option>
                <option value="delete"  <?= ($filters['action'] ?? '') === 'delete'  ? 'selected' : '' ?>>DELETE</option>
                <option value="restore" <?= ($filters['action'] ?? '') === 'restore' ? 'selected' : '' ?>>RESTORE</option>
            </select>
        </div>

        <div class="filter-group">
            <label>Data</label>
            <input type="date" name="date" value="<?= htmlspecialchars((string)($filters['date'] ?? '')) ?>">
        </div>

        <button type="submit">Filtrar</button>
        <a href="/history" style="padding:8px 12px; color:#555; font-size:13px; align-self:center;">Limpar</a>
    </form>

    <div class="card">
        <?php if (empty($logs)): ?>
            <div style="padding:30px; color:#888; text-align:center;">Nenhum log encontrado.</div>
        <?php else: ?>
            <table>
                <thead>
                <tr>
                    <th>ID</th>
                    <th>Entidade</th>
                    <th>Nome</th>
                    <th>Responsável</th>
                    <th>Ação</th>
                    <th>Antes</th>
                    <th>Depois</th>
                    <th>Data</th>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($logs as $log):

                    $old = !empty($log['old_value']) ? json_decode((string)$log['old_value'], true) : null;
                    $new = !empty($log['new_value']) ? json_decode((string)$log['new_value'], true) : null;

                    // Campos a ignorar nas comparações (sem valor visual)
                    $ignoredKeys = ['password', 'id', 'created_at', 'updated_at'];

                    $changes = [];
                    if ($log['action'] === 'update' && is_array($old) && is_array($new)) {
                        foreach ($new as $key => $value) {
                            if (in_array($key, $ignoredKeys, true)) continue;
                            if (($old[$key] ?? null) != $value) {
                                $changes[$key] = ['old' => $old[$key] ?? null, 'new' => $value];
                            }
                        }
                    }

                    $entityClass = 'entity-' . ($log['entity_type'] ?? '');
                    $actionClass = 'badge-' . ($log['action'] ?? '');
                    ?>
                    <tr>
                        <td><?= (int)$log['id'] ?></td>

                        <td>
                            <span class="badge <?= htmlspecialchars($entityClass) ?>">
                                <?= htmlspecialchars($log['entity_type'] ?? '-') ?>
                            </span>
                            <div style="font-size:11px;color:#aaa;margin-top:2px;">
                                #<?= (int)($log['entity_id'] ?? 0) ?>
                            </div>
                        </td>

                        <td><?= htmlspecialchars($log['entity_name'] ?? '-') ?></td>

                        <td>
                            <?php if (!empty($log['user_name'])): ?>
                                <?= htmlspecialchars($log['user_name']) ?>
                                <div style="font-size:11px;color:#aaa;">ID <?= (int)$log['user_id'] ?></div>
                            <?php else: ?>
                                <span class="empty-dash">-</span>
                            <?php endif; ?>
                        </td>

                        <td>
                            <span class="badge <?= htmlspecialchars($actionClass) ?>">
                                <?= htmlspecialchars(strtoupper($log['action'] ?? '')) ?>
                            </span>
                        </td>

                        <!-- ANTES -->
                        <td>
                            <?php if ($log['action'] === 'update' && $changes): ?>
                                <?php foreach ($changes as $k => $v): ?>
                                    <div class="change-row">
                                        <span class="change-key"><?= htmlspecialchars($k) ?>:</span>
                                        <?= htmlspecialchars((string)($v['old'] ?? '')) ?>
                                    </div>
                                <?php endforeach; ?>

                            <?php elseif ($log['action'] === 'delete' && is_array($old)): ?>
                                <?php foreach ($old as $k => $v): ?>
                                    <?php if (in_array($k, $ignoredKeys, true)) continue; ?>
                                    <div class="change-row">
                                        <span class="change-key"><?= htmlspecialchars($k) ?>:</span>
                                        <?= htmlspecialchars((string)$v) ?>
                                    </div>
                                <?php endforeach; ?>

                            <?php else: ?>
                                <span class="empty-dash">-</span>
                            <?php endif; ?>
                        </td>

                        <!-- DEPOIS -->
                        <td>
                            <?php if ($log['action'] === 'update' && $changes): ?>
                                <?php foreach ($changes as $k => $v): ?>
                                    <div class="change-row">
                                        <span class="change-key"><?= htmlspecialchars($k) ?>:</span>
                                        <?= htmlspecialchars((string)($v['new'] ?? '')) ?>
                                    </div>
                                <?php endforeach; ?>

                            <?php elseif ($log['action'] === 'create' && is_array($new)): ?>
                                <?php foreach ($new as $k => $v): ?>
                                    <?php if (in_array($k, $ignoredKeys, true)) continue; ?>
                                    <div class="change-row">
                                        <span class="change-key"><?= htmlspecialchars($k) ?>:</span>
                                        <?= htmlspecialchars((string)$v) ?>
                                    </div>
                                <?php endforeach; ?>

                            <?php elseif ($log['action'] === 'restore' && is_array($new)): ?>
                                <?php foreach ($new as $k => $v): ?>
                                    <?php if (in_array($k, $ignoredKeys, true)) continue; ?>
                                    <div class="change-row">
                                        <span class="change-key"><?= htmlspecialchars($k) ?>:</span>
                                        <?= htmlspecialchars((string)$v) ?>
                                    </div>
                                <?php endforeach; ?>

                            <?php else: ?>
                                <span class="empty-dash">-</span>
                            <?php endif; ?>
                        </td>

                        <td style="white-space: nowrap;">
                            <?= date('d/m/Y H:i', strtotime($log['created_at'])) ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>
    </div>
</div>