<?php
// models/ComisionesModel.php
class ComisionesModel {
    public function obtenerTodas() {
        $db = getDB();
        $stmt = $db->prepare("SELECT * FROM comisiones ORDER BY producto");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    public function obtenerPorProducto($producto) {
        $db = getDB();
        $stmt = $db->prepare("SELECT * FROM comisiones WHERE producto = ?");
        $stmt->execute([$producto]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    
    public function crear($datos) {
        $db = getDB();
        $stmt = $db->prepare(
            "INSERT INTO comisiones (
                producto, porcentaje_base, porcentaje_maximo, 
                monto_minimo, monto_maximo, activo
            ) VALUES (?, ?, ?, ?, ?, ?)"
        );
        
        return $stmt->execute([
            $datos['producto'],
            $datos['porcentaje_base'],
            $datos['porcentaje_maximo'],
            $datos['monto_minimo'],
            $datos['monto_maximo'],
            $datos['activo']
        ]);
    }
    
    public function actualizar($id, $datos) {
        $db = getDB();
        $stmt = $db->prepare(
            "UPDATE comisiones SET
                porcentaje_base = ?,
                porcentaje_maximo = ?,
                monto_minimo = ?,
                monto_maximo = ?,
                activo = ?
            WHERE id = ?"
        );
        
        return $stmt->execute([
            $datos['porcentaje_base'],
            $datos['porcentaje_maximo'],
            $datos['monto_minimo'],
            $datos['monto_maximo'],
            $datos['activo'],
            $id
        ]);
    }
    
    public function cambiarEstado($id, $activo) {
        $db = getDB();
        $stmt = $db->prepare("UPDATE comisiones SET activo = ? WHERE id = ?");
        return $stmt->execute([$activo, $id]);
    }
    
    public function calcularComision($producto, $valor_total, $intermediario_id = null) {
        $db = getDB();
        
        $porcentaje = 5; // Valor por defecto
        
        $stmt = $db->prepare("SELECT * FROM comisiones WHERE producto = ? AND activo = 1");
        $stmt->execute([$producto]);
        $comision = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if ($comision) {
            $porcentaje = $comision['porcentaje_base'];
            
            if ($intermediario_id) {
                $stmt = $db->prepare("SELECT porcentaje_comision FROM intermediarios WHERE id = ?");
                $stmt->execute([$intermediario_id]);
                $intermediario = $stmt->fetch(PDO::FETCH_ASSOC);
                
                if ($intermediario && $intermediario['porcentaje_comision'] > 0) {
                    $porcentaje = min($intermediario['porcentaje_comision'], $comision['porcentaje_maximo']);
                }
            }
        }
        
        $valor_comision = ($valor_total * $porcentaje) / 100;
        
        if ($comision && $comision['monto_minimo'] > 0 && $valor_comision < $comision['monto_minimo']) {
            $valor_comision = $comision['monto_minimo'];
        }
        
        if ($comision && $comision['monto_maximo'] > 0 && $valor_comision > $comision['monto_maximo']) {
            $valor_comision = $comision['monto_maximo'];
        }
        
        return $valor_comision;
    }
}