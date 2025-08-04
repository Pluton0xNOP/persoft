<?php
class HomeController {
    
    public function index() {
        $titulo = "PerSoft - Consulta de Tecnomecánica";
        $descripcion = "Agenda tu revisión tecnomecánica en CDAs cerca de ti a precios exclusivos";
        
        require_once ROOT_PATH . 'views/layouts/main.php';
    }
}
?>