<?php
//index.php
session_start();

require_once __DIR__ . '/config/database.php';

$isLocal = (strpos($_SERVER['HTTP_HOST'], 'localhost') !== false ||
    strpos($_SERVER['HTTP_HOST'], '127.0.0.1') !== false);

if ($isLocal) {
    define('BASE_URL', 'http://localhost/persoft/');
    define('ROOT_PATH', __DIR__ . '/');
} else {
    define('BASE_URL', 'https://' . $_SERVER['HTTP_HOST'] . '/');
    define('ROOT_PATH', $_SERVER['DOCUMENT_ROOT'] . '/../');
}

if (!isset($_SESSION['usuario_id']) && isset($_COOKIE['recuerdame'])) {
    require_once ROOT_PATH . 'controllers/AuthController.php';
    AuthController::validarTokenRecordarme();
}

$url = isset($_GET['url']) ? $_GET['url'] : '';
$url = rtrim($url, '/');
$url = filter_var($url, FILTER_SANITIZE_URL);

switch ($url) {
    case '':
    case 'home':
        require_once ROOT_PATH . 'controllers/HomeController.php';
        $controller = new HomeController();
        $controller->index();
        break;

    case 'dashboard':
        require_once ROOT_PATH . 'controllers/DashboardController.php';
        $controller = new DashboardController();
        $controller->index();
        break;

    case 'dashboard/vehiculos':
        require_once ROOT_PATH . 'controllers/DashboardController.php';
        $controller = new DashboardController();
        $controller->vehiculos();
        break;

    case 'dashboard/agregar-vehiculo':
        require_once ROOT_PATH . 'controllers/DashboardController.php';
        $controller = new DashboardController();
        $controller->agregar_vehiculo();
        break;
    case 'dashboard/pagos':
        require_once ROOT_PATH . 'controllers/DashboardController.php';
        $controller = new DashboardController();
        $controller->pagos();
        break;

    case 'dashboard/multas':
        require_once ROOT_PATH . 'controllers/DashboardController.php';
        $controller = new DashboardController();
        $controller->multas();
        break;
    case 'dashboard/ahorros':
        require_once ROOT_PATH . 'controllers/DashboardController.php';
        $controller = new DashboardController();
        $controller->ahorros();
        break;

    case 'dashboard/referidos':
        require_once ROOT_PATH . 'controllers/DashboardController.php';
        $controller = new DashboardController();
        $controller->referidos();
        break;

    case 'dashboard/recordatorios':
            require_once ROOT_PATH . 'controllers/DashboardController.php';
            $controller = new DashboardController();
            $controller->recordatorios();
            break;
    case 'dashboard/tramites':
        require_once ROOT_PATH . 'controllers/DashboardController.php';
        $controller = new DashboardController();
        $controller->tramites();
        break;
    case 'dashboard/ahorros':
        require_once ROOT_PATH . 'controllers/DashboardController.php';
        $controller = new DashboardController();
        $controller->ahorros();
        break;
        
    case 'dashboard/crear-tramite':
        require_once ROOT_PATH . 'controllers/DashboardController.php';
        $controller = new DashboardController();
        $controller->crear_tramite();
        break;
        
    case 'dashboard/perfil':
        require_once ROOT_PATH . 'controllers/DashboardController.php';
        $controller = new DashboardController();
        $controller->perfil();
        break;

    case 'dashboard/configuracion':
        require_once ROOT_PATH . 'controllers/DashboardController.php';
        $controller = new DashboardController();
        $controller->configuracion();
        break;

    case 'auth/login':
        require_once ROOT_PATH . 'controllers/AuthController.php';
        $controller = new AuthController();
        $controller->login();
        break;

    case 'auth/register':
        require_once ROOT_PATH . 'controllers/AuthController.php';
        $controller = new AuthController();
        $controller->register();
        break;

    case 'auth/cambiar-password':
        require_once ROOT_PATH . 'controllers/AuthController.php';
        $controller = new AuthController();
        $controller->cambiarPassword();
        break;

    case 'auth/confirmacion':
        require_once ROOT_PATH . 'controllers/AuthController.php';
        $controller = new AuthController();
        $controller->confirmacion();
        break;
    
    case 'auth/logout':
        require_once ROOT_PATH . 'controllers/AuthController.php';
        $controller = new AuthController();
        $controller->logout();
        break;
    case 'semaforizacion/actualizarSemaforizacion':
        require_once ROOT_PATH . 'controllers/SemaforizacionController.php';
        $controller = new SemaforizacionController();
        $controller->actualizarSemaforizacion();
        break; 
    case 'dashboard/centros-servicio':
        require_once ROOT_PATH . 'controllers/DashboardController.php';
        $controller = new DashboardController();
        $controller->centros_servicio();
        break;
  
        
    default:
        if (preg_match('/^dashboard\/gestionar-vehiculo\/(\d+)$/', $url, $matches)) {
            require_once ROOT_PATH . 'controllers/DashboardController.php';
            $controller = new DashboardController();
            $vehiculoId = $matches[1];
            $controller->gestionar_vehiculo($vehiculoId);
        } else {
            http_response_code(404);
            require_once ROOT_PATH . 'views/layouts/404.php';
        }
        break;
}