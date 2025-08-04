<?php
// models/TramiteModel.php
class TramiteModel {
    public function obtenerTramitesPorUsuario($usuario_id) {
        $db = getDB();
        $stmt = $db->prepare("
            SELECT t.*, v.placa as vehiculo_placa
            FROM tramites t
            JOIN vehiculos v ON t.vehiculo_id = v.id
            WHERE t.usuario_id = ?
            ORDER BY t.fecha DESC
        ");
        $stmt->execute([$usuario_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function crearTramite($datos) {
        $db = getDB();
        $stmt = $db->prepare("
            INSERT INTO tramites (usuario_id, vehiculo_id, tipo_tramite, fecha, estado, costo)
            VALUES (?, ?, ?, ?, ?, ?)
        ");
        return $stmt->execute([
            $datos['usuario_id'],
            $datos['vehiculo_id'],
            $datos['tipo_tramite'],
            $datos['fecha'],
            'En Proceso',
            $datos['costo']
        ]);
    }

    public function obtenerAhorrosPorUsuario($usuario_id) {
    $db = getDB();
    $stmt = $db->prepare("
        SELECT t.*, v.placa as vehiculo_placa, v.marca, v.linea, v.cilindraje, 
               (SELECT SUM(monto) FROM depositos_ahorro WHERE ahorro_id = t.id) as total_ahorrado
        FROM tramites t
        JOIN vehiculos v ON t.vehiculo_id = v.id
        WHERE t.usuario_id = ? AND t.tipo_tramite IN ('Ahorro SOAT', 'Ahorro Tecnomecánica')
        ORDER BY t.fecha DESC
    ");
    $stmt->execute([$usuario_id]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

public function crearAhorro($datos) {
    $db = getDB();
    $db->beginTransaction();
    
    try {
        // Crear el trámite de ahorro
        $stmt = $db->prepare("
            INSERT INTO tramites (usuario_id, vehiculo_id, tipo_tramite, fecha, estado, costo, monto_mensual)
            VALUES (?, ?, ?, ?, ?, ?, ?)
        ");
        
        $stmt->execute([
            $datos['usuario_id'],
            $datos['vehiculo_id'],
            $datos['tipo_tramite'],
            $datos['fecha_objetivo'],
            'En Proceso',
            $datos['costo_estimado'],
            $datos['monto_mensual']
        ]);
        
        $ahorroId = $db->lastInsertId();
        $db->commit();
        return $ahorroId;
    } catch (Exception $e) {
        $db->rollBack();
        return false;
    }
}
public function actualizarAhorro($datos) {
    $db = getDB();
    $stmt = $db->prepare("
        UPDATE tramites 
        SET monto_mensual = ?, costo = ?
        WHERE id = ? AND usuario_id = ?
    ");
    
    return $stmt->execute([
        $datos['monto_mensual'],
        $datos['costo_estimado'],
        $datos['ahorro_id'],
        $datos['usuario_id']
    ]);
}





public function obtenerAhorroPorId($ahorro_id, $usuario_id) {
    $db = getDB();
    $stmt = $db->prepare("
        SELECT t.*, v.placa as vehiculo_placa, v.marca, v.linea, v.cilindraje,
               (SELECT SUM(monto) FROM depositos_ahorro WHERE ahorro_id = t.id) as total_ahorrado
        FROM tramites t
        JOIN vehiculos v ON t.vehiculo_id = v.id
        WHERE t.id = ? AND t.usuario_id = ? AND t.tipo_tramite IN ('Ahorro SOAT', 'Ahorro Tecnomecánica')
    ");
    $stmt->execute([$ahorro_id, $usuario_id]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

public function registrarDeposito($datos) {
    $db = getDB();
    $stmt = $db->prepare("
        INSERT INTO depositos_ahorro (ahorro_id, monto, fecha, comprobante)
        VALUES (?, ?, ?, ?)
    ");
    
    return $stmt->execute([
        $datos['ahorro_id'],
        $datos['monto'],
        $datos['fecha'],
        $datos['comprobante']
    ]);
}

public function obtenerDepositosPorAhorro($ahorro_id) {
    $db = getDB();
    $stmt = $db->prepare("
        SELECT * FROM depositos_ahorro
        WHERE ahorro_id = ?
        ORDER BY fecha DESC
    ");
    $stmt->execute([$ahorro_id]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}
}