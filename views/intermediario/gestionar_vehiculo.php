<?php
//intermediario/gestionar_cotizacion.php
?>

<?php $c = $datos['cotizacion']; ?>

<div class="min-h-screen bg-gradient-to-br from-slate-50 to-slate-100 py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <nav class="mb-6">
            <a href="<?php echo BASE_URL; ?>intermediario/cotizaciones" class="inline-flex items-center text-sm text-blue-600 hover:text-blue-800 font-medium transition-colors">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                Volver a Mis Cotizaciones
            </a>
        </nav>

        <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-6 mb-8">
            <div class="flex items-center justify-between">
                <div class="flex items-center space-x-6">
                    <div class="w-20 h-20 bg-gradient-to-br 
                        <?php echo $c['producto'] === 'SOAT' ? 'from-blue-500 to-blue-600' : 'from-green-500 to-green-600'; ?> 
                        rounded-xl flex items-center justify-center text-white shadow-lg">
                        <?php if ($c['producto'] === 'SOAT'): ?>
                            <svg class="w-10 h-10" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M20 4H4c-1.11 0-1.99.89-1.99 2L2 18c0 1.11.89 2 2 2h16c1.11 0 2-.89 2-2V6c0-1.11-.89-2-2-2zm0 14H4v-6h16v6zm0-10H4V6h16v2z"/>
                            </svg>
                        <?php else: ?>
                            <svg class="w-10 h-10" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M19.77 7.23l.01-.01-3.72-3.72L15 4.56l2.11 2.11c-.94.36-1.61 1.26-1.61 2.33 0 1.38 1.12 2.5 2.5 2.5.36 0 .69-.08 1-.21v7.21c0 .55-.45 1-1 1s-1-.45-1-1V14c0-1.1-.9-2-2-2h-1V5c0-1.1-.9-2-2-2H6c-1.1 0-2 .9-2 2v16h10v-7.5h1.5v5c0 1.38 1.12 2.5 2.5 2.5s2.5-1.12 2.5-2.5V9c0-.69-.28-1.32-.73-1.77zM18 10c-.55 0-1-.45-1-1s.45-1 1-1 1 .45 1 1-.45 1-1 1zM8 18v-4.5H6L10 6v5h2l-4 7z"/>
                            </svg>
                        <?php endif; ?>
                    </div>
                    <div>
                        <h1 class="text-3xl font-bold text-slate-900 mb-1">Cotización #<?php echo htmlspecialchars($c['id']); ?></h1>
                        <p class="text-slate-600 text-lg"><?php echo htmlspecialchars($c['producto'] . ' - Placa: ' . $c['placa']); ?></p>
                    </div>
                </div>
                <div class="flex items-center space-x-3">
                    <?php if ($c['estado'] === 'pendiente'): ?>
                        <button type="button" id="enviarCotizacionBtn" class="inline-flex items-center px-4 py-2.5 bg-blue-600 text-white font-medium rounded-lg hover:bg-blue-700 focus:ring-4 focus:ring-blue-200 transition-all duration-200">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                            </svg>
                            Enviar al Cliente
                        </button>
                    <?php endif; ?>
                    <button id="eliminarCotizacionBtn" class="inline-flex items-center px-4 py-2.5 bg-red-600 text-white font-medium rounded-lg hover:bg-red-700 focus:ring-4 focus:ring-red-200 transition-all duration-200">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                        </svg>
                        Eliminar Cotización
                    </button>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 xl:grid-cols-4 gap-8">
            <div class="xl:col-span-3 space-y-8">
                <div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden">
                    <div class="px-6 py-4 border-b border-slate-200 bg-slate-50">
                        <h2 class="text-xl font-semibold text-slate-900 flex items-center">
                            <svg class="w-5 h-5 mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                            </svg>
                            Información del Cliente
                        </h2>
                    </div>
                    <div class="p-6">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                            <div>
                                <h3 class="text-sm font-medium text-slate-500 mb-3 uppercase tracking-wider">Datos Personales</h3>
                                <dl class="space-y-3">
                                    <div>
                                        <dt class="text-sm text-slate-600">Nombre Completo</dt>
                                        <dd class="font-medium text-slate-900"><?php echo htmlspecialchars($c['nombre_cliente']); ?></dd>
                                    </div>
                                    <div>
                                        <dt class="text-sm text-slate-600">Correo Electrónico</dt>
                                        <dd class="font-medium text-slate-900"><?php echo htmlspecialchars($c['email_cliente']); ?></dd>
                                    </div>
                                    <div>
                                        <dt class="text-sm text-slate-600">Teléfono</dt>
                                        <dd class="font-medium text-slate-900"><?php echo htmlspecialchars($c['telefono_cliente']); ?></dd>
                                    </div>
                                </dl>
                            </div>
                            <div>
                                <h3 class="text-sm font-medium text-slate-500 mb-3 uppercase tracking-wider">Historial</h3>
                                <dl class="space-y-3">
                                    <div>
                                        <dt class="text-sm text-slate-600">Cotizaciones Previas</dt>
                                        <dd class="font-medium text-slate-900">
                                            <?php echo isset($datos['cotizaciones_previas']) ? count($datos['cotizaciones_previas']) : '0'; ?>
                                        </dd>
                                    </div>
                                    <div>
                                        <dt class="text-sm text-slate-600">Cliente Desde</dt>
                                        <dd class="font-medium text-slate-900">
                                            <?php echo isset($datos['cliente_desde']) ? date('d/m/Y', strtotime($datos['cliente_desde'])) : 'Nuevo cliente'; ?>
                                        </dd>
                                    </div>
                                    <div>
                                        <dt class="text-sm text-slate-600">Último Contacto</dt>
                                        <dd class="font-medium text-slate-900">
                                            <?php echo isset($datos['ultimo_contacto']) ? date('d/m/Y', strtotime($datos['ultimo_contacto'])) : 'N/A'; ?>
                                        </dd>
                                    </div>
                                </dl>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden">
                    <div class="px-6 py-4 border-b border-slate-200 bg-slate-50">
                        <h2 class="text-xl font-semibold text-slate-900 flex items-center">
                            <svg class="w-5 h-5 mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                            Detalles de la Cotización
                        </h2>
                    </div>
                    <div class="p-6">
                        <div class="overflow-x-auto">
                            <table class="w-full">
                                <thead>
                                    <tr class="border-b border-slate-200">
                                        <th class="text-left py-3 px-4 font-semibold text-slate-700">Producto</th>
                                        <th class="text-left py-3 px-4 font-semibold text-slate-700">Placa</th>
                                        <th class="text-left py-3 px-4 font-semibold text-slate-700">Vehículo</th>
                                        <th class="text-right py-3 px-4 font-semibold text-slate-700">Valor</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr class="hover:bg-slate-50 transition-colors">
                                        <td class="py-4 px-4 font-medium text-slate-900">
                                            <div class="flex items-center">
                                                <span class="inline-block w-8 h-8 rounded-full mr-3
                                                    <?php echo $c['producto'] === 'SOAT' ? 'bg-blue-100 text-blue-600' : 'bg-green-100 text-green-600'; ?> 
                                                    flex items-center justify-center">
                                                    <?php if ($c['producto'] === 'SOAT'): ?>
                                                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                                            <path fill-rule="evenodd" d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4zm2 6a1 1 0 011-1h6a1 1 0 110 2H7a1 1 0 01-1-1zm1 3a1 1 0 100 2h6a1 1 0 100-2H7z" clip-rule="evenodd"></path>
                                                        </svg>
                                                    <?php else: ?>
                                                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-14a3 3 0 00-3 3v2H7a1 1 0 000 2h1v1a1 1 0 01-1 1 1 1 0 100 2h6a1 1 0 100-2H9.83c.11-.313.17-.65.17-1v-1h1a1 1 0 100-2h-1V7a1 1 0 112 0 1 1 0 102 0 3 3 0 00-3-3z" clip-rule="evenodd"></path>
                                                        </svg>
                                                    <?php endif; ?>
                                                </span>
                                                <?php echo htmlspecialchars($c['producto']); ?>
                                            </div>
                                        </td>
                                        <td class="py-4 px-4 text-slate-700"><?php echo htmlspecialchars($c['placa']); ?></td>
                                        <td class="py-4 px-4 text-slate-700">
                                            <?php echo htmlspecialchars($c['tipo_vehiculo'] . ' ' . $c['modelo'] . ' (' . $c['cilindraje'] . 'cc)'); ?>
                                        </td>
                                        <td class="py-4 px-4 text-right font-mono font-semibold text-slate-900">
                                            $<?php echo number_format($c['valor'], 0, ',', '.'); ?>
                                        </td>
                                    </tr>
                                </tbody>
                                <tfoot>
                                    <tr class="border-t-2 border-slate-300 bg-slate-50">
                                        <td class="py-4 px-4 font-bold text-slate-900" colspan="3">Total</td>
                                        <td class="py-4 px-4 text-right font-mono font-bold text-slate-900 text-lg">
                                            $<?php echo number_format($c['valor'], 0, ',', '.'); ?>
                                        </td>
                                    </tr>
                                    <tr class="border-t border-slate-200 bg-blue-50">
                                        <td class="py-4 px-4 font-bold text-blue-700" colspan="3">Tu Comisión</td>
                                        <td class="py-4 px-4 text-right font-mono font-bold text-blue-700">
                                            $<?php echo number_format($c['valor'] * ($intermediario['porcentaje_comision'] / 100), 0, ',', '.'); ?> 
                                            <span class="text-xs text-blue-600">(<?php echo $intermediario['porcentaje_comision']; ?>%)</span>
                                        </td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden">
                    <div class="px-6 py-4 border-b border-slate-200 bg-slate-50">
                        <h2 class="text-xl font-semibold text-slate-900 flex items-center">
                            <svg class="w-5 h-5 mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            Historial de Actividad
                        </h2>
                    </div>
                    <div class="p-6">
                        <?php if(empty($datos['historial_actividad'])): ?>
                            <div class="text-center py-8">
                                <div class="w-16 h-16 bg-blue-100 rounded-full flex items-center justify-center mx-auto mb-4">
                                    <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                </div>
                                <h3 class="text-lg font-semibold text-slate-900 mb-2">Sin actividad reciente</h3>
                                <p class="text-slate-600">No hay registros de actividad para esta cotización.</p>
                            </div>
                        <?php else: ?>
                            <div class="relative">
                                <div class="absolute left-5 top-0 bottom-0 w-0.5 bg-slate-200"></div>
                                <ul class="space-y-6 relative">
                                    <?php foreach($datos['historial_actividad'] as $actividad): ?>
                                        <li class="ml-8">
                                            <div class="absolute -left-3 mt-1.5">
                                                <div class="w-6 h-6 rounded-full border-2 border-white bg-blue-500 flex items-center justify-center shadow-md">
                                                    <?php if($actividad['tipo'] === 'creacion'): ?>
                                                        <svg class="w-3 h-3 text-white" fill="currentColor" viewBox="0 0 20 20">
                                                            <path fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" clip-rule="evenodd"></path>
                                                        </svg>
                                                    <?php elseif($actividad['tipo'] === 'envio'): ?>
                                                        <svg class="w-3 h-3 text-white" fill="currentColor" viewBox="0 0 20 20">
                                                            <path d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z"></path>
                                                            <path d="M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z"></path>
                                                        </svg>
                                                    <?php elseif($actividad['tipo'] === 'aprobacion'): ?>
                                                        <svg class="w-3 h-3 text-white" fill="currentColor" viewBox="0 0 20 20">
                                                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                                        </svg>
                                                    <?php elseif($actividad['tipo'] === 'rechazo'): ?>
                                                        <svg class="w-3 h-3 text-white" fill="currentColor" viewBox="0 0 20 20">
                                                            <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                                                        </svg>
                                                    <?php endif; ?>
                                                </div>
                                            </div>
                                            <div class="bg-white rounded-lg border border-slate-200 shadow-sm p-4">
                                                <div class="flex items-start justify-between">
                                                    <h3 class="text-base font-semibold text-slate-900"><?php echo htmlspecialchars($actividad['descripcion']); ?></h3>
                                                    <span class="text-xs text-slate-500"><?php echo date('d/m/Y H:i', strtotime($actividad['fecha'])); ?></span>
                                                </div>
                                                <?php if(!empty($actividad['detalle'])): ?>
                                                    <p class="mt-2 text-sm text-slate-600"><?php echo htmlspecialchars($actividad['detalle']); ?></p>
                                                <?php endif; ?>
                                            </div>
                                        </li>
                                    <?php endforeach; ?>
                                </ul>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

            <div class="xl:col-span-1">
                <div class="bg-white rounded-xl shadow-sm border border-slate-200 sticky top-8">
                    <div class="px-6 py-4 border-b border-slate-200 bg-slate-50">
                        <h2 class="text-xl font-semibold text-slate-900 flex items-center">
                            <svg class="w-5 h-5 mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            Estado de Cotización
                        </h2>
                    </div>
                    <div class="p-6">
                        <div class="mb-6">
                            <div class="flex justify-between items-center mb-2">
                                <h3 class="text-sm font-semibold text-slate-900">Estado Actual</h3>
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                    <?php 
                                    switch($c['estado']) {
                                        case 'pendiente':
                                            echo 'bg-yellow-100 text-yellow-800';
                                            break;
                                        case 'aprobada':
                                            echo 'bg-emerald-100 text-emerald-800';
                                            break;
                                        case 'rechazada':
                                            echo 'bg-red-100 text-red-800';
                                            break;
                                        default:
                                            echo 'bg-slate-100 text-slate-800';
                                    }
                                    ?>">
                                    <?php 
                                    switch($c['estado']) {
                                        case 'pendiente':
                                            echo 'Pendiente';
                                            break;
                                        case 'aprobada':
                                            echo 'Aprobada';
                                            break;
                                        case 'rechazada':
                                            echo 'Rechazada';
                                            break;
                                        default:
                                            echo ucfirst($c['estado']);
                                    }
                                    ?>
                                </span>
                            </div>
                            
                            <?php if($c['estado'] === 'pendiente'): ?>
                                <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-3 text-yellow-700 text-sm">
                                    <div class="flex items-center">
                                        <svg class="w-4 h-4 mr-2 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                                        </svg>
                                        <span>Esta cotización está pendiente de aprobación por el cliente.</span>
                                    </div>
                                </div>
                            <?php elseif($c['estado'] === 'aprobada'): ?>
                                <div class="bg-emerald-50 border border-emerald-200 rounded-lg p-3 text-emerald-700 text-sm">
                                    <div class="flex items-center">
                                        <svg class="w-4 h-4 mr-2 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                        </svg>
                                        <span>Esta cotización ha sido aprobada por el cliente.</span>
                                    </div>
                                </div>
                            <?php elseif($c['estado'] === 'rechazada'): ?>
                                <div class="bg-red-50 border border-red-200 rounded-lg p-3 text-red-700 text-sm">
                                    <div class="flex items-center">
                                        <svg class="w-4 h-4 mr-2 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path>
                                        </svg>
                                        <span>Esta cotización ha sido rechazada por el cliente.</span>
                                    </div>
                                </div>
                            <?php endif; ?>
                        </div>
                        
                        <dl class="space-y-4">
                            <div class="flex justify-between py-2 border-b border-slate-100">
                                <dt class="text-sm text-slate-600">Fecha de Creación</dt>
                                <dd class="text-sm font-medium text-slate-900"><?php echo date('d/m/Y H:i', strtotime($c['fecha_creacion'])); ?></dd>
                            </div>
                            <div class="flex justify-between py-2 border-b border-slate-100">
                                <dt class="text-sm text-slate-600">Fecha de Vencimiento</dt>
                                <dd class="text-sm font-medium 
                                    <?php 
                                    $fechaVenc = new DateTime($c['fecha_vencimiento']);
                                    $hoy = new DateTime();
                                    $diff = $fechaVenc->diff($hoy);
                                    
                                    if ($hoy > $fechaVenc) {
                                        echo 'text-red-600';
                                    } elseif ($diff->days <= 2) {
                                        echo 'text-amber-600';
                                    } else {
                                        echo 'text-slate-900';
                                    }
                                    ?>">
                                    <?php echo date('d/m/Y H:i', strtotime($c['fecha_vencimiento'])); ?>
                                </dd>
                            </div>
                           <?php if($c['estado'] === 'aprobada'): ?>
                                <div class="flex justify-between py-2 border-b border-slate-100">
                                    <dt class="text-sm text-slate-600">Fecha de Aprobación</dt>
                                    <dd class="text-sm font-medium text-emerald-600">
                                        <?php echo isset($datos['fecha_aprobacion']) ? date('d/m/Y H:i', strtotime($datos['fecha_aprobacion'])) : 'N/A'; ?>
                                    </dd>
                                </div>
                                <div class="flex justify-between py-2 border-b border-slate-100">
                                    <dt class="text-sm text-slate-600">Comisión Acreditada</dt>
                                    <dd class="text-sm font-medium text-emerald-600">
                                        $<?php echo number_format($c['valor'] * ($intermediario['porcentaje_comision'] / 100), 0, ',', '.'); ?>
                                    </dd>
                                </div>
                            <?php endif; ?>
                            
                            <?php if($c['estado'] === 'rechazada'): ?>
                                <div class="flex justify-between py-2 border-b border-slate-100">
                                    <dt class="text-sm text-slate-600">Fecha de Rechazo</dt>
                                    <dd class="text-sm font-medium text-red-600">
                                        <?php echo isset($datos['fecha_rechazo']) ? date('d/m/Y H:i', strtotime($datos['fecha_rechazo'])) : 'N/A'; ?>
                                    </dd>
                                </div>
                                <div class="flex justify-between py-2 border-b border-slate-100">
                                    <dt class="text-sm text-slate-600">Motivo de Rechazo</dt>
                                    <dd class="text-sm font-medium text-red-600">
                                        <?php echo isset($datos['motivo_rechazo']) ? htmlspecialchars($datos['motivo_rechazo']) : 'No especificado'; ?>
                                    </dd>
                                </div>
                            <?php endif; ?>
                            
                            <div class="flex justify-between py-2">
                                <dt class="text-sm text-slate-600">Intermediario</dt>
                                <dd class="text-sm font-medium text-slate-900 text-right"><?php echo htmlspecialchars($intermediario['nombre_negocio']); ?></dd>
                            </div>
                        </dl>
                        
                        <?php if($c['estado'] === 'pendiente'): ?>
                            <div class="mt-6 space-y-3">
                                <button id="marcarAprobadaBtn" class="w-full inline-flex items-center justify-center px-4 py-2 bg-emerald-600 text-white text-sm font-medium rounded-lg hover:bg-emerald-700 focus:ring-4 focus:ring-emerald-200 transition-all duration-200">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                    </svg>
                                    Marcar como Aprobada
                                </button>
                                
                                <button id="marcarRechazadaBtn" class="w-full inline-flex items-center justify-center px-4 py-2 bg-red-600 text-white text-sm font-medium rounded-lg hover:bg-red-700 focus:ring-4 focus:ring-red-200 transition-all duration-200">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                    </svg>
                                    Marcar como Rechazada
                                </button>
                                
                                <a href="<?php echo BASE_URL; ?>intermediario/editar_cotizacion/<?php echo $c['id']; ?>" class="w-full inline-flex items-center justify-center px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded-lg hover:bg-blue-700 focus:ring-4 focus:ring-blue-200 transition-all duration-200">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path>
                                    </svg>
                                    Editar Cotización
                                </a>
                            </div>
                        <?php elseif($c['estado'] === 'aprobada'): ?>
                            <div class="mt-6 space-y-3">
                                <a href="<?php echo BASE_URL; ?>intermediario/generar_comprobante/<?php echo $c['id']; ?>" class="w-full inline-flex items-center justify-center px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded-lg hover:bg-blue-700 focus:ring-4 focus:ring-blue-200 transition-all duration-200">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path>
                                    </svg>
                                    Descargar Comprobante
                                </a>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal para enviar cotización por email -->
<div id="enviarCotizacionModal" class="hidden fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center p-4">
    <div class="bg-white rounded-lg shadow-xl max-w-md w-full">
        <div class="border-b px-4 py-3 flex justify-between items-center">
            <h3 class="text-lg font-medium text-slate-900">Enviar Cotización al Cliente</h3>
            <button class="cerrarModal text-slate-400 hover:text-slate-500">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
        </div>
        
        <form id="enviarCotizacionForm" action="<?php echo BASE_URL; ?>intermediario/enviar_cotizacion" method="POST" class="p-4">
            <input type="hidden" name="cotizacion_id" value="<?php echo $c['id']; ?>">
            
            <div class="mb-4">
                <label class="block text-sm font-medium text-slate-700 mb-1" for="email_destino">Correo electrónico</label>
                <input type="email" id="email_destino" name="email_destino" value="<?php echo htmlspecialchars($c['email_cliente']); ?>" class="w-full px-3 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500" required>
                <p class="text-xs text-slate-500 mt-1">Se enviará la cotización a este correo electrónico</p>
            </div>
            
            <div class="mb-6">
                <label class="block text-sm font-medium text-slate-700 mb-1" for="mensaje_personalizado">Mensaje personalizado (opcional)</label>
                <textarea id="mensaje_personalizado" name="mensaje_personalizado" rows="3" class="w-full px-3 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"></textarea>
            </div>
            
            <div class="flex justify-end">
                <button type="button" class="cerrarModal mr-2 px-4 py-2 border border-slate-300 rounded-lg text-slate-700 bg-white hover:bg-slate-50">Cancelar</button>
                <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">Enviar</button>
            </div>
        </form>
    </div>
</div>

<!-- Modal para marcar como aprobada -->
<div id="marcarAprobadaModal" class="hidden fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center p-4">
    <div class="bg-white rounded-lg shadow-xl max-w-md w-full">
        <div class="border-b px-4 py-3 flex justify-between items-center">
            <h3 class="text-lg font-medium text-slate-900">Marcar como Aprobada</h3>
            <button class="cerrarModal text-slate-400 hover:text-slate-500">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
        </div>
        
        <form action="<?php echo BASE_URL; ?>intermediario/actualizar_estado_cotizacion" method="POST" class="p-4">
            <input type="hidden" name="cotizacion_id" value="<?php echo $c['id']; ?>">
            <input type="hidden" name="estado" value="aprobada">
            
            <div class="mb-4">
                <div class="bg-emerald-50 border border-emerald-200 rounded-lg p-4 text-emerald-700">
                    <div class="flex">
                        <svg class="w-5 h-5 mr-3 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path>
                        </svg>
                        <div>
                            <h3 class="text-emerald-800 font-medium mb-2">¿Confirmar aprobación?</h3>
                            <p class="text-sm">Al marcar esta cotización como aprobada se registrará la comisión correspondiente y se notificará al sistema.</p>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="mb-6">
                <label class="block text-sm font-medium text-slate-700 mb-1" for="comentarios_aprobacion">Comentarios (opcional)</label>
                <textarea id="comentarios_aprobacion" name="comentarios" rows="2" class="w-full px-3 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"></textarea>
            </div>
            
            <div class="flex justify-end">
                <button type="button" class="cerrarModal mr-2 px-4 py-2 border border-slate-300 rounded-lg text-slate-700 bg-white hover:bg-slate-50">Cancelar</button>
                <button type="submit" class="px-4 py-2 bg-emerald-600 text-white rounded-lg hover:bg-emerald-700">Confirmar Aprobación</button>
            </div>
        </form>
    </div>
</div>

<!-- Modal para marcar como rechazada -->
<div id="marcarRechazadaModal" class="hidden fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center p-4">
    <div class="bg-white rounded-lg shadow-xl max-w-md w-full">
        <div class="border-b px-4 py-3 flex justify-between items-center">
            <h3 class="text-lg font-medium text-slate-900">Marcar como Rechazada</h3>
            <button class="cerrarModal text-slate-400 hover:text-slate-500">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
        </div>
        
        <form action="<?php echo BASE_URL; ?>intermediario/actualizar_estado_cotizacion" method="POST" class="p-4">
            <input type="hidden" name="cotizacion_id" value="<?php echo $c['id']; ?>">
            <input type="hidden" name="estado" value="rechazada">
            
            <div class="mb-4">
                <label class="block text-sm font-medium text-slate-700 mb-1" for="motivo_rechazo">Motivo del rechazo</label>
                <select id="motivo_rechazo" name="motivo_rechazo" class="w-full px-3 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500" required>
                    <option value="">Seleccionar motivo</option>
                    <option value="precio_alto">Precio demasiado alto</option>
                    <option value="encontro_mejor_oferta">Encontró mejor oferta</option>
                    <option value="cambio_opinion">Cambió de opinión</option>
                    <option value="falta_documentacion">Falta de documentación</option>
                    <option value="otro">Otro motivo</option>
                </select>
            </div>
            
            <div class="mb-6">
                <label class="block text-sm font-medium text-slate-700 mb-1" for="detalle_rechazo">Detalles adicionales</label>
                <textarea id="detalle_rechazo" name="detalle_rechazo" rows="3" class="w-full px-3 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"></textarea>
            </div>
            
            <div class="flex justify-end">
                <button type="button" class="cerrarModal mr-2 px-4 py-2 border border-slate-300 rounded-lg text-slate-700 bg-white hover:bg-slate-50">Cancelar</button>
                <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700">Confirmar Rechazo</button>
            </div>
        </form>
    </div>
</div>

<!-- Modal para eliminar cotización -->
<div id="eliminarCotizacionModal" class="hidden fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center p-4">
    <div class="bg-white rounded-lg shadow-xl max-w-md w-full">
        <div class="border-b px-4 py-3 flex justify-between items-center">
            <h3 class="text-lg font-medium text-slate-900">Eliminar Cotización</h3>
            <button class="cerrarModal text-slate-400 hover:text-slate-500">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
        </div>
        
        <div class="p-4">
            <div class="mb-5 bg-red-50 border border-red-200 rounded-lg p-4 text-red-700">
                <div class="flex">
                    <svg class="w-5 h-5 mr-3 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path>
                    </svg>
                    <div>
                        <h3 class="text-red-800 font-medium mb-2">¿Estás seguro de eliminar esta cotización?</h3>
                        <p class="text-sm">Esta acción no se puede deshacer. Todos los datos relacionados a esta cotización serán eliminados permanentemente.</p>
                    </div>
                </div>
            </div>
            
            <form action="<?php echo BASE_URL; ?>intermediario/eliminar_cotizacion" method="POST">
                <input type="hidden" name="cotizacion_id" value="<?php echo $c['id']; ?>">
                
                <div class="flex justify-end">
                    <button type="button" class="cerrarModal mr-2 px-4 py-2 border border-slate-300 rounded-lg text-slate-700 bg-white hover:bg-slate-50">Cancelar</button>
                    <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700">Eliminar Cotización</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Botones para abrir modales
    const enviarCotizacionBtn = document.getElementById('enviarCotizacionBtn');
    const marcarAprobadaBtn = document.getElementById('marcarAprobadaBtn');
    const marcarRechazadaBtn = document.getElementById('marcarRechazadaBtn');
    const eliminarCotizacionBtn = document.getElementById('eliminarCotizacionBtn');
    
    // Modales
    const enviarCotizacionModal = document.getElementById('enviarCotizacionModal');
    const marcarAprobadaModal = document.getElementById('marcarAprobadaModal');
    const marcarRechazadaModal = document.getElementById('marcarRechazadaModal');
    const eliminarCotizacionModal = document.getElementById('eliminarCotizacionModal');
    
    // Botones para cerrar modales
    const cerrarModales = document.querySelectorAll('.cerrarModal');
    
    // Abrir modales
    if (enviarCotizacionBtn) {
        enviarCotizacionBtn.addEventListener('click', function() {
            enviarCotizacionModal.classList.remove('hidden');
        });
    }
    
    if (marcarAprobadaBtn) {
        marcarAprobadaBtn.addEventListener('click', function() {
            marcarAprobadaModal.classList.remove('hidden');
        });
    }
    
    if (marcarRechazadaBtn) {
        marcarRechazadaBtn.addEventListener('click', function() {
            marcarRechazadaModal.classList.remove('hidden');
        });
    }
    
    if (eliminarCotizacionBtn) {
        eliminarCotizacionBtn.addEventListener('click', function() {
            eliminarCotizacionModal.classList.remove('hidden');
        });
    }
    
    // Cerrar modales
    cerrarModales.forEach(function(btn) {
        btn.addEventListener('click', function() {
            enviarCotizacionModal.classList.add('hidden');
            marcarAprobadaModal.classList.add('hidden');
            marcarRechazadaModal.classList.add('hidden');
            eliminarCotizacionModal.classList.add('hidden');
        });
    });
    
    // También cerrar al hacer clic fuera del modal
    window.addEventListener('click', function(event) {
        if (event.target === enviarCotizacionModal) {
            enviarCotizacionModal.classList.add('hidden');
        }
        if (event.target === marcarAprobadaModal) {
            marcarAprobadaModal.classList.add('hidden');
        }
        if (event.target === marcarRechazadaModal) {
            marcarRechazadaModal.classList.add('hidden');
        }
        if (event.target === eliminarCotizacionModal) {
            eliminarCotizacionModal.classList.add('hidden');
        }
    });
});
</script>

<style>
@keyframes fadeIn {
    from { opacity: 0; transform: translateY(10px); }
    to { opacity: 1; transform: translateY(0); }
}

.bg-white {
    animation: fadeIn 0.4s ease-out;
}

tbody tr:hover {
    transform: translateX(2px);
}

.sticky {
    position: sticky;
}
</style>