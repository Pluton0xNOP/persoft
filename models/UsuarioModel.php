<?php
// models/UsuarioModel.php
class UsuarioModel {
    public function obtenerPorId($id) {
        $db = getDB();
        $stmt = $db->prepare("SELECT * FROM usuarios WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function obtenerPorCodigoReferido($codigo) {
        $db = getDB();
        $stmt = $db->prepare("SELECT * FROM usuarios WHERE referral_code = ?");
        $stmt->execute([$codigo]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function obtenerReferidosPorUsuario($usuario_id) {
        $db = getDB();
        $stmt = $db->prepare("SELECT nombres, email, created_at FROM usuarios WHERE referred_by_id = ? ORDER BY created_at DESC");
        $stmt->execute([$usuario_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function agregarPunto($usuario_id) {
        $db = getDB();
        $stmt = $db->prepare("UPDATE usuarios SET puntos = puntos + 1 WHERE id = ?");
        return $stmt->execute([$usuario_id]);
    }

    public function actualizarCodigoReferido($usuario_id, $codigo) {
        $db = getDB();
        $stmt = $db->prepare("UPDATE usuarios SET referral_code = ? WHERE id = ?");
        return $stmt->execute([$codigo, $usuario_id]);
    }
}