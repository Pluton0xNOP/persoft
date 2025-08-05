<?php
//models/VehiculoModel.php
class VehiculoModel {

    
    private function calcularEstadoDocumento($fechaVencimiento, $diasPeriodo = 365) {
        if (!$fechaVencimiento) {
            return ['estado' => 'Sin información', 'progreso' => 0, 'vencimiento' => 'No disponible', 'dias_restantes' => null];
        }
        $hoy = new DateTime();
        $vencimiento = new DateTime($fechaVencimiento);
        $diferencia = $hoy->diff($vencimiento);
        $diasRestantes = (int)$diferencia->format('%r%a');
        
        $fechaExpedicion = (clone $vencimiento)->modify("-{$diasPeriodo} days");
        $totalDias = max(1, $fechaExpedicion->diff($vencimiento)->days);
        $diasTranscurridos = $fechaExpedicion->diff($hoy)->days;
        $progreso = round(max(0, min(100, ($diasTranscurridos / $totalDias) * 100)));

        if ($diasRestantes < 0) {
            return ['estado' => 'Vencido', 'progreso' => 100, 'vencimiento' => $vencimiento->format('d/m/Y'), 'dias_restantes' => $diasRestantes];
        }
        if ($diasRestantes <= 30) {
            return ['estado' => 'Próximo a Vencer', 'progreso' => $progreso, 'vencimiento' => $vencimiento->format('d/m/Y'), 'dias_restantes' => $diasRestantes];
        }
        return ['estado' => 'Activa', 'progreso' => $progreso, 'vencimiento' => $vencimiento->format('d/m/Y'), 'dias_restantes' => $diasRestantes];
    }
    public function obtenerVehiculosPorPlaca($placa) {
    $db = getDB();
    $vehiculos = [];
    
    $stmtVehiculos = $db->prepare("SELECT v.*, u.nombres, u.cedula FROM vehiculos v JOIN usuarios u ON v.usuario_id = u.id WHERE v.placa = ?");
    $stmtVehiculos->execute([$placa]);
    
    foreach ($stmtVehiculos->fetchAll(PDO::FETCH_ASSOC) as $vehiculo) {
        if ($this->debeActualizarSemaforizacion($vehiculo['id'])) {
            $this->consultarYGuardarSemaforizacion($db, $vehiculo['id'], $vehiculo['placa']);
        }
        
        $stmtSoat = $db->prepare("SELECT fecha_vencimiento FROM soat WHERE vehiculo_id = ? ORDER BY fecha_vencimiento DESC LIMIT 1");
        $stmtSoat->execute([$vehiculo['id']]);
        $soatData = $stmtSoat->fetch(PDO::FETCH_ASSOC);
        
        $stmtTecno = $db->prepare("SELECT fecha_vigente FROM revision_tecnico_mecanica WHERE vehiculo_id = ? ORDER BY fecha_vigente DESC LIMIT 1");
        $stmtTecno->execute([$vehiculo['id']]);
        $tecnoData = $stmtTecno->fetch(PDO::FETCH_ASSOC);
        
        $stmtSemaf = $db->prepare("SELECT SUM(total_tarifa) as total_deuda, GROUP_CONCAT(DISTINCT municipio SEPARATOR ', ') as municipios, MAX(fecha_ultimo_pago) as ultimo_pago FROM semaforizacion WHERE vehiculo_id = ? AND total_tarifa > 0");
        $stmtSemaf->execute([$vehiculo['id']]);
        $semafData = $stmtSemaf->fetch(PDO::FETCH_ASSOC);
        
        $semaforizacionInfo = ['estado' => 'Al día'];
        if ($semafData && $semafData['total_deuda'] > 0) {
            $municipios = $semafData['municipios'] ? explode(', ', $semafData['municipios']) : [];
            $semaforizacionInfo = ['estado' => 'Pago Pendiente', 'total_deuda' => $semafData['total_deuda'], 'municipios' => $municipios, 'ultimo_pago' => $semafData['ultimo_pago']];
        }
        
        $vehiculos[] = [
            'id' => $vehiculo['id'], 
            'usuario_id' => $vehiculo['usuario_id'],
            'info' => [
                'placa' => $vehiculo['placa'], 
                'marca' => $vehiculo['marca'], 
                'modelo' => $vehiculo['modelo'], 
                'linea' => $vehiculo['linea'], 
                'color' => $vehiculo['color'], 
                'cilindraje' => $vehiculo['cilindraje'], 
                'tipo' => $vehiculo['clase_vehiculo'] === 'MOTOCICLETA' ? 'Motocicleta' : 'Automóvil'
            ], 
            'propietario' => [
                'nombre' => $vehiculo['nombres'], 
                'cedula' => $vehiculo['cedula']
            ], 
            'soat' => $this->calcularEstadoDocumento($soatData['fecha_vencimiento'] ?? null), 
            'tecnomecanica' => $this->calcularEstadoDocumento($tecnoData['fecha_vigente'] ?? null), 
            'semaforizacion' => $semaforizacionInfo
        ];
    }
    
    return $vehiculos;
}
    private function consultarYGuardarSemaforizacion($db, $vehiculoId, $placa) {
        $stmtDelete = $db->prepare("DELETE FROM semaforizacion WHERE vehiculo_id = ?");
        $stmtDelete->execute([$vehiculoId]);
        
        $municipios = [
            'bello' => BASE_URL . "api_runt/antioquia/bello.php?placa=" . urlencode($placa),
            'envigado' => BASE_URL . "api_runt/antioquia/envigado.php?placa=" . urlencode($placa),
            'sabaneta' => BASE_URL . "api_runt/antioquia/sabaneta.php?placa=" . urlencode($placa)
        ];
        
        $stmt = $db->prepare("INSERT INTO semaforizacion (vehiculo_id, municipio, anno, total_tarifa, fecha_ultimo_pago) VALUES (?, ?, ?, ?, ?)");
        
        foreach ($municipios as $nombre => $url) {
            $ch = curl_init($url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_TIMEOUT, 15);
            $response = curl_exec($ch);
            $error = curl_error($ch);
            curl_close($ch);

            if ($error || $response === false) {
                error_log("Error de cURL para $nombre (placa: $placa): " . $error);
                continue;
            }

            $data = json_decode($response, true);
            if (isset($data['listaVigencias']) && !empty($data['listaVigencias'])) {
                $fechaUltimoPago = isset($data['fechaUltimoPago']) && !empty($data['fechaUltimoPago']) ? $data['fechaUltimoPago'] : null;
                
                foreach ($data['listaVigencias'] as $vigencia) {
                    $totalTarifa = isset($vigencia['totalTarifa']) ? (float)$vigencia['totalTarifa'] : 0;
                    $stmt->execute([$vehiculoId, ucfirst($nombre), $vigencia['anno'], $totalTarifa, $fechaUltimoPago]);
                }
            }
        }
    }
    
    private function debeActualizarSemaforizacion($vehiculoId) {
        $db = getDB();
        $stmt = $db->prepare("SELECT MAX(fecha_consulta) as ultima_consulta FROM semaforizacion WHERE vehiculo_id = ?");
        $stmt->execute([$vehiculoId]);
        $resultado = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if (!$resultado || !$resultado['ultima_consulta']) {
            return true;
        }
        
        $ultimaConsulta = new DateTime($resultado['ultima_consulta']);
        $ahora = new DateTime();
        $diff = $ultimaConsulta->diff($ahora);
        
        return $diff->days > 0;
    }

    public function obtenerVehiculosPorUsuario($usuario_id) {
        $db = getDB(); 
        $vehiculos = [];
        
        $stmtVehiculos = $db->prepare("SELECT v.*, u.nombres, u.cedula FROM vehiculos v JOIN usuarios u ON v.usuario_id = u.id WHERE v.usuario_id = ?");
        $stmtVehiculos->execute([$usuario_id]);
        
        foreach ($stmtVehiculos->fetchAll(PDO::FETCH_ASSOC) as $vehiculo) {
            if ($this->debeActualizarSemaforizacion($vehiculo['id'])) {
                $this->consultarYGuardarSemaforizacion($db, $vehiculo['id'], $vehiculo['placa']);
            }
            
            $stmtSoat = $db->prepare("SELECT fecha_vencimiento FROM soat WHERE vehiculo_id = ? ORDER BY fecha_vencimiento DESC LIMIT 1");
            $stmtSoat->execute([$vehiculo['id']]);
            $soatData = $stmtSoat->fetch(PDO::FETCH_ASSOC);
            
            $stmtTecno = $db->prepare("SELECT fecha_vigente FROM revision_tecnico_mecanica WHERE vehiculo_id = ? ORDER BY fecha_vigente DESC LIMIT 1");
            $stmtTecno->execute([$vehiculo['id']]);
            $tecnoData = $stmtTecno->fetch(PDO::FETCH_ASSOC);
            
            $stmtSemaf = $db->prepare("SELECT SUM(total_tarifa) as total_deuda, GROUP_CONCAT(DISTINCT municipio SEPARATOR ', ') as municipios, MAX(fecha_ultimo_pago) as ultimo_pago FROM semaforizacion WHERE vehiculo_id = ? AND total_tarifa > 0");
            $stmtSemaf->execute([$vehiculo['id']]);
            $semafData = $stmtSemaf->fetch(PDO::FETCH_ASSOC);
            
            $semaforizacionInfo = ['estado' => 'Al día'];
            if ($semafData && $semafData['total_deuda'] > 0) {
                $municipios = $semafData['municipios'] ? explode(', ', $semafData['municipios']) : [];
                $semaforizacionInfo = ['estado' => 'Pago Pendiente', 'total_deuda' => $semafData['total_deuda'], 'municipios' => $municipios, 'ultimo_pago' => $semafData['ultimo_pago']];
            }
            
            $vehiculos[] = [
                'id' => $vehiculo['id'], 
                'info' => [
                    'placa' => $vehiculo['placa'], 
                    'marca' => $vehiculo['marca'], 
                    'modelo' => $vehiculo['modelo'], 
                    'linea' => $vehiculo['linea'], 
                    'color' => $vehiculo['color'], 
                    'cilindraje' => $vehiculo['cilindraje'], 
                    'tipo' => $vehiculo['clase_vehiculo'] === 'MOTOCICLETA' ? 'Motocicleta' : 'Automóvil'
                ], 
                'propietario' => [
                    'nombre' => $vehiculo['nombres'], 
                    'cedula' => $vehiculo['cedula']
                ], 
                'soat' => $this->calcularEstadoDocumento($soatData['fecha_vencimiento'] ?? null), 
                'tecnomecanica' => $this->calcularEstadoDocumento($tecnoData['fecha_vigente'] ?? null), 
                'semaforizacion' => $semaforizacionInfo
            ];
        }
        
        return $vehiculos;
    }
    
    public function actualizarSemaforizacion($vehiculo_id) {
        $db = getDB();
        $stmt = $db->prepare("SELECT placa FROM vehiculos WHERE id = ?");
        $stmt->execute([$vehiculo_id]);
        $vehiculo = $stmt->fetch(PDO::FETCH_ASSOC);
        if (!$vehiculo) return false;
        $this->consultarYGuardarSemaforizacion($db, $vehiculo_id, $vehiculo['placa']);
        return true;
    }
    
    public function obtenerVehiculoPorId($vehiculo_id, $usuario_id) {
        $db = getDB();
        $stmt = $db->prepare("SELECT v.*, u.nombres, u.cedula FROM vehiculos v JOIN usuarios u ON v.usuario_id = u.id WHERE v.id = ? AND v.usuario_id = ?");
        $stmt->execute([$vehiculo_id, $usuario_id]);
        $vehiculo = $stmt->fetch(PDO::FETCH_ASSOC);
        if (!$vehiculo) return null;
        
        if ($this->debeActualizarSemaforizacion($vehiculo_id)) {
            $this->consultarYGuardarSemaforizacion($db, $vehiculo_id, $vehiculo['placa']);
        }
        
        $stmtSoat = $db->prepare("SELECT * FROM soat WHERE vehiculo_id = ? ORDER BY fecha_vencimiento DESC");
        $stmtSoat->execute([$vehiculo_id]);
        $vehiculo['historial_soat'] = $stmtSoat->fetchAll(PDO::FETCH_ASSOC);
        $stmtTecno = $db->prepare("SELECT * FROM revision_tecnico_mecanica WHERE vehiculo_id = ? ORDER BY fecha_vigente DESC");
        $stmtTecno->execute([$vehiculo_id]);
        $vehiculo['historial_rtm'] = $stmtTecno->fetchAll(PDO::FETCH_ASSOC);
        $stmtSemaf = $db->prepare("SELECT * FROM semaforizacion WHERE vehiculo_id = ? ORDER BY municipio, anno DESC");
        $stmtSemaf->execute([$vehiculo_id]);
        $vehiculo['historial_semaforizacion'] = $stmtSemaf->fetchAll(PDO::FETCH_ASSOC);
        return $vehiculo;
    }

    public function guardarVehiculoDesdeRUNT($usuario_id, $datos_runt) {
    $db = getDB();
    
    try {
        $db->beginTransaction();
        
        if (!isset($datos_runt['runt']['vehiculo']['informacionGeneralVehiculo'])) {
            throw new Exception("Datos del vehículo incompletos");
        }
        
        $info_vehiculo = $datos_runt['runt']['vehiculo']['informacionGeneralVehiculo'];
        
        $stmt = $db->prepare(
            "INSERT INTO vehiculos (usuario_id, placa, licencia_transito, estado, tipo_servicio, clase_vehiculo, marca, linea, modelo, color, no_motor, no_chasis, no_vin, cilindraje, tipo_carroceria, fecha_matricula, organismo_transito, tipo_combustible, pasajeros_sentados) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, STR_TO_DATE(?, '%d/%m/%Y'), ?, ?, ?)"
        );
        
        $stmt->execute([
            $usuario_id, 
            $info_vehiculo['noPlaca'], 
            $info_vehiculo['noLicenciaTransito'], 
            $info_vehiculo['estadoDelVehiculo'], 
            $info_vehiculo['tipoServicio'], 
            $info_vehiculo['claseVehiculo'], 
            $info_vehiculo['marca'], 
            $info_vehiculo['linea'], 
            $info_vehiculo['modelo'], 
            $info_vehiculo['color'], 
            $info_vehiculo['noMotor'], 
            $info_vehiculo['noChasis'], 
            $info_vehiculo['noVin'], 
            $info_vehiculo['cilidraje'], 
            $info_vehiculo['tipoCarroceria'], 
            $info_vehiculo['fechaMatricula'], 
            $info_vehiculo['organismoTransito'], 
            $info_vehiculo['tipoCombustible'], 
            $info_vehiculo['pasajerosSentados']
        ]);
        
        $vehiculo_id = $db->lastInsertId();
        
        if (isset($datos_runt['runt']['soat']['data']) && is_array($datos_runt['runt']['soat']['data'])) {
            $stmt = $db->prepare(
                "INSERT INTO soat (vehiculo_id, no_poliza, fecha_expedicion, fecha_vigencia, fecha_vencimiento, entidad_expide, estado, tipo_tarifa) VALUES (?, ?, STR_TO_DATE(?, '%d/%m/%Y'), STR_TO_DATE(?, '%d/%m/%Y'), STR_TO_DATE(?, '%d/%m/%Y'), ?, ?, ?)"
            );
            
            foreach ($datos_runt['runt']['soat']['data'] as $soat) {
                $stmt->execute([
                    $vehiculo_id, 
                    $soat['noPoliza'], 
                    $soat['fechaExpedicion'], 
                    $soat['fechaVigencia'], 
                    $soat['fechaVencimiento'], 
                    $soat['entidadExpideSoat'], 
                    $soat['estado'], 
                    $soat['tipoTarifa']
                ]);
            }
        }
        
        if (isset($datos_runt['runt']['rtm']['data']) && is_array($datos_runt['runt']['rtm']['data'])) {
            $stmt = $db->prepare(
                "INSERT INTO revision_tecnico_mecanica (vehiculo_id, tipo_revision, fecha_expedicion, fecha_vigente, cda_expide, vigente, nro_certificado, informacion_consistente, url_certificado) VALUES (?, ?, STR_TO_DATE(?, '%d/%m/%Y'), STR_TO_DATE(?, '%d/%m/%Y'), ?, ?, ?, ?, ?)"
            );
            
            foreach ($datos_runt['runt']['rtm']['data'] as $rtm) {
                $url_certificado = isset($rtm['url']) ? $rtm['url'] : null;
                $stmt->execute([
                    $vehiculo_id, 
                    $rtm['tipoRevision'], 
                    $rtm['fechaExpedicion'], 
                    $rtm['fechaVigente'], 
                    $rtm['cdaExpide'], 
                    $rtm['vigente'], 
                    $rtm['nroCertificado'], 
                    $rtm['informacionConsistente'], 
                    $url_certificado
                ]);
            }
        }
        
        if (isset($datos_runt['multas']) && is_array($datos_runt['multas'])) {
            $stmt = $db->prepare("INSERT INTO multas (vehiculo_id, usuario_id, numero_comparendo, estado_comparendo, organismo_transito, fecha_comparendo, valor_pagar, descripcion_infraccion, datos_completos) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
            
            foreach ($datos_runt['multas'] as $multa) {
                $descripcion = '';
                if (isset($multa['infracciones']) && is_array($multa['infracciones']) && count($multa['infracciones']) > 0) {
                    $descripcion = $multa['infracciones'][0]['descripcionInfraccion'] ?? '';
                }
                
                $fecha = null;
                if (isset($multa['fechaComparendo'])) {
                    $fechaObj = DateTime::createFromFormat('d/m/Y H:i:s', $multa['fechaComparendo']);
                    if ($fechaObj) {
                        $fecha = $fechaObj->format('Y-m-d H:i:s');
                    }
                }
                
                $stmt->execute([
                    $vehiculo_id,
                    $usuario_id,
                    $multa['numeroComparendo'] ?? '',
                    $multa['estadoComparendo'] ?? '',
                    $multa['organismoTransito'] ?? '',
                    $fecha,
                    $multa['valorPagar'] ?? 0,
                    $descripcion,
                    json_encode($multa)
                ]);
            }
        }
        
        $db->commit();
        return $vehiculo_id;
    } catch (Exception $e) {
        $db->rollBack();
        throw $e;
    }
}
    
    public function obtenerResumenDashboard($usuario_id) {
        $db = getDB();
        $stmt = $db->prepare("SELECT * FROM vehiculos WHERE usuario_id = ? ORDER BY id ASC LIMIT 1");
        $stmt->execute([$usuario_id]);
        $vehiculo = $stmt->fetch(PDO::FETCH_ASSOC);
        if (!$vehiculo) {
            return ['vehiculo' => null, 'alertas' => [], 'proyeccion_pagos' => ['labels' => [], 'data' => []]];
        }
        
        if ($this->debeActualizarSemaforizacion($vehiculo['id'])) {
            $this->consultarYGuardarSemaforizacion($db, $vehiculo['id'], $vehiculo['placa']);
        }
        
        $stmtSoat = $db->prepare("SELECT fecha_vencimiento FROM soat WHERE vehiculo_id = ? ORDER BY fecha_vencimiento DESC LIMIT 1");
        $stmtSoat->execute([$vehiculo['id']]);
        $soatData = $stmtSoat->fetch(PDO::FETCH_ASSOC);

        $stmtTecno = $db->prepare("SELECT fecha_vigente FROM revision_tecnico_mecanica WHERE vehiculo_id = ? ORDER BY fecha_vigente DESC LIMIT 1");
        $stmtTecno->execute([$vehiculo['id']]);
        $tecnoData = $stmtTecno->fetch(PDO::FETCH_ASSOC);

        $alertas = [
            'tecnomecanica' => $this->calcularEstadoDocumento($tecnoData['fecha_vigente'] ?? null),
            'soat' => $this->calcularEstadoDocumento($soatData['fecha_vencimiento'] ?? null)
        ];
        
        $stmtSemaf = $db->prepare("SELECT SUM(total_tarifa) as total_deuda FROM semaforizacion WHERE vehiculo_id = ? AND total_tarifa > 0");
        $stmtSemaf->execute([$vehiculo['id']]);
        $semafData = $stmtSemaf->fetch(PDO::FETCH_ASSOC);
        
        if ($semafData && $semafData['total_deuda'] > 0) {
            $alertas['semaforizacion'] = ['estado' => 'Pago Pendiente', 'total_deuda' => $semafData['total_deuda']];
        } else {
            $alertas['semaforizacion'] = ['estado' => 'Al día', 'total_deuda' => 0];
        }
        
        $vehiculo['clase'] = $vehiculo['clase_vehiculo'] === 'MOTOCICLETA' ? 'Motocicleta' : 'Automóvil';
        return ['vehiculo' => $vehiculo, 'alertas' => $alertas, 'proyeccion_pagos' => ['labels' => ['Jul', 'Ago', 'Sep', 'Oct', 'Nov', 'Dic'], 'data' => [180000, 0, 0, 850000, 0, 1200000]]];
    }
}