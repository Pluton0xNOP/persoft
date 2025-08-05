<?php
// models/CotizacionesModel.php
class CotizacionesModel {
    public function obtenerPorId($id) {
        $db = getDB();
        $stmt = $db->prepare("
            SELECT c.*, i.nombre_negocio
            FROM cotizaciones c
            JOIN intermediarios i ON c.intermediario_id = i.id
            WHERE c.id = ?
        ");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    
    public function obtenerPorIntermediario($intermediario_id, $estado = null) {
        $db = getDB();
        
        $sql = "
            SELECT * FROM cotizaciones 
            WHERE intermediario_id = ?
        ";
        
        $params = [$intermediario_id];
        
        if ($estado) {
            $sql .= " AND estado = ?";
            $params[] = $estado;
        }
        
        $sql .= " ORDER BY fecha_creacion DESC";
        
        $stmt = $db->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    public function crear($datos) {
        $db = getDB();
        $fecha_vencimiento = date('Y-m-d H:i:s', strtotime('+7 days'));
        
        $stmt = $db->prepare(
            "INSERT INTO cotizaciones (
                intermediario_id, placa, tipo_vehiculo, modelo, cilindraje,
                nombre_cliente, telefono_cliente, email_cliente, producto,
                valor, estado, fecha_vencimiento
            ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)"
        );
        
        return $stmt->execute([
            $datos['intermediario_id'],
            $datos['placa'],
            $datos['tipo_vehiculo'],
            $datos['modelo'],
            $datos['cilindraje'],
            $datos['nombre_cliente'],
            $datos['telefono_cliente'],
            $datos['email_cliente'],
            $datos['producto'],
            $datos['valor'],
            $datos['estado'] ?? 'pendiente',
            $fecha_vencimiento
        ]);
    }
    
    public function actualizarEstado($id, $estado) {
        $db = getDB();
        $stmt = $db->prepare("UPDATE cotizaciones SET estado = ? WHERE id = ?");
        return $stmt->execute([$estado, $id]);
    }
    
    public function obtenerCotizacionesVencidas() {
        $db = getDB();
        $stmt = $db->prepare("
            SELECT c.*, i.nombre_negocio
            FROM cotizaciones c
            JOIN intermediarios i ON c.intermediario_id = i.id
            WHERE c.estado = 'pendiente' AND c.fecha_vencimiento < NOW()
        ");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    public function obtenerPorPlaca($placa, $intermediario_id = null) {
        $db = getDB();
        
        $sql = "
            SELECT c.*, i.nombre_negocio
            FROM cotizaciones c
            JOIN intermediarios i ON c.intermediario_id = i.id
            WHERE c.placa = ? AND c.estado = 'pendiente' AND c.fecha_vencimiento > NOW()
        ";
        
        $params = [$placa];
        
        if ($intermediario_id) {
            $sql .= " AND c.intermediario_id = ?";
            $params[] = $intermediario_id;
        }
        
        $sql .= " ORDER BY c.fecha_creacion DESC";
        
        $stmt = $db->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}