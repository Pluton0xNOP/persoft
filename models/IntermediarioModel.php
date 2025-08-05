<?php
// models/IntermediarioModel.php
class IntermediarioModel {
    public function obtenerPorUsuarioId($usuario_id) {
        $db = getDB();
        $stmt = $db->prepare("SELECT * FROM intermediarios WHERE usuario_id = ?");
        $stmt->execute([$usuario_id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    
    public function obtenerPorId($id) {
        $db = getDB();
        $stmt = $db->prepare("SELECT i.*, u.nombres, u.apellidos, u.email, u.celular 
                             FROM intermediarios i
                             JOIN usuarios u ON i.usuario_id = u.id
                             WHERE i.id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    
    public function obtenerTodos() {
        $db = getDB();
        $stmt = $db->prepare("SELECT i.*, u.nombres, u.apellidos, u.email, u.celular 
                             FROM intermediarios i
                             JOIN usuarios u ON i.usuario_id = u.id
                             ORDER BY i.fecha_registro DESC");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    public function crearIntermediario($datos) {
        $db = getDB();
        try {
            $db->beginTransaction();
            
            $stmtUsuario = $db->prepare("UPDATE usuarios SET tipo_usuario = 'intermediario' WHERE id = ?");
            $stmtUsuario->execute([$datos['usuario_id']]);
            
            $stmt = $db->prepare(
                "INSERT INTO intermediarios (
                    usuario_id, nombre_negocio, direccion, telefono_negocio,
                    tipo_documento, numero_documento, cuenta_bancaria,
                    entidad_bancaria, porcentaje_comision, estado
                ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)"
            );
            
            $stmt->execute([
                $datos['usuario_id'],
                $datos['nombre_negocio'],
                $datos['direccion'],
                $datos['telefono_negocio'],
                $datos['tipo_documento'],
                $datos['numero_documento'],
                $datos['cuenta_bancaria'],
                $datos['entidad_bancaria'],
                $datos['porcentaje_comision'],
                $datos['estado']
            ]);
            
            $intermediario_id = $db->lastInsertId();
            $db->commit();
            return $intermediario_id;
        } catch (Exception $e) {
            $db->rollBack();
            return false;
        }
    }
    
    public function actualizarIntermediario($datos) {
        $db = getDB();
        $stmt = $db->prepare(
            "UPDATE intermediarios SET 
                nombre_negocio = ?,
                direccion = ?,
                telefono_negocio = ?,
                tipo_documento = ?,
                numero_documento = ?,
                cuenta_bancaria = ?,
                entidad_bancaria = ?,
                porcentaje_comision = ?,
                estado = ?
            WHERE id = ?"
        );
        
        return $stmt->execute([
            $datos['nombre_negocio'],
            $datos['direccion'],
            $datos['telefono_negocio'],
            $datos['tipo_documento'],
            $datos['numero_documento'],
            $datos['cuenta_bancaria'],
            $datos['entidad_bancaria'],
            $datos['porcentaje_comision'],
            $datos['estado'],
            $datos['id']
        ]);
    }
    
    public function actualizarSaldo($intermediario_id, $monto, $tipo, $referencia = null, $descripcion = null) {
        $db = getDB();
        try {
            $db->beginTransaction();
            
            $stmt = $db->prepare("SELECT saldo_actual FROM intermediarios WHERE id = ? FOR UPDATE");
            $stmt->execute([$intermediario_id]);
            $intermediario = $stmt->fetch(PDO::FETCH_ASSOC);
            
            if (!$intermediario) {
                $db->rollBack();
                return false;
            }
            
            $saldo_anterior = $intermediario['saldo_actual'];
            $saldo_nuevo = $saldo_anterior + $monto;
            
            $stmt = $db->prepare("UPDATE intermediarios SET saldo_actual = ? WHERE id = ?");
            $stmt->execute([$saldo_nuevo, $intermediario_id]);
            
            $stmt = $db->prepare(
                "INSERT INTO transacciones_saldo (
                    intermediario_id, tipo, monto, saldo_anterior, 
                    saldo_nuevo, referencia, descripcion
                ) VALUES (?, ?, ?, ?, ?, ?, ?)"
            );
            
            $stmt->execute([
                $intermediario_id,
                $tipo,
                $monto,
                $saldo_anterior,
                $saldo_nuevo,
                $referencia,
                $descripcion
            ]);
            
            $db->commit();
            return true;
        } catch (Exception $e) {
            $db->rollBack();
            return false;
        }
    }
    
    public function obtenerTransaccionesSaldo($intermediario_id) {
        $db = getDB();
        $stmt = $db->prepare("
            SELECT * FROM transacciones_saldo 
            WHERE intermediario_id = ? 
            ORDER BY fecha_transaccion DESC
        ");
        $stmt->execute([$intermediario_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    public function solicitarRetiro($datos) {
        $db = getDB();
        try {
            $db->beginTransaction();
            
            $stmt = $db->prepare("SELECT saldo_actual FROM intermediarios WHERE id = ? FOR UPDATE");
            $stmt->execute([$datos['intermediario_id']]);
            $intermediario = $stmt->fetch(PDO::FETCH_ASSOC);
            
            if (!$intermediario || $intermediario['saldo_actual'] < $datos['monto']) {
                $db->rollBack();
                return false;
            }
            
            $stmt = $db->prepare(
                "INSERT INTO solicitudes_retiro (
                    intermediario_id, monto, medio_pago, comentario
                ) VALUES (?, ?, ?, ?)"
            );
            
            $stmt->execute([
                $datos['intermediario_id'],
                $datos['monto'],
                $datos['medio_pago'],
                $datos['comentario']
            ]);
            
            $db->commit();
            return $db->lastInsertId();
        } catch (Exception $e) {
            $db->rollBack();
            return false;
        }
    }
    
    public function procesarSolicitudRetiro($solicitud_id, $estado, $comprobante = null) {
        $db = getDB();
        try {
            $db->beginTransaction();
            
            $stmt = $db->prepare("
                SELECT sr.*, i.id as intermediario_id, i.saldo_actual 
                FROM solicitudes_retiro sr
                JOIN intermediarios i ON sr.intermediario_id = i.id
                WHERE sr.id = ? AND sr.estado = 'pendiente'
                FOR UPDATE
            ");
            $stmt->execute([$solicitud_id]);
            $solicitud = $stmt->fetch(PDO::FETCH_ASSOC);
            
            if (!$solicitud) {
                $db->rollBack();
                return false;
            }
            
            if ($estado == 'procesada') {
                if ($solicitud['saldo_actual'] < $solicitud['monto']) {
                    $db->rollBack();
                    return false;
                }
                
                $this->actualizarSaldo(
                    $solicitud['intermediario_id'],
                    -$solicitud['monto'],
                    'retiro',
                    "Retiro #" . $solicitud_id,
                    "Retiro procesado mediante " . $solicitud['medio_pago']
                );
            }
            
            $stmt = $db->prepare("
                UPDATE solicitudes_retiro 
                SET estado = ?, comprobante = ?, fecha_procesamiento = NOW()
                WHERE id = ?
            ");
            
            $stmt->execute([$estado, $comprobante, $solicitud_id]);
            
            $db->commit();
            return true;
        } catch (Exception $e) {
            $db->rollBack();
            return false;
        }
    }
    
    public function obtenerSolicitudesRetiro($intermediario_id = null, $estado = null) {
        $db = getDB();
        
        $sql = "
            SELECT sr.*, i.nombre_negocio, u.nombres, u.apellidos, u.email
            FROM solicitudes_retiro sr
            JOIN intermediarios i ON sr.intermediario_id = i.id
            JOIN usuarios u ON i.usuario_id = u.id
        ";
        
        $params = [];
        $conditions = [];
        
        if ($intermediario_id) {
            $conditions[] = "sr.intermediario_id = ?";
            $params[] = $intermediario_id;
        }
        
        if ($estado) {
            $conditions[] = "sr.estado = ?";
            $params[] = $estado;
        }
        
        if (!empty($conditions)) {
            $sql .= " WHERE " . implode(" AND ", $conditions);
        }
        
        $sql .= " ORDER BY sr.fecha_solicitud DESC";
        
        $stmt = $db->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}