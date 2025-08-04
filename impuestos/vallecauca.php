<?php
header('Content-Type: application/json; charset=utf-8');

$placa = isset($_GET['placa']) ? strtoupper(trim($_GET['placa'])) : '';
$identificacion = isset($_GET['identificacion']) ? trim($_GET['identificacion']) : '';

if (empty($placa) || empty($identificacion)) {
   echo json_encode([
       'error' => true,
       'mensaje' => 'Faltan parámetros requeridos: placa y identificacion'
   ], JSON_UNESCAPED_UNICODE);
   exit;
}

try {
   $ch = curl_init();
   
   $jsonData = json_encode([
       'placa' => $placa,
       'idTipoIdentificacion' => '1',
       'identificacion' => $identificacion,
       'idConfigConsumoQloudsi' => 14
   ]);
   
   curl_setopt_array($ch, [
       CURLOPT_URL => 'https://www.vehiculosvalle.com.co/backimpuestosweb//ConsultarEstadoCuenta/consultarDetalleFront',
       CURLOPT_RETURNTRANSFER => true,
       CURLOPT_POST => true,
       CURLOPT_POSTFIELDS => $jsonData,
       CURLOPT_SSL_VERIFYPEER => false,
       CURLOPT_SSL_VERIFYHOST => false,
       CURLOPT_HTTPHEADER => [
           'Host: www.vehiculosvalle.com.co',
           'Connection: keep-alive',
           'sec-ch-ua-platform: "Windows"',
           'X-Requested-With: XMLHttpRequest',
           'User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36',
           'Accept: */*',
           'sec-ch-ua: "Not)A;Brand";v="8", "Chromium";v="138", "Google Chrome";v="138"',
           'Content-Type: application/json',
           'sec-ch-ua-mobile: ?0',
           'Origin: https://www.vehiculosvalle.com.co',
           'Sec-Fetch-Site: same-origin',
           'Sec-Fetch-Mode: cors',
           'Sec-Fetch-Dest: empty',
           'Referer: https://www.vehiculosvalle.com.co/',
           'Accept-Language: es,en-US;q=0.9,en;q=0.8',
           'Accept-Encoding: gzip, deflate'
       ]
   ]);
   
   $response = curl_exec($ch);
   
   if (curl_error($ch)) {
       throw new Exception('Error cURL: ' . curl_error($ch));
   }
   
   $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
   curl_close($ch);
   
   if ($httpCode !== 200) {
       throw new Exception('Error HTTP: ' . $httpCode);
   }
   
   $data = json_decode($response, true);
   
   if (!$data || !isset($data['vehiculoRunt'])) {
       throw new Exception('No se encontraron datos para la placa y identificación proporcionadas');
   }
   
   $vehiculoRunt = $data['vehiculoRunt'];
   $listaDetallePago = isset($data['listaDetallePago']) ? $data['listaDetallePago'] : [];
   
   $resultado = [
       'error' => false,
       'placa' => $placa,
       'identificacion' => $identificacion,
       'datos' => [
           'periodo_certificacion' => date('Y'),
           'fecha_consulta' => date('d/m/Y'),
           'placa' => $vehiculoRunt['placa'],
           'marca' => $vehiculoRunt['descripcionMarca']
       ]
   ];
   
   if (!empty($listaDetallePago)) {
       $ultimoPago = end($listaDetallePago);
       $resultado['datos']['ultimo_pago'] = [
           'ultimo_pago_realizado' => $ultimoPago['vigencia'],
           'fecha_pago' => $ultimoPago['fechaPago'],
           'valor_pagado' => '$ ' . number_format($ultimoPago['totalPago'], 0, ',', '.') . ' COP'
       ];
   } else {
       $resultado['datos']['ultimo_pago'] = [
           'ultimo_pago_realizado' => 'No disponible',
           'fecha_pago' => 'No disponible',
           'valor_pagado' => 'No disponible'
       ];
   }
   
   echo json_encode($resultado, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
   
} catch (Exception $e) {
   echo json_encode([
       'error' => true,
       'mensaje' => $e->getMessage()
   ], JSON_UNESCAPED_UNICODE);
}
?>