<?php
if (session_status() !== PHP_SESSION_ACTIVE) session_start();
if (!isset($_SESSION['user_id']) || (int)($_SESSION['tipo'] ?? -1) !== 1) {
    http_response_code(403);
    exit('Esta operación requiere una sesión de administrador.');
}
