<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\User;
use App\Models\BusCompany;
use DateTime;
use PDO;

final class HistoryService
{
    private PDO $pdo;

    public function __construct(?PDO $pdo = null)
    {
        $this->pdo = $pdo ?? \getPdo();
    }

    public function all(array $filters = [], int $page = 1, int $perPage = 10): array
    {
        $sql = 'SELECT * FROM tasks.entity_logs WHERE 1=1';
        $params = [];

         /*if ($name !== '') {
            $sql .= ' AND name LIKE :name';
            $params['name'] = "%$name%";
        }

        if ($status !== '') {
            $sql .= ' AND status = :status';
            $params['status'] = $status;
        } else {
            $sql .= " AND status != 'deleted'";
        }
*/

        $countSql = str_replace('SELECT *', 'SELECT COUNT(*)', $sql);
        $countStmt = $this->pdo->prepare($countSql);
        $countStmt->execute($params);
        $total = (int)$countStmt->fetchColumn();

        $offset = ($page - 1) * $perPage;
        $sql .= ' ORDER BY created_at DESC LIMIT :limit OFFSET :offset';
        $stmt = $this->pdo->prepare($sql);
        foreach ($params as $k => $v) {
            $stmt->bindValue($k, $v);
        }
        $stmt->bindValue(':limit', $perPage, PDO::PARAM_INT);
        $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
        $stmt->execute();

        return [
            'items' => $stmt->fetchAll(),
            'total' => $total,
            'page' => $page,
            'perPage' => $perPage,
            'pages' => (int)ceil($total / $perPage),
        ];
    }

}