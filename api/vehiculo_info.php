<?php
// api/vehiculo_info.php
session_start();
header('Content-Type: application/json');

require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../models/VehiculoModel.php';

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

$vehiculoId = (int)$_GET['id'];

// Obtener información del vehículo
$vehiculoModel = new VehiculoModel();
$vehiculo = $vehiculoModel->obtenerVehiculoPorId($vehiculoId, $_SESSION['usuario_id']);

if (!$vehiculo) {
    echo json_encode(['error' => 'Vehículo no encontrado']);
    exit;
}

// Obtener fechas de vencimiento de SOAT y Tecnomecánica
$db = getDB();

$stmtSoat = $db->prepare("
    SELECT fecha_vencimiento FROM soat 
    WHERE vehiculo_id = ? 
    ORDER BY fecha_vencimiento DESC 
    LIMIT 1
");
$stmtSoat->execute([$vehiculoId]);
$soatData = $stmtSoat->fetch(PDO::FETCH_ASSOC);

$stmtTecno = $db->prepare("
    SELECT fecha_vigente FROM revision_tecnico_mecanica 
    WHERE vehiculo_id = ? 
    ORDER BY fecha_vigente DESC 
    LIMIT 1
");
$stmtTecno->execute([$vehiculoId]);
$tecnoData = $stmtTecno->fetch(PDO::FETCH_ASSOC);

// Formatear la respuesta
$response = [
    'info' => [
        'placa' => $vehiculo['placa'],
        'marca' => $vehiculo['marca'],
        'linea' => $vehiculo['linea'],
        'modelo' => $vehiculo['modelo'],
        'clase' => $vehiculo['clase_vehiculo'],
        'cilindraje' => $vehiculo['cilindraje']
    ],
    'soat' => [
        'vencimiento' => $soatData ? date('d/m/Y', strtotime($soatData['fecha_vencimiento'])) : null
    ],
    'tecnomecanica' => [
        'vencimiento' => $tecnoData ? date('d/m/Y', strtotime($tecnoData['fecha_vigente'])) : null
    ]
];

echo json_encode($response);