<?php
// views/intermediario/transacciones.php
$status_classes = [
    'Acreditado' => 'bg-emerald-100 text-emerald-800',
    'Pendiente' => 'bg-amber-100 text-amber-800',
    'Rechazado' => 'bg-red-100 text-red-800',
    'Pagado' => 'bg-blue-100 text-blue-800',
    'En proceso' => 'bg-purple-100 text-purple-800',
];

$tipo_classes = [
    'comision' => 'bg-green-100 text-green-800',
    'retiro' => 'bg-blue-100 text-blue-800',
    'ajuste' => 'bg-slate-100 text-slate-800',
];
?>
<div class="min-h-screen bg-gradient-to-br from-slate-50 to-slate-100 py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-slate-900 mb-2">Transacciones y Comisiones</h1>
            <p class="text-slate-600">Gestiona tus comisiones, retiros y movimientos de cuenta como intermediario.</p>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-4 gap-6 mb-8">
            <div class="lg:col-span-1">
                <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-6">
                    <h2 class="text-lg font-semibold text-slate-900 mb-4">Resumen Financiero</h2>
                    
                    <div class="space-y-4">
                        <div class="bg-blue-50 rounded-lg p-4">
                            <div class="text-xs text-blue-600 font-medium uppercase mb-1">Saldo Disponible</div>
                            <div class="text-2xl font-bold text-blue-800">$<?php echo number_format($intermediario['saldo_actual'] ?? 0, 0, ',', '.'); ?></div>
                        </div>
                        
                        <div>
                            <div class="flex justify-between mb-1 text-sm">
                                <span class="text-slate-600">Total Comisiones (Mes)</span>
                                <span class="font-medium text-slate-900">$<?php echo number_format($resumen['comisiones_mes'] ?? 0, 0, ',', '.'); ?></span>
                            </div>
                            <div class="w-full bg-gray-200 rounded-full h-2.5">
                                <div class="bg-green-500 h-2.5 rounded-full" style="width: <?php echo min(100, ($resumen['comisiones_mes'] / $resumen['meta_mes'] * 100) ?? 0); ?>%"></div>
                            </div>
                            <div class="text-xs text-gray-500 mt-1 text-right">
                                Meta: $<?php echo number_format($resumen['meta_mes'] ?? 0, 0, ',', '.'); ?>
                            </div>
                        </div>
                        
                        <div class="border-t border-slate-200 pt-4">
                            <div class="flex justify-between items-center mb-2">
                                <span class="text-sm text-slate-600">Retiros Procesados</span>
                                <span class="text-sm font-medium text-slate-900">$<?php echo number_format($resumen['retiros_procesados'] ?? 0, 0, ',', '.'); ?></span>
                            </div>
                            <div class="flex justify-between items-center">
                                <span class="text-sm text-slate-600">Retiros Pendientes</span>
                                <span class="text-sm font-medium text-amber-600">$<?php echo number_format($resumen['retiros_pendientes'] ?? 0, 0, ',', '.'); ?></span>
                            </div>
                        </div>
                    </div>
                    
                    <div class="mt-6">
                        <button id="solicitarRetiroBtn" class="w-full px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors flex items-center justify-center">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3"></path>
                            </svg>
                            Solicitar Retiro
                        </button>
                    </div>
                </div>
            </div>
            
            <div class="lg:col-span-3">
                <div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden">
                    <div class="p-6 border-b border-slate-200 flex justify-between items-center">
                        <h2 class="text-lg font-semibold text-slate-900">Historial de Transacciones</h2>
                        
                        <div class="flex gap-2">
                            <select id="filtroTipo" class="bg-slate-50 border border-slate-200 text-slate-700 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 px-4 py-2">
                                <option value="todos">Todos los tipos</option>
                                <option value="comision">Comisiones</option>
                                <option value="retiro">Retiros</option>
                                <option value="ajuste">Ajustes</option>
                            </select>
                            
                            <select id="filtroEstado" class="bg-slate-50 border border-slate-200 text-slate-700 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 px-4 py-2">
                                <option value="todos">Todos los estados</option>
                                <option value="Acreditado">Acreditados</option>
                                <option value="Pendiente">Pendientes</option>
                                <option value="Pagado">Pagados</option>
                                <option value="En proceso">En proceso</option>
                            </select>
                        </div>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="w-full">
                            <thead>
                                <tr class="border-b border-slate-200 bg-slate-50">
                                    <th class="text-left py-3 px-6 font-semibold text-slate-700">Tipo</th>
                                    <th class="text-left py-3 px-6 font-semibold text-slate-700">Referencia</th>
                                    <th class="text-left py-3 px-6 font-semibold text-slate-700">Fecha</th>
                                    <th class="text-right py-3 px-6 font-semibold text-slate-700">Monto</th>
                                    <th class="text-center py-3 px-6 font-semibold text-slate-700">Estado</th>
                                    <th class="text-center py-3 px-6 font-semibold text-slate-700">Detalle</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-100">
                                <?php if (empty($transacciones)): ?>
                                    <tr>
                                        <td colspan="6" class="text-center py-16 text-slate-500">
                                            <div class="w-20 h-20 bg-slate-100 rounded-full flex items-center justify-center mx-auto mb-4">
                                                <svg class="w-10 h-10 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                </svg>
                                            </div>
                                            No tienes transacciones registradas.
                                        </td>
                                    </tr>
                                <?php else: ?>
                                    <?php foreach($transacciones as $trans): ?>
                                        <tr class="hover:bg-slate-50 transition-colors transaccion-fila" 
                                            data-tipo="<?php echo htmlspecialchars($trans['tipo']); ?>" 
                                            data-estado="<?php echo htmlspecialchars($trans['estado']); ?>">
                                            <td class="py-4 px-6">
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium <?php echo $tipo_classes[$trans['tipo']] ?? 'bg-slate-100 text-slate-800'; ?>">
                                                    <?php 
                                                    switch($trans['tipo']) {
                                                        case 'comision':
                                                            echo 'Comisión';
                                                            break;
                                                        case 'retiro':
                                                            echo 'Retiro';
                                                            break;
                                                        case 'ajuste':
                                                            echo 'Ajuste';
                                                            break;
                                                        default:
                                                            echo ucfirst($trans['tipo']);
                                                    }
                                                    ?>
                                                </span>
                                            </td>
                                            <td class="py-4 px-6 font-medium text-slate-900"><?php echo htmlspecialchars($trans['referencia']); ?></td>
                                            <td class="py-4 px-6 text-slate-600"><?php echo htmlspecialchars((new DateTime($trans['fecha_transaccion']))->format('d/m/Y H:i')); ?></td>
                                            <td class="py-4 px-6 text-right font-mono <?php echo $trans['monto'] >= 0 ? 'text-emerald-600' : 'text-red-600'; ?> font-semibold">
                                                <?php echo $trans['monto'] >= 0 ? '+' : ''; ?>$<?php echo htmlspecialchars(number_format(abs($trans['monto']), 0, ',', '.')); ?>
                                            </td>
                                            <td class="py-4 px-6 text-center">
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold <?php echo $status_classes[$trans['estado']] ?? 'bg-slate-100 text-slate-800'; ?>">
                                                    <?php echo htmlspecialchars($trans['estado']); ?>
                                                </span>
                                            </td>
                                            <td class="py-4 px-6 text-center">
                                                <button class="verDetalleBtn text-slate-400 hover:text-blue-600 transition-colors" 
                                                       data-id="<?php echo $trans['id']; ?>"
                                                       data-tipo="<?php echo htmlspecialchars($trans['tipo']); ?>" 
                                                       data-referencia="<?php echo htmlspecialchars($trans['referencia']); ?>"
                                                       data-descripcion="<?php echo htmlspecialchars($trans['descripcion']); ?>"
                                                       data-saldo-anterior="<?php echo htmlspecialchars(number_format($trans['saldo_anterior'], 0, ',', '.')); ?>"
                                                       data-saldo-nuevo="<?php echo htmlspecialchars(number_format($trans['saldo_nuevo'], 0, ',', '.')); ?>"
                                                       data-fecha="<?php echo htmlspecialchars((new DateTime($trans['fecha_transaccion']))->format('d/m/Y H:i')); ?>">
                                                    <svg class="w-5 h-5 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                                    </svg>
                                                </button>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                    
                    <?php if (!empty($transacciones) && count($transacciones) > 10): ?>
                        <div class="bg-slate-50 px-6 py-3 border-t border-slate-200 flex justify-between items-center">
                            <span class="text-sm text-slate-600">Mostrando 1-10 de <?php echo count($transacciones); ?> transacciones</span>
                            <div class="flex space-x-2">
                                <button class="px-3 py-1 border border-slate-300 rounded-md bg-white text-slate-700 hover:bg-slate-100 disabled:opacity-50" disabled>
                                    Anterior
                                </button>
                                <button class="px-3 py-1 border border-slate-300 rounded-md bg-white text-slate-700 hover:bg-slate-100">
                                    Siguiente
                                </button>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
        
        <div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden">
            <div class="p-6 border-b border-slate-200">
                <h2 class="text-lg font-semibold text-slate-900">Solicitudes de Retiro</h2>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead>
                        <tr class="border-b border-slate-200 bg-slate-50">
                            <th class="text-left py-3 px-6 font-semibold text-slate-700">ID Solicitud</th>
                            <th class="text-left py-3 px-6 font-semibold text-slate-700">Fecha</th>
                            <th class="text-left py-3 px-6 font-semibold text-slate-700">Método de Pago</th>
                            <th class="text-right py-3 px-6 font-semibold text-slate-700">Monto</th>
                            <th class="text-center py-3 px-6 font-semibold text-slate-700">Estado</th>
                            <th class="text-center py-3 px-6 font-semibold text-slate-700">Comprobante</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        <?php if (empty($retiros)): ?>
                            <tr>
                                <td colspan="6" class="text-center py-16 text-slate-500">
                                    <div class="w-20 h-20 bg-slate-100 rounded-full flex items-center justify-center mx-auto mb-4">
                                        <svg class="w-10 h-10 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path>
                                        </svg>
                                    </div>
                                    No tienes solicitudes de retiro.
                                </td>
                            </tr>
                        <?php else: ?>
                            <?php foreach($retiros as $retiro): ?>
                                <tr class="hover:bg-slate-50 transition-colors">
                                    <td class="py-4 px-6 font-medium text-slate-900">#<?php echo htmlspecialchars($retiro['id']); ?></td>
                                    <td class="py-4 px-6 text-slate-600"><?php echo htmlspecialchars((new DateTime($retiro['fecha_solicitud']))->format('d/m/Y')); ?></td>
                                    <td class="py-4 px-6 text-slate-700">
                                        <?php 
                                        switch($retiro['medio_pago']) {
                                            case 'transferencia_bancaria':
                                                echo 'Transferencia Bancaria';
                                                break;
                                            case 'nequi':
                                                echo 'Nequi';
                                                break;
                                            case 'daviplata':
                                                echo 'Daviplata';
                                                break;
                                            default:
                                                echo ucfirst($retiro['medio_pago']);
                                        }
                                        ?>
                                    </td>
                                    <td class="py-4 px-6 text-right font-mono font-semibold text-slate-800">$<?php echo htmlspecialchars(number_format($retiro['monto'], 0, ',', '.')); ?></td>
                                    <td class="py-4 px-6 text-center">
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold
                                            <?php 
                                            switch($retiro['estado']) {
                                                case 'pendiente':
                                                    echo 'bg-amber-100 text-amber-800';
                                                    break;
                                                case 'procesada':
                                                    echo 'bg-emerald-100 text-emerald-800';
                                                    break;
                                                case 'rechazada':
                                                    echo 'bg-red-100 text-red-800';
                                                    break;
                                                default:
                                                    echo 'bg-slate-100 text-slate-800';
                                            }
                                            ?>">
                                            <?php echo ucfirst($retiro['estado']); ?>
                                        </span>
                                    </td>
                                    <td class="py-4 px-6 text-center">
                                        <?php if($retiro['estado'] === 'procesada' && !empty($retiro['comprobante'])): ?>
                                            <a href="<?php echo BASE_URL . $retiro['comprobante']; ?>" target="_blank" class="text-blue-600 hover:text-blue-800 transition-colors">
                                                <svg class="w-5 h-5 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path>
                                                </svg>
                                            </a>
                                        <?php else: ?>
                                            <span class="text-slate-400">-</span>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Modal de Detalles de Transacción -->
<div id="detalleTransaccionModal" class="hidden fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center p-4">
    <div class="bg-white rounded-lg shadow-xl max-w-md w-full">
        <div class="border-b px-4 py-3 flex justify-between items-center">
            <h3 class="text-lg font-medium text-slate-900">Detalle de Transacción</h3>
            <button id="cerrarDetalleModal" class="text-slate-400 hover:text-slate-500">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
        </div>
        <div class="p-6">
            <div class="space-y-4">
                <div class="flex justify-between border-b border-slate-100 pb-3">
                    <span class="text-sm text-slate-600">Tipo</span>
                    <span id="detalleTipo" class="text-sm font-medium text-slate-900"></span>
                </div>
                <div class="flex justify-between border-b border-slate-100 pb-3">
                    <span class="text-sm text-slate-600">Referencia</span>
                    <span id="detalleReferencia" class="text-sm font-medium text-slate-900"></span>
                </div>
                <div class="flex justify-between border-b border-slate-100 pb-3">
                    <span class="text-sm text-slate-600">Fecha</span>
                    <span id="detalleFecha" class="text-sm font-medium text-slate-900"></span>
                </div>
                <div class="flex justify-between border-b border-slate-100 pb-3">
                    <span class="text-sm text-slate-600">Saldo Anterior</span>
                    <span id="detalleSaldoAnterior" class="text-sm font-medium text-slate-900"></span>
                </div>
                <div class="flex justify-between border-b border-slate-100 pb-3">
                    <span class="text-sm text-slate-600">Saldo Nuevo</span>
                    <span id="detalleSaldoNuevo" class="text-sm font-medium text-slate-900"></span>
                </div>
                <div>
                    <span class="text-sm text-slate-600 block mb-2">Descripción</span>
                    <p id="detalleDescripcion" class="text-sm text-slate-900 bg-slate-50 p-3 rounded-lg"></p>
                </div>
            </div>
        </div>
        <div class="border-t px-4 py-3 bg-slate-50 flex justify-end">
            <button id="cerrarDetalleBtn" class="px-4 py-2 bg-slate-200 text-slate-700 rounded-lg hover:bg-slate-300 transition-colors">
                Cerrar
            </button>
        </div>
    </div>
</div>

<!-- Modal para solicitar retiro -->
<div id="solicitarRetiroModal" class="hidden fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center p-4">
    <div class="bg-white rounded-lg shadow-xl max-w-md w-full">
        <div class="border-b px-4 py-3 flex justify-between items-center">
            <h3 class="text-lg font-medium text-slate-900">Solicitar Retiro de Fondos</h3>
            <button class="cerrarModal text-slate-400 hover:text-slate-500">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
        </div>
        
        <form action="<?php echo BASE_URL; ?>intermediario/solicitar_retiro" method="POST" class="p-4">
            <div class="mb-4">
                <label class="block text-sm font-medium text-slate-700 mb-1" for="monto">Monto a retirar</label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <span class="text-slate-500">$</span>
                    </div>
                    <input type="number" id="monto" name="monto" min="50000" max="<?php echo $intermediario['saldo_actual'] ?? 0; ?>" class="w-full pl-7 pr-3 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500" placeholder="0" required>
                </div>
                <p class="text-xs text-slate-500 mt-1">Monto mínimo: $50,000. Saldo disponible: $<?php echo number_format($intermediario['saldo_actual'] ?? 0, 0, ',', '.'); ?></p>
            </div>
            
            <div class="mb-4">
                <label class="block text-sm font-medium text-slate-700 mb-1" for="medio_pago">Método de pago</label>
                <select id="medio_pago" name="medio_pago" class="w-full px-3 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500" required>
                    <option value="">Seleccionar método</option>
                    <option value="transferencia_bancaria">Transferencia Bancaria</option>
                    <option value="nequi">Nequi</option>
                    <option value="daviplata">Daviplata</option>
                </select>
            </div>
            
            <div class="mb-6">
                <label class="block text-sm font-medium text-slate-700 mb-1" for="comentario">Comentarios (opcional)</label>
                <textarea id="comentario" name="comentario" rows="3" class="w-full px-3 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"></textarea>
            </div>
            
            <div class="flex justify-end">
                <button type="button" class="cerrarModal mr-2 px-4 py-2 border border-slate-300 rounded-lg text-slate-700 bg-white hover:bg-slate-50">Cancelar</button>
                <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">Solicitar Retiro</button>
            </div>
        </form>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Filtros
    const filtroTipo = document.getElementById('filtroTipo');
    const filtroEstado = document.getElementById('filtroEstado');
    const filas = document.querySelectorAll('.transaccion-fila');
    
    function aplicarFiltros() {
        const tipoSeleccionado = filtroTipo.value;
        const estadoSeleccionado = filtroEstado.value;
        
        filas.forEach(fila => {
            const tipo = fila.getAttribute('data-tipo');
            const estado = fila.getAttribute('data-estado');
            
            const mostrarPorTipo = tipoSeleccionado === 'todos' || tipo === tipoSeleccionado;
            const mostrarPorEstado = estadoSeleccionado === 'todos' || estado === estadoSeleccionado;
            
            if (mostrarPorTipo && mostrarPorEstado) {
                fila.classList.remove('hidden');
            } else {
                fila.classList.add('hidden');
            }
        });
    }
    
    if (filtroTipo) filtroTipo.addEventListener('change', aplicarFiltros);
    if (filtroEstado) filtroEstado.addEventListener('change', aplicarFiltros);
    
    // Modal de Detalle de Transacción
    const detalleModal = document.getElementById('detalleTransaccionModal');
    const cerrarDetalleModal = document.getElementById('cerrarDetalleModal');
    const cerrarDetalleBtn = document.getElementById('cerrarDetalleBtn');
    const verDetalleBtns = document.querySelectorAll('.verDetalleBtn');
    
    // Campos del modal
    const detalleTipo = document.getElementById('detalleTipo');
    const detalleReferencia = document.getElementById('detalleReferencia');
    const detalleFecha = document.getElementById('detalleFecha');
    const detalleSaldoAnterior = document.getElementById('detalleSaldoAnterior');
    const detalleSaldoNuevo = document.getElementById('detalleSaldoNuevo');
    const detalleDescripcion = document.getElementById('detalleDescripcion');
    
    verDetalleBtns.forEach(btn => {
        btn.addEventListener('click', function() {
            const tipo = this.getAttribute('data-tipo');
            const referencia = this.getAttribute('data-referencia');
            const descripcion = this.getAttribute('data-descripcion');
            const saldoAnterior = this.getAttribute('data-saldo-anterior');
            const saldoNuevo = this.getAttribute('data-saldo-nuevo');
            const fecha = this.getAttribute('data-fecha');
            
            // Poblar los campos del modal
           // Poblar los campos del modal
            detalleTipo.textContent = tipo === 'comision' ? 'Comisión' : (tipo === 'retiro' ? 'Retiro' : 'Ajuste');
            detalleReferencia.textContent = referencia;
            detalleFecha.textContent = fecha;
            detalleSaldoAnterior.textContent = '$' + saldoAnterior;
            detalleSaldoNuevo.textContent = '$' + saldoNuevo;
            detalleDescripcion.textContent = descripcion || 'No hay descripción disponible';
            
            // Mostrar el modal
            detalleModal.classList.remove('hidden');
        });
    });
    
    if (cerrarDetalleModal) {
        cerrarDetalleModal.addEventListener('click', function() {
            detalleModal.classList.add('hidden');
        });
    }
    
    if (cerrarDetalleBtn) {
        cerrarDetalleBtn.addEventListener('click', function() {
            detalleModal.classList.add('hidden');
        });
    }
    
    // Modal para solicitar retiro
    const solicitarRetiroBtn = document.getElementById('solicitarRetiroBtn');
    const solicitarRetiroModal = document.getElementById('solicitarRetiroModal');
    const cerrarModales = document.querySelectorAll('.cerrarModal');
    
    if (solicitarRetiroBtn) {
        solicitarRetiroBtn.addEventListener('click', function() {
            solicitarRetiroModal.classList.remove('hidden');
        });
    }
    
    cerrarModales.forEach(function(btn) {
        btn.addEventListener('click', function() {
            solicitarRetiroModal.classList.add('hidden');
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
    
    // Cierre de modales al hacer clic fuera
    window.addEventListener('click', function(event) {
        if (event.target === detalleModal) {
            detalleModal.classList.add('hidden');
        }
        if (event.target === solicitarRetiroModal) {
            solicitarRetiroModal.classList.add('hidden');
        }
    });
});
</script>