<?php
class RecordatorioModel {
    public function obtenerRecordatoriosPorUsuario($usuario_id) {
        $db = getDB();
        $stmt = $db->prepare("
            SELECT r.*, v.placa as vehiculo_placa, v.marca, v.linea
            FROM recordatorios r
            LEFT JOIN vehiculos v ON r.vehiculo_id = v.id
            WHERE r.usuario_id = ?
            ORDER BY r.fecha_recordatorio ASC
        ");
        $stmt->execute([$usuario_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    public function crearRecordatorio($datos) {
        $db = getDB();
        $stmt = $db->prepare("
            INSERT INTO recordatorios (
                usuario_id, vehiculo_id, titulo, descripcion, 
                fecha_inicio, fecha_recordatorio, frecuencia, 
                notificacion_email, notificacion_sms
            ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)
        ");
        
        return $stmt->execute([
            $datos['usuario_id'],
            $datos['vehiculo_id'] ?: null,
            $datos['titulo'],
            $datos['descripcion'] ?: null,
            $datos['fecha_inicio'],
            $datos['fecha_recordatorio'],
            $datos['frecuencia'] ?: 'una_vez',
            isset($datos['notificacion_email']) ? 1 : 0,
            isset($datos['notificacion_sms']) ? 1 : 0
        ]);
    }
    
    public function actualizarRecordatorio($datos) {
        $db = getDB();
        $stmt = $db->prepare("
            UPDATE recordatorios 
            SET vehiculo_id = ?, titulo = ?, descripcion = ?, 
                fecha_inicio = ?, fecha_recordatorio = ?, frecuencia = ?, 
                notificacion_email = ?, notificacion_sms = ?
            WHERE id = ? AND usuario_id = ?
        ");
        
        return $stmt->execute([
            $datos['vehiculo_id'] ?: null,
            $datos['titulo'],
            $datos['descripcion'] ?: null,
            $datos['fecha_inicio'],
            $datos['fecha_recordatorio'],
            $datos['frecuencia'] ?: 'una_vez',
            isset($datos['notificacion_email']) ? 1 : 0,
            isset($datos['notificacion_sms']) ? 1 : 0,
            $datos['recordatorio_id'],
            $datos['usuario_id']
        ]);
    }
    
    public function completarRecordatorio($recordatorio_id, $usuario_id) {
        $db = getDB();
        $stmt = $db->prepare("
            UPDATE recordatorios 
            SET estado = 'completado'
            WHERE id = ? AND usuario_id = ?
        ");
        
        return $stmt->execute([$recordatorio_id, $usuario_id]);
    }
    
    public function cancelarRecordatorio($recordatorio_id, $usuario_id) {
        $db = getDB();
        $stmt = $db->prepare("
            UPDATE recordatorios 
            SET estado = 'cancelado'
            WHERE id = ? AND usuario_id = ?
        ");
        
        return $stmt->execute([$recordatorio_id, $usuario_id]);
    }
    
    public function eliminarRecordatorio($recordatorio_id, $usuario_id) {
        $db = getDB();
        $stmt = $db->prepare("
            DELETE FROM recordatorios
            WHERE id = ? AND usuario_id = ?
        ");
        
        return $stmt->execute([$recordatorio_id, $usuario_id]);
    }
    
    public function obtenerRecordatorioPorId($recordatorio_id, $usuario_id) {
        $db = getDB();
        $stmt = $db->prepare("
            SELECT r.*, v.placa as vehiculo_placa
            FROM recordatorios r
            LEFT JOIN vehiculos v ON r.vehiculo_id = v.id
            WHERE r.id = ? AND r.usuario_id = ?
        ");
        $stmt->execute([$recordatorio_id, $usuario_id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    
    public function obtenerRecordatoriosProximos($usuario_id, $dias = 7) {
        $db = getDB();
        $stmt = $db->prepare("
            SELECT r.*, v.placa as vehiculo_placa, v.marca, v.linea
            FROM recordatorios r
            LEFT JOIN vehiculos v ON r.vehiculo_id = v.id
            WHERE r.usuario_id = ? 
              AND r.estado = 'pendiente' 
              AND r.fecha_recordatorio BETWEEN CURRENT_DATE() AND DATE_ADD(CURRENT_DATE(), INTERVAL ? DAY)
            ORDER BY r.fecha_recordatorio ASC
        ");
        $stmt->execute([$usuario_id, $dias]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}