<?php
header('Content-Type: application/json; charset=utf-8');

$placa = isset($_GET['placa']) ? strtoupper(trim($_GET['placa'])) : '';

if (empty($placa)) {
   echo json_encode([
       'error' => true,
       'mensaje' => 'Falta parámetro requerido: placa'
   ], JSON_UNESCAPED_UNICODE);
   exit;
}

try {
   $ch = curl_init();
   
   curl_setopt_array($ch, [
       CURLOPT_URL => "https://vehiculos.caldas.gov.co/api-rest-caldas/index.php/liquidarVehiculo/{$placa}/1",
       CURLOPT_RETURNTRANSFER => true,
       CURLOPT_SSL_VERIFYPEER => false,
       CURLOPT_SSL_VERIFYHOST => false,
       CURLOPT_TIMEOUT => 30,
       CURLOPT_HTTPHEADER => [
           'User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36',
           'Accept: application/json, text/plain, */*',
           'Accept-Language: es-ES,es;q=0.9',
           'Connection: keep-alive'
       ]
   ]);
   
   $response = curl_exec($ch);
   $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
   $error = curl_error($ch);
   curl_close($ch);
   
   if ($error) {
       throw new Exception('Error cURL: ' . $error);
   }
   
   if ($httpCode !== 200) {
       throw new Exception('Error HTTP: ' . $httpCode);
   }
   
   $data = json_decode($response, true);
   
   if (!$data || $data['status'] !== 'SUCCESS') {
       throw new Exception('No se encontraron datos para la placa proporcionada');
   }
   
   $resultado = [
       'error' => false,
       'placa' => $placa,
       'vehiculo' => $data['vehiculo'],
       'pagos' => []
   ];
   
   if (isset($data['pagos']) && is_array($data['pagos'])) {
       foreach ($data['pagos'] as $pago) {
           $pagoFormateado = [
               'periodo' => $pago['peri'],
               'formulario' => $pago['form'],
               'fecha_pago' => $pago['fecp'],
               'avaluo' => str_replace(' ', '', $pago['aval']),
               'impuesto' => str_replace(' ', '', $pago['impu']),
               'sancion' => str_replace(' ', '', $pago['sanc']),
               'descuento' => str_replace(' ', '', $pago['dess']),
               'intereses' => str_replace(' ', '', $pago['intm']),
               'total_pagado' => str_replace(' ', '', $pago['topg']),
               'propietario' => [
                   'documento' => $pago['docu'],
                   'nombre' => trim(($pago['nomb'] ?? '') . ' ' . ($pago['apel'] ?? '')),
                   'telefono' => $pago['tele'],
                   'direccion' => $pago['dire'],
                   'email' => $pago['emai'],
                   'municipio' => $pago['muni']
               ],
               'tipo_pago' => $pago['tipa'],
               'estado_fiscal' => $pago['fisc']
           ];
           
           $resultado['pagos'][] = $pagoFormateado;
       }
   }
   
   if (empty($resultado['pagos'])) {
       $resultado['mensaje'] = 'No se encontraron pagos para esta placa';
   }
   
   echo json_encode($resultado, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
   
} catch (Exception $e) {
   echo json_encode([
       'error' => true,
       'mensaje' => $e->getMessage()
   ], JSON_UNESCAPED_UNICODE);
}
?>