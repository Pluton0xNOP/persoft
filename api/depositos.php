<?php
// api/depositos.php
session_start();
header('Content-Type: application/json');

require_once __DIR__ . '/../config/database.php';

// Verificar autenticación
if (!isset($_SESSION['usuario_id'])) {
    echo json_encode(['error' => 'No autorizado']);
    exit;
}

// Verificar parámetro ahorro_id
if (!isset($_GET['ahorro_id']) || empty($_GET['ahorro_id'])) {
    echo json_encode(['error' => 'Parámetro ahorro_id requerido']);
    exit;
}

$ahorroId = (int)$_GET['ahorro_id'];

// Verificar que el ahorro pertenezca al usuario actual
$db = getDB();
$stmt = $db->prepare("
    SELECT id FROM tramites 
    WHERE id = ? AND usuario_id = ? AND tipo_tramite IN ('Ahorro SOAT', 'Ahorro Tecnomecánica')
");
$stmt->execute([$ahorroId, $_SESSION['usuario_id']]);

if (!$stmt->fetch()) {
    echo json_encode(['error' => 'Ahorro no encontrado']);
    exit;
}

// Obtener historial de depósitos
$stmt = $db->prepare("
    SELECT * FROM depositos_ahorro
    WHERE ahorro_id = ?
    ORDER BY fecha DESC, id DESC
");
$stmt->execute([$ahorroId]);
$depositos = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Formatear URLs de comprobantes
foreach ($depositos as &$deposito) {
    if ($deposito['comprobante']) {
        $deposito['comprobante'] = rtrim(BASE_URL, '/') . '/' . $deposito['comprobante'];
    }
}

echo json_encode($depositos);