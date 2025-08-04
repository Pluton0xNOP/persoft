<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require_once ROOT_PATH . 'vendor/autoload.php';

define('SMTP_HOST', 'smtp.hostinger.com');
define('SMTP_USERNAME', 'info@capersof.com');
define('SMTP_PASSWORD', 'Capersof2025*');
define('SMTP_PORT', 465);
define('SMTP_FROM_NAME', 'PerSoft Tramites');

function enviarEmail($destinatario, $nombre_destinatario, $asunto, $cuerpo_html) {
    $mail = new PHPMailer(true);
    try {
        $mail->isSMTP();
        $mail->Host       = SMTP_HOST;
        $mail->SMTPAuth   = true;
        $mail->Username   = SMTP_USERNAME;
        $mail->Password   = SMTP_PASSWORD;
        $mail->SMTPSecure = 'ssl';
        $mail->Port       = SMTP_PORT;
        $mail->CharSet    = 'UTF-8';

        $mail->Timeout = 60;
        $mail->SMTPKeepAlive = true;
        
        $mail->setFrom(SMTP_USERNAME, SMTP_FROM_NAME);
        $mail->addAddress($destinatario, $nombre_destinatario);

        $mail->isHTML(true);
        $mail->Subject = $asunto;
        $mail->Body    = $cuerpo_html;
        $mail->AltBody = 'Por favor, use un cliente de correo que soporte HTML para ver este mensaje.';

        error_log('Intentando enviar email a: ' . $destinatario);
        
        $mail->send();
        
        error_log('Email enviado correctamente a: ' . $destinatario);
        return true;
    } catch (Exception $e) {
        error_log('Error al enviar correo a ' . $destinatario . ': ' . $e->getMessage());
        error_log('Detalles del error: ' . $mail->ErrorInfo);
        return false;
    }
}

function getHtmlTemplateBienvenida($nombre, $email, $password) {
    $url_login = BASE_URL . 'auth/login';
    
    error_log('Generando plantilla de bienvenida para: ' . $email);
    
    $template = "
        <!DOCTYPE html>
        <html>
        <head>
            <style>
                body { font-family: Arial, sans-serif; background-color: #f4f4f4; margin: 0; padding: 20px; }
                .container { background-color: #ffffff; max-width: 600px; margin: auto; padding: 20px; border-radius: 8px; box-shadow: 0 4px 8px rgba(0,0,0,0.1); }
                .header { background-color: #0e7490; color: white; padding: 10px 20px; border-radius: 8px 8px 0 0; text-align: center; }
                .content { padding: 20px; line-height: 1.6; }
                .credentials { background-color: #e8f0fe; padding: 15px; border: 1px dashed #0891b2; border-radius: 5px; margin: 20px 0; }
                .credentials p { margin: 5px 0; }
                .warning { background-color: #fff3cd; border: 1px solid #ffeaa7; padding: 15px; border-radius: 5px; margin: 20px 0; color: #856404; }
                .button { display: inline-block; background-color: #06b6d4; color: white !important; padding: 12px 25px; text-decoration: none; border-radius: 5px; text-align: center; }
                .footer { text-align: center; font-size: 12px; color: #777; margin-top: 20px; }
            </style>
        </head>
        <body>
            <div class='container'>
                <div class='header'><h1>¡Bienvenido a PerSoft!</h1></div>
                <div class='content'>
                    <p>Hola <strong>{$nombre}</strong>,</p>
                    <p>Tu cuenta ha sido creada exitosamente. Ahora puedes gestionar todos tus trámites vehiculares de forma digital y segura.</p>
                    
                    <div class='credentials'>
                        <p><strong>Usuario:</strong> {$email}</p>
                        <p><strong>Contraseña Temporal:</strong> <strong>{$password}</strong></p>
                    </div>
                    
                    <div class='warning'>
                        <p><strong>⚠️ IMPORTANTE:</strong> Por tu seguridad, deberás cambiar esta contraseña temporal en tu primer inicio de sesión. El sistema te solicitará crear una nueva contraseña.</p>
                   </div>
                   
                   <p style='text-align:center;'>
                       <a href='{$url_login}' class='button'>Iniciar Sesión Ahora</a>
                   </p>
                   <p>Si tienes alguna pregunta, no dudes en contactarnos.</p>
               </div>
               <div class='footer'><p>&copy; " . date('Y') . " PerSoft. Todos los derechos reservados.</p></div>
           </div>
       </body>
       </html>
   ";
   
   return $template;
}