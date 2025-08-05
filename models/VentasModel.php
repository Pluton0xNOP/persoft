<?php
class VentasModel {
    public function obtenerPorId($id) {
        $db = getDB();
        $stmt = $db->prepare("
            SELECT v.*, i.nombre_negocio, u.nombres as cliente_nombres, u.apellidos as cliente_apellidos,
                  vh.placa as vehiculo_placa, vh.marca as vehiculo_marca, vh.linea as vehiculo_linea
            FROM ventas v
            JOIN intermediarios i ON v.intermediario_id = i.id
            JOIN usuarios u ON v.cliente_id = u.id
            JOIN vehiculos vh ON v.vehiculo_id = vh.id
            WHERE v.id = ?
        ");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    
    public function obtenerPorIntermediario($intermediario_id, $estado = null) {
        $db = getDB();
        
        $sql = "
            SELECT v.*, u.nombres as cliente_nombres, u.apellidos as cliente_apellidos,
                  vh.placa as vehiculo_placa, vh.marca as vehiculo_marca, vh.linea as vehiculo_linea
            FROM ventas v
            JOIN usuarios u ON v.cliente_id = u.id
            JOIN vehiculos vh ON v.vehiculo_id = vh.id
            WHERE v.intermediario_id = ?
        ";
        
        $params = [$intermediario_id];
        
        if ($estado) {
            $sql .= " AND v.estado = ?";
            $params[] = $estado;
        }
        
        $sql .= " ORDER BY v.fecha_venta DESC";
        
        $stmt = $db->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    public function obtenerTodas($estado = null) {
        $db = getDB();
        
        $sql = "
            SELECT v.*, i.nombre_negocio, u.nombres as cliente_nombres, u.apellidos as cliente_apellidos,
                  vh.placa as vehiculo_placa, vh.marca as vehiculo_marca, vh.linea as vehiculo_linea
            FROM ventas v
            JOIN intermediarios i ON v.intermediario_id = i.id
            JOIN usuarios u ON v.cliente_id = u.id
            JOIN vehiculos vh ON v.vehiculo_id = vh.id
        ";
        
        $params = [];
        
        if ($estado) {
            $sql .= " WHERE v.estado = ?";
            $params[] = $estado;
        }
        
        $sql .= " ORDER BY v.fecha_venta DESC";
        
        $stmt = $db->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    public function registrarVenta($datos) {
        $db = getDB();
        try {
            $db->beginTransaction();
            
            $stmt = $db->prepare(
                "INSERT INTO ventas (
                    intermediario_id, cliente_id, vehiculo_id, producto,
                    referencia, valor_total, valor_comision, estado
                ) VALUES (?, ?, ?, ?, ?, ?, ?, ?)"
            );
            
            $stmt->execute([
                $datos['intermediario_id'],
                $datos['cliente_id'],
                $datos['vehiculo_id'],
                $datos['producto'],
                $datos['referencia'],
                $datos['valor_total'],
                $datos['valor_comision'],
                $datos['estado'] ?? 'pendiente'
            ]);
            
            $venta_id = $db->lastInsertId();
            
            if ($datos['producto'] == 'SOAT' && isset($datos['soat_data'])) {
                $stmt = $db->prepare(
                    "INSERT INTO soat (
                        vehiculo_id, no_poliza, fecha_expedicion, fecha_vigencia, 
                        fecha_vencimiento, entidad_expide, estado, tipo_tarifa,
                        venta_id, intermediario_id
                    ) VALUES (?, ?, STR_TO_DATE(?, '%d/%m/%Y'), STR_TO_DATE(?, '%d/%m/%Y'), 
                            STR_TO_DATE(?, '%d/%m/%Y'), ?, ?, ?, ?, ?)"
                );
                
                $stmt->execute([
                    $datos['vehiculo_id'],
                    $datos['soat_data']['no_poliza'],
                    $datos['soat_data']['fecha_expedicion'],
                    $datos['soat_data']['fecha_vigencia'],
                    $datos['soat_data']['fecha_vencimiento'],
                    $datos['soat_data']['entidad_expide'],
                    'VIGENTE',
                    $datos['soat_data']['tipo_tarifa'] ?? '120',
                    $venta_id,
                    $datos['intermediario_id']
                ]);
            } elseif ($datos['producto'] == 'Tecnomecanica' && isset($datos['rtm_data'])) {
                $stmt = $db->prepare(
                    "INSERT INTO revision_tecnico_mecanica (
                        vehiculo_id, tipo_revision, fecha_expedicion, fecha_vigente, 
                        cda_expide, vigente, nro_certificado, informacion_consistente,
                        venta_id, intermediario_id
                    ) VALUES (?, ?, STR_TO_DATE(?, '%d/%m/%Y'), STR_TO_DATE(?, '%d/%m/%Y'), 
                            ?, ?, ?, ?, ?, ?)"
                );
                
                $stmt->execute([
                    $datos['vehiculo_id'],
                    'REVISION TECNICO-MECANICO',
                    $datos['rtm_data']['fecha_expedicion'],
                    $datos['rtm_data']['fecha_vigente'],
                    $datos['rtm_data']['cda_expide'],
                    'SI',
                    $datos['rtm_data']['nro_certificado'],
                    'SI',
                    $venta_id,
                    $datos['intermediario_id']
                ]);
            }
            
            $db->commit();
            return $venta_id;
        } catch (Exception $e) {
            $db->rollBack();
            return false;
        }
    }
    
    public function actualizarEstadoVenta($venta_id, $estado) {
        $db = getDB();
        $stmt = $db->prepare("UPDATE ventas SET estado = ? WHERE id = ?");
        return $stmt->execute([$estado, $venta_id]);
    }
    
    public function procesarComision($venta_id) {
        $db = getDB();
        try {
            $db->beginTransaction();
            
            $stmt = $db->prepare("
                SELECT v.*, i.id as intermediario_id 
                FROM ventas v
                JOIN intermediarios i ON v.intermediario_id = i.id
                WHERE v.id = ? AND v.estado = 'completada' AND v.fecha_pago_comision IS NULL
                FOR UPDATE
            ");
            $stmt->execute([$venta_id]);
            $venta = $stmt->fetch(PDO::FETCH_ASSOC);
            
            if (!$venta) {
                $db->rollBack();
                return false;
            }
            
            require_once ROOT_PATH . 'models/IntermediarioModel.php';
            $intermediarioModel = new IntermediarioModel();
            
            $intermediarioModel->actualizarSaldo(
                $venta['intermediario_id'],
                $venta['valor_comision'],
                'comision',
                "Venta #" . $venta_id,
                "Comisión por venta de " . $venta['producto'] . " - " . $venta['referencia']
            );
            
            $stmt = $db->prepare("
                UPDATE ventas 
                SET fecha_pago_comision = NOW()
                WHERE id = ?
            ");
            
            $stmt->execute([$venta_id]);
            
            $db->commit();
            return true;
        } catch (Exception $e) {
            $db->rollBack();
            return false;
        }
    }
    
    public function obtenerEstadisticas($intermediario_id = null, $periodo = 'mes') {
        $db = getDB();
        
        $condicion = "";
        $params = [];
        
        if ($intermediario_id) {
            $condicion = " WHERE v.intermediario_id = ?";
            $params[] = $intermediario_id;
        }
        
        $sql_periodo = "";
        switch ($periodo) {
            case 'semana':
                $sql_periodo = "AND v.fecha_venta >= DATE_SUB(CURRENT_DATE(), INTERVAL 7 DAY)";
                break;
            case 'mes':
                $sql_periodo = "AND YEAR(v.fecha_venta) = YEAR(CURRENT_DATE()) AND MONTH(v.fecha_venta) = MONTH(CURRENT_DATE())";
                break;
            case 'año':
                $sql_periodo = "AND YEAR(v.fecha_venta) = YEAR(CURRENT_DATE())";
                break;
        }
        
        if (!empty($condicion) && !empty($sql_periodo)) {
            $condicion .= " " . $sql_periodo;
        } elseif (empty($condicion) && !empty($sql_periodo)) {
            $condicion = " WHERE " . ltrim($sql_periodo, "AND ");
        }
        
        $stmt = $db->prepare("
            SELECT 
                COUNT(*) as total_ventas,
                SUM(CASE WHEN v.estado = 'completada' THEN 1 ELSE 0 END) as ventas_completadas,
                SUM(CASE WHEN v.estado = 'pendiente' THEN 1 ELSE 0 END) as ventas_pendientes,
                SUM(v.valor_total) as valor_total,
                SUM(v.valor_comision) as valor_comision,
                SUM(CASE WHEN v.producto = 'SOAT' THEN 1 ELSE 0 END) as total_soat,
                SUM(CASE WHEN v.producto = 'Tecnomecanica' THEN 1 ELSE 0 END) as total_tecno
            FROM ventas v
            $condicion
        ");
        
        $stmt->execute($params);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}