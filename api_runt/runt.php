<?php

//runt.php viejo pero sirve
header('Content-Type: application/json; charset=utf-8');
ini_set('display_errors', 0);
set_time_limit(0);

if (!isset($_GET['placa'])) {
    echo json_encode(["error" => "Falta parámetro placa del vehículo"], JSON_UNESCAPED_UNICODE);
    exit;
}

if (!isset($_GET['documento'])) {
    echo json_encode(["error" => "Falta parámetro documento (cédula)"], JSON_UNESCAPED_UNICODE);
    exit;
}

$placa = trim($_GET['placa']);
$documento = trim($_GET['documento']);
$tipo = isset($_GET['tipo']) ? $_GET['tipo'] : "C";
$endpointVehiculo = "https://www.runt.gov.co/consultaCiudadana/publico/automotores/?429";
$endpointSoat = "https://www.runt.gov.co/consultaCiudadana/publico/automotores/soats?478";
$endpointRtm = "https://www.runt.gov.co/consultaCiudadana/publico/automotores/rtms?96";
$captchaPoolSize = 10;

if (!preg_match('/^[A-Za-z0-9]{3,7}$/', $placa)) {
    echo json_encode(["error" => "Formato de placa inválido"], JSON_UNESCAPED_UNICODE);
    exit;
}

if (!preg_match('/^\d{5,12}$/', $documento)) {
    echo json_encode(["error" => "Formato de documento inválido"], JSON_UNESCAPED_UNICODE);
    exit;
}

function obtenerCaptchasParalelo($cantidad) {
    $multiHandle = curl_multi_init();
    $curlHandles = [];
    
    for ($i = 0; $i < $cantidad; $i++) {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "https://www.runt.gov.co/consultaCiudadana/captcha?id=" . rand(1, 1000));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HEADER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/125.0.0.0 Safari/537.36');
        curl_setopt($ch, CURLOPT_TIMEOUT, 4);
        curl_multi_add_handle($multiHandle, $ch);
        $curlHandles[] = $ch;
    }
    
    $active = null;
    do {
        $mrc = curl_multi_exec($multiHandle, $active);
    } while ($mrc == CURLM_CALL_MULTI_PERFORM);
    
    while ($active && $mrc == CURLM_OK) {
        if (curl_multi_select($multiHandle) != -1) {
            do {
                $mrc = curl_multi_exec($multiHandle, $active);
            } while ($mrc == CURLM_CALL_MULTI_PERFORM);
        }
    }
    
    $captchas = [];
    foreach ($curlHandles as $ch) {
        $response = curl_multi_getcontent($ch);
        if ($response) {
            $headerSize = curl_getinfo($ch, CURLINFO_HEADER_SIZE);
            $headers = substr($response, 0, $headerSize);
            $imageData = substr($response, $headerSize);
            
            if (!empty($imageData)) {
                $cookies = [];
                preg_match_all('/^Set-Cookie:\s*([^;]*)/mi', $headers, $matches);
                foreach ($matches[1] as $cookie) {
                    $parts = explode('=', $cookie, 2);
                    if (count($parts) == 2) {
                        $cookies[trim($parts[0])] = trim($parts[1]);
                    }
                }
                
                $xsrfToken = '';
                if (preg_match('/XSRF-TOKEN=([^;]+)/', $headers, $match)) {
                    $xsrfToken = urldecode($match[1]);
                }
                
                $captchas[] = ['imageData' => $imageData, 'cookies' => $cookies, 'xsrfToken' => $xsrfToken];
            }
        }
        curl_multi_remove_handle($multiHandle, $ch);
        curl_close($ch);
    }
    curl_multi_close($multiHandle);
    return $captchas;
}

function consultarVehiculo($captchaInfo, $placa, $documento, $tipo, $endpoint) {
    if (empty($captchaInfo['text'])) {
        return ['body' => '{"error":true,"mensajeError":"CAPTCHA no disponible"}'];
    }
    
    $payload = [
        "tipoDocumento" => $tipo, "procedencia" => "NACIONAL", "tipoConsulta" => "1", "vin" => null,
        "noDocumento" => $documento, "noPlaca" => $placa, "soat" => null, "codigoSoat" => null, "rtm" => null,
        "captcha" => $captchaInfo['text']
    ];
    $acceptData = base64_encode(json_encode($payload));
    
    $cookieStr = '';
    foreach ($captchaInfo['cookies'] as $name => $value) {
        $cookieStr .= "$name=$value; ";
    }
    $cookieStr = rtrim($cookieStr, '; ');
    
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $endpoint);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_TIMEOUT, 5);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($payload));
    
    $headers = [
        'Accept: application/json, text/plain, */*', 'Accept-Data: ' . $acceptData, 'Content-Type: application/json;charset=UTF-8',
        'Origin: https://www.runt.gov.co', 'Referer: https://www.runt.gov.co/consultaCiudadana/',
        'X-XSRF-TOKEN: ' . urlencode($captchaInfo['xsrfToken']), 'Cookie: ' . $cookieStr
    ];
    
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    $response = curl_exec($ch);
    $error = curl_error($ch);
    curl_close($ch);
    
    if ($error) return ['body' => json_encode(["error" => true, "mensajeError" => "Error de cURL: " . $error])];
    if (empty($response)) return ['body' => '{"error":true,"mensajeError":"Respuesta vacía del servidor"}'];
    
    return ['body' => $response];
}

function consultarEndpoint($captchaInfo, $token, $placa, $documento, $endpoint) {
    if (empty($token)) {
        return ['body' => '{"error":true,"mensajeError":"Token no disponible"}'];
    }
    
    $dataPayload = [
        "tipoDocumento" => "C", "procedencia" => "NACIONAL", "tipoConsulta" => "1", "vin" => null,
        "noDocumento" => $documento, "noPlaca" => $placa, "soat" => null, "codigoSoat" => null, "rtm" => null,
        "captcha" => $captchaInfo['text']
    ];
    $acceptData = base64_encode(json_encode($dataPayload));
    
    $cookieStr = '';
    foreach ($captchaInfo['cookies'] as $name => $value) {
        $cookieStr .= "$name=$value; ";
    }
    $cookieStr = rtrim($cookieStr, '; ');
    
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $endpoint);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_TIMEOUT, 5);
    
    $headers = [
        'Accept: application/json, text/plain, */*', 'Accept-Data: ' . $acceptData, 'Authorization: Bearer ' . $token,
        'Referer: https://www.runt.gov.co/consultaCiudadana/', 'X-XSRF-TOKEN: ' . urlencode($captchaInfo['xsrfToken']), 'Cookie: ' . $cookieStr
    ];
    
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    $response = curl_exec($ch);
    $error = curl_error($ch);
    curl_close($ch);

    if ($error) return ['body' => json_encode(["error" => true, "mensajeError" => "Error de cURL: " . $error])];
    if (empty($response)) return ['body' => '{"error":true,"mensajeError":"Respuesta vacía del servidor"}'];
    
    return ['body' => $response];
}

function obtenerDatosRUNT($placa, $documento, $tipo, $endpointVehiculo, $endpointSoat, $endpointRtm, $captchaPoolSize) {
    $captchasObtenidos = obtenerCaptchasParalelo($captchaPoolSize);

    if (empty($captchasObtenidos)) {
        return ['error' => 'No se pudo obtener ninguna imagen de CAPTCHA del servidor.'];
    }
    
    foreach ($captchasObtenidos as $captcha) {
        $tempImageFile = tempnam(sys_get_temp_dir(), 'captcha_') . '.png';
        file_put_contents($tempImageFile, $captcha['imageData']);

        $whitelist = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
        $command = "\"C:\\Program Files\\Tesseract-OCR\\tesseract.exe\" \"{$tempImageFile}\" stdout -l eng --psm 7 -c tessedit_char_whitelist={$whitelist}";
        
        $captchaTextRaw = shell_exec($command);
        unlink($tempImageFile);

        $captchaText = preg_replace('/[^a-zA-Z0-9]/', '', $captchaTextRaw);

        if (empty($captchaText) || strlen($captchaText) < 4) {
            continue;
        }

        $captchaInfo = array_merge($captcha, ['text' => $captchaText]);
        $resultadoVehiculo = consultarVehiculo($captchaInfo, $placa, $documento, $tipo, $endpointVehiculo);
        $jsonVehiculo = preg_replace('/^\)\]\}\'/', '', $resultadoVehiculo['body']);
        $datosVehiculo = json_decode($jsonVehiculo, true);
        
        if ($datosVehiculo === null || isset($datosVehiculo['error']) || strpos($resultadoVehiculo['body'], 'La imagen no coincide') !== false || (isset($datosVehiculo['mensajeError']) && $datosVehiculo['mensajeError'] === "Parametros invalidos.")) {
            continue;
        }

        if (!isset($datosVehiculo['token']) || empty($datosVehiculo['token'])) {
            continue;
        }
        
        $tokenRunt = $datosVehiculo['token'];
        $resultadoSoat = consultarEndpoint($captchaInfo, $tokenRunt, $placa, $documento, $endpointSoat);
        $datosSoat = json_decode(preg_replace('/^\)\]\}\'/', '', $resultadoSoat['body']), true);

        $resultadoRtm = consultarEndpoint($captchaInfo, $tokenRunt, $placa, $documento, $endpointRtm);
        $datosRtm = json_decode(preg_replace('/^\)\]\}\'/', '', $resultadoRtm['body']), true);

        return ['vehiculo' => $datosVehiculo, 'soat' => $datosSoat, 'rtm' => $datosRtm];
    }
    
    return ['error' => 'Ningún intento en este lote fue exitoso.'];
}

$transactionId = uniqid();
$tiempoInicio = microtime(true);

while (true) {
    $resultadoRunt = obtenerDatosRUNT($placa, $documento, $tipo, $endpointVehiculo, $endpointSoat, $endpointRtm, $captchaPoolSize);

    if (!isset($resultadoRunt['error'])) {
        $resultadoCombinado = [
            "status" => "success",
            "runt" => $resultadoRunt,
            "transactionId" => $transactionId,
            "documentoConsulta" => $documento,
            "placa" => $placa,
            "tiempoConsulta" => round(microtime(true) - $tiempoInicio, 2) . " segundos"
        ];
        echo json_encode($resultadoCombinado, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
        break;
    }
    
    sleep(2);
}