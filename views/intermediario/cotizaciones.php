<?php
// views/intermediario/cotizaciones.php
$status_map = [
    'Aprobada' => ['icon' => 'check-circle', 'color' => 'emerald', 'bg' => 'bg-emerald-100', 'text' => 'text-emerald-700'],
    'Pendiente' => ['icon' => 'clock', 'color' => 'blue', 'bg' => 'bg-blue-100', 'text' => 'text-blue-700'],
    'Rechazada' => ['icon' => 'x-circle', 'color' => 'red', 'bg' => 'bg-red-100', 'text' => 'text-red-700'],
    'Pagada' => ['icon' => 'badge-check', 'color' => 'purple', 'bg' => 'bg-purple-100', 'text' => 'text-purple-700']
];

$type_icon_map = [
    'SOAT' => 'shield-check',
    'Seguro Todo Riesgo' => 'shield-exclamation',
    'Seguro de Vida' => 'heart',
    'Seguro Hogar' => 'home',
    'Seguro Pyme' => 'office-building',
    'Otro' => 'document'
];
?>

<div class="min-h-screen bg-gradient-to-br from-slate-50 to-slate-100 py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="mb-8">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-3xl font-bold text-slate-900 mb-2">Gestión de Cotizaciones</h1>
                    <p class="text-slate-600">Administra todas las cotizaciones generadas para tus clientes</p>
                </div>
                <button id="addCotizacionBtn" class="inline-flex items-center px-6 py-3 bg-blue-600 text-white font-semibold rounded-lg shadow-sm hover:bg-blue-700 focus:ring-4 focus:ring-blue-200 transition-all duration-200 transform hover:scale-105">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                    </svg>
                    Nueva Cotización
                </button>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
            <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-5">
                <div class="flex items-center">
                    <div class="w-12 h-12 bg-blue-100 rounded-full flex items-center justify-center text-blue-600 mr-4">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                    </div>
                    <div>
                        <p class="text-sm text-slate-500">Total Cotizaciones</p>
                        <h3 class="text-2xl font-bold text-slate-900"><?php echo count($cotizaciones); ?></h3>
                    </div>
                </div>
            </div>
            
            <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-5">
                <div class="flex items-center">
                    <div class="w-12 h-12 bg-green-100 rounded-full flex items-center justify-center text-green-600 mr-4">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <div>
                        <p class="text-sm text-slate-500">Aprobadas</p>
                        <h3 class="text-2xl font-bold text-slate-900">
                            <?php 
                            $aprobadas = array_filter($cotizaciones, function($c) { return $c['estado'] === 'Aprobada'; });
                            echo count($aprobadas); 
                            ?>
                        </h3>
                    </div>
                </div>
            </div>
            
            <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-5">
                <div class="flex items-center">
                    <div class="w-12 h-12 bg-purple-100 rounded-full flex items-center justify-center text-purple-600 mr-4">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <div>
                        <p class="text-sm text-slate-500">Pagadas</p>
                        <h3 class="text-2xl font-bold text-slate-900">
                            <?php 
                            $pagadas = array_filter($cotizaciones, function($c) { return $c['estado'] === 'Pagada'; });
                            echo count($pagadas); 
                            ?>
                        </h3>
                    </div>
                </div>
            </div>
            
            <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-5">
                <div class="flex items-center">
                    <div class="w-12 h-12 bg-amber-100 rounded-full flex items-center justify-center text-amber-600 mr-4">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <div>
                        <p class="text-sm text-slate-500">Pendientes</p>
                        <h3 class="text-2xl font-bold text-slate-900">
                            <?php 
                            $pendientes = array_filter($cotizaciones, function($c) { return $c['estado'] === 'Pendiente'; });
                            echo count($pendientes); 
                            ?>
                        </h3>
                    </div>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden">
            <div class="p-6 border-b border-slate-200 bg-slate-50">
                <div class="flex space-x-1" id="cotizaciones-tabs">
                    <button data-tab="todos" class="px-4 py-2.5 text-sm font-semibold rounded-lg text-white bg-blue-600 transition-all duration-200">
                        Todas
                    </button>
                    <button data-tab="pendiente" class="px-4 py-2.5 text-sm font-semibold rounded-lg text-slate-600 hover:bg-slate-100 hover:text-slate-900 transition-all duration-200">
                        Pendientes
                    </button>
                    <button data-tab="aprobada" class="px-4 py-2.5 text-sm font-semibold rounded-lg text-slate-600 hover:bg-slate-100 hover:text-slate-900 transition-all duration-200">
                        Aprobadas
                    </button>
                    <button data-tab="pagada" class="px-4 py-2.5 text-sm font-semibold rounded-lg text-slate-600 hover:bg-slate-100 hover:text-slate-900 transition-all duration-200">
                        Pagadas
                    </button>
                    <button data-tab="rechazada" class="px-4 py-2.5 text-sm font-semibold rounded-lg text-slate-600 hover:bg-slate-100 hover:text-slate-900 transition-all duration-200">
                        Rechazadas
                    </button>
                </div>
            </div>

            <div class="divide-y divide-slate-200" id="cotizaciones-list">
                <?php if (empty($cotizaciones)): ?>
                    <div class="p-12 text-center">
                        <div class="w-16 h-16 bg-slate-100 rounded-full flex items-center justify-center mx-auto mb-4">
                            <svg class="w-8 h-8 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                        </div>
                        <h3 class="text-lg font-semibold text-slate-900 mb-2">Sin cotizaciones registradas</h3>
                        <p class="text-slate-600">Aún no has generado ninguna cotización para tus clientes.</p>
                    </div>
                <?php else: ?>
                    <?php foreach($cotizaciones as $cotizacion): ?>
                        <div class="p-6 hover:bg-slate-50 transition-all duration-200 cotizaciones-item" data-status="<?php echo strtolower($cotizacion['estado']); ?>">
                            <div class="flex items-center space-x-6">
                                <div class="w-12 h-12 bg-gradient-to-br from-blue-500 to-blue-600 rounded-xl flex-shrink-0 flex items-center justify-center text-white shadow-lg">
                                    <?php
                                    $iconName = $type_icon_map[$cotizacion['producto']] ?? 'document';
                                    switch($iconName):
                                        case 'shield-check': ?>
                                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                                            </svg>
                                        <?php break; case 'shield-exclamation': ?>
                                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.618 5.984A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016zM12 9v2m0 4h.01"></path>
                                            </svg>
                                        <?php break; case 'heart': ?>
                                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                                            </svg>
                                        <?php break; case 'home': ?>
                                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                                            </svg>
                                        <?php break; case 'office-building': ?>
                                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                                            </svg>
                                        <?php break; default: ?>
                                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                            </svg>
                                    <?php endswitch; ?>
                                </div>
                                
                                <div class="flex-1 grid grid-cols-1 lg:grid-cols-6 gap-4 lg:gap-6 items-start lg:items-center">
                                    <div class="lg:col-span-2">
                                        <h3 class="font-bold text-slate-900 mb-1"><?php echo htmlspecialchars($cotizacion['producto']); ?></h3>
                                        <p class="text-sm text-slate-600">
                                            Cliente: <span class="font-medium"><?php echo htmlspecialchars($cotizacion['nombre_cliente']); ?></span>
                                        </p>
                                        <p class="text-sm text-slate-600">
                                            <span><?php echo htmlspecialchars($cotizacion['telefono_cliente']); ?></span>
                                        </p>
                                    </div>
                                    
                                    <div class="lg:col-span-1">
                                        <p class="text-sm text-slate-600 mb-1">Fecha</p>
                                        <p class="font-medium text-slate-900"><?php echo (new DateTime($cotizacion['fecha_creacion']))->format('d/m/Y'); ?></p>
                                    </div>
                                    
                                    <div class="lg:col-span-1">
                                        <p class="text-sm text-slate-600 mb-1">Estado</p>
                                        <div class="inline-flex items-center">
                                            <?php $statusInfo = $status_map[$cotizacion['estado']]; ?>
                                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold <?php echo $statusInfo['bg'] . ' ' . $statusInfo['text']; ?>">
                                                <?php
                                                switch($statusInfo['icon']):
                                                    case 'check-circle': ?>
                                                        <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                                        </svg>
                                                    <?php break; case 'clock': ?>
                                                        <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                        </svg>
                                                    <?php break; case 'x-circle': ?>
                                                        <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path>
                                                        </svg>
                                                    <?php break; case 'badge-check': ?>
                                                        <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                            <path fill-rule="evenodd" d="M6.267 3.455a3.066 3.066 0 001.745-.723 3.066 3.066 0 013.976 0 3.066 3.066 0 001.745.723 3.066 3.066 0 012.812 2.812c.051.643.304 1.254.723 1.745a3.066 3.066 0 010 3.976 3.066 3.066 0 00-.723 1.745 3.066 3.066 0 01-2.812 2.812 3.066 3.066 0 00-1.745.723 3.066 3.066 0 01-3.976 0 3.066 3.066 0 00-1.745-.723 3.066 3.066 0 01-2.812-2.812 3.066 3.066 0 00-.723-1.745 3.066 3.066 0 010-3.976 3.066 3.066 0 00.723-1.745 3.066 3.066 0 012.812-2.812zm7.44 5.252a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                                        </svg>
                                                <?php endswitch; ?>
                                                <?php echo htmlspecialchars($cotizacion['estado']); ?>
                                            </span>
                                        </div>
                                    </div>
                                    
                                    <div class="lg:col-span-1">
                                        <p class="text-sm text-slate-600 mb-1">Valor</p>
                                        <p class="font-bold text-slate-900 text-lg">$<?php echo number_format($cotizacion['valor'], 0, ',', '.'); ?></p>
                                    </div>
                                    
                                    <div class="lg:col-span-1 flex justify-start lg:justify-end space-x-2">
                                        <a href="<?php echo BASE_URL; ?>intermediario/detalle_cotizacion/<?php echo $cotizacion['id']; ?>" class="inline-flex items-center justify-center w-10 h-10 border border-slate-300 rounded-lg text-slate-600 hover:bg-slate-100 hover:text-blue-600 transition-all duration-200 transform hover:scale-105" title="Ver detalles">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                            </svg>
                                        </a>
                                        
                                        <a href="<?php echo BASE_URL; ?>intermediario/editar_cotizacion/<?php echo $cotizacion['id']; ?>" class="inline-flex items-center justify-center w-10 h-10 border border-slate-300 rounded-lg text-slate-600 hover:bg-slate-100 hover:text-blue-600 transition-all duration-200 transform hover:scale-105" title="Editar">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path>
                                            </svg>
                                        </a>
                                        
                                        <?php if (in_array($cotizacion['estado'], ['Aprobada', 'Pagada'])): ?>
                                            <a href="<?php echo BASE_URL; ?>intermediario/descargar_cotizacion/<?php echo $cotizacion['id']; ?>" class="inline-flex items-center justify-center w-10 h-10 bg-slate-800 text-white rounded-lg hover:bg-slate-900 transition-all duration-200 transform hover:scale-105" title="Descargar PDF">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                                </svg>
                                            </a>
                                        <?php endif; ?>
                                        
                                        <button data-id="<?php echo $cotizacion['id']; ?>" class="createSeguimientoBtn inline-flex items-center justify-center w-10 h-10 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-all duration-200 transform hover:scale-105" title="Crear seguimiento">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                            </svg>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<div id="addCotizacionModal" class="modal fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center hidden">
    <div class="modal-content bg-white rounded-xl shadow-xl w-full max-w-md mx-4 transform transition-all duration-300">
        <div class="px-6 py-4 border-b border-slate-200 bg-slate-50 rounded-t-xl">
            <div class="flex justify-between items-center">
                <h3 class="text-xl font-bold text-slate-900">Crear Nueva Cotización</h3>
                <button onclick="closeModal('addCotizacionModal')" class="modal-close text-slate-500 hover:text-slate-700 p-1 rounded-lg hover:bg-slate-100 transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
        </div>
        
        <form id="addCotizacionForm" action="<?php echo BASE_URL; ?>intermediario/crear-cotizacion" method="POST" class="p-6">
            <div class="space-y-6">
                <div>
                    <label for="producto" class="block text-sm font-semibold text-slate-900 mb-2">Producto</label>
                    <select id="producto" name="producto" class="w-full px-4 py-3 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors" required>
                        <option value="">Selecciona un producto</option>
                        <option value="SOAT">SOAT</option>
                        <option value="Seguro Todo Riesgo">Seguro Todo Riesgo</option>
                        <option value="Seguro de Vida">Seguro de Vida</option>
                        <option value="Seguro Hogar">Seguro Hogar</option>
                        <option value="Seguro Pyme">Seguro Pyme</option>
                        <option value="Otro">Otro</option>
                    </select>
                </div>
                
                <div>
                    <label for="nombre_cliente" class="block text-sm font-semibold text-slate-900 mb-2">Nombre del Cliente</label>
                    <input type="text" id="nombre_cliente" name="nombre_cliente" class="w-full px-4 py-3 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors" placeholder="Nombre completo" required>
                </div>
                
                <div>
                    <label for="correo_cliente" class="block text-sm font-semibold text-slate-900 mb-2">Correo Electrónico</label>
                   <label for="correo_cliente" class="block text-sm font-semibold text-slate-900 mb-2">Correo Electrónico</label>
                    <input type="email" id="correo_cliente" name="correo_cliente" class="w-full px-4 py-3 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors" placeholder="ejemplo@correo.com">
                </div>
                
                <div>
                    <label for="telefono_cliente" class="block text-sm font-semibold text-slate-900 mb-2">Teléfono del Cliente</label>
                    <input type="tel" id="telefono_cliente" name="telefono_cliente" class="w-full px-4 py-3 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors" placeholder="300-123-4567" required>
                </div>
                
                <div>
                    <label for="valor" class="block text-sm font-semibold text-slate-900 mb-2">Valor de la Cotización</label>
                    <div class="relative">
                        <span class="absolute left-3 top-3 text-slate-500">$</span>
                        <input type="number" id="valor" name="valor" class="w-full pl-8 pr-4 py-3 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors" placeholder="250,000" required>
                    </div>
                </div>
                
                <div>
                    <label for="detalles" class="block text-sm font-semibold text-slate-900 mb-2">Detalles Adicionales</label>
                    <textarea id="detalles" name="detalles" rows="3" class="w-full px-4 py-3 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors" placeholder="Detalles específicos sobre la cotización..."></textarea>
                </div>
            </div>
            
            <div class="mt-8 flex justify-end space-x-3">
                <button type="button" onclick="closeModal('addCotizacionModal')" class="px-6 py-3 border border-slate-300 text-slate-700 font-medium rounded-lg hover:bg-slate-50 transition-colors">
                    Cancelar
                </button>
                <button type="submit" class="px-6 py-3 bg-blue-600 text-white font-semibold rounded-lg hover:bg-blue-700 focus:ring-4 focus:ring-blue-200 transition-all duration-200 transform hover:scale-105">
                    Crear Cotización
                </button>
            </div>
        </form>
    </div>
</div>

<div id="crearSeguimientoModal" class="modal fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center hidden">
    <div class="modal-content bg-white rounded-xl shadow-xl w-full max-w-md mx-4 transform transition-all duration-300">
        <div class="px-6 py-4 border-b border-slate-200 bg-slate-50 rounded-t-xl">
            <div class="flex justify-between items-center">
                <h3 class="text-xl font-bold text-slate-900">Crear Seguimiento</h3>
                <button onclick="closeModal('crearSeguimientoModal')" class="modal-close text-slate-500 hover:text-slate-700 p-1 rounded-lg hover:bg-slate-100 transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
        </div>
        
        <form id="crearSeguimientoForm" action="<?php echo BASE_URL; ?>intermediario/crear-seguimiento" method="POST" class="p-6">
            <input type="hidden" id="cotizacion_id" name="cotizacion_id" value="">
            <input type="hidden" name="accion" value="crear_seguimiento">
            
            <div class="space-y-6">
                <div>
                    <label for="tipo_seguimiento" class="block text-sm font-semibold text-slate-900 mb-2">Tipo de Seguimiento</label>
                    <select id="tipo_seguimiento" name="tipo" class="w-full px-4 py-3 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors" required>
                        <option value="cotizacion">Seguimiento de cotización</option>
                        <option value="renovacion">Recordatorio de renovación</option>
                        <option value="post_venta">Seguimiento post-venta</option>
                    </select>
                </div>
                
                <div>
                    <label for="titulo_seguimiento" class="block text-sm font-semibold text-slate-900 mb-2">Título</label>
                    <input type="text" id="titulo_seguimiento" name="titulo" class="w-full px-4 py-3 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors" value="Seguimiento de cotización" required>
                </div>
                
                <div>
                    <label for="descripcion_seguimiento" class="block text-sm font-semibold text-slate-900 mb-2">Descripción</label>
                    <textarea id="descripcion_seguimiento" name="descripcion" rows="3" class="w-full px-4 py-3 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors">Contactar al cliente para conocer si está interesado en la cotización enviada.</textarea>
                </div>
                
                <div>
                    <label for="fecha_recordatorio" class="block text-sm font-semibold text-slate-900 mb-2">Fecha de Seguimiento</label>
                    <input type="date" id="fecha_recordatorio" name="fecha_recordatorio" class="w-full px-4 py-3 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors" required>
                </div>
                
                <div>
                    <label for="frecuencia" class="block text-sm font-semibold text-slate-900 mb-2">Frecuencia</label>
                    <select id="frecuencia" name="frecuencia" class="w-full px-4 py-3 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors">
                        <option value="una_vez">Una vez</option>
                        <option value="diario">Diario</option>
                        <option value="semanal">Semanal</option>
                        <option value="mensual">Mensual</option>
                    </select>
                </div>
                
                <div>
                    <label class="block text-sm font-semibold text-slate-900 mb-2">Notificaciones</label>
                    <div class="space-y-2">
                        <label class="inline-flex items-center">
                            <input type="checkbox" name="notificacion_email" class="h-4 w-4 text-blue-600 border-gray-300 rounded" checked>
                            <span class="ml-2 text-sm text-gray-700">Recibir notificación por email</span>
                        </label>
                    </div>
                </div>
            </div>
            
            <div class="mt-8 flex justify-end space-x-3">
                <button type="button" onclick="closeModal('crearSeguimientoModal')" class="px-6 py-3 border border-slate-300 text-slate-700 font-medium rounded-lg hover:bg-slate-50 transition-colors">
                    Cancelar
                </button>
                <button type="submit" class="px-6 py-3 bg-blue-600 text-white font-semibold rounded-lg hover:bg-blue-700 focus:ring-4 focus:ring-blue-200 transition-all duration-200 transform hover:scale-105">
                    Crear Seguimiento
                </button>
            </div>
        </form>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const addCotizacionBtn = document.getElementById('addCotizacionBtn');
    const tabs = document.querySelectorAll('[data-tab]');
    const cotizacionesItems = document.querySelectorAll('.cotizaciones-item');
    const createSeguimientoBtns = document.querySelectorAll('.createSeguimientoBtn');

    if (addCotizacionBtn) {
        addCotizacionBtn.addEventListener('click', function() {
            document.getElementById('addCotizacionModal').classList.remove('hidden');
        });
    }

    tabs.forEach(tab => {
        tab.addEventListener('click', function() {
            const targetTab = this.dataset.tab;
            
            tabs.forEach(t => {
                t.classList.remove('text-white', 'bg-blue-600');
                t.classList.add('text-slate-600', 'hover:bg-slate-100', 'hover:text-slate-900');
            });
            
            this.classList.add('text-white', 'bg-blue-600');
            this.classList.remove('text-slate-600', 'hover:bg-slate-100', 'hover:text-slate-900');
            
            cotizacionesItems.forEach(item => {
                if (targetTab === 'todos' || item.dataset.status.includes(targetTab)) {
                    item.style.display = 'block';
                } else {
                    item.style.display = 'none';
                }
            });
        });
    });
    
    createSeguimientoBtns.forEach(btn => {
        btn.addEventListener('click', function() {
            const cotizacionId = this.getAttribute('data-id');
            document.getElementById('cotizacion_id').value = cotizacionId;
            
            // Establecer fecha de seguimiento por defecto (3 días después)
            const hoy = new Date();
            const tresDiasDespues = new Date();
            tresDiasDespues.setDate(hoy.getDate() + 3);
            
            // Formatear para input date (YYYY-MM-DD)
            const tresDiasDespuesStr = tresDiasDespues.toISOString().split('T')[0];
            document.getElementById('fecha_recordatorio').value = tresDiasDespuesStr;
            
            document.getElementById('crearSeguimientoModal').classList.remove('hidden');
        });
    });
    
    // Cambiar título y descripción del seguimiento según el tipo seleccionado
    const tipoSeguimientoSelect = document.getElementById('tipo_seguimiento');
    const tituloSeguimientoInput = document.getElementById('titulo_seguimiento');
    const descripcionSeguimientoTextarea = document.getElementById('descripcion_seguimiento');
    
    if (tipoSeguimientoSelect) {
        tipoSeguimientoSelect.addEventListener('change', function() {
            const tipoSeleccionado = this.value;
            
            switch(tipoSeleccionado) {
                case 'cotizacion':
                    tituloSeguimientoInput.value = 'Seguimiento de cotización';
                    descripcionSeguimientoTextarea.value = 'Contactar al cliente para conocer si está interesado en la cotización enviada.';
                    break;
                case 'renovacion':
                    tituloSeguimientoInput.value = 'Recordatorio de renovación';
                    descripcionSeguimientoTextarea.value = 'Contactar al cliente para recordarle la renovación próxima de su póliza.';
                    break;
                case 'post_venta':
                    tituloSeguimientoInput.value = 'Seguimiento post-venta';
                    descripcionSeguimientoTextarea.value = 'Contactar al cliente para verificar su satisfacción con el producto adquirido.';
                    break;
            }
        });
    }

    window.closeModal = function(modalId) {
        document.getElementById(modalId).classList.add('hidden');
    };
});
</script>

<style>
@keyframes fadeIn {
    from { opacity: 0; transform: translateY(10px); }
    to { opacity: 1; transform: translateY(0); }
}

.cotizaciones-item {
    animation: fadeIn 0.3s ease-out;
}

.modal {
    backdrop-filter: blur(4px);
}

.modal-content {
    max-height: 90vh;
    overflow-y: auto;
}

.transform {
    transition: transform 0.2s ease-in-out;
}
</style>