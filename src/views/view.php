<?php
declare(strict_types=1);

/** @var array $company */

$companyData = (array) ($company ?? []);
?>

<div class="header">
    <h1>Visualizar Viação #<?= htmlspecialchars((string)($companyData['id'] ?? '')) ?></h1>

    <a href="/bus-companies" class="btn">
        Voltar
    </a>
</div>

<link href="https://fonts.googleapis.com/css2?family=Sora:wght@400;700&display=swap" rel="stylesheet">

<div class="container">
    <div class="form-card">

        <?php if (!empty($companyData['logo'])): ?>
            <div class="info-group">
                <label>Logo da Viação</label>

                <img
                        src="/<?= htmlspecialchars($companyData['logo']) ?>"
                        alt="Logo da Viação"
                        class="company-logo"
                >
            </div>
        <?php endif; ?>

        <div class="info-group">
            <label>Nome da Viação</label>
            <p><?= htmlspecialchars($companyData['name'] ?? '') ?></p>
        </div>

        <div class="info-group">
            <label>URL do Site</label>

            <?php if (!empty($companyData['url'])): ?>
                <p>
                    <a
                            href="<?= htmlspecialchars($companyData['url']) ?>"
                            target="_blank"
                            rel="noopener noreferrer"
                    >
                        <?= htmlspecialchars($companyData['url']) ?>
                    </a>
                </p>
            <?php else: ?>
                <p>-</p>
            <?php endif; ?>
        </div>

        <div class="info-group">
            <label>Cidade</label>
            <p><?= htmlspecialchars($companyData['city'] ?? '') ?></p>
        </div>

        <div class="info-group">
            <label>Status</label>

            <p>
                <?= ($companyData['status'] ?? '') === 'active'
                        ? 'Ativo'
                        : 'Inativo' ?>
            </p>
        </div>

    </div>
</div>

<style>
    * {
        font-family: 'Sora', sans-serif;
    }

    .header {
        width: 90%;
        margin: 30px auto 15px;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .container {
        width: 90%;
        max-width: 650px;
        margin: auto;
    }

    .form-card {
        background: white;
        padding: 30px;
        border-radius: 10px;
        box-shadow: 0 2px 12px rgba(0, 0, 0, 0.07);
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

    .company-logo {
        display: block;
        margin-left: auto;
        margin-right: auto;
        width: 50%;
        height: 120px;
        object-fit: contain;
        border-radius: 8px;
        border: 1px solid #ddd;
        background: white;
        padding: 10px;
    }

    .btn {
        background: #1a2e6e;
        color: white;
        padding: 10px 16px;
        text-decoration: none;
        border-radius: 6px;
        font-weight: bold;
        transition: all 0.25s ease;
    }

    .btn:hover {
        background: #2d5bff;
        transform: translateY(-2px);
    }
</style>