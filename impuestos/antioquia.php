<?php
header('Content-Type: application/json; charset=utf-8');

// Obtener parámetros de la URL
$placa = isset($_GET['placa']) ? strtoupper(trim($_GET['placa'])) : '';
$cedula = isset($_GET['cedula']) ? trim($_GET['cedula']) : '';

// Validar parámetros
if (empty($placa) || empty($cedula)) {
    echo json_encode([
        'error' => true,
        'mensaje' => 'Faltan parámetros requeridos: placa y cedula'
    ], JSON_UNESCAPED_UNICODE);
    exit;
}

try {
    // Inicializar curl para mantener cookies
    $cookieFile = tempnam(sys_get_temp_dir(), 'cookies');
    
    // PASO 1: GET inicial para obtener el CSRF token
    $ch = curl_init();
    curl_setopt_array($ch, [
        CURLOPT_URL => 'https://www.vehiculosantioquia.com.co/impuestosWeb/',
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_SSL_VERIFYPEER => false,
        CURLOPT_SSL_VERIFYHOST => false,
        CURLOPT_COOKIEJAR => $cookieFile,
        CURLOPT_COOKIEFILE => $cookieFile,
        CURLOPT_USERAGENT => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/80.0.3987.149 Safari/537.36',
        CURLOPT_HTTPHEADER => [
            'Pragma: no-cache',
            'Accept: */*'
        ]
    ]);
    
    $initialResponse = curl_exec($ch);
    
    if (curl_error($ch)) {
        throw new Exception('Error en GET inicial: ' . curl_error($ch));
    }
    
    // Extraer CSRF token
    preg_match('/name="csrfPreventionSalt" value=\'([^\']+)\'/', $initialResponse, $matches);
    if (!isset($matches[1])) {
        throw new Exception('No se pudo obtener el token CSRF');
    }
    $csrfToken = $matches[1];
    
    // PASO 2: POST con los datos del vehículo
    $postData = http_build_query([
        'csrfPreventionSalt' => $csrfToken,
        'pagina' => 'rediseno/estadoCuenta.jsp',
        'nombreDocumento' => 'CEDULA',
        'tipoProceso' => '1',
        'placa' => $placa,
        'tipoDocumento' => 'CC',
        'nroDocumento' => $cedula,
        'token' => '',
        'parametroToken' => 'N'
    ]);
    
    curl_setopt_array($ch, [
        CURLOPT_URL => 'https://www.vehiculosantioquia.com.co/impuestosWeb/ConsultarEstadoCuentaServlet',
        CURLOPT_POST => true,
        CURLOPT_POSTFIELDS => $postData,
        CURLOPT_HTTPHEADER => [
            'Content-Type: application/x-www-form-urlencoded',
            'User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/80.0.3987.149 Safari/537.36',
            'Pragma: no-cache',
            'Accept: */*'
        ]
    ]);
    
    $response = curl_exec($ch);
    
    if (curl_error($ch)) {
        throw new Exception('Error en POST: ' . curl_error($ch));
    }
    
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);
    
    // Limpiar archivo de cookies
    unlink($cookieFile);
    
    if ($httpCode !== 200) {
        throw new Exception('Error HTTP: ' . $httpCode);
    }
    
    // Crear DOMDocument para parsear el HTML
    $dom = new DOMDocument();
    libxml_use_internal_errors(true);
    $dom->loadHTML('<?xml encoding="utf-8" ?>' . $response);
    libxml_clear_errors();
    
    $xpath = new DOMXPath($dom);
    
    // Extraer valores solicitados
    $resultado = [
        'error' => false,
        'placa' => $placa,
        'cedula' => $cedula,
        'datos' => []
    ];
    
    // Período de certificación
    $periodoNodes = $xpath->query("//span[contains(text(), 'Período de certificación:')]/following-sibling::span");
    if ($periodoNodes->length > 0) {
        $resultado['datos']['periodo_certificacion'] = trim($periodoNodes->item(0)->textContent);
    }
    
    // Fecha de consulta
    $fechaConsultaNodes = $xpath->query("//span[contains(text(), 'Fecha de consulta:')]/following-sibling::span");
    if ($fechaConsultaNodes->length > 0) {
        $resultado['datos']['fecha_consulta'] = trim($fechaConsultaNodes->item(0)->textContent);
    }
    
    // Marca del vehículo
    $marcaNodes = $xpath->query("//span[@class='txtMarcaReg']");
    if ($marcaNodes->length > 0) {
        $marcaCompleta = trim($marcaNodes->item(0)->textContent);
        $marcaCompleta = str_replace(' / ', ' / ', $marcaCompleta);
        $resultado['datos']['marca_vehiculo'] = $marcaCompleta;
    }
    
    // Último pago realizado - Año
    $anoNodes = $xpath->query("//span[contains(text(), 'Año:')]/following-sibling::span");
    if ($anoNodes->length > 0) {
        $resultado['datos']['ultimo_pago']['ano'] = trim($anoNodes->item(0)->textContent);
    }
    
    // Último pago realizado - Fecha de pago
    $fechaPagoNodes = $xpath->query("//span[contains(text(), 'Fecha de pago:')]/following-sibling::span");
    if ($fechaPagoNodes->length > 0) {
        $resultado['datos']['ultimo_pago']['fecha_pago'] = trim($fechaPagoNodes->item(0)->textContent);
    }
    
    // Último pago realizado - Valor pagado
    $valorNodes = $xpath->query("//span[contains(text(), 'Valor pagado:')]/following-sibling::span");
    if ($valorNodes->length > 0) {
        $resultado['datos']['ultimo_pago']['valor_pagado'] = trim($valorNodes->item(0)->textContent);
    }
    
    // Verificar si hay información de vigencia (tabla)
    $vigenciaNodes = $xpath->query("//table//tr[position()>1]/td[1]/span[@class='txtCarSbold']");
    if ($vigenciaNodes->length > 0) {
        $resultado['datos']['vigencias_disponibles'] = [];
        foreach ($vigenciaNodes as $node) {
            $vigencia = trim($node->textContent);
            if (!empty($vigencia)) {
                $resultado['datos']['vigencias_disponibles'][] = $vigencia;
            }
        }
    }
    
    // Verificar si hay errores en la consulta
    if (empty($resultado['datos'])) {
        // Buscar mensajes de error
        $errorNodes = $xpath->query("//p[contains(@class, 'txtRegList')] | //div[contains(@class, 'alert')] | //span[contains(@class, 'error')]");
        if ($errorNodes->length > 0) {
            $resultado['error'] = true;
            $resultado['mensaje'] = trim($errorNodes->item(0)->textContent);
        } else {
            $resultado['error'] = true;
            $resultado['mensaje'] = 'No se encontraron datos para la placa y cédula proporcionadas';
        }
    }
    
    echo json_encode($resultado, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
    
} catch (Exception $e) {
    echo json_encode([
        'error' => true,
        'mensaje' => $e->getMessage()
    ], JSON_UNESCAPED_UNICODE);
}
?>