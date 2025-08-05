<?php
// controllers/AuthController.php
class AuthController
{
    public function login() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $db = getDB();
            $email = trim($_POST['email']);
            $password = $_POST['password'];

            $stmt = $db->prepare("SELECT * FROM usuarios WHERE email = ?");
            $stmt->execute([$email]);
            $usuario = $stmt->fetch();

            if ($usuario && password_verify($password, $usuario['password_hash'])) {
                session_regenerate_id(true);
                $_SESSION['usuario_id'] = $usuario['id'];
                $_SESSION['usuario_nombre'] = $usuario['nombres'];

                if ($usuario['password_temporal']) {
                    $_SESSION['requiere_cambio_password'] = true;
                    header('Location: ' . BASE_URL . 'auth/cambiar-password');
                    exit;
                }

                if (!empty($_POST['remember'])) {
                    $this->crearTokenRecordarme($usuario['id']);
                }
                
                header('Location: ' . BASE_URL . 'dashboard');
                exit;
            } else {
                $error = "Correo o contraseña incorrectos.";
                $isLoginActive = true;
                require_once ROOT_PATH . 'views/auth/auth.php';
                return;
            }
        } else {
            $isLoginActive = true;
            require_once ROOT_PATH . 'views/auth/auth.php';
        }
    }

    public function cambiarPassword() {
        if (!isset($_SESSION['usuario_id']) || !isset($_SESSION['requiere_cambio_password'])) {
            header('Location: ' . BASE_URL . 'auth/login');
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $password_actual = $_POST['password_actual'];
            $nueva_password = $_POST['nueva_password'];
            $confirmar_password = $_POST['confirmar_password'];

            if (strlen($nueva_password) < 8) {
                $error = "La nueva contraseña debe tener al menos 8 caracteres.";
            } elseif ($nueva_password !== $confirmar_password) {
                $error = "Las contraseñas no coinciden.";
            } else {
                $db = getDB();
                
                $stmt = $db->prepare("SELECT password_hash FROM usuarios WHERE id = ?");
                $stmt->execute([$_SESSION['usuario_id']]);
                $usuario = $stmt->fetch();

                if (!password_verify($password_actual, $usuario['password_hash'])) {
                    $error = "La contraseña actual es incorrecta.";
                } else {
                    $nuevo_hash = password_hash($nueva_password, PASSWORD_DEFAULT);
                    $stmt = $db->prepare("UPDATE usuarios SET password_hash = ?, password_temporal = 0 WHERE id = ?");
                    
                    if ($stmt->execute([$nuevo_hash, $_SESSION['usuario_id']])) {
                        unset($_SESSION['requiere_cambio_password']);
                        $_SESSION['password_cambiada'] = true;
                        header('Location: ' . BASE_URL . 'dashboard');
                        exit;
                    } else {
                        $error = "Error al actualizar la contraseña. Intente nuevamente.";
                    }
                }
            }
        }

        require_once ROOT_PATH . 'views/auth/cambiar_password.php';
    }

    public function register() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->mostrarPaginaCarga();
            
            require_once ROOT_PATH . 'helpers/email_helper.php';
            require_once ROOT_PATH . 'models/UsuarioModel.php';
            $db = getDB();

            $email = trim($_POST['email']);
            $stmt = $db->prepare("SELECT id FROM usuarios WHERE email = ?");
            $stmt->execute([$email]);
            if ($stmt->fetch()) {
                $error = "El correo electrónico ya está registrado.";
                $isLoginActive = false;
                require_once ROOT_PATH . 'views/auth/auth.php';
                return;
            }

            $password_aleatoria = bin2hex(random_bytes(8));
            $password_hash = password_hash($password_aleatoria, PASSWORD_DEFAULT);
            $cedula = trim($_POST['cedula']);
            $placa = trim($_POST['placa']);
            $codigo_referido = strtoupper(bin2hex(random_bytes(5)));

            try {
                $db->beginTransaction();
                $usuarioModel = new UsuarioModel();

                $id_referente = null;
                if (isset($_POST['ref']) && !empty($_POST['ref'])) {
                    $referente = $usuarioModel->obtenerPorCodigoReferido($_POST['ref']);
                    if ($referente) {
                        $id_referente = $referente['id'];
                    }
                }
                
                $stmt = $db->prepare(
                    "INSERT INTO usuarios (nombres, apellidos, email, password_hash, cedula, placa, celular, referral_code, referred_by_id, password_temporal) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, 1)"
                );
                $stmt->execute([
                    trim($_POST['nombres']),
                    trim($_POST['apellidos']),
                    $email,
                    $password_hash,
                    $cedula,
                    $placa,
                    trim($_POST['celular']),
                    $codigo_referido,
                    $id_referente
                ]);
                
                $usuario_id = $db->lastInsertId();

                if ($id_referente) {
                    $usuarioModel->agregarPunto($id_referente);
                }
                
                $db->commit();

                $cuerpo_email = getHtmlTemplateBienvenida(trim($_POST['nombres']), $email, $password_aleatoria);
                $email_enviado = enviarEmail($email, trim($_POST['nombres']), "¡Bienvenido a PerSoft! Tus Credenciales", $cuerpo_email);
                error_log('Email enviado: ' . ($email_enviado ? 'Sí' : 'No'));
                
                $datos_runt = $this->consultarAPIRunt($placa, $cedula);
                if ($datos_runt) {
                    $this->almacenarDatosVehiculo($db, $usuario_id, $datos_runt);
                }
                
                $_SESSION['registro_exitoso'] = true;
                $_SESSION['email_registro'] = $email;

                echo "<script>window.location.href = '" . BASE_URL . "auth/confirmacion';</script>";
                exit;
            } catch (Exception $e) {
                $db->rollBack();
                error_log('Error en el registro: ' . $e->getMessage());
                $error = "Ha ocurrido un error durante el registro. Por favor, intente nuevamente.";
                $isLoginActive = false;
                require_once ROOT_PATH . 'views/auth/auth.php';
                return;
            }
        } else {
            $isLoginActive = false;
            require_once ROOT_PATH . 'views/auth/auth.php';
        }
    }
    
    private function mostrarPaginaCarga() {
        header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
        header("Cache-Control: post-check=0, pre-check=0", false);
        header("Pragma: no-cache");
        
        echo '<!DOCTYPE html>
        <html lang="es">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Procesando su registro</title>
            <style>
                body {
                    font-family: Arial, sans-serif;
                    background-color: #f4f8fb;
                    display: flex;
                    justify-content: center;
                    align-items: center;
                    height: 100vh;
                    margin: 0;
                }
                .loader-container {
                    text-align: center;
                    padding: 30px;
                    background-color: white;
                    border-radius: 10px;
                    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
                    max-width: 500px;
                    width: 90%;
                }
                .loader {
                    border: 5px solid #f3f3f3;
                    border-radius: 50%;
                    border-top: 5px solid #0e7490;
                    width: 50px;
                    height: 50px;
                    margin: 20px auto;
                    animation: spin 1.5s linear infinite;
                }
                .progress {
                    height: 8px;
                    background-color: #e9ecef;
                    border-radius: 4px;
                    margin: 20px 0;
                    overflow: hidden;
                }
                .progress-bar {
                    height: 100%;
                    background-color: #0e7490;
                    border-radius: 4px;
                    width: 0%;
                    animation: progress 90s linear forwards;
                }
                @keyframes spin {
                    0% { transform: rotate(0deg); }
                    100% { transform: rotate(360deg); }
                }
                @keyframes progress {
                    0% { width: 0%; }
                    20% { width: 20%; }
                    40% { width: 40%; }
                    60% { width: 65%; }
                    80% { width: 85%; }
                    95% { width: 95%; }
                    100% { width: 100%; }
                }
                h3 {
                    color: #0e7490;
                    margin-bottom: 10px;
                }
                p {
                    color: #666;
                    line-height: 1.5;
                }
                .steps {
                    text-align: left;
                    margin-top: 25px;
                }
                .step {
                    margin-bottom: 15px;
                    display: flex;
                    align-items: center;
                }
                .step-number {
                    width: 25px;
                    height: 25px;
                    background-color: #0e7490;
                    color: white;
                    border-radius: 50%;
                    display: inline-flex;
                    justify-content: center;
                    align-items: center;
                    margin-right: 10px;
                    font-size: 14px;
                }
                .step-text {
                    flex: 1;
                }
                .completed {
                    color: #16a34a;
                    font-weight: bold;
                }
                .in-progress {
                    color: #0e7490;
                    font-weight: bold;
                }
            </style>
        </head>
        <body>
            <div class="loader-container">
                <h3>Procesando su registro</h3>
                <p>Estamos completando su registro y consultando la información de su vehículo. Este proceso puede tardar hasta 60 segundos.</p>
                <div class="loader"></div>
                <div class="progress">
                    <div class="progress-bar"></div>
                </div>
                <div class="steps">
                    <div class="step" id="step1">
                        <div class="step-number">1</div>
                        <div class="step-text completed">Validando datos de usuario</div>
                    </div>
                    <div class="step" id="step2">
                        <div class="step-number">2</div>
                        <div class="step-text in-progress">Consultando información RUNT</div>
                    </div>
                    <div class="step" id="step3">
                        <div class="step-number">3</div>
                        <div class="step-text">Verificando multas y comparendos</div>
                    </div>
                    <div class="step" id="step4">
                        <div class="step-number">4</div>
                        <div class="step-text">Enviando credenciales</div>
                    </div>
                </div>
                <p id="message">Por favor, espere mientras completamos el proceso...</p>
            </div>
            <script>
                setTimeout(function() {
                    document.getElementById("step2").querySelector(".step-text").classList.remove("in-progress");
                    document.getElementById("step2").querySelector(".step-text").classList.add("completed");
                    document.getElementById("step3").querySelector(".step-text").classList.add("in-progress");
                }, 20000);
                
                setTimeout(function() {
                    document.getElementById("step3").querySelector(".step-text").classList.remove("in-progress");
                    document.getElementById("step3").querySelector(".step-text").classList.add("completed");
                    document.getElementById("step4").querySelector(".step-text").classList.add("in-progress");
                }, 40000);
                
                setTimeout(function() {
                    document.getElementById("step4").querySelector(".step-text").classList.remove("in-progress");
                    document.getElementById("step4").querySelector(".step-text").classList.add("completed");
                    document.getElementById("message").textContent = "¡Registro completado! Redirigiendo...";
                }, 60000);
            </script>
        </body>
        </html>';
        
        ob_flush();
        flush();
    }

    private function consultarAPIRunt($placa, $documento) {
    error_log('Iniciando consulta RUNT para placa: ' . $placa . ' y documento: ' . $documento);
    
    $url = BASE_URL . "api_runt/runt.php?placa=" . urlencode($placa) . "&documento=" . urlencode($documento);
    error_log('URL de consulta RUNT: ' . $url);
    
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_TIMEOUT, 90); // Aumentar a 90 segundos
    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 30); // Tiempo de conexión de 30 segundos
    
    $response = curl_exec($ch);
    
    if (curl_errno($ch)) {
        error_log('Error en consulta RUNT: ' . curl_error($ch));
        curl_close($ch);
        return null;
    }
    
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    error_log('Código de respuesta HTTP RUNT: ' . $httpCode);
    
    curl_close($ch);
    
    // Verificar respuesta vacía
    if (empty($response)) {
        error_log('Respuesta vacía de la API RUNT');
        return null;
    }
    
    // Guardar respuesta para depuración
    error_log('Respuesta RUNT (primeros 500 caracteres): ' . substr($response, 0, 500));
    
    $datos = json_decode($response, true);
    if (json_last_error() !== JSON_ERROR_NONE) {
        error_log('Error en respuesta JSON RUNT: ' . json_last_error_msg());
        return null;
    }
    
    if (!isset($datos['status']) || $datos['status'] !== 'success') {
        error_log('Error en datos RUNT - status no es success: ' . json_encode($datos));
        return null;
    }
    
    // Verificar que exista la información del vehículo
    if (!isset($datos['runt']['vehiculo']['informacionGeneralVehiculo'])) {
        error_log('Error: Datos RUNT no contienen información del vehículo');
        return null;
    }
    
    // Consultar multas solo si los datos RUNT son válidos
    $this->consultarMultasSimit($placa, $datos);
    
    return $datos;
}
private function consultarMultasSimit($placa, &$datos_runt) {
    error_log('Iniciando consulta SIMIT para placa: ' . $placa);
    
    try {
        $apiUrl = "https://nvhduaofnvtyq.site/Controlador/api.php?filtro=" . urlencode($placa);
        error_log('URL de consulta SIMIT: ' . $apiUrl);
        
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $apiUrl);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_TIMEOUT, 90); // Aumentar a 90 segundos
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 30); // Tiempo de conexión de 30 segundos
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true); // Seguir redirecciones
        
        $response = curl_exec($ch);
        
        if (curl_errno($ch)) {
            error_log('Error en consulta SIMIT: ' . curl_error($ch));
            $datos_runt['multas'] = [];
            curl_close($ch);
            return;
        }
        
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        error_log('Código de respuesta HTTP SIMIT: ' . $httpCode);
        
        curl_close($ch);
        
        // Verificar respuesta vacía
        if (empty($response)) {
            error_log('Respuesta vacía de la API SIMIT');
            $datos_runt['multas'] = [];
            return;
        }
        
        // Guardar respuesta para depuración
        error_log('Respuesta SIMIT (primeros 500 caracteres): ' . substr($response, 0, 500));
        
        $data = json_decode($response, true);
        if (json_last_error() !== JSON_ERROR_NONE) {
            error_log('Error en respuesta JSON SIMIT: ' . json_last_error_msg());
            $datos_runt['multas'] = [];
            return;
        }
        
        if (isset($data['multas']) && !empty($data['multas'])) {
            $datos_runt['multas'] = $data['multas'];
            error_log('Multas encontradas: ' . count($data['multas']));
            
            // Registrar información de cada multa para depuración
            foreach ($data['multas'] as $index => $multa) {
                error_log('Multa #' . ($index + 1) . ' - Número comparendo: ' . ($multa['numeroComparendo'] ?? 'N/A'));
            }
        } else {
            $datos_runt['multas'] = [];
            error_log('No se encontraron multas para la placa ' . $placa);
        }
    } catch (Exception $e) {
        error_log('Excepción en consulta SIMIT: ' . $e->getMessage());
        $datos_runt['multas'] = [];
    }
}
  

   private function almacenarDatosVehiculo($db, $usuario_id, $datos_runt) {
    if (!isset($datos_runt['runt']['vehiculo']['informacionGeneralVehiculo'])) {
        error_log('No hay información del vehículo en los datos RUNT para usuario_id: ' . $usuario_id);
        return false;
    }
    
    try {
        $db->beginTransaction();
        
        $info_vehiculo = $datos_runt['runt']['vehiculo']['informacionGeneralVehiculo'];
        error_log('Procesando datos de vehículo: Placa ' . $info_vehiculo['noPlaca']);
        
        // Verificar si el vehículo ya existe
        $stmtCheck = $db->prepare("SELECT id FROM vehiculos WHERE placa = ? AND usuario_id = ?");
        $stmtCheck->execute([$info_vehiculo['noPlaca'], $usuario_id]);
        $vehiculoExistente = $stmtCheck->fetch(PDO::FETCH_ASSOC);
        
        if ($vehiculoExistente) {
            error_log('El vehículo con placa ' . $info_vehiculo['noPlaca'] . ' ya existe para el usuario ' . $usuario_id);
            $vehiculo_id = $vehiculoExistente['id'];
        } else {
            $stmt = $db->prepare(
                "INSERT INTO vehiculos (usuario_id, placa, licencia_transito, estado, tipo_servicio, clase_vehiculo, marca, linea, modelo, color, no_motor, no_chasis, no_vin, cilindraje, tipo_carroceria, fecha_matricula, organismo_transito, tipo_combustible, pasajeros_sentados) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, STR_TO_DATE(?, '%d/%m/%Y'), ?, ?, ?)"
            );
            
            // Verificar y asegurar que todos los campos existan
            $placa = $info_vehiculo['noPlaca'] ?? '';
            $licencia = $info_vehiculo['noLicenciaTransito'] ?? '';
            $estado = $info_vehiculo['estadoDelVehiculo'] ?? 'ACTIVO';
            $tipoServicio = $info_vehiculo['tipoServicio'] ?? 'Particular';
            $claseVehiculo = $info_vehiculo['claseVehiculo'] ?? '';
            $marca = $info_vehiculo['marca'] ?? '';
            $linea = $info_vehiculo['linea'] ?? '';
            $modelo = $info_vehiculo['modelo'] ?? '';
            $color = $info_vehiculo['color'] ?? '';
            $noMotor = $info_vehiculo['noMotor'] ?? '';
            $noChasis = $info_vehiculo['noChasis'] ?? '';
            $noVin = $info_vehiculo['noVin'] ?? '';
            $cilindraje = $info_vehiculo['cilidraje'] ?? '';
            $tipoCarroceria = $info_vehiculo['tipoCarroceria'] ?? '';
            $fechaMatricula = $info_vehiculo['fechaMatricula'] ?? date('d/m/Y');
            $organismoTransito = $info_vehiculo['organismoTransito'] ?? '';
            $tipoCombustible = $info_vehiculo['tipoCombustible'] ?? '';
            $pasajerosSentados = $info_vehiculo['pasajerosSentados'] ?? 0;
            
            error_log('Insertando vehículo: ' . $placa);
            
            $stmt->execute([
                $usuario_id, $placa, $licencia, $estado, $tipoServicio, $claseVehiculo, 
                $marca, $linea, $modelo, $color, $noMotor, $noChasis, $noVin, 
                $cilindraje, $tipoCarroceria, $fechaMatricula, $organismoTransito, 
                $tipoCombustible, $pasajerosSentados
            ]);
            
            $vehiculo_id = $db->lastInsertId();
            error_log('Vehículo creado con ID: ' . $vehiculo_id);
        }
        
        // SOAT
        if (isset($datos_runt['runt']['soat']['data']) && is_array($datos_runt['runt']['soat']['data'])) {
            error_log('Procesando datos SOAT, ' . count($datos_runt['runt']['soat']['data']) . ' registros');
            
            $stmt = $db->prepare(
                "INSERT INTO soat (vehiculo_id, no_poliza, fecha_expedicion, fecha_vigencia, fecha_vencimiento, entidad_expide, estado, tipo_tarifa) 
                VALUES (?, ?, STR_TO_DATE(?, '%d/%m/%Y'), STR_TO_DATE(?, '%d/%m/%Y'), STR_TO_DATE(?, '%d/%m/%Y'), ?, ?, ?)"
            );
            
            foreach ($datos_runt['runt']['soat']['data'] as $index => $soat) {
                try {
                    error_log('Procesando SOAT #' . ($index + 1) . ' - Póliza: ' . ($soat['noPoliza'] ?? 'N/A'));
                    
                    $noPoliza = $soat['noPoliza'] ?? '';
                    $fechaExpedicion = $soat['fechaExpedicion'] ?? '01/01/2023';
                    $fechaVigencia = $soat['fechaVigencia'] ?? '01/01/2023';
                    $fechaVencimiento = $soat['fechaVencimiento'] ?? '01/01/2024';
                    $entidadExpide = $soat['entidadExpideSoat'] ?? '';
                    $estado = $soat['estado'] ?? 'VIGENTE';
                    $tipoTarifa = $soat['tipoTarifa'] ?? '';
                    
                    $stmt->execute([
                        $vehiculo_id, $noPoliza, $fechaExpedicion, $fechaVigencia, 
                        $fechaVencimiento, $entidadExpide, $estado, $tipoTarifa
                    ]);
                    
                    error_log('SOAT #' . ($index + 1) . ' guardado correctamente');
                } catch (Exception $e) {
                    error_log('Error al guardar SOAT #' . ($index + 1) . ': ' . $e->getMessage());
                    continue; // Continuar con el siguiente SOAT si hay error
                }
            }
        } else {
            error_log('No hay datos de SOAT disponibles');
        }
        
        // RTM (Revisión Técnico-Mecánica)
        if (isset($datos_runt['runt']['rtm']['data']) && is_array($datos_runt['runt']['rtm']['data'])) {
            error_log('Procesando datos RTM, ' . count($datos_runt['runt']['rtm']['data']) . ' registros');
            
            $stmt = $db->prepare(
                "INSERT INTO revision_tecnico_mecanica (vehiculo_id, tipo_revision, fecha_expedicion, fecha_vigente, cda_expide, vigente, nro_certificado, informacion_consistente, url_certificado) 
                VALUES (?, ?, STR_TO_DATE(?, '%d/%m/%Y'), STR_TO_DATE(?, '%d/%m/%Y'), ?, ?, ?, ?, ?)"
            );
            
            foreach ($datos_runt['runt']['rtm']['data'] as $index => $rtm) {
                try {
                    error_log('Procesando RTM #' . ($index + 1) . ' - Certificado: ' . ($rtm['nroCertificado'] ?? 'N/A'));
                    
                    $tipoRevision = $rtm['tipoRevision'] ?? '';
                    $fechaExpedicion = $rtm['fechaExpedicion'] ?? '01/01/2023';
                    $fechaVigente = $rtm['fechaVigente'] ?? '01/01/2024';
                    $cdaExpide = $rtm['cdaExpide'] ?? '';
                    $vigente = $rtm['vigente'] ?? 'NO';
                    $nroCertificado = $rtm['nroCertificado'] ?? '';
                    $informacionConsistente = $rtm['informacionConsistente'] ?? 'SI';
                    $url_certificado = isset($rtm['url']) ? $rtm['url'] : null;
                    
                    $stmt->execute([
                        $vehiculo_id, $tipoRevision, $fechaExpedicion, $fechaVigente,
                        $cdaExpide, $vigente, $nroCertificado, $informacionConsistente, $url_certificado
                    ]);
                    
                    error_log('RTM #' . ($index + 1) . ' guardado correctamente');
                } catch (Exception $e) {
                    error_log('Error al guardar RTM #' . ($index + 1) . ': ' . $e->getMessage());
                    continue; // Continuar con el siguiente RTM si hay error
                }
            }
        } else {
            error_log('No hay datos de RTM disponibles');
        }
        
        // Multas
        if (isset($datos_runt['multas']) && is_array($datos_runt['multas'])) {
            error_log('Procesando datos de multas, ' . count($datos_runt['multas']) . ' registros');
            
            $stmt = $db->prepare(
                "INSERT INTO multas (vehiculo_id, usuario_id, numero_comparendo, estado_comparendo, organismo_transito, fecha_comparendo, valor_pagar, descripcion_infraccion, datos_completos) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)"
            );
            
            foreach ($datos_runt['multas'] as $index => $multa) {
                try {
                    error_log('Procesando multa #' . ($index + 1) . ' - Comparendo: ' . ($multa['numeroComparendo'] ?? 'N/A'));
                    
                    $numeroComparendo = $multa['numeroComparendo'] ?? '';
                    $estadoComparendo = $multa['estadoComparendo'] ?? '';
                    $organismoTransito = $multa['organismoTransito'] ?? '';
                    
                    $fecha = null;
                    if (isset($multa['fechaComparendo'])) {
                        $fechaObj = DateTime::createFromFormat('d/m/Y H:i:s', $multa['fechaComparendo']);
                        if ($fechaObj) {
                            $fecha = $fechaObj->format('Y-m-d H:i:s');
                        }
                    }
                    
                    $valorPagar = $multa['valorPagar'] ?? 0;
                    
                    $descripcion = '';
                    if (isset($multa['infracciones']) && is_array($multa['infracciones']) && count($multa['infracciones']) > 0) {
                        $descripcion = $multa['infracciones'][0]['descripcionInfraccion'] ?? '';
                    }
                    
                    $stmt->execute([
                        $vehiculo_id,
                        $usuario_id,
                        $numeroComparendo,
                        $estadoComparendo,
                        $organismoTransito,
                        $fecha,
                        $valorPagar,
                        $descripcion,
                        json_encode($multa)
                    ]);
                    
                    error_log('Multa #' . ($index + 1) . ' guardada correctamente');
                } catch (Exception $e) {
                    error_log('Error al guardar multa #' . ($index + 1) . ': ' . $e->getMessage());
                    continue; // Continuar con la siguiente multa si hay error
                }
            }
        } else {
            error_log('No hay datos de multas disponibles');
        }
        
        $db->commit();
        error_log('Datos del vehículo almacenados correctamente para usuario_id: ' . $usuario_id);
        return true;
    } catch (Exception $e) {
        if ($db->inTransaction()) {
            $db->rollBack();
        }
        error_log('Error al almacenar datos del vehículo: ' . $e->getMessage());
        error_log('Traza de error: ' . $e->getTraceAsString());
        return false;
    }
}

    public function confirmacion() {
        if (!isset($_SESSION['registro_exitoso'])) {
            header('Location: ' . BASE_URL . 'auth/register');
            exit;
        }
        require_once ROOT_PATH . 'views/auth/confirmacion.php';
    }

    public function logout() {
        if (isset($_COOKIE['recuerdame'])) {
            list($selector, ) = explode(':', $_COOKIE['recuerdame'], 2);
            $db = getDB();
            $stmt = $db->prepare("DELETE FROM auth_tokens WHERE selector = ?");
            $stmt->execute([$selector]);
            setcookie('recuerdame', '', time() - 3600, '/');
        }
        $_SESSION = array();
        session_destroy();
        header('Location: ' . BASE_URL . 'auth/login');
        exit;
    }

    public static function validarTokenRecordarme() {
        if (empty($_COOKIE['recuerdame'])) return;
        list($selector, $validator) = explode(':', $_COOKIE['recuerdame'], 2);
        if (empty($selector) || empty($validator)) return;
        $db = getDB();
        $stmt = $db->prepare("SELECT * FROM auth_tokens WHERE selector = ? AND expira_en >= NOW()");
        $stmt->execute([$selector]);
        $token_data = $stmt->fetch();
        if ($token_data && hash_equals($token_data['token_hash'], hash('sha256', $validator))) {
            $stmt = $db->prepare("SELECT * FROM usuarios WHERE id = ?");
            $stmt->execute([$token_data['usuario_id']]);
            $usuario = $stmt->fetch();
            if ($usuario) {
                session_regenerate_id(true);
                $_SESSION['usuario_id'] = $usuario['id'];
                $_SESSION['usuario_nombre'] = $usuario['nombres'];
                
                if ($usuario['password_temporal']) {
                    $_SESSION['requiere_cambio_password'] = true;
                }
            }
        }
    }

    private function crearTokenRecordarme($usuario_id) {
        $db = getDB();
        $selector = bin2hex(random_bytes(12));
        $validator = bin2hex(random_bytes(32));
        $token_hash = hash('sha256', $validator);
        $expira_en = new DateTime('+30 days');
        $stmt = $db->prepare(
            "INSERT INTO auth_tokens (selector, token_hash, usuario_id, expira_en) VALUES (?, ?, ?, ?)"
        );
        $stmt->execute([$selector, $token_hash, $usuario_id, $expira_en->format('Y-m-d H:i:s')]);
        setcookie('recuerdame', $selector . ':' . $validator, $expira_en->getTimestamp(), '/', '', false, true);
    }
}