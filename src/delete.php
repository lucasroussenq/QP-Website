<?php

require 'db.php';
$pdo = $pdo ?? null;

//remove uma viacao do banco pelo ID e redireciona para a listagem
function deleteBusCompany(PDO $pdo, int $id): void
{
    $statement = $pdo->prepare("
        DELETE FROM bus_companies
        WHERE id = :id
    ");

    $statement->execute([':id' => $id]);
}

$busCompanyId = (int) ($_GET['id'] ?? 0);

if ($busCompanyId === 0) {
    header('Location: index.php');
    exit;
}

$stmt = $pdo->prepare("SELECT * FROM bus_companies WHERE id = :id");
$stmt->execute([':id' => $busCompanyId]);
$oldData = $stmt->fetch();
deleteBusCompany($pdo, $busCompanyId);

logAction(
    $pdo,
    $busCompanyId,
    'delete',
    json_encode($oldData),
    null
);
header('Location: index.php');
exit;
header  ('Location: index.php');
exit;

function logAction(PDO $pdo, int $id, string $action, ?string $old = null, ?string $new = null): void
{
    $stmt = $pdo->prepare("
        INSERT INTO bus_company_logs (bus_company_id, action, old_value, new_value)
        VALUES (:id, :action, :old, :new)
    ");

    $stmt->execute([
        ':id' => $id,
        ':action' => $action,
        ':old' => $old,
        ':new' => $new
    ]);
}