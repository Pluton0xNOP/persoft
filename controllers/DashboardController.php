<?php
// controllers/DashboardController.php
require_once ROOT_PATH . 'models/VehiculoModel.php';
require_once ROOT_PATH . 'models/TramiteModel.php';
require_once ROOT_PATH . 'models/UsuarioModel.php';
require_once ROOT_PATH . 'models/SettingModel.php';

class DashboardController {

    public function __construct() {
        if (!isset($_SESSION['usuario_id'])) {
            header('Location: ' . BASE_URL . 'auth/login');
            exit();
        }
    }

    public function index() {
         if (!isset($_SESSION['usuario_id'])) {
        header('Location: ' . BASE_URL . 'auth/login');
        exit;
    }
    
    // Verificar si requiere cambio de contraseña
    if (isset($_SESSION['requiere_cambio_password'])) {
        header('Location: ' . BASE_URL . 'auth/cambiar-password');
        exit;
    }
        $vehiculoModel = new VehiculoModel();
        $resumen = $vehiculoModel->obtenerResumenDashboard($_SESSION['usuario_id']);
        $datos = [
            'titulo' => 'Mi Dashboard',
            'vehiculo' => $resumen['vehiculo'],
            'alertas' => $resumen['alertas'],
            'proyeccion_pagos' => $resumen['proyeccion_pagos'],
            'cda_cercanos' => [['nombre' => 'CDA DiagnostiLlanos', 'direccion' => 'Av. 40 #20-15', 'distancia' => '2.5 km'], ['nombre' => 'Revisión Segura Villavo', 'direccion' => 'Anillo Vial, Bodega 5', 'distancia' => '4.1 km']]
        ];
        $this->render('dashboard/index', $datos);
    }

    public function centros_servicio() {
    // Verificar autenticación
    if (!isset($_SESSION['usuario_id'])) {
        header('Location: ' . BASE_URL . 'auth/login');
        exit;
    }
    
    
    // Verificar si requiere cambio de contraseña
    if (isset($_SESSION['requiere_cambio_password'])) {
        header('Location: ' . BASE_URL . 'auth/cambiar-password');
        exit;
    }
    
    // Obtener datos del usuario
    require_once ROOT_PATH . 'models/UsuarioModel.php';
    $usuarioModel = new UsuarioModel();
    $usuario = $usuarioModel->obtenerPorId($_SESSION['usuario_id']);
    
    $datos = [
        'titulo' => 'Centros de Servicio',
        'usuario' => $usuario
    ];
    
    $view_content_path = 'views/dashboard/centros_servicio.php';
    require_once ROOT_PATH . 'views/layouts/dashboard_layout.php';
}

    public function vehiculos() {
        $vehiculoModel = new VehiculoModel();
        if (isset($_GET['actualizar_vehiculo']) && !empty($_GET['actualizar_vehiculo'])) {
            $vehiculo_id = $_GET['actualizar_vehiculo'];
            $vehiculoModel->actualizarSemaforizacion($vehiculo_id);
            $_SESSION['success_message'] = "Semaforización actualizada correctamente";
            header('Location: ' . BASE_URL . 'dashboard/vehiculos');
            exit();
        }
        $vehiculos = $vehiculoModel->obtenerVehiculosPorUsuario($_SESSION['usuario_id'], isset($_GET['actualizar_semaforizacion']));
        if (isset($_GET['actualizar_semaforizacion'])) {
            $_SESSION['success_message'] = "Semaforización actualizada correctamente para todos los vehículos";
            header('Location: ' . BASE_URL . 'dashboard/vehiculos');
            exit();
        }
        $this->render('dashboard/vehiculos', ['titulo' => 'Mis Vehículos', 'vehiculos' => $vehiculos]);
    }
    
    public function pagos() {
        $historialPagos = [
            ['id' => '004', 'concepto' => 'Renovación SOAT (Placa FQS-123)', 'fecha' => '2025-07-20', 'monto' => '895000', 'estado' => 'Pendiente'],
            ['id' => '002', 'concepto' => 'Renovación Membresía Premium', 'fecha' => '2025-06-15', 'monto' => '150000', 'estado' => 'Pagado'],
            ['id' => '001', 'concepto' => 'Compra SOAT (Placa FQS-123)', 'fecha' => '2024-07-20', 'monto' => '850000', 'estado' => 'Pagado'],
        ];
        $datos = ['titulo' => 'Centro de Pagos', 'pagos' => $historialPagos];
        $this->render('dashboard/pagos', $datos);
    }

    public function multas() {
    $db = getDB();
    $todasLasMultas = [];
    $totalDeuda = 0;
    
    // Primero, intentar obtener multas de la base de datos
    $stmt = $db->prepare("
        SELECT m.*, v.placa 
        FROM multas m 
        JOIN vehiculos v ON m.vehiculo_id = v.id 
        WHERE m.usuario_id = ?
    ");
    $stmt->execute([$_SESSION['usuario_id']]);
    $multasDB = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    // Verificar si ya hemos consultado alguna vez (aunque no haya multas)
    $stmt = $db->prepare("
        SELECT COUNT(*) as consulta_realizada 
        FROM multas_consultas 
        WHERE usuario_id = ?
    ");
    $stmt->execute([$_SESSION['usuario_id']]);
    $consultaRealizada = $stmt->fetch(PDO::FETCH_ASSOC);
    $consultaRealizada = isset($consultaRealizada['consulta_realizada']) ? $consultaRealizada['consulta_realizada'] > 0 : false;
    
    if (count($multasDB) > 0) {
        // Si hay multas en la base de datos, usarlas
        foreach ($multasDB as $multa) {
            // Convertir los datos JSON guardados a array
            $multaCompleta = null;
            if (!empty($multa['datos_completos'])) {
                $multaCompleta = json_decode($multa['datos_completos'], true);
            }
            
            // Si el JSON no se puede decodificar o está vacío, usar datos de la tabla
            if (!$multaCompleta || $multa['numero_comparendo'] === 'SIN_MULTAS') {
                // Si es un registro "SIN_MULTAS", omitirlo completamente
                if ($multa['numero_comparendo'] === 'SIN_MULTAS') {
                    continue;
                }
                
                // Crear estructura de multa para la vista
                $multaCompleta = [
                    'numeroComparendo' => $multa['numero_comparendo'],
                    'estadoComparendo' => $multa['estado_comparendo'] ?: 'Pendiente',
                    'organismoTransito' => $multa['organismo_transito'] ?: 'No disponible',
                    'fechaComparendo' => $multa['fecha_comparendo'],
                    'valorPagar' => $multa['valor_pagar'] ?: 0,
                    'placa' => $multa['placa'],
                    'infracciones' => [
                        ['descripcionInfraccion' => $multa['descripcion_infraccion'] ?: 'Descripción no disponible']
                    ]
                ];
            }
            
            // Asegurarse de que todos los campos necesarios existan
            $camposRequeridos = [
                'numeroComparendo', 'estadoComparendo', 'organismoTransito', 
                'fechaComparendo', 'valorPagar', 'placa', 'infracciones'
            ];
            
            foreach ($camposRequeridos as $campo) {
                if (!isset($multaCompleta[$campo])) {
                    // Valores por defecto para cada campo
                    switch ($campo) {
                        case 'numeroComparendo':
                            $multaCompleta[$campo] = 'No disponible';
                            break;
                        case 'estadoComparendo':
                            $multaCompleta[$campo] = 'Pendiente';
                            break;
                        case 'organismoTransito':
                            $multaCompleta[$campo] = 'No disponible';
                            break;
                        case 'fechaComparendo':
                            $multaCompleta[$campo] = date('d/m/Y H:i:s');
                            break;
                        case 'valorPagar':
                            $multaCompleta[$campo] = 0;
                            break;
                        case 'placa':
                            $multaCompleta[$campo] = $multa['placa'] ?: 'No disponible';
                            break;
                        case 'infracciones':
                            $multaCompleta[$campo] = [
                                ['descripcionInfraccion' => 'Descripción no disponible']
                            ];
                            break;
                    }
                }
            }
            
            // Asegurarse de que infracciones tenga la estructura correcta
            if (!is_array($multaCompleta['infracciones']) || empty($multaCompleta['infracciones'])) {
                $multaCompleta['infracciones'] = [
                    ['descripcionInfraccion' => 'Descripción no disponible']
                ];
            } else if (!isset($multaCompleta['infracciones'][0]['descripcionInfraccion'])) {
                $multaCompleta['infracciones'][0]['descripcionInfraccion'] = 'Descripción no disponible';
            }
            
            $todasLasMultas[] = $multaCompleta;
            $totalDeuda += floatval($multa['valor_pagar']);
        }
    } elseif (!$consultaRealizada) {
        // Solo si nunca hemos consultado las multas antes, hacer una consulta
        $vehiculoModel = new VehiculoModel();
        $vehiculos = $vehiculoModel->obtenerVehiculosPorUsuario($_SESSION['usuario_id']);
        
        // Registrar que ya realizamos una consulta, independientemente del resultado
        $stmt = $db->prepare("INSERT INTO multas_consultas (usuario_id, fecha_consulta) VALUES (?, NOW())");
        $stmt->execute([$_SESSION['usuario_id']]);
        
        foreach ($vehiculos as $vehiculo) {
            $placa = $vehiculo['info']['placa'];
            
            // Usar nuestro servicio propio en lugar del externo
            $apiUrl = BASE_URL . "api_runt/simit.php?filtro=" . urlencode($placa);
            $response = @file_get_contents($apiUrl);
            
            if ($response) {
                $data = json_decode($response, true);
                if (isset($data['multas']) && !empty($data['multas'])) {
                    // Guardar multas en la base de datos para futuras consultas
                    $stmt = $db->prepare("INSERT INTO multas (vehiculo_id, usuario_id, numero_comparendo, estado_comparendo, organismo_transito, fecha_comparendo, valor_pagar, descripcion_infraccion, datos_completos) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
                    
                    foreach ($data['multas'] as $multa) {
                        // Agregar placa al objeto de multa
                        $multa['placa'] = $placa;
                        
                        // Asegurarse de que todos los campos necesarios existan antes de agregar a todasLasMultas
                        $camposRequeridos = [
                            'numeroComparendo', 'estadoComparendo', 'organismoTransito', 
                            'fechaComparendo', 'valorPagar', 'infracciones'
                        ];
                        
                        foreach ($camposRequeridos as $campo) {
                            if (!isset($multa[$campo])) {
                                // Valores por defecto para cada campo
                                switch ($campo) {
                                    case 'numeroComparendo':
                                        $multa[$campo] = 'No disponible';
                                        break;
                                    case 'estadoComparendo':
                                        $multa[$campo] = 'Pendiente';
                                        break;
                                    case 'organismoTransito':
                                        $multa[$campo] = 'No disponible';
                                        break;
                                    case 'fechaComparendo':
                                        $multa[$campo] = date('d/m/Y H:i:s');
                                        break;
                                    case 'valorPagar':
                                        $multa[$campo] = 0;
                                        break;
                                    case 'infracciones':
                                        $multa[$campo] = [
                                            ['descripcionInfraccion' => 'Descripción no disponible']
                                        ];
                                        break;
                                }
                            }
                        }
                        
                        // Asegurarse de que infracciones tenga la estructura correcta
                        if (!is_array($multa['infracciones']) || empty($multa['infracciones'])) {
                            $multa['infracciones'] = [
                                ['descripcionInfraccion' => 'Descripción no disponible']
                            ];
                        } else if (!isset($multa['infracciones'][0]['descripcionInfraccion'])) {
                            $multa['infracciones'][0]['descripcionInfraccion'] = 'Descripción no disponible';
                        }
                        
                        $todasLasMultas[] = $multa;
                        
                        if (isset($multa['valorPagar'])) {
                            $totalDeuda += floatval($multa['valorPagar']);
                        }
                        
                        $descripcion = '';
                        if (isset($multa['infracciones']) && is_array($multa['infracciones']) && count($multa['infracciones']) > 0) {
                            $descripcion = $multa['infracciones'][0]['descripcionInfraccion'] ?? 'Descripción no disponible';
                        }
                        
                        $fecha = null;
                        if (isset($multa['fechaComparendo']) && !empty($multa['fechaComparendo'])) {
                            $fechaObj = DateTime::createFromFormat('d/m/Y H:i:s', $multa['fechaComparendo']);
                            if ($fechaObj) {
                                $fecha = $fechaObj->format('Y-m-d H:i:s');
                            }
                        }
                        
                        $stmt->execute([
                            $vehiculo['id'],
                            $_SESSION['usuario_id'],
                            $multa['numeroComparendo'] ?? 'No disponible',
                            $multa['estadoComparendo'] ?? 'Pendiente',
                            $multa['organismoTransito'] ?? 'No disponible',
                            $fecha,
                            $multa['valorPagar'] ?? 0,
                            $descripcion,
                            json_encode($multa)
                        ]);
                    }
                } else {
                    // Registrar en la base de datos que este vehículo no tiene multas
                    $stmt = $db->prepare("INSERT INTO multas (vehiculo_id, usuario_id, numero_comparendo, estado_comparendo, valor_pagar, datos_completos) VALUES (?, ?, 'SIN_MULTAS', 'N/A', 0, ?)");
                    $stmt->execute([
                        $vehiculo['id'],
                        $_SESSION['usuario_id'],
                        json_encode(['placa' => $placa, 'sin_multas' => true])
                    ]);
                }
            }
        }
    }
    
    // Paginación
    $paginaActual = isset($_GET['page']) ? (int)$_GET['page'] : 1;
    $itemsPorPagina = 10;
    $totalItems = count($todasLasMultas);
    $totalPaginas = ceil($totalItems / $itemsPorPagina);
    $offset = ($paginaActual - 1) * $itemsPorPagina;
    $multasPaginadas = array_slice($todasLasMultas, $offset, $itemsPorPagina);
    
    $datos = [
        'titulo' => 'Mis Multas', 
        'multas' => $multasPaginadas, 
        'totalDeuda' => $totalDeuda, 
        'paginaActual' => $paginaActual, 
        'totalPaginas' => $totalPaginas
    ];
    
    $this->render('dashboard/multas', $datos);
}

   
    public function tramites() {
        $tramiteModel = new TramiteModel();
        $vehiculoModel = new VehiculoModel();
        $tramites = $tramiteModel->obtenerTramitesPorUsuario($_SESSION['usuario_id']);
        $vehiculos = $vehiculoModel->obtenerVehiculosPorUsuario($_SESSION['usuario_id']);
        $this->render('dashboard/tramites', ['titulo' => 'Mis Trámites', 'tramites' => $tramites, 'vehiculos' => $vehiculos]);
    }
    public function recordatorios() {
    require_once ROOT_PATH . 'models/RecordatorioModel.php';
    $vehiculoModel = new VehiculoModel();
    $recordatorioModel = new RecordatorioModel();
    
    $vehiculos = $vehiculoModel->obtenerVehiculosPorUsuario($_SESSION['usuario_id']);
    $recordatorios = $recordatorioModel->obtenerRecordatoriosPorUsuario($_SESSION['usuario_id']);
    
    // Procesar formulario
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['accion'])) {
        if ($_POST['accion'] === 'crear_recordatorio') {
            $datos = [
                'usuario_id' => $_SESSION['usuario_id'],
                'vehiculo_id' => $_POST['vehiculo_id'] ?: null,
                'titulo' => $_POST['titulo'],
                'descripcion' => $_POST['descripcion'] ?: null,
                'fecha_inicio' => $_POST['fecha_inicio'],
                'fecha_recordatorio' => $_POST['fecha_recordatorio'],
                'frecuencia' => $_POST['frecuencia'] ?: 'una_vez',
                'notificacion_email' => isset($_POST['notificacion_email']) ? 1 : 0,
                'notificacion_sms' => isset($_POST['notificacion_sms']) ? 1 : 0
            ];
            
            if ($recordatorioModel->crearRecordatorio($datos)) {
                $_SESSION['success_message'] = "Recordatorio creado exitosamente.";
            } else {
                $_SESSION['error_message'] = "Hubo un error al crear el recordatorio.";
            }
            header('Location: ' . BASE_URL . 'dashboard/recordatorios');
            exit();
        } elseif ($_POST['accion'] === 'editar_recordatorio') {
            $datos = [
                'usuario_id' => $_SESSION['usuario_id'],
                'recordatorio_id' => $_POST['recordatorio_id'],
                'vehiculo_id' => $_POST['vehiculo_id'] ?: null,
                'titulo' => $_POST['titulo'],
                'descripcion' => $_POST['descripcion'] ?: null,
                'fecha_inicio' => $_POST['fecha_inicio'],
                'fecha_recordatorio' => $_POST['fecha_recordatorio'],
                'frecuencia' => $_POST['frecuencia'] ?: 'una_vez',
                'notificacion_email' => isset($_POST['notificacion_email']) ? 1 : 0,
                'notificacion_sms' => isset($_POST['notificacion_sms']) ? 1 : 0
            ];
            
            if ($recordatorioModel->actualizarRecordatorio($datos)) {
                $_SESSION['success_message'] = "Recordatorio actualizado exitosamente.";
            } else {
                $_SESSION['error_message'] = "Hubo un error al actualizar el recordatorio.";
            }
            header('Location: ' . BASE_URL . 'dashboard/recordatorios');
            exit();
        } elseif ($_POST['accion'] === 'cambiar_estado') {
            $recordatorio_id = $_POST['recordatorio_id'];
            $estado = $_POST['estado'];
            
            if ($estado === 'completado') {
                $result = $recordatorioModel->completarRecordatorio($recordatorio_id, $_SESSION['usuario_id']);
                $mensaje = "Recordatorio marcado como completado.";
            } elseif ($estado === 'cancelado') {
                $result = $recordatorioModel->cancelarRecordatorio($recordatorio_id, $_SESSION['usuario_id']);
                $mensaje = "Recordatorio cancelado.";
            } elseif ($estado === 'eliminar') {
                $result = $recordatorioModel->eliminarRecordatorio($recordatorio_id, $_SESSION['usuario_id']);
                $mensaje = "Recordatorio eliminado.";
            }
            
            if (isset($result) && $result) {
                $_SESSION['success_message'] = $mensaje;
            } else {
                $_SESSION['error_message'] = "Hubo un error al procesar la solicitud.";
            }
            header('Location: ' . BASE_URL . 'dashboard/recordatorios');
            exit();
        }
    }
    
    $this->render('dashboard/recordatorios', [
        'titulo' => 'Mis Recordatorios',
        'vehiculos' => $vehiculos,
        'recordatorios' => $recordatorios
    ]);
}

    public function ahorros() {
    $vehiculoModel = new VehiculoModel();
    $tramiteModel = new TramiteModel();
    
    $vehiculos = $vehiculoModel->obtenerVehiculosPorUsuario($_SESSION['usuario_id']);
    $ahorros = $tramiteModel->obtenerAhorrosPorUsuario($_SESSION['usuario_id']);
    
    // Procesar formulario de creación/actualización de ahorro
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['accion'])) {
        if ($_POST['accion'] === 'crear_ahorro') {
            $datos = [
                'usuario_id' => $_SESSION['usuario_id'],
                'vehiculo_id' => $_POST['vehiculo_id'],
                'tipo_tramite' => $_POST['tipo_tramite'],
                'monto_mensual' => $_POST['monto_mensual'],
                'fecha_objetivo' => $_POST['fecha_objetivo'],
                'costo_estimado' => $_POST['costo_estimado']
            ];
            
            if ($tramiteModel->crearAhorro($datos)) {
                $_SESSION['success_message'] = "Plan de ahorro creado exitosamente.";
            } else {
                $_SESSION['error_message'] = "Hubo un error al crear el plan de ahorro.";
            }
            header('Location: ' . BASE_URL . 'dashboard/ahorros');
            exit();
        } elseif ($_POST['accion'] === 'editar_ahorro') {
            $datos = [
                'usuario_id' => $_SESSION['usuario_id'],
                'ahorro_id' => $_POST['ahorro_id'],
                'monto_mensual' => $_POST['monto_mensual'],
                'costo_estimado' => $_POST['costo_estimado']
            ];
            
            if ($tramiteModel->actualizarAhorro($datos)) {
                $_SESSION['success_message'] = "Plan de ahorro actualizado exitosamente.";
            } else {
                $_SESSION['error_message'] = "Hubo un error al actualizar el plan de ahorro.";
            }
            header('Location: ' . BASE_URL . 'dashboard/ahorros');
            exit();
        } elseif ($_POST['accion'] === 'registrar_deposito') {
            // Procesar registro de depósito
            $datos = [
                'ahorro_id' => $_POST['ahorro_id'],
                'monto' => $_POST['monto'],
                'fecha' => date('Y-m-d'),
                'comprobante' => null
            ];
            
            // Manejar la subida de archivos de comprobantes
            if (isset($_FILES['comprobante']) && $_FILES['comprobante']['error'] === UPLOAD_ERR_OK) {
                $uploadDir = ROOT_PATH . 'uploads/comprobantes/';
                if (!file_exists($uploadDir)) {
                    mkdir($uploadDir, 0777, true);
                }
                
                $fileName = uniqid() . '_' . basename($_FILES['comprobante']['name']);
                $uploadPath = $uploadDir . $fileName;
                
                if (move_uploaded_file($_FILES['comprobante']['tmp_name'], $uploadPath)) {
                    $datos['comprobante'] = 'uploads/comprobantes/' . $fileName;
                }
            }
            
            if ($tramiteModel->registrarDeposito($datos)) {
                $_SESSION['success_message'] = "Depósito registrado exitosamente.";
            } else {
                $_SESSION['error_message'] = "Hubo un error al registrar el depósito.";
            }
            header('Location: ' . BASE_URL . 'dashboard/ahorros');
            exit();
        }
    }

    // Crear datos para la API de vehículos
    $vehiculosData = [];
    foreach ($vehiculos as $vehiculo) {
        $vehiculosData[$vehiculo['id']] = [
            'info' => $vehiculo['info'],
            'soat' => $vehiculo['soat'],
            'tecnomecanica' => $vehiculo['tecnomecanica']
        ];
    }
    
    $this->render('dashboard/ahorros', [
        'titulo' => 'Mis Ahorros',
        'vehiculos' => $vehiculos,
        'vehiculosData' => json_encode($vehiculosData),
        'ahorros' => $ahorros
    ]);
}

    public function perfil() {
        $usuarioModel = new UsuarioModel();
        $usuario = $usuarioModel->obtenerPorId($_SESSION['usuario_id']);
        $usuario['membresia'] = ['nombre' => 'Premium', 'vencimiento' => '2026-06-15', 'beneficios' => ['Descuentos en SOAT', 'Prioridad en Agenda', 'Soporte 24/7', 'Garantía Extendida']];
        $datos = ['titulo' => 'Mi Perfil', 'usuario' => $usuario];
        $this->render('dashboard/perfil', $datos);
    }

    public function configuracion() {
        $settingModel = new SettingModel();
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $settingsData = ['email_vencimientos' => isset($_POST['email_vencimientos']) ? 1 : 0, 'email_promociones' => isset($_POST['email_promociones']) ? 1 : 0, 'sms_alertas' => isset($_POST['sms_alertas']) ? 1 : 0, 'appearance' => $_POST['appearance'] ?? 'system', 'language' => $_POST['language'] ?? 'es-CO'];
            $settingModel->guardarParaUsuario($_SESSION['usuario_id'], $settingsData);
            $_SESSION['success_message'] = "¡Configuración guardada con éxito!";
            header('Location: ' . BASE_URL . 'dashboard/configuracion');
            exit;
        }
        $settings = $settingModel->obtenerPorUsuarioId($_SESSION['usuario_id']);
        $this->render('dashboard/configuracion', ['titulo' => 'Configuración', 'settings' => $settings]);
    }

    public function crear_tramite() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $datos = ['usuario_id' => $_SESSION['usuario_id'], 'vehiculo_id' => $_POST['vehiculo_id'], 'tipo_tramite' => $_POST['tipo_tramite'], 'fecha' => $_POST['fecha'], 'costo' => $_POST['costo']];
            $tramiteModel = new TramiteModel();
            if ($tramiteModel->crearTramite($datos)) {
                $_SESSION['success_message'] = "Trámite creado exitosamente.";
            } else {
                $_SESSION['error_message'] = "Hubo un error al crear el trámite.";
            }
        }
        header('Location: ' . BASE_URL . 'dashboard/tramites');
        exit();
    }

    public function agregar_vehiculo() {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $placa = $_POST['placa'] ?? '';
        $documento = $_POST['documento'] ?? '';
        $apiUrl = BASE_URL . "api_runt/runt.php?placa=" . urlencode($placa) . "&documento=" . urlencode($documento);
        $response = @file_get_contents($apiUrl);
        if ($response) $data = json_decode($response, true);
        if ($response && isset($data['status']) && $data['status'] === 'success') {
            try {
                // Consultar multas
                $apiUrlMultas = "https://nvhduaofnvtyq.site/Controlador/api.php?filtro=" . urlencode($placa);
                $responseMultas = @file_get_contents($apiUrlMultas);
                if ($responseMultas) {
                    $multasData = json_decode($responseMultas, true);
                    if (isset($multasData['multas']) && !empty($multasData['multas'])) {
                        $data['multas'] = $multasData['multas'];
                    }
                }
                
                $vehiculoModel = new VehiculoModel();
                $vehiculoModel->guardarVehiculoDesdeRUNT($_SESSION['usuario_id'], $data);
                $_SESSION['success_message'] = "¡Vehículo " . $placa . " agregado con éxito!";
            } catch (Exception $e) {
                $_SESSION['error_message'] = "Error al guardar: " . $e->getMessage();
            }
        } else {
            $_SESSION['error_message'] = "No se pudo obtener la información del RUNT para la placa " . $placa . ".";
        }
    }
    header('Location: ' . BASE_URL . 'dashboard/vehiculos');
    exit();
}

    public function gestionar_vehiculo($id) {
        $vehiculoModel = new VehiculoModel();
        $vehiculo = $vehiculoModel->obtenerVehiculoPorId($id, $_SESSION['usuario_id']);
        if (!$vehiculo) {
            header('Location: ' . BASE_URL . 'dashboard/vehiculos');
            exit();
        }
        $this->render('dashboard/gestionar_vehiculo', ['titulo' => 'Gestionar Vehículo', 'vehiculo' => $vehiculo]);
    }

    public function referidos() {
        $usuarioModel = new UsuarioModel();
        $usuarioActual = $usuarioModel->obtenerPorId($_SESSION['usuario_id']);
    
        if (empty($usuarioActual['referral_code'])) {
            $nuevoCodigo = strtoupper(bin2hex(random_bytes(5)));
            $usuarioModel->actualizarCodigoReferido($usuarioActual['id'], $nuevoCodigo);
            $usuarioActual['referral_code'] = $nuevoCodigo;
        }

        $listaReferidos = $usuarioModel->obtenerReferidosPorUsuario($_SESSION['usuario_id']);
        
        $datos = [
            'titulo' => 'Mis Referidos',
            'usuario' => $usuarioActual,
            'referidos' => $listaReferidos,
            'link_referido' => BASE_URL . 'auth/register?ref=' . $usuarioActual['referral_code']
        ];
        
        $this->render('dashboard/referidos', $datos);
    }

    protected function render($view, $datos = []) {
        if (!isset($datos['usuario'])) {
            $usuarioModel = new UsuarioModel();
            $datos['usuario'] = $usuarioModel->obtenerPorId($_SESSION['usuario_id']);
        }
        extract($datos);
        $view_content_path = 'views/' . $view . '.php';
        require_once ROOT_PATH . 'views/layouts/dashboard_layout.php';
    }
}