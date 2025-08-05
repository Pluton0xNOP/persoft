<?php
// models/SettingModel.php
class SettingModel {
    private function getDefaults() {
        return [
            'notifications' => [
                'email_vencimientos' => true,
                'email_promociones' => false,
                'sms_alertas' => true
            ],
            'appearance' => 'system',
            'language' => 'es-CO'
        ];
    }
    
    public function obtenerPorUsuarioId($usuario_id) {
        $db = getDB();
        $stmt = $db->prepare("SELECT * FROM user_settings WHERE usuario_id = ?");
        $stmt->execute([$usuario_id]);
        $settings = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$settings) {
            return $this->getDefaults();
        }

        return [
            'notifications' => [
                'email_vencimientos' => (bool)$settings['email_vencimientos'],
                'email_promociones' => (bool)$settings['email_promociones'],
                'sms_alertas' => (bool)$settings['sms_alertas']
            ],
            'appearance' => $settings['appearance'],
            'language' => $settings['language']
        ];
    }

    public function guardarParaUsuario($usuario_id, $data) {
        $db = getDB();
        $sql = "
            INSERT INTO user_settings (usuario_id, email_vencimientos, email_promociones, sms_alertas, appearance, language) 
            VALUES (?, ?, ?, ?, ?, ?)
            ON DUPLICATE KEY UPDATE 
            email_vencimientos = VALUES(email_vencimientos),
            email_promociones = VALUES(email_promociones),
            sms_alertas = VALUES(sms_alertas),
            appearance = VALUES(appearance),
            language = VALUES(language)
        ";
        $stmt = $db->prepare($sql);
        return $stmt->execute([
            $usuario_id,
            $data['email_vencimientos'],
            $data['email_promociones'],
            $data['sms_alertas'],
            $data['appearance'],
            $data['language']
        ]);
    }
}