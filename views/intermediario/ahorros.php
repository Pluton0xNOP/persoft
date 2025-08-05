<div class="space-y-6">
    <div class="flex justify-between items-center">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Mis Comisiones</h1>
            <p class="text-gray-600">Gestiona tus comisiones y movimientos financieros como intermediario</p>
        </div>
        <a href="<?php echo BASE_URL; ?>intermediario/nueva_cotizacion" class="px-4 py-2 bg-primary-600 text-white rounded-lg hover:bg-primary-700 transition-colors">
            <i class="fas fa-plus mr-2"></i>Nueva Cotización
        </a>
    </div>

    <?php if (isset($_SESSION['success_message'])): ?>
        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 rounded-md shadow-sm" role="alert">
            <div class="flex">
                <div class="flex-shrink-0">
                    <i class="fas fa-check-circle text-green-500"></i>
                </div>
                <div class="ml-3">
                    <p class="text-sm"><?php echo $_SESSION['success_message']; ?></p>
                </div>
                <button class="ml-auto -mx-1.5 -my-1.5 bg-green-50 text-green-500 rounded-md p-1.5 focus:outline-none">
                    <span class="sr-only">Cerrar</span>
                    <i class="fas fa-times"></i>
                </button>
            </div>
        </div>
        <?php unset($_SESSION['success_message']); ?>
    <?php endif; ?>

    <?php if (isset($_SESSION['error_message'])): ?>
        <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 rounded-md shadow-sm" role="alert">
            <div class="flex">
                <div class="flex-shrink-0">
                    <i class="fas fa-exclamation-circle text-red-500"></i>
                </div>
                <div class="ml-3">
                    <p class="text-sm"><?php echo $_SESSION['error_message']; ?></p>
                </div>
                <button class="ml-auto -mx-1.5 -my-1.5 bg-red-50 text-red-500 rounded-md p-1.5 focus:outline-none">
                    <span class="sr-only">Cerrar</span>
                    <i class="fas fa-times"></i>
                </button>
            </div>
        </div>
        <?php unset($_SESSION['error_message']); ?>
    <?php endif; ?>

    <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">
        <div class="lg:col-span-4 space-y-6">
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Resumen Financiero</h3>
                
                <?php 
                $totalComisiones = 0;
                $pendientePago = 0;
                $cotizacionesActivas = 0;
                
                if (isset($transacciones)) {
                    foreach ($transacciones as $transaccion) {
                        if ($transaccion['tipo'] == 'comision') {
                            $totalComisiones += floatval($transaccion['monto']);
                        }
                    }
                }
                
                if (isset($cotizaciones)) {
                    foreach ($cotizaciones as $cotizacion) {
                        if ($cotizacion['estado'] == 'pendiente') {
                            $cotizacionesActivas++;
                            $pendientePago += floatval($cotizacion['valor']) * (floatval($intermediario['porcentaje_comision']) / 100);
                        }
                    }
                }
                ?>
                
                <div class="grid grid-cols-2 gap-4 mb-4">
                    <div class="bg-blue-50 rounded-lg p-4">
                        <div class="text-xs text-blue-600 font-medium uppercase mb-1">Saldo actual</div>
                        <div class="text-2xl font-bold text-blue-800">$<?php echo number_format($intermediario['saldo_actual'] ?? 0, 0, ',', '.'); ?></div>
                    </div>
                    <div class="bg-green-50 rounded-lg p-4">
                        <div class="text-xs text-green-600 font-medium uppercase mb-1">Total comisiones</div>
                        <div class="text-2xl font-bold text-green-800">$<?php echo number_format($totalComisiones, 0, ',', '.'); ?></div>
                    </div>
                </div>
                
                <div class="bg-yellow-50 rounded-lg p-4 mb-4">
                    <div class="text-xs text-yellow-600 font-medium uppercase mb-1">Potencial pendiente</div>
                    <div class="text-xl font-bold text-yellow-800">$<?php echo number_format($pendientePago, 0, ',', '.'); ?></div>
                    <div class="text-xs text-yellow-600 mt-1">De <?php echo $cotizacionesActivas; ?> cotizaciones activas</div>
                </div>
                
                <div class="flex justify-between">
                    <a href="<?php echo BASE_URL; ?>intermediario/transacciones" class="text-primary-600 text-sm hover:underline">
                        <i class="fas fa-history mr-1"></i>Ver historial completo
                    </a>
                    <button id="solicitarRetiroBtn" class="text-sm text-primary-600 hover:underline">
                        <i class="fas fa-money-bill-wave mr-1"></i>Solicitar retiro
                    </button>
                </div>
            </div>
            
            <div class="bg-gradient-to-br from-blue-500 to-indigo-600 rounded-xl shadow-md p-6 text-white">
                <div class="flex items-center mb-4">
                    <div class="bg-white/20 rounded-full p-2 mr-3">
                        <i class="fas fa-lightbulb text-yellow-300"></i>
                    </div>
                    <h3 class="text-lg font-semibold">Consejos para intermediarios</h3>
                </div>
                
                <ul class="space-y-3 text-blue-50">
                    <li class="flex items-start">
                        <i class="fas fa-check-circle mt-1 mr-2 text-blue-200"></i>
                        <p class="text-sm">Mantén actualizados los datos de tus clientes para agilizar las cotizaciones.</p>
                    </li>
                    <li class="flex items-start">
                        <i class="fas fa-check-circle mt-1 mr-2 text-blue-200"></i>
                        <p class="text-sm">Haz seguimiento a tus cotizaciones pendientes para aumentar tus conversiones.</p>
                    </li>
                    <li class="flex items-start">
                        <i class="fas fa-check-circle mt-1 mr-2 text-blue-200"></i>
                        <p class="text-sm">Programa recordatorios de renovación para tus clientes y aumenta tus comisiones.</p>
                    </li>
                </ul>
                
                <div class="mt-4 pt-4 border-t border-white/20">
                    <p class="text-xs text-blue-100">Tu porcentaje de comisión actual es de <?php echo $intermediario['porcentaje_comision'] ?? 5; ?>%. Contacta con soporte si deseas revisar este valor.</p>
                </div>
            </div>
        </div>
        
        <div class="lg:col-span-8">
            <?php if (empty($cotizaciones)): ?>
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 text-center">
                    <div class="py-8">
                        <div class="inline-flex items-center justify-center w-16 h-16 bg-blue-50 rounded-full mb-4">
                            <i class="fas fa-file-invoice-dollar text-3xl text-blue-500"></i>
                        </div>
                        <h3 class="text-xl font-medium text-gray-900 mb-2">No tienes cotizaciones activas</h3>
                        <p class="text-gray-600 mb-6 max-w-md mx-auto">Crea tu primera cotización para empezar a generar comisiones. Puedes ofrecer SOAT, Revisión Técnico Mecánica y otros servicios a tus clientes.</p>
                        <a href="<?php echo BASE_URL; ?>intermediario/nueva_cotizacion" class="px-6 py-3 bg-primary-600 text-white rounded-lg hover:bg-primary-700 transition-colors">
                            <i class="fas fa-plus mr-2"></i>Crear mi primera cotización
                        </a>
                    </div>
                </div>
            <?php else: ?>
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="text-lg font-semibold text-gray-900">Cotizaciones Recientes</h3>
                        <a href="<?php echo BASE_URL; ?>intermediario/cotizaciones" class="text-sm text-primary-600 hover:underline">Ver todas</a>
                    </div>
                    
                    <div class="space-y-4">
                        <?php 
                        $contador = 0;
                        foreach ($cotizaciones as $cotizacion): 
                            if ($contador >= 5) break; // Mostrar solo las 5 más recientes
                            $contador++;
                            
                            $tipoIcono = $cotizacion['producto'] === 'SOAT' ? 'fa-id-card' : 'fa-car';
                            $colorClase = $cotizacion['producto'] === 'SOAT' ? 'bg-blue-600' : 'bg-green-600';
                            $colorClaseLight = $cotizacion['producto'] === 'SOAT' ? 'bg-blue-50 text-blue-700' : 'bg-green-50 text-green-700';
                            
                            $fechaVencimiento = new DateTime($cotizacion['fecha_vencimiento']);
                            $hoy = new DateTime();
                            $diasRestantes = $hoy > $fechaVencimiento ? 0 : $fechaVencimiento->diff($hoy)->days;
                            
                            $estadoClase = '';
                            $estadoTexto = '';
                            switch ($cotizacion['estado']) {
                                case 'pendiente':
                                    $estadoClase = 'bg-yellow-100 text-yellow-800';
                                    $estadoTexto = 'Pendiente';
                                    break;
                                case 'aprobada':
                                    $estadoClase = 'bg-green-100 text-green-800';
                                    $estadoTexto = 'Aprobada';
                                    break;
                                case 'rechazada':
                                    $estadoClase = 'bg-red-100 text-red-800';
                                    $estadoTexto = 'Rechazada';
                                    break;
                                case 'vencida':
                                    $estadoClase = 'bg-gray-100 text-gray-800';
                                    $estadoTexto = 'Vencida';
                                    break;
                            }
                            
                            $comision = ($cotizacion['valor'] * ($intermediario['porcentaje_comision'] ?? 5)) / 100;
                        ?>
                            <div class="border border-gray-200 rounded-xl overflow-hidden">
                                <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                                    <div class="md:col-span-1 p-4 flex flex-col justify-between border-b md:border-b-0 md:border-r border-gray-200">
                                        <div>
                                            <div class="flex items-center">
                                                <div class="<?php echo $colorClaseLight; ?> rounded-lg p-2 mr-3">
                                                    <i class="fas <?php echo $tipoIcono; ?>"></i>
                                                </div>
                                                <h4 class="font-semibold text-gray-900"><?php echo $cotizacion['producto']; ?></h4>
                                            </div>
                                            <p class="text-sm text-gray-600 mt-2">Placa: <?php echo $cotizacion['placa']; ?></p>
                                            <p class="text-xs text-gray-500 mt-1"><?php echo $cotizacion['tipo_vehiculo'] . ' ' . $cotizacion['modelo']; ?></p>
                                        </div>
                                        
                                        <div class="mt-3">
                                            <span class="inline-flex px-2 py-1 text-xs font-medium rounded-full <?php echo $estadoClase; ?>">
                                                <?php echo $estadoTexto; ?>
                                            </span>
                                        </div>
                                    </div>
                                    
                                    <div class="md:col-span-2 p-4 flex flex-col justify-between border-b md:border-b-0 md:border-r border-gray-200">
                                        <div>
                                            <div class="text-sm font-medium text-gray-900 mb-1">Información del cliente</div>
                                            <p class="text-sm text-gray-600"><?php echo $cotizacion['nombre_cliente']; ?></p>
                                            <p class="text-xs text-gray-500"><?php echo $cotizacion['telefono_cliente']; ?></p>
                                            <p class="text-xs text-gray-500"><?php echo $cotizacion['email_cliente']; ?></p>
                                        </div>
                                        
                                        <div class="mt-3 grid grid-cols-2 gap-3 text-sm">
                                            <div>
                                                <div class="text-gray-500">Valor total</div>
                                                <div class="font-semibold text-gray-900">$<?php echo number_format($cotizacion['valor'], 0, ',', '.'); ?></div>
                                            </div>
                                            <div>
                                                <div class="text-gray-500">Tu comisión</div>
                                                <div class="font-semibold text-green-600">$<?php echo number_format($comision, 0, ',', '.'); ?></div>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="md:col-span-1 p-4 flex flex-col justify-between">
                                        <div class="text-sm">
                                            <div class="text-gray-500 mb-1">Fecha de expiración</div>
                                            <div class="font-semibold <?php echo $diasRestantes < 2 ? 'text-red-600' : 'text-gray-900'; ?>">
                                                <?php echo date('d/m/Y', strtotime($cotizacion['fecha_vencimiento'])); ?>
                                                <?php if ($cotizacion['estado'] === 'pendiente'): ?>
                                                    <span class="text-xs block">(<?php echo $diasRestantes; ?> días restantes)</span>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                        
                                        <div class="space-y-2 mt-3">
                                            <?php if ($cotizacion['estado'] === 'pendiente'): ?>
                                                <a href="<?php echo BASE_URL; ?>intermediario/editar_cotizacion/<?php echo $cotizacion['id']; ?>" class="w-full px-3 py-2 bg-primary-600 text-white text-sm rounded hover:bg-primary-700 transition-colors flex items-center justify-center">
                                                    <i class="fas fa-edit mr-1"></i>Editar
                                                </a>
                                                
                                                <button data-cotizacion-id="<?php echo $cotizacion['id']; ?>" class="enviarCotizacionBtn w-full px-3 py-2 bg-gray-200 text-gray-700 text-sm rounded hover:bg-gray-300 transition-colors flex items-center justify-center">
                                                    <i class="fas fa-envelope mr-1"></i>Reenviar
                                                </button>
                                            <?php elseif ($cotizacion['estado'] === 'aprobada'): ?>
                                                <a href="<?php echo BASE_URL; ?>intermediario/ver_cotizacion/<?php echo $cotizacion['id']; ?>" class="w-full px-3 py-2 bg-green-600 text-white text-sm rounded hover:bg-green-700 transition-colors flex items-center justify-center">
                                                    <i class="fas fa-check-circle mr-1"></i>Ver detalles
                                                </a>
                                            <?php else: ?>
                                                <a href="<?php echo BASE_URL; ?>intermediario/ver_cotizacion/<?php echo $cotizacion['id']; ?>" class="w-full px-3 py-2 bg-gray-200 text-gray-700 text-sm rounded hover:bg-gray-300 transition-colors flex items-center justify-center">
                                                    <i class="fas fa-eye mr-1"></i>Ver detalles
                                                </a>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                        
                        <div class="border border-gray-200 border-dashed rounded-xl p-6 flex flex-col items-center justify-center text-center">
                            <i class="fas fa-plus-circle text-3xl text-gray-400 mb-3"></i>
                            <h3 class="text-lg font-medium text-gray-700 mb-2">Nueva cotización</h3>
                            <p class="text-sm text-gray-500 mb-4">Crea una cotización para tus clientes</p>
                            <a href="<?php echo BASE_URL; ?>intermediario/nueva_cotizacion" class="px-4 py-2 bg-gray-600 text-white rounded-lg hover:bg-gray-700 transition-colors">
                                Crear Cotización
                            </a>
                        </div>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <div class="bg-blue-50 border border-blue-200 rounded-xl p-6">
        <h3 class="text-lg font-semibold text-blue-900 mb-4">
            <i class="fas fa-info-circle mr-2"></i>¿Cómo funcionan las comisiones?
        </h3>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 text-sm text-blue-800">
            <div class="bg-white/60 p-4 rounded-lg">
                <div class="flex items-center mb-3">
                    <div class="bg-blue-100 text-blue-700 rounded-full w-8 h-8 flex items-center justify-center mr-3">
                        <span>1</span>
                    </div>
                    <h4 class="font-medium">Crear cotizaciones</h4>
                </div>
                <p class="text-blue-700">Genera cotizaciones para tus clientes en diversos productos como SOAT y Tecnomecánica. La plataforma calculará automáticamente tu comisión basada en tu porcentaje actual.</p>
            </div>
            <div class="bg-white/60 p-4 rounded-lg">
                <div class="flex items-center mb-3">
                    <div class="bg-blue-100 text-blue-700 rounded-full w-8 h-8 flex items-center justify-center mr-3">
                        <span>2</span>
                    </div>
                    <h4 class="font-medium">Seguimiento y conversión</h4>
                </div>
                <p class="text-blue-700">Realiza seguimiento a tus cotizaciones pendientes para aumentar la probabilidad de compra. Las cotizaciones aprobadas generarán comisiones que se acreditarán a tu saldo.</p>
            </div>
            <div class="bg-white/60 p-4 rounded-lg">
                <div class="flex items-center mb-3">
                    <div class="bg-blue-100 text-blue-700 rounded-full w-8 h-8 flex items-center justify-center mr-3">
                        <span>3</span>
                    </div>
                    <h4 class="font-medium">Retiro de comisiones</h4>
                </div>
                <p class="text-blue-700">Solicita el retiro de tus comisiones acumuladas cuando lo desees. El pago se realizará a través de la información bancaria que hayas proporcionado en tu perfil.</p>
            </div>
        </div>
    </div>
</div>

<!-- Modal para solicitar retiro -->
<div id="solicitarRetiroModal" class="hidden fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center p-4">
    <div class="bg-white rounded-lg shadow-xl max-w-md w-full">
        <div class="border-b px-4 py-3 flex justify-between items-center">
            <h3 class="text-lg font-medium text-gray-900">Solicitar Retiro de Fondos</h3>
            <button class="cerrarModal text-gray-400 hover:text-gray-500">
                <i class="fas fa-times"></i>
            </button>
        </div>
        
        <form action="<?php echo BASE_URL; ?>intermediario/solicitar_retiro" method="POST" class="p-4">
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-1" for="monto">Monto a retirar</label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <span class="text-gray-500">$</span>
                    </div>
                    <input type="number" id="monto" name="monto" min="50000" max="<?php echo $intermediario['saldo_actual'] ?? 0; ?>" class="w-full pl-7 pr-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500" placeholder="0" required>
                </div>
                <p class="text-xs text-gray-500 mt-1">Monto mínimo: $50,000. Saldo disponible: $<?php echo number_format($intermediario['saldo_actual'] ?? 0, 0, ',', '.'); ?></p>
            </div>
            
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-1" for="medio_pago">Método de pago</label>
                <select id="medio_pago" name="medio_pago" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500" required>
                    <option value="">Seleccionar método</option>
                    <option value="transferencia_bancaria">Transferencia Bancaria</option>
                    <option value="nequi">Nequi</option>
                    <option value="daviplata">Daviplata</option>
                </select>
            </div>
            
            <div class="mb-6">
                <label class="block text-sm font-medium text-gray-700 mb-1" for="comentario">Comentarios (opcional)</label>
                <textarea id="comentario" name="comentario" rows="3" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500"></textarea>
            </div>
            
            <div class="flex justify-end">
                <button type="button" class="cerrarModal mr-2 px-4 py-2 border border-gray-300 rounded-lg text-gray-700 bg-white hover:bg-gray-50">Cancelar</button>
                <button type="submit" class="px-4 py-2 bg-primary-600 text-white rounded-lg hover:bg-primary-700">Solicitar Retiro</button>
            </div>
        </form>
    </div>
</div>

<!-- Modal para enviar cotización por email -->
<div id="enviarCotizacionModal" class="hidden fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center p-4">
    <div class="bg-white rounded-lg shadow-xl max-w-md w-full">
        <div class="border-b px-4 py-3 flex justify-between items-center">
            <h3 class="text-lg font-medium text-gray-900">Reenviar Cotización</h3>
            <button class="cerrarModal text-gray-400 hover:text-gray-500">
                <i class="fas fa-times"></i>
            </button>
        </div>
        
        <form id="enviarCotizacionForm" action="<?php echo BASE_URL; ?>intermediario/enviar_cotizacion" method="POST" class="p-4">
            <input type="hidden" id="cotizacion_id" name="cotizacion_id" value="">
            
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-1" for="email_destino">Correo electrónico</label>
                <input type="email" id="email_destino" name="email_destino" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500" required>
                <p class="text-xs text-gray-500 mt-1">Se enviará la cotización a este correo electrónico</p>
            </div>
            
            <div class="mb-6">
                <label class="block text-sm font-medium text-gray-700 mb-1" for="mensaje_personalizado">Mensaje personalizado (opcional)</label>
                <textarea id="mensaje_personalizado" name="mensaje_personalizado" rows="3" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500"></textarea>
            </div>
            
            <div class="flex justify-end">
                <button type="button" class="cerrarModal mr-2 px-4 py-2 border border-gray-300 rounded-lg text-gray-700 bg-white hover:bg-gray-50">Cancelar</button>
                <button type="submit" class="px-4 py-2 bg-primary-600 text-white rounded-lg hover:bg-primary-700">Enviar</button>
            </div>
        </form>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Solicitar retiro
        const solicitarRetiroBtn = document.getElementById('solicitarRetiroBtn');
        if (solicitarRetiroBtn) {
            solicitarRetiroBtn.addEventListener('click', function() {
                document.getElementById('solicitarRetiroModal').classList.remove('hidden');
            });
        }
        
        // Enviar cotización
        document.querySelectorAll('.enviarCotizacionBtn').forEach(function(btn) {
            btn.addEventListener('click', function() {
                const cotizacionId = this.getAttribute('data-cotizacion-id');
                document.getElementById('cotizacion_id').value = cotizacionId;
                
                // Cargar email del cliente via AJAX
                fetch('<?php echo BASE_URL; ?>api/cotizacion.php?id=' + cotizacionId)
                    .then(response => response.json())
                    .then(data => {
                        document.getElementById('email_destino').value = data.email_cliente || '';
                    })
                    .catch(error => {
                        console.error('Error:', error);
                    });
                
                document.getElementById('enviarCotizacionModal').classList.remove('hidden');
            });
        });
        
        // Cerrar modales
        document.querySelectorAll('.cerrarModal').forEach(function(btn) {
            btn.addEventListener('click', function() {
                document.getElementById('solicitarRetiroModal').classList.add('hidden');
                document.getElementById('enviarCotizacionModal').classList.add('hidden');
            });
        });
        
        // Validación de monto de retiro
        const montoInput = document.getElementById('monto');
        const saldoDisponible = <?php echo $intermediario['saldo_actual'] ?? 0; ?>;
        
        if (montoInput) {
            montoInput.addEventListener('input', function() {
                const valor = parseFloat(this.value);
                if (valor > saldoDisponible) {
                    this.value = saldoDisponible;
                }
            });
        }
        
        // Cerrar alertas
        document.querySelectorAll('.bg-green-100 button, .bg-red-100 button').forEach(button => {
            button.addEventListener('click', function() {
                this.closest('div[role="alert"]').remove();
            });
        });
    });
</script>