<?php
/**
 * Script para consultar información de vehículo en el sistema de tránsito de Envigado
 * Realiza primero autenticación y luego la consulta de datos
 * 
 * @param string $placa Placa del vehículo a consultar (por defecto: QTN10E)
 * @return object Respuesta JSON con la información del vehículo
 */

// Función para obtener el tiempo Unix actual en milisegundos
function getCurrentUnixTime() {
    return time() * 1000;
}

// Parámetro de placa (se puede recibir vía GET)
$placa = isset($_GET['placa']) ? $_GET['placa'] : 'QTN10E';

// URL base
$baseUrl = "https://movilidad.envigado.gov.co";
$refererUrl = "https://transitosabaneta.utsetsa.com/";

// Archivo temporal para almacenar cookies
$cookieJar = tempnam(sys_get_temp_dir(), 'cookie');

// === PASO 1: Autenticación para obtener el token ===
$loginUrl = $baseUrl . "/backavit/avit/login/";

// Datos para la autenticación
$loginData = json_encode([
    "usuario" => "ANONIMO",
    "password" => "admin",
    "consumidor" => "web"
]);

// Inicializar cURL para la autenticación
$ch = curl_init();

// Configurar opciones de cURL para la solicitud de autenticación
curl_setopt_array($ch, [
    CURLOPT_URL => $loginUrl,
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_POST => true,
    CURLOPT_POSTFIELDS => $loginData,
    CURLOPT_HTTPHEADER => [
        "Content-Type: application/json",
        "Referer: " . $refererUrl
    ],
    CURLOPT_COOKIEJAR => $cookieJar,  // Guardar cookies recibidas
    CURLOPT_HEADER => true  // Capturar encabezados para analizar cookies
]);

// Ejecutar la solicitud de autenticación
$response = curl_exec($ch);

// Verificar errores
if (curl_errno($ch)) {
    echo json_encode(['error' => 'Error en autenticación: ' . curl_error($ch)]);
    exit;
}

// Separar encabezados y cuerpo de la respuesta
$headerSize = curl_getinfo($ch, CURLINFO_HEADER_SIZE);
$header = substr($response, 0, $headerSize);
$body = substr($response, $headerSize);

// Cerrar la sesión cURL
curl_close($ch);

// Decodificar la respuesta para obtener el token
$responseData = json_decode($body, true);
if (!isset($responseData['token'])) {
    echo json_encode(['error' => 'No se pudo obtener el token de autenticación', 'response' => $body]);
    exit;
}

// Obtener el token
$token = $responseData['token'];

// Extraer cookies manualmente para asegurarnos de capturarlas correctamente
$cookies = [];
preg_match_all('/^Set-Cookie:\s*([^;]*)/mi', $header, $matches);
foreach($matches[1] as $item) {
    parse_str($item, $cookie);
    $cookies = array_merge($cookies, $cookie);
}

// === PASO 2: Consultar información del vehículo ===
$tiempo = getCurrentUnixTime();
$consultaUrl = $baseUrl . "/backavit/avit/impuestos/semaforizacion/{$placa}?idSecretaria=0&placa={$placa}&idSecretaria=0&_={$tiempo}";

// Inicializar cURL para la consulta
$ch = curl_init();

// Crear cadena de cookies para incluir en la solicitud
$cookieString = "";
foreach ($cookies as $key => $value) {
    $cookieString .= "$key=$value; ";
}

// Configurar opciones de cURL para la solicitud de consulta
curl_setopt_array($ch, [
    CURLOPT_URL => $consultaUrl,
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_HTTPHEADER => [
        "Content-Type: application/json",
        "Referer: " . $refererUrl,
        "Authorization: Bearer " . $token, // Agregamos el token obtenido
        "Cookie: " . $cookieString // Agregamos las cookies obtenidas
    ],
    CURLOPT_COOKIEFILE => $cookieJar // Usar cookies guardadas
]);

// Ejecutar la solicitud de consulta
$response = curl_exec($ch);

// Verificar errores
if (curl_errno($ch)) {
    echo json_encode(['error' => 'Error en consulta: ' . curl_error($ch)]);
    exit;
}

// Cerrar la sesión cURL
curl_close($ch);

// Eliminar el archivo de cookies temporal
@unlink($cookieJar);

// Devolver la respuesta en formato JSON
header('Content-Type: application/json');
echo $response;

// Agregar información de depuración si está habilitada
if (isset($_GET['debug']) && $_GET['debug'] == 1) {
    echo "\n\n<!-- DEBUG INFO -->\n";
    echo "<!-- Token: " . $token . " -->\n";
    echo "<!-- Tiempo: " . $tiempo . " -->\n";
    echo "<!-- Cookies: " . $cookieString . " -->\n";
}
?>