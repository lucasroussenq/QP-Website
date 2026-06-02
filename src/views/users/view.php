<?php
declare(strict_types=1);

/** @var array $user */

$userData = (array) ($user ?? []);
?>

<div class="header">
    <h1>Visualizar Usuário #<?= htmlspecialchars((string)($userData['id'] ?? '')) ?></h1>

    <a href="/users" class="btn">
        Voltar
    </a>
</div>

<div class="container">
    <div class="form-card">

        <div class="info-group">
            <label>Nome do Usuário</label>
            <p><?= htmlspecialchars($userData['name'] ?? '') ?></p>
        </div>

        <div class="info-group">
            <label>E-mail</label>
            <p><?= htmlspecialchars($userData['email'] ?? '') ?></p>
        </div>

        <div class="info-group">
            <label>Status</label>

            <p>
                <?php
                $status = $userData['status'] ?? '';

                echo match ($status) {
                    'active' => 'Ativo',
                    'inactive' => 'Inativo',
                    'deleted' => 'Deletado',
                    default => 'Não informado'
                };
                ?>
            </p>
        </div>

    </div>
</div>

<style>
    .container {
        width: 90%;
        max-width: 650px;
        margin: auto;
    }

    .form-card {
        background: white;
        padding: 30px;
        border-radius: 10px;
        box-shadow: 0 2px 12px rgba(0,0,0,0.07);
    }

    .info-group {
        margin-bottom: 20px;
    }

    .info-group label {
        display: block;
        margin-bottom: 6px;
        font-size: 13px;
        font-weight: bold;
        color: #555;
    }

    .info-group p {
        margin: 0;
        padding: 10px;
        background: #f8f9fa;
        border: 1px solid #ddd;
        border-radius: 5px;
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
    }

    .btn:hover {
        background: #2d5bff;
    }
</style>