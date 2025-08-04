<?php
// api/recordatorio.php
session_start();
header('Content-Type: application/json');

require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../models/RecordatorioModel.php';

// Verificar autenticación
if (!isset($_SESSION['usuario_id'])) {
    echo json_encode(['error' => 'No autorizado']);
    exit;
}

// Verificar parámetro id
if (!isset($_GET['id']) || empty($_GET['id'])) {
    echo json_encode(['error' => 'Parámetro id requerido']);
    exit;
}

$recordatorioId = (int)$_GET['id'];

// Obtener información del recordatorio
$recordatorioModel = new RecordatorioModel();
$recordatorio = $recordatorioModel->obtenerRecordatorioPorId($recordatorioId, $_SESSION['usuario_id']);

if (!$recordatorio) {
    echo json_encode(['error' => 'Recordatorio no encontrado']);
    exit;
}

echo json_encode($recordatorio);