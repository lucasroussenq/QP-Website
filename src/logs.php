<?php

require 'db.php';
$pdo = $pdo ?? null;

// busca todos os logs
$stmt = $pdo->query("
    SELECT l.*, b.name, b.logo
    FROM bus_company_logs l
    LEFT JOIN bus_companies b ON b.id = l.bus_company_id
    ORDER BY l.created_at DESC
");

$logs = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Histórico de Alterações</title>

    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f5f5f5;
            margin: 0;
        }

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
            font-weight: bold;
            transition: 0.25s;
        }

        .btn:hover {
            background: #2d5bff;
            transform: translateY(-2px);
        }

        .container {
            width: 90%;
            margin: auto;
        }

        .card {
            background: white;
            border-radius: 10px;
            box-shadow: 0 2px 12px rgba(0,0,0,0.07);
            overflow: hidden;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th {
            background: #f8f9ff;
            padding: 10px;
            border: 1px solid #eee;
        }

        td {
            padding: 10px;
            border: 1px solid #eee;
            font-size: 13px;
        }

        tr:hover {
            background: #fafbff;
        }

        pre {
            margin: 0;
            white-space: pre-wrap;
            font-size: 12px;
        }
    </style>
</head>

<body>

<div class="header">
    <h1>Histórico de Alterações</h1>
    <a href="index.php" class="btn">Voltar</a>
</div>

<div class="container">

    <div class="card">

        <?php if (empty($logs)): ?>
            <div style="padding:20px;">Nenhum log encontrado</div>
        <?php else: ?>

            <table>
                <tr>
                    <th>ID</th>
                    <th>Logo</th>
                    <th>Viação</th>
                    <th>Ação</th>
                    <th>Antes</th>
                    <th>Depois</th>
                    <th>Data</th>
                </tr>

                <?php foreach ($logs as $log): ?>

                    <?php
                    $old = !empty($log['old_value']) ? json_decode($log['old_value'], true) : null;
                    $new = !empty($log['new_value']) ? json_decode($log['new_value'], true) : null;
                    ?>

                    <tr>
                        <td><?= $log['id'] ?></td>

                        <td>

                            <?php if ($log['action'] === 'update'): ?>

                                <!-- LOGO ANTIGA -->
                                <div>
                                    <strong>Antes:</strong><br>
                                    <?php if (!empty($old['logo'])): ?>
                                        <img src="<?= $old['logo'] ?>" width="50">
                                    <?php else: ?>
                                        -
                                    <?php endif; ?>
                                </div>

                                <!-- LOGO NOVA -->
                                <div style="margin-top:5px;">
                                    <strong>Depois:</strong><br>
                                    <?php if (!empty($new['logo'])): ?>
                                        <img src="<?= $new['logo'] ?>" width="50">
                                    <?php else: ?>
                                        -
                                    <?php endif; ?>
                                </div>

                            <?php elseif ($log['action'] === 'create'): ?>

                                <!-- SÓ NOVA -->
                                <?php if (!empty($new['logo'])): ?>
                                    <img src="<?= $new['logo'] ?>" width="50">
                                <?php else: ?>
                                    -
                                <?php endif; ?>

                            <?php elseif ($log['action'] === 'delete'): ?>

                                <!-- SÓ ANTIGA -->
                                <?php if (!empty($old['logo'])): ?>
                                    <img src="<?= $old['logo'] ?>" width="50">
                                <?php else: ?>
                                    -
                                <?php endif; ?>

                            <?php endif; ?>

                        </td>

                        <td><?= htmlspecialchars($log['name'] ?? 'Removida') ?></td>

                        <td><?= strtoupper($log['action']) ?></td>

                        <td>
                            <?php if ($log['action'] === 'update' && $old): ?>
                                <ul>
                                    <?php foreach ($old as $key => $value): ?>
                                        <li><strong><?= $key ?>:</strong> <?= htmlspecialchars($value) ?></li>
                                    <?php endforeach; ?>
                                </ul>
                            <?php else: ?>
                                -
                            <?php endif; ?>
                        </td>

                        <td>
                            <?php if ($log['action'] === 'update' && $new): ?>
                                <ul>
                                    <?php foreach ($new as $key => $value): ?>
                                        <li><strong><?= $key ?>:</strong> <?= htmlspecialchars($value) ?></li>
                                    <?php endforeach; ?>
                                </ul>
                            <?php else: ?>
                                -
                            <?php endif; ?>
                        </td>

                        <td><?= date('d/m/Y H:i', strtotime($log['created_at'])) ?></td>
                    </tr>

                <?php endforeach; ?>

            </table>

        <?php endif; ?>

    </div>

</div>

</body>
</html>
