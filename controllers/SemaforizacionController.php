<?php
require_once ROOT_PATH . 'models/VehiculoModel.php';

class SemaforizacionController {
    private $vehiculoModel;
    
    public function __construct() {
        if (!isset($_SESSION['usuario_id'])) {
            header('Location: ' . BASE_URL . 'auth/login');
            exit();
        }
        $this->vehiculoModel = new VehiculoModel();
    }
    
    public function actualizarSemaforizacion() {
        if (!isset($_SESSION['usuario_id'])) {
            echo json_encode(['success' => false, 'message' => 'No autorizado']);
            return;
        }
        
        if (!isset($_POST['vehiculo_id']) || empty($_POST['vehiculo_id'])) {
            echo json_encode(['success' => false, 'message' => 'ID de vehículo no proporcionado']);
            return;
        }
        
        $vehiculo_id = $_POST['vehiculo_id'];
        
        try {
            $resultado = $this->vehiculoModel->actualizarSemaforizacion($vehiculo_id);
            
            if ($resultado) {
                $db = getDB();
                $stmtSemaf = $db->prepare("SELECT SUM(total_tarifa) as total_deuda, GROUP_CONCAT(DISTINCT municipio SEPARATOR ', ') as municipios, MAX(fecha_ultimo_pago) as ultimo_pago FROM semaforizacion WHERE vehiculo_id = ? AND total_tarifa > 0");
                $stmtSemaf->execute([$vehiculo_id]);
                $semafData = $stmtSemaf->fetch(PDO::FETCH_ASSOC);
                
                if ($semafData && $semafData['total_deuda'] > 0) {
                    $municipios = $semafData['municipios'] ? explode(', ', $semafData['municipios']) : [];
                    $semaforizacionInfo = [
                        'estado' => 'Pago Pendiente', 
                        'total_deuda' => $semafData['total_deuda'], 
                        'municipios' => $municipios, 
                        'ultimo_pago' => $semafData['ultimo_pago']
                    ];
                } else {
                    $semaforizacionInfo = ['estado' => 'Al día'];
                }
                
                echo json_encode([
                    'success' => true, 
                    'message' => 'Semaforización actualizada correctamente',
                    'semaforizacion' => $semaforizacionInfo
                ]);
            } else {
                echo json_encode(['success' => false, 'message' => 'Error al actualizar la semaforización']);
            }
        } catch (Exception $e) {
            echo json_encode(['success' => false, 'message' => $e->getMessage()]);
        }
    }
}