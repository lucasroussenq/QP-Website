<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Core\View;
use App\Services\HistoryService;

final class HistoryController
{
    private HistoryService $service;

    public function __construct(?HistoryService $service = null)
    {
        $this->service = $service ?? new HistoryService();
    }

    private function checkAdmin(): void
    {
        if (session_status() === PHP_SESSION_NONE) session_start();

        $email = strtolower($_SESSION['user_email'] ?? '');

        if (!in_array($email, ['adm@gmail.com', 'adm2@gmail.com', 'adm3@gmail.com'], true)) {
            View::flash('error', 'Acesso negado.');
            header('Location: /');
            exit;
        }
    }

    public function index(): void
    {
        $this->checkAdmin();

        $filters = [
            'entity_type' => $_GET['entity_type'] ?? '',
            'entity_id'   => $_GET['entity_id']   ?? '',
            'user_id'     => $_GET['user_id']      ?? '',
            'action'      => $_GET['action']       ?? '',
            'date'        => $_GET['date']          ?? '',
            'entity_name' => $_GET['entity_name']  ?? '',
        ];

        // Remove filtros vazios para não poluir a query
        $filters = array_filter($filters, fn($v) => $v !== '');


        //consertar pq o all esta recebendo uma array, colocar array lá
        $page   = max(1, (int) ($_GET['page'] ?? 1));
        $result = $this->service->all($filters, $page);

        View::render('logs', [
            'title'      => 'Histórico Geral',
            'logs'       => $result['items'],
            'pagination' => $result,
            'filters'    => $filters,
        ]);
    }
}