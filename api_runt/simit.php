<?php
// api_runt/simit.php
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
header('Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept, Authorization');
header('Access-Control-Allow-Credentials: true');
header('Access-Control-Max-Age: 86400');

if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
    http_response_code(200);
    exit;
}

function esPrimo($valor) {
    if ($valor < 2) return false;
    for ($i = 2; $i <= sqrt($valor); $i++) {
        if ($valor % $i === 0) return false;
    }
    return true;
}

function resolverCaptcha($data, $nonce = 1) {
    $nonce++;
    $verifyArray = [
        "question" => $data['question'],
        "time" => $data['time'],
        "nonce" => $nonce
    ];
    $verifyJson = json_encode($verifyArray);
    $hashActual = hash('sha256', $verifyJson);

    while (substr($hashActual, 0, 4) !== "0000" || !esPrimo($nonce)) {
        $nonce++;
        $verifyArray['nonce'] = $nonce;
        $verifyJson = json_encode($verifyArray);
        $hashActual = hash('sha256', $verifyJson);
    }

    return [
        "verify_array" => $verifyArray,
        "nonce" => $nonce,
        "hash" => $hashActual
    ];
}

function obtenerQuestion() {
    $headers = [
        "Accept: */*",
        "Accept-Encoding: gzip, deflate, br, zstd",
        "Accept-Language: es,es-ES;q=0.9,en;q=0.8,en-GB;q=0.7,en-US;q=0.6",
        "Connection: keep-alive",
        "Content-Type: multipart/form-data; boundary=----WebKitFormBoundaryCdmQ3AUbNA5ZGilX",
        "Host: qxcaptcha.fcm.org.co",
        "Origin: https://www.fcm.org.co",
        "Referer: https://www.fcm.org.co/",
        "Sec-Fetch-Dest: empty",
        "Sec-Fetch-Mode: cors",
        "Sec-Fetch-Site: cross-site",
        "User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/130.0.0.0 Safari/537.36 Edg/130.0.0.0",
        "sec-ch-ua: \"Chromium\";v=\"130\", \"Microsoft Edge\";v=\"130\", \"Not?A_Brand\";v=\"99\"",
        "sec-ch-ua-mobile: ?0",
        "sec-ch-ua-platform: \"Windows\""
    ];

    $payload = "------WebKitFormBoundaryCdmQ3AUbNA5ZGilX\r\nContent-Disposition: form-data; name=\"endpoint\"\r\n\r\nquestion\r\n------WebKitFormBoundaryCdmQ3AUbNA5ZGilX--";

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, "https://qxcaptcha.fcm.org.co/api.php");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

    $response = curl_exec($ch);
    if ($response === false) {
        throw new Exception("Error obteniendo la question: " . curl_error($ch));
    }
    curl_close($ch);

    $responseData = json_decode($response, true);
    return $responseData['data']['question'];
}

/**
 * Función mejorada para determinar si una respuesta tiene información útil
 */
function tieneResultadosUtiles($respuestaData) {
    // Verifica si hay multas
    if (isset($respuestaData['multas']) && is_array($respuestaData['multas']) && !empty($respuestaData['multas'])) {
        return true;
    }
    
    // Verifica si hay resoluciones
    if (isset($respuestaData['resoluciones']) && is_array($respuestaData['resoluciones']) && !empty($respuestaData['resoluciones'])) {
        return true;
    }
    
    // Verifica si hay comparendos
    if (isset($respuestaData['comparendos']) && is_array($respuestaData['comparendos']) && !empty($respuestaData['comparendos'])) {
        return true;
    }
    
    return false;
}

/**
 * Función para procesar la respuesta de la API y corregir problemas con el JSON
 */
function procesarRespuestaApi($respuesta) {
    // Verificar si la respuesta es un JSON válido
    $respuestaData = json_decode($respuesta, true);
    
    // Si la respuesta ya es un JSON válido, solo la devolvemos
    if ($respuestaData !== null && json_last_error() === JSON_ERROR_NONE) {
        // Aplicamos sanitización a ciertos campos que puedan causar problemas
        if (isset($respuestaData['multas']) && is_array($respuestaData['multas'])) {
            foreach ($respuestaData['multas'] as &$multa) {
                if (isset($multa['proyeccion']) && is_array($multa['proyeccion'])) {
                    foreach ($multa['proyeccion'] as &$proyeccion) {
                        if (isset($proyeccion['instrucciones'])) {
                            // Sanitizamos el campo instrucciones
                            $proyeccion['instrucciones'] = preg_replace('/\r\n|\r|\n/', ' ', $proyeccion['instrucciones']);
                        }
                    }
                }
            }
        }
        
        // Codificamos nuevamente con opciones que evitan problemas
        return json_encode($respuestaData, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
    }
    
    // Si no es un JSON válido, intentamos repararlo
    
    // 1. Reemplazar saltos de línea que puedan causar problemas
    $respuestaLimpia = preg_replace('/\r\n|\r|\n/', ' ', $respuesta);
    
    // 2. Intentar decodificar nuevamente
    $respuestaData = json_decode($respuestaLimpia, true);
    
    if ($respuestaData !== null && json_last_error() === JSON_ERROR_NONE) {
        // Codificamos nuevamente con opciones que evitan problemas
        return json_encode($respuestaData, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
    }
    
    // 3. Si sigue fallando, aplicamos una sanitización más agresiva
    // Intentamos reparar errores comunes en JSON como comillas no escapadas
    $respuestaLimpia = preg_replace('/(["\]}])([,{]?)(\s*)(["\[{])/', '$1$2$3$4', $respuestaLimpia);
    $respuestaLimpia = preg_replace('/"([^"]*?)\\n([^"]*?)"/', '"$1 $2"', $respuestaLimpia);
    
    // 4. Último intento de decodificar
    $respuestaData = json_decode($respuestaLimpia, true);
    
    if ($respuestaData !== null && json_last_error() === JSON_ERROR_NONE) {
        // Codificamos nuevamente con opciones que evitan problemas
        return json_encode($respuestaData, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
    }
    
    // Si todo falla, devolvemos un mensaje de error en formato JSON
    return json_encode(["error" => "Error procesando la respuesta: " . json_last_error_msg()]);
}

/**
 * Función para realizar consulta al API del SIMIT
 * @param string $url URL del endpoint a consultar
 * @param array $payloadData Datos a enviar en la consulta
 * @param int $intentos Número de reintentos si falla
 * @return array Resultado de la consulta y los datos decodificados
 */
function consultarApi($url, $payloadData, $intentos = 2) {
    $resultado = [
        'success' => false,
        'respuesta' => null,
        'respuestaData' => null
    ];
    
    for ($i = 0; $i < $intentos; $i++) {
        // Obtener un nuevo captcha para cada intento
        try {
            $question = obtenerQuestion();
            $data = [
                "question" => $question,
                "time" => time() 
            ];
            
            $resultadoCaptcha = resolverCaptcha($data);
            
            // Actualizar el captcha en el payload
            $payloadData['reCaptchaDTO'] = [
                "response" => json_encode([$resultadoCaptcha['verify_array']]),
                "consumidor" => "1"
            ];
            
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($payloadData));
            curl_setopt($ch, CURLOPT_HTTPHEADER, [
                "Content-Type: application/json"
            ]);
            
            $respuesta = curl_exec($ch);
            curl_close($ch);
            
            if ($respuesta !== false) {
                $respuestaData = json_decode($respuesta, true);
                
                if ($respuestaData !== null && json_last_error() === JSON_ERROR_NONE) {
                    $resultado['success'] = true;
                    $resultado['respuesta'] = $respuesta;
                    $resultado['respuestaData'] = $respuestaData;
                    
                    // Si encontramos resultados útiles, terminar inmediatamente
                    if (tieneResultadosUtiles($respuestaData)) {
                        return $resultado;
                    }
                }
            }
            
            // Pequeña pausa entre intentos
            usleep(300000); // 300ms
        } catch (Exception $e) {
            // Registrar el error pero continuar con el siguiente intento
            error_log("Error en intento " . ($i + 1) . ": " . $e->getMessage());
        }
    }
    
    return $resultado;
}

function main() {
    try {
        header('Content-Type: application/json; charset=utf-8');
        
        $filtro = isset($_GET['filtro']) ? $_GET['filtro'] : null;

        if (!$filtro) {
            echo json_encode(["error" => "El parámetro 'filtro' es requerido."]);
            exit;
        }

        // Estrategia: Combinar todos los métodos de consulta y usar el que devuelve resultados
        $respuestasPositivas = [];
        
        // Determinar si es una placa o un documento
        $esPlaca = !is_numeric($filtro) && strlen($filtro) <= 7;
        
        if ($esPlaca) {
            // 1. Intentar distintos formatos de placa con el endpoint consulta
            $formatosPlaca = [
                strtoupper($filtro),                // PLACA (mayúsculas)
                strtolower($filtro),                // placa (minúsculas)
                ucfirst(strtolower($filtro)),       // Placa (primera mayúscula)
                preg_replace('/\s+/', '', $filtro)  // Sin espacios
            ];
            
            // Endpoint principal: consulta
            foreach ($formatosPlaca as $formatoPlaca) {
                $resultadoConsulta = consultarApi(
                    "https://consultasimit.fcm.org.co/simit/microservices/estado-cuenta-simit/estadocuenta/consulta",
                    ["filtro" => $formatoPlaca]
                );
                
                if ($resultadoConsulta['success'] && tieneResultadosUtiles($resultadoConsulta['respuestaData'])) {
                    $respuestasPositivas[] = $resultadoConsulta;
                }
            }
            
            // 2. Si no encontramos resultados positivos, probar consultaPorPlaca
            if (empty($respuestasPositivas)) {
                foreach ($formatosPlaca as $formatoPlaca) {
                    $resultadoConsultaPlaca = consultarApi(
                        "https://consultasimit.fcm.org.co/simit/microservices/estado-cuenta-simit/estadocuenta/consultaPorPlaca",
                        [
                            "placa" => $formatoPlaca,
                            "idTipoDocumento" => null,
                            "numeroDocumento" => null
                        ]
                    );
                    
                    if ($resultadoConsultaPlaca['success'] && tieneResultadosUtiles($resultadoConsultaPlaca['respuestaData'])) {
                        $respuestasPositivas[] = $resultadoConsultaPlaca;
                    }
                }
            }
            
            // 3. Probar consultaComparendo con las mismas variaciones
            if (empty($respuestasPositivas)) {
                foreach ($formatosPlaca as $formatoPlaca) {
                    $resultadoConsultaComparendo = consultarApi(
                        "https://consultasimit.fcm.org.co/simit/microservices/comparendos/comparendo/consultaComparendo",
                        [
                            "placa" => $formatoPlaca,
                            "idTipoDocumento" => null,
                            "numeroDocumento" => null
                        ]
                    );
                    
                    if ($resultadoConsultaComparendo['success'] && tieneResultadosUtiles($resultadoConsultaComparendo['respuestaData'])) {
                        $respuestasPositivas[] = $resultadoConsultaComparendo;
                    }
                }
            }
        } else {
            // Es un documento - primero intentar el método estándar
            $resultadoConsulta = consultarApi(
                "https://consultasimit.fcm.org.co/simit/microservices/estado-cuenta-simit/estadocuenta/consulta",
                ["filtro" => $filtro]
            );
            
            if ($resultadoConsulta['success']) {
                $respuestaData = $resultadoConsulta['respuestaData'];
                
                // Si ya tiene resultados, excelente
                if (tieneResultadosUtiles($respuestaData)) {
                    $respuestasPositivas[] = $resultadoConsulta;
                } else {
                    // Intentar consulta por infractor
                    $idTipoDocumento = 1; // Por defecto Cédula
                    
                    // Si hay personasMismoDocumento, encontrar el tipo de documento correcto
                    if (isset($respuestaData['personasMismoDocumento']) && is_array($respuestaData['personasMismoDocumento']) && !empty($respuestaData['personasMismoDocumento'])) {
                        foreach ($respuestaData['personasMismoDocumento'] as $persona) {
                            if (isset($persona['tipoDocumento']) && $persona['tipoDocumento'] === 'Cédula') {
                                $idTipoDocumento = $persona['idTipoDocumento'];
                                break;
                            }
                        }
                    }
                    
                    // Probar con consultaPorInfractor
                    $resultadoInfractor = consultarApi(
                        "https://consultasimit.fcm.org.co/simit/microservices/estado-cuenta-simit/estadocuenta/consultaPorInfractor",
                        [
                            "placa" => null,
                            "idTipoDocumento" => $idTipoDocumento,
                            "numeroDocumento" => $filtro
                        ]
                    );
                    
                    if ($resultadoInfractor['success'] && tieneResultadosUtiles($resultadoInfractor['respuestaData'])) {
                        $respuestasPositivas[] = $resultadoInfractor;
                    }
                    
                    // Probar también con distintos tipos de documento si aún no hay resultados
                    if (empty($respuestasPositivas)) {
                        $tiposDocumento = [1, 2, 3, 4, 5]; // Cédula, NIT, Pasaporte, etc.
                        
                        foreach ($tiposDocumento as $idTipo) {
                            if ($idTipo == $idTipoDocumento) continue; // Saltar el que ya probamos
                            
                            $resultadoTipoDoc = consultarApi(
                                "https://consultasimit.fcm.org.co/simit/microservices/estado-cuenta-simit/estadocuenta/consultaPorInfractor",
                                [
                                    "placa" => null,
                                    "idTipoDocumento" => $idTipo,
                                    "numeroDocumento" => $filtro
                                ]
                            );
                            
                            if ($resultadoTipoDoc['success'] && tieneResultadosUtiles($resultadoTipoDoc['respuestaData'])) {
                                $respuestasPositivas[] = $resultadoTipoDoc;
                                break; // Encontramos uno positivo, terminamos
                            }
                        }
                    }
                }
            }
        }
        
        // Procesar el resultado final
        if (!empty($respuestasPositivas)) {
            // Ordenar por cantidad de multas (más multas primero)
            usort($respuestasPositivas, function($a, $b) {
                $multasA = isset($a['respuestaData']['multas']) ? count($a['respuestaData']['multas']) : 0;
                $multasB = isset($b['respuestaData']['multas']) ? count($b['respuestaData']['multas']) : 0;
                return $multasB - $multasA;
            });
            
            // Devolver la respuesta con más multas
            echo procesarRespuestaApi($respuestasPositivas[0]['respuesta']);
            exit;
        }
        
        // Si llegamos aquí, no encontramos resultados positivos
        // Hacer una última consulta estándar y devolver lo que sea que encontremos
        $resultadoFinal = consultarApi(
            "https://consultasimit.fcm.org.co/simit/microservices/estado-cuenta-simit/estadocuenta/consulta",
            ["filtro" => $filtro]
        );
        
        if ($resultadoFinal['success']) {
            echo procesarRespuestaApi($resultadoFinal['respuesta']);
        } else {
            echo json_encode(["error" => "No se pudieron obtener resultados para el filtro proporcionado."]);
        }
        
    } catch (Exception $e) {
        echo json_encode(["error" => $e->getMessage()]);
    }
}

main();
?>