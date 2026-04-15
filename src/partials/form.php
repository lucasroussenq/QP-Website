<?php
?>


<div class="form-group">
    <label for="logo">Logo</label>
    <input
            type="file"
            id="logo"
            name="logo"
            accept="image/png, image/jpeg"
    >
</div>


<div class="form-group">
    <label for="name">Nome da Viação</label>
    <input
            type="text"
            id="name"
            name="name"
            value="<?= htmlspecialchars($busCompany['name'] ?? '') ?>"
            placeholder="Ex: Viação Cometa"
            required
    >
</div>

<div class="form-group">
    <label for="url">URL do Site</label>
    <input
            type="url"
            id="url"
            name="url"
            value="<?= htmlspecialchars($busCompany['url'] ?? '') ?>"
            placeholder="Ex: https://www.viacaocometa.com.br"
            required
    >
</div>

<div class="form-group">
    <label for="city">Cidade</label>
    <input
            type="text"
            id="city"
            name="city"
            value="<?= htmlspecialchars($busCompany['city'] ?? '') ?>"
            placeholder="Ex: São Paulo"
            required
    >
</div>

<div class="form-group">
    <label for="status">Status</label>
    <select id="status" name="status">
        <option value="active"   <?= ($busCompany['status'] ?? 'active') === 'active'   ? 'selected' : '' ?>>Ativo</option>
        <option value="inactive" <?= ($busCompany['status'] ?? '')        === 'inactive' ? 'selected' : '' ?>>Inativo</option>
    </select>
</div>
