<?php
// Obtener parámetros GET para departamento y ciudad
$departamento = isset($_GET['departamento']) ? $_GET['departamento'] : '16';
$ciudad = isset($_GET['ciudad']) ? $_GET['ciudad'] : '687';

// Inicializar sesión cURL para la petición GET inicial
$ch = curl_init();

// Configurar URL y cabeceras para la petición GET
curl_setopt($ch, CURLOPT_URL, "https://aplicaciones.supertransporte.gov.co/OrganismosApoyo/Tarifas_CDA_Busqueda_Usuario/");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HEADER, false);
curl_setopt($ch, CURLOPT_ENCODING, ""); // Manejar automáticamente la compresión
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    "User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/80.0.3987.149 Safari/537.36",
    "Pragma: no-cache",
    "Accept: */*"
]);

// Crear un archivo de cookies para almacenar y pasar cookies entre peticiones
$cookieJar = tempnam(sys_get_temp_dir(), "cookie");
curl_setopt($ch, CURLOPT_COOKIEJAR, $cookieJar);
curl_setopt($ch, CURLOPT_COOKIEFILE, $cookieJar);

// Ejecutar la petición GET
$response = curl_exec($ch);

// Verificar errores
if(curl_errno($ch)) {
    echo 'Error en petición GET: ' . curl_error($ch);
    exit;
}

// Parsear script_case_init de la respuesta
preg_match('/<input type="hidden" name="script_case_init" value="(.*?)">/', $response, $matches);
$script_case_init = $matches[1] ?? '';

// Parsear script_case_session de la respuesta
preg_match('/<input type="hidden" name="script_case_session" value="(.*?)">/', $response, $matches);
$script_case_session = $matches[1] ?? '';

// Parsear csrf_token de la respuesta
preg_match('/<input type="hidden" name="csrf_token" value="(.*?)" \/>/', $response, $matches);
$csrf_token = $matches[1] ?? '';

// Inicializar la petición POST
curl_setopt($ch, CURLOPT_URL, "https://aplicaciones.supertransporte.gov.co/OrganismosApoyo/Tarifas_CDA_Usuario/");
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_ENCODING, ""); // Manejar automáticamente la compresión
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    "Accept: text/html,application/xhtml+xml,application/xml;q=0.9,image/avif,image/webp,image/apng,*/*;q=0.8,application/signed-exchange;v=b3;q=0.7",
    "Accept-Encoding: gzip, deflate, br, zstd",
    "Accept-Language: es-ES,es;q=0.9",
    "Cache-Control: max-age=0",
    "Connection: keep-alive",
    "Content-Type: application/x-www-form-urlencoded",
    "Host: aplicaciones.supertransporte.gov.co",
    "Origin: https://aplicaciones.supertransporte.gov.co",
    "Referer: https://aplicaciones.supertransporte.gov.co/OrganismosApoyo/Tarifas_CDA_Busqueda_Usuario/",
    "Sec-Fetch-Dest: document",
    "Sec-Fetch-Mode: navigate",
    "Sec-Fetch-Site: same-origin",
    "Upgrade-Insecure-Requests: 1",
    "User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/137.0.0.0 Safari/537.36",
    "sec-ch-ua: \"Google Chrome\";v=\"137\", \"Chromium\";v=\"137\", \"Not/A)Brand\";v=\"24\"",
    "sec-ch-ua-mobile: ?0",
    "sec-ch-ua-platform: \"Windows\""
]);

// Preparar los datos POST
$postData = http_build_query([
    'nm_form_submit' => '1',
    'nmgp_idioma_novo' => '',
    'nmgp_schema_f' => '',
    'nmgp_url_saida' => '',
    'bok' => 'OK',
    'nmgp_opcao' => 'alterar',
    'nmgp_ancora' => '',
    'nmgp_num_form' => '',
    'nmgp_parms' => '',
    'script_case_init' => $script_case_init,
    'script_case_session' => $script_case_session,
    'NM_cancel_return_new' => '',
    'csrf_token' => $csrf_token,
    '_sc_force_mobile' => '',
    'departamento' => $departamento,
    'ciudad' => $ciudad,
    'tipovehiculo' => 'MOTOCICLETA',
    'servicio' => '',
    'antiguedad_vehiculo' => '2',
    'electrico' => 'No'
]);

curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

// Ejecutar la petición POST y obtener la respuesta
$finalResponse = curl_exec($ch);

// Verificar errores
if(curl_errno($ch)) {
    echo 'Error en petición POST: ' . curl_error($ch);
    exit;
}

// Función para extraer los datos de la tabla usando el DOM
function extractTableData($html) {
    $data = [];
    
    // Buscar todas las filas de la tabla que contengan datos (clases scGridFieldOdd y scGridFieldEven)
    preg_match_all('/<TR\s+class="scGridField(Odd|Even)".*?>(.*?)<\/TR>/is', $html, $rows);
    
    if (empty($rows[2])) {
        return $data;
    }
    
    foreach ($rows[2] as $row) {
        // Extraer todas las celdas TD de la fila
        preg_match_all('/<TD.*?<span id="id_sc_field_(.*?)_(\d+)">(.*?)<\/span><\/TD>/is', $row, $cells);
        
        if (!empty($cells[1]) && !empty($cells[3])) {
            $rowData = [];
            
            // Reconstruir el array de datos con los campos encontrados
            for ($i = 0; $i < count($cells[1]); $i++) {
                $fieldName = strtoupper($cells[1][$i]);
                $fieldValue = trim(strip_tags($cells[3][$i]));
                $rowData[$fieldName] = $fieldValue;
            }
            
            // Solo agregar filas que tengan datos
            if (!empty($rowData)) {
                $data[] = $rowData;
            }
        }
    }
    
    return $data;
}

// Verificar cuántos resultados se están mostrando
preg_match('/\[(\d+) a (\d+) de (\d+)\]/', $finalResponse, $paginationMatches);
$totalResults = isset($paginationMatches[3]) ? (int)$paginationMatches[3] : 0;
$showing = isset($paginationMatches[2]) ? (int)$paginationMatches[2] : 0;

// Extraer datos de la primera respuesta
$results = extractTableData($finalResponse);

// Si hay más resultados disponibles, intentar obtener todos
if ($showing < $totalResults) {
    // Hacer una nueva petición para obtener todos los resultados
    curl_setopt($ch, CURLOPT_URL, "https://aplicaciones.supertransporte.gov.co/OrganismosApoyo/Tarifas_CDA_Usuario/index.php");
    
    // Cambiar el número de líneas a mostrar
    $morePostData = http_build_query([
        'script_case_init' => $script_case_init,
        'script_case_session' => $script_case_session,
        'nmgp_opcao' => 'recarga',
        'nmgp_quant_linhas' => $totalResults, // Solicitar todos los resultados
        'sc_ifr_height' => '80%'
    ]);
    
    curl_setopt($ch, CURLOPT_POSTFIELDS, $morePostData);
    $allResponse = curl_exec($ch);
    
    if (!curl_errno($ch)) {
        $moreResults = extractTableData($allResponse);
        if (count($moreResults) > 0) {
            $results = $moreResults; // Usar los nuevos resultados si hay más
        }
    }
}

// Cerrar sesión cURL y limpiar
curl_close($ch);
unlink($cookieJar);

// Verificar si hay resultados
$total = count($results);
if ($total == 0) {
    // Si no se encontraron resultados con el enfoque principal, intentar un método alternativo de extracción
    preg_match_all('/<TR\s+class="scGridField(Odd|Even)".*?>(.*?)<\/TR>/is', $finalResponse, $rows);
    
    if (!empty($rows[2])) {
        foreach ($rows[2] as $row) {
            // Extraer los valores directamente de los TD
            preg_match_all('/<TD.*?>(.*?)<\/TD>/is', $row, $cells);
            
            if (!empty($cells[1]) && count($cells[1]) >= 7) {
                // El primer TD es generalmente un TD vacío de control, lo ignoramos
                $cleanCells = [];
                foreach ($cells[1] as $cell) {
                    // Intentar extraer el valor dentro de un span
                    if (preg_match('/<span.*?>(.*?)<\/span>/is', $cell, $spanMatch)) {
                        $cleanCells[] = trim(strip_tags($spanMatch[1]));
                    } else {
                        $cleanCells[] = trim(strip_tags($cell));
                    }
                }
                
                // Quitar el primer elemento si es un TD vacío o de control
                if (empty($cleanCells[0])) {
                    array_shift($cleanCells);
                }
                
                // Solo usar las celdas si tenemos al menos 6 (los campos que esperamos)
                if (count($cleanCells) >= 6) {
                    $results[] = [
                        'ID_RUNT' => $cleanCells[0],
                        'NOMBRE_CDA' => $cleanCells[1],
                        'NIT' => $cleanCells[2],
                        'CIUDAD' => $cleanCells[3],
                        'DEPARTAMENTO' => $cleanCells[4],
                        'DIRECCION' => $cleanCells[5],
                        'TOTAL' => $cleanCells[6]
                    ];
                }
            }
        }
    }
}

// Establecer cabecera para JSON
header('Content-Type: application/json; charset=utf-8');

// Devolver los resultados como JSON formateado
echo json_encode([
    'total' => count($results),
    'data' => $results
], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
?>