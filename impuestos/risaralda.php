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
       CURLOPT_URL => 'https://vehiculosrisaralda.com.co/backimpuestosweb//ConsultarEstadoCuenta/consultarDetalleFront',
       CURLOPT_RETURNTRANSFER => true,
       CURLOPT_POST => true,
       CURLOPT_POSTFIELDS => $jsonData,
       CURLOPT_SSL_VERIFYPEER => false,
       CURLOPT_SSL_VERIFYHOST => false,
       CURLOPT_HTTPHEADER => [
           'Host: vehiculosrisaralda.com.co',
           'Connection: keep-alive',
           'sec-ch-ua-platform: "Windows"',
           'User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36',
           'Accept: */*',
           'sec-ch-ua: "Not)A;Brand";v="8", "Chromium";v="138", "Google Chrome";v="138"',
           'Content-Type: application/json',
           'sec-ch-ua-mobile: ?0',
           'Origin: https://www.vehiculosrisaralda.com.co',
           'Sec-Fetch-Site: same-site',
           'Sec-Fetch-Mode: cors',
           'Sec-Fetch-Dest: empty',
           'Referer: https://www.vehiculosrisaralda.com.co/',
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
           'vehiculo' => [
               'placa' => $vehiculoRunt['placa'],
               'marca' => $vehiculoRunt['descripcionMarca'],
               'modelo' => $vehiculoRunt['modelo'],
               'linea' => $vehiculoRunt['descripcionLinea'],
               'clase' => $vehiculoRunt['descripcionClase'],
               'cilindraje' => $vehiculoRunt['cilindraje'],
               'combustible' => $vehiculoRunt['descripcionCombustible'],
               'carroceria' => $vehiculoRunt['descripcionCarroceria'],
               'estado' => $vehiculoRunt['estadoVehiculo']
           ],
           'propietario' => [],
           'pagos' => []
       ]
   ];
   
   if (!empty($vehiculoRunt['listaPropietariosActuales'])) {
       $propietario = $vehiculoRunt['listaPropietariosActuales'][0];
       $resultado['datos']['propietario'] = [
           'identificacion' => $propietario['identificacion'],
           'nombre' => trim($propietario['nombre1'] . ' ' . $propietario['nombre2']),
           'apellidos' => trim($propietario['apellido1'] . ' ' . $propietario['apellido2']),
           'nombre_completo' => $propietario['nombreCompletoRunt'],
           'direccion' => $propietario['direccion'],
           'telefono' => $propietario['telefono'],
           'celular' => $propietario['celular'],
           'ciudad' => $propietario['tipoCiudad']['nombreCiudad']
       ];
   }
   
   if (!empty($listaDetallePago)) {
       foreach ($listaDetallePago as $pago) {
           $pagoFormateado = [
               'vigencia' => $pago['vigencia'],
               'formulario' => $pago['formularioLiquidacion'],
               'fecha_liquidacion' => $pago['fechaLiquidacion'],
               'fecha_pago' => $pago['fechaPago'],
               'avaluo' => number_format($pago['avaluo'], 0, ',', '.'),
               'impuesto' => number_format($pago['impuesto'], 0, ',', '.'),
               'sancion' => number_format($pago['sancion'], 0, ',', '.'),
               'descuento' => number_format($pago['descuento'], 0, ',', '.'),
               'intereses_mora' => number_format($pago['interesMora'], 0, ',', '.'),
               'otros_pagos' => number_format($pago['otrosPago'], 0, ',', '.'),
               'total_pagado' => number_format($pago['totalPago'], 0, ',', '.'),
               'canal_pago' => $pago['canalPago'],
               'banco' => $pago['nombreBanco']
           ];
           $resultado['datos']['pagos'][] = $pagoFormateado;
       }
       
       if (!empty($resultado['datos']['pagos'])) {
           $ultimoPago = end($resultado['datos']['pagos']);
           $resultado['datos']['ultimo_pago'] = [
               'ultimo_pago_realizado' => $ultimoPago['vigencia'],
               'fecha_pago' => $ultimoPago['fecha_pago'],
               'valor_pagado' => '$ ' . $ultimoPago['total_pagado'] . ' COP'
           ];
       }
   }
   
   if (empty($resultado['datos']['pagos'])) {
       $resultado['datos']['mensaje'] = 'No se encontraron pagos para esta placa';
   }
   
   echo json_encode($resultado, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
   
} catch (Exception $e) {
   echo json_encode([
       'error' => true,
       'mensaje' => $e->getMessage()
   ], JSON_UNESCAPED_UNICODE);
}
?>