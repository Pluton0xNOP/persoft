<?php
require_once ROOT_PATH . 'models/IntermediarioModel.php';
require_once ROOT_PATH . 'models/VentasModel.php';
require_once ROOT_PATH . 'models/CotizacionesModel.php';
require_once ROOT_PATH . 'models/ComisionesModel.php';
require_once ROOT_PATH . 'models/VehiculoModel.php';
require_once ROOT_PATH . 'models/UsuarioModel.php';

class IntermediarioController {
    private $intermediarioModel;
    private $ventasModel;
    private $cotizacionesModel;
    
    public function __construct() {
        if (!isset($_SESSION['usuario_id'])) {
            header('Location: ' . BASE_URL . 'auth/login');
            exit();
        }
        
        $this->intermediarioModel = new IntermediarioModel();
        $this->ventasModel = new VentasModel();
        $this->cotizacionesModel = new CotizacionesModel();
    }
    
    public function index() {
        $usuarioModel = new UsuarioModel();
        $usuario = $usuarioModel->obtenerPorId($_SESSION['usuario_id']);
        
        if ($usuario['tipo_usuario'] !== 'intermediario') {
            $intermediario = $this->intermediarioModel->obtenerPorUsuarioId($_SESSION['usuario_id']);
            
            if (!$intermediario) {
                header('Location: ' . BASE_URL . 'intermediario/registro');
                exit();
            }
        }
        
        $intermediario = $this->intermediarioModel->obtenerPorUsuarioId($_SESSION['usuario_id']);
        $estadisticas = $this->ventasModel->obtenerEstadisticas($intermediario['id']);
        $ventas_recientes = $this->ventasModel->obtenerPorIntermediario($intermediario['id']);
        $cotizaciones = $this->cotizacionesModel->obtenerPorIntermediario($intermediario['id']);
        $transacciones = $this->intermediarioModel->obtenerTransaccionesSaldo($intermediario['id']);
        
        $datos = [
            'titulo' => 'Panel de Intermediario',
            'intermediario' => $intermediario,
            'estadisticas' => $estadisticas,
            'ventas_recientes' => $ventas_recientes,
            'cotizaciones' => $cotizaciones,
            'transacciones' => $transacciones
        ];
        
        $this->render('intermediario/index', $datos);
    }
    
    public function registro() {
        $usuarioModel = new UsuarioModel();
        $usuario = $usuarioModel->obtenerPorId($_SESSION['usuario_id']);
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $datos = [
                'usuario_id' => $_SESSION['usuario_id'],
                'nombre_negocio' => $_POST['nombre_negocio'],
                'direccion' => $_POST['direccion'] ?? null,
                'telefono_negocio' => $_POST['telefono_negocio'] ?? null,
                'tipo_documento' => $_POST['tipo_documento'] ?? 'CC',
                'numero_documento' => $_POST['numero_documento'],
                'cuenta_bancaria' => $_POST['cuenta_bancaria'] ?? null,
                'entidad_bancaria' => $_POST['entidad_bancaria'] ?? null,
                'porcentaje_comision' => 5.00,
                'estado' => 'activo'
            ];
            
            $resultado = $this->intermediarioModel->crearIntermediario($datos);
            
            if ($resultado) {
                $_SESSION['success_message'] = "¡Registro como intermediario completado con éxito!";
                header('Location: ' . BASE_URL . 'intermediario');
                exit();
            } else {
                $_SESSION['error_message'] = "Hubo un error al registrarse como intermediario. Intente nuevamente.";
            }
        }
        
        $datos = [
            'titulo' => 'Registro de Intermediario',
            'usuario' => $usuario
        ];
        
        $this->render('intermediario/registro', $datos);
    }
    
    public function perfil() {
        $intermediario = $this->intermediarioModel->obtenerPorUsuarioId($_SESSION['usuario_id']);
        
        if (!$intermediario) {
            header('Location: ' . BASE_URL . 'intermediario/registro');
            exit();
        }
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $datos = [
                'id' => $intermediario['id'],
                'nombre_negocio' => $_POST['nombre_negocio'],
                'direccion' => $_POST['direccion'] ?? null,
                'telefono_negocio' => $_POST['telefono_negocio'] ?? null,
                'tipo_documento' => $_POST['tipo_documento'] ?? 'CC',
                'numero_documento' => $_POST['numero_documento'],
                'cuenta_bancaria' => $_POST['cuenta_bancaria'] ?? null,
                'entidad_bancaria' => $_POST['entidad_bancaria'] ?? null,
                'porcentaje_comision' => $intermediario['porcentaje_comision'],
                'estado' => $intermediario['estado']
            ];
            
            $resultado = $this->intermediarioModel->actualizarIntermediario($datos);
            
            if ($resultado) {
                $_SESSION['success_message'] = "Perfil actualizado correctamente.";
                header('Location: ' . BASE_URL . 'intermediario/perfil');
                exit();
            } else {
                $_SESSION['error_message'] = "Hubo un error al actualizar el perfil. Intente nuevamente.";
            }
        }
        
        $usuarioModel = new UsuarioModel();
        $usuario = $usuarioModel->obtenerPorId($_SESSION['usuario_id']);
        
        $datos = [
            'titulo' => 'Mi Perfil de Intermediario',
            'intermediario' => $intermediario,
            'usuario' => $usuario
        ];
        
        $this->render('intermediario/perfil', $datos);
    }
    
    public function ventas() {
        $intermediario = $this->intermediarioModel->obtenerPorUsuarioId($_SESSION['usuario_id']);
        
        if (!$intermediario) {
            header('Location: ' . BASE_URL . 'intermediario/registro');
            exit();
        }
        
        $ventas = $this->ventasModel->obtenerPorIntermediario($intermediario['id']);
        
        $datos = [
            'titulo' => 'Mis Ventas',
            'intermediario' => $intermediario,
            'ventas' => $ventas
        ];
        
        $this->render('intermediario/ventas', $datos);
    }
    
    public function nueva_venta() {
        $intermediario = $this->intermediarioModel->obtenerPorUsuarioId($_SESSION['usuario_id']);
        
        if (!$intermediario) {
            header('Location: ' . BASE_URL . 'intermediario/registro');
            exit();
        }
        
        $vehiculoModel = new VehiculoModel();
        $comisionesModel = new ComisionesModel();
        $usuarioModel = new UsuarioModel();
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $vehiculo = null;
            $cliente_id = null;
            
            if (isset($_POST['placa']) && !empty($_POST['placa'])) {
                $vehiculos = $vehiculoModel->obtenerVehiculosPorPlaca($_POST['placa']);
                if (!empty($vehiculos)) {
                    $vehiculo = $vehiculos[0];
                    $cliente = $usuarioModel->obtenerPorId($vehiculo['usuario_id']);
                    $cliente_id = $cliente['id'];
                }
            }
            
            if (!$vehiculo) {
                $_SESSION['error_message'] = "No se pudo encontrar un vehículo con la placa especificada.";
                header('Location: ' . BASE_URL . 'intermediario/nueva_venta');
                exit();
            }
            
            $producto = $_POST['producto'];
            $valor_total = $_POST['valor_total'];
            
            $valor_comision = $comisionesModel->calcularComision($producto, $valor_total, $intermediario['id']);
            
            $datos_venta = [
                'intermediario_id' => $intermediario['id'],
                'cliente_id' => $cliente_id,
                'vehiculo_id' => $vehiculo['id'],
                'producto' => $producto,
                'referencia' => $_POST['referencia'] ?? '',
                'valor_total' => $valor_total,
                'valor_comision' => $valor_comision,
                'estado' => 'pendiente'
            ];
            
            if ($producto == 'SOAT') {
                $datos_venta['soat_data'] = [
                    'no_poliza' => $_POST['no_poliza'],
                    'fecha_expedicion' => $_POST['fecha_expedicion'],
                    'fecha_vigencia' => $_POST['fecha_vigencia'],
                    'fecha_vencimiento' => $_POST['fecha_vencimiento'],
                    'entidad_expide' => $_POST['entidad_expide'],
                    'tipo_tarifa' => $_POST['tipo_tarifa'] ?? '120'
                ];
            } elseif ($producto == 'Tecnomecanica') {
                $datos_venta['rtm_data'] = [
                    'fecha_expedicion' => $_POST['fecha_expedicion'],
                    'fecha_vigente' => $_POST['fecha_vigente'],
                    'cda_expide' => $_POST['cda_expide'],
                    'nro_certificado' => $_POST['nro_certificado']
                ];
            }
            
            $venta_id = $this->ventasModel->registrarVenta($datos_venta);
            
            if ($venta_id) {
                $_SESSION['success_message'] = "Venta registrada correctamente.";
                header('Location: ' . BASE_URL . 'intermediario/ventas');
                exit();
            } else {
                $_SESSION['error_message'] = "Hubo un error al registrar la venta. Intente nuevamente.";
            }
        }
        
        $comisiones = $comisionesModel->obtenerTodas();
        
        $datos = [
            'titulo' => 'Nueva Venta',
            'intermediario' => $intermediario,
            'comisiones' => $comisiones
        ];
        
        $this->render('intermediario/nueva_venta', $datos);
    }
    
    public function cotizaciones() {
        $intermediario = $this->intermediarioModel->obtenerPorUsuarioId($_SESSION['usuario_id']);
        
        if (!$intermediario) {
            header('Location: ' . BASE_URL . 'intermediario/registro');
            exit();
        }
        
        $cotizaciones = $this->cotizacionesModel->obtenerPorIntermediario($intermediario['id']);
        
        $datos = [
            'titulo' => 'Mis Cotizaciones',
            'intermediario' => $intermediario,
            'cotizaciones' => $cotizaciones
        ];
        
        $this->render('intermediario/cotizaciones', $datos);
    }
    
    public function nueva_cotizacion() {
        $intermediario = $this->intermediarioModel->obtenerPorUsuarioId($_SESSION['usuario_id']);
        
        if (!$intermediario) {
            header('Location: ' . BASE_URL . 'intermediario/registro');
            exit();
        }
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $datos = [
                'intermediario_id' => $intermediario['id'],
                'placa' => $_POST['placa'],
                'tipo_vehiculo' => $_POST['tipo_vehiculo'],
                'modelo' => $_POST['modelo'],
                'cilindraje' => $_POST['cilindraje'],
                'nombre_cliente' => $_POST['nombre_cliente'],
                'telefono_cliente' => $_POST['telefono_cliente'],
                'email_cliente' => $_POST['email_cliente'],
                'producto' => $_POST['producto'],
                'valor' => $_POST['valor']
            ];
            
            $resultado = $this->cotizacionesModel->crear($datos);
            
            if ($resultado) {
                $_SESSION['success_message'] = "Cotización creada correctamente.";
                header('Location: ' . BASE_URL . 'intermediario/cotizaciones');
                exit();
            } else {
                $_SESSION['error_message'] = "Hubo un error al crear la cotización. Intente nuevamente.";
            }
        }
        
        $comisionesModel = new ComisionesModel();
        $comisiones = $comisionesModel->obtenerTodas();
        
        $datos = [
            'titulo' => 'Nueva Cotización',
            'intermediario' => $intermediario,
            'comisiones' => $comisiones
        ];
        
        $this->render('intermediario/nueva_cotizacion', $datos);
    }
    
    public function convertir_cotizacion($id) {
        $intermediario = $this->intermediarioModel->obtenerPorUsuarioId($_SESSION['usuario_id']);
        
        if (!$intermediario) {
            header('Location: ' . BASE_URL . 'intermediario/registro');
            exit();
        }
        
        $cotizacion = $this->cotizacionesModel->obtenerPorId($id);
        
        if (!$cotizacion || $cotizacion['intermediario_id'] != $intermediario['id']) {
            $_SESSION['error_message'] = "Cotización no encontrada o no autorizada.";
            header('Location: ' . BASE_URL . 'intermediario/cotizaciones');
            exit();
        }
        
        $vehiculoModel = new VehiculoModel();
        $comisionesModel = new ComisionesModel();
        $usuarioModel = new UsuarioModel();
        
        $vehiculos = $vehiculoModel->obtenerVehiculosPorPlaca($cotizacion['placa']);
        $vehiculo = !empty($vehiculos) ? $vehiculos[0] : null;
        
        if ($vehiculo) {
            $cliente = $usuarioModel->obtenerPorId($vehiculo['usuario_id']);
            $cliente_id = $cliente['id'];
            
            $valor_comision = $comisionesModel->calcularComision($cotizacion['producto'], $cotizacion['valor'], $intermediario['id']);
            
            $datos_venta = [
                'intermediario_id' => $intermediario['id'],
                'cliente_id' => $cliente_id,
                'vehiculo_id' => $vehiculo['id'],
                'producto' => $cotizacion['producto'],
                'referencia' => 'Cotización #' . $cotizacion['id'],
                'valor_total' => $cotizacion['valor'],
                'valor_comision' => $valor_comision,
                'estado' => 'pendiente'
            ];
            
            $venta_id = $this->ventasModel->registrarVenta($datos_venta);
            
            if ($venta_id) {
                $this->cotizacionesModel->actualizarEstado($cotizacion['id'], 'aceptada');
                $_SESSION['success_message'] = "Cotización convertida a venta correctamente.";
                header('Location: ' . BASE_URL . 'intermediario/ventas');
                exit();
            } else {
                $_SESSION['error_message'] = "Hubo un error al convertir la cotización a venta. Intente nuevamente.";
            }
        } else {
            $_SESSION['error_message'] = "No se pudo encontrar un vehículo con la placa especificada.";
        }
        
        header('Location: ' . BASE_URL . 'intermediario/cotizaciones');
        exit();
    }
    
    public function finanzas() {
        $intermediario = $this->intermediarioModel->obtenerPorUsuarioId($_SESSION['usuario_id']);
        
        if (!$intermediario) {
            header('Location: ' . BASE_URL . 'intermediario/registro');
            exit();
        }
        
        $transacciones = $this->intermediarioModel->obtenerTransaccionesSaldo($intermediario['id']);
        $solicitudes = $this->intermediarioModel->obtenerSolicitudesRetiro($intermediario['id']);
        
        $datos = [
            'titulo' => 'Mis Finanzas',
            'intermediario' => $intermediario,
            'transacciones' => $transacciones,
            'solicitudes' => $solicitudes
        ];
        
        $this->render('intermediario/finanzas', $datos);
    }
    
    public function solicitar_retiro() {
        $intermediario = $this->intermediarioModel->obtenerPorUsuarioId($_SESSION['usuario_id']);
        
        if (!$intermediario) {
            header('Location: ' . BASE_URL . 'intermediario/registro');
            exit();
        }
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $monto = floatval($_POST['monto']);
            
            if ($monto <= 0 || $monto > $intermediario['saldo_actual']) {
                $_SESSION['error_message'] = "El monto de retiro debe ser mayor a cero y no puede exceder su saldo actual.";
                header('Location: ' . BASE_URL . 'intermediario/finanzas');
                exit();
            }
            
            $datos = [
                'intermediario_id' => $intermediario['id'],
                'monto' => $monto,
                'medio_pago' => $_POST['medio_pago'],
                'comentario' => $_POST['comentario'] ?? null
            ];
            
            $resultado = $this->intermediarioModel->solicitarRetiro($datos);
            
            if ($resultado) {
                $_SESSION['success_message'] = "Solicitud de retiro enviada correctamente.";
            } else {
                $_SESSION['error_message'] = "Hubo un error al procesar su solicitud de retiro. Intente nuevamente.";
            }
            
            header('Location: ' . BASE_URL . 'intermediario/finanzas');
            exit();
        }
        
        header('Location: ' . BASE_URL . 'intermediario/finanzas');
        exit();
    }
    
    protected function render($view, $datos = []) {
        extract($datos);
        $view_content_path = 'views/' . $view . '.php';
        require_once ROOT_PATH . 'views/layouts/intermediario_layout.php';
    }
}