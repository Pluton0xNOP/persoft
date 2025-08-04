<?php
// middleware/AuthMiddleware.php
class AuthMiddleware {
    public static function verificarCambioPassword() {
        if (isset($_SESSION['usuario_id']) && isset($_SESSION['requiere_cambio_password'])) {
            // Si está en cualquier página que no sea cambiar-password, redirigir
            $current_url = $_GET['url'] ?? '';
            if ($current_url !== 'auth/cambiar-password') {
                header('Location: ' . BASE_URL . 'auth/cambiar-password');
                exit;
            }
        }
    }
}