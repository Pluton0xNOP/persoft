<?php
$status_colors = [
    'Activa' => ['bg' => 'bg-emerald-50', 'text' => 'text-emerald-700', 'progress' => 'bg-emerald-500', 'icon' => 'check-circle'],
    'Próximo a Vencer' => ['bg' => 'bg-amber-50', 'text' => 'text-amber-700', 'progress' => 'bg-amber-500', 'icon' => 'clock'],
    'Vencida' => ['bg' => 'bg-red-50', 'text' => 'text-red-700', 'progress' => 'bg-red-500', 'icon' => 'x-circle'],
    'Vencido' => ['bg' => 'bg-red-50', 'text' => 'text-red-700', 'progress' => 'bg-red-500', 'icon' => 'x-circle'],
    'Al día' => ['bg' => 'bg-emerald-50', 'text' => 'text-emerald-700', 'progress' => 'bg-emerald-500', 'icon' => 'check-circle'],
    'Pago Pendiente' => ['bg' => 'bg-orange-50', 'text' => 'text-orange-700', 'progress' => 'bg-orange-500', 'icon' => 'exclamation-triangle'],
    'Sin información' => ['bg' => 'bg-slate-50', 'text' => 'text-slate-600', 'progress' => 'bg-slate-400', 'icon' => 'question-mark-circle']
];
?>

<div class="min-h-screen bg-gradient-to-br from-slate-50 to-slate-100 py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="mb-8">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-3xl font-bold text-slate-900 mb-2">Mis Vehículos</h1>
                    <p class="text-slate-600">Gestiona toda la información y documentos de tus vehículos</p>
                </div>
                <button id="addVehicleBtn" class="inline-flex items-center px-6 py-3 bg-blue-600 text-white font-semibold rounded-lg shadow-sm hover:bg-blue-700 focus:ring-4 focus:ring-blue-200 transition-all duration-200 transform hover:scale-105">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                    </svg>
                    Agregar Vehículo
                </button>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-sm border border-slate-200 mb-8">
            <div class="p-6 border-b border-slate-200">
                <h2 class="text-lg font-semibold text-slate-900 flex items-center">
                    <svg class="w-5 h-5 mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                    Buscar y Filtrar
                </h2>
            </div>
            <div class="p-6">
                <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
                    <div class="md:col-span-2">
                        <label for="searchVehicles" class="block text-sm font-medium text-slate-700 mb-2">Buscar vehículo</label>
                        <div class="relative">
                            <input type="text" id="searchVehicles" class="w-full pl-10 pr-4 py-3 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200" placeholder="Placa, marca, modelo...">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="w-5 h-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                </svg>
                            </div>
                        </div>
                    </div>
                    <div>
                        <label for="filterType" class="block text-sm font-medium text-slate-700 mb-2">Tipo de Vehículo</label>
                        <select id="filterType" class="w-full px-3 py-3 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200">
                            <option value="">Todos los tipos</option>
                            <option value="Automóvil">Automóvil</option>
                            <option value="Motocicleta">Motocicleta</option>
                        </select>
                    </div>
                    <div>
                        <label for="filterStatus" class="block text-sm font-medium text-slate-700 mb-2">Estado de Documentos</label>
                        <select id="filterStatus" class="w-full px-3 py-3 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200">
                            <option value="">Todos los estados</option>
                            <option value="Activa">Activos</option>
                            <option value="Próximo a Vencer">Próximos a vencer</option>
                            <option value="Vencido">Vencidos</option>
                            <option value="Pago Pendiente">Pago pendiente</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>

        <div id="noResultsMessage" class="hidden text-center py-12 bg-white rounded-xl shadow-sm border border-slate-200">
            <div class="w-16 h-16 bg-slate-100 rounded-full flex items-center justify-center mx-auto mb-4">
                <svg class="w-8 h-8 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                </svg>
            </div>
            <h3 class="text-lg font-semibold text-slate-900 mb-2">No se encontraron vehículos</h3>
            <p class="text-slate-600 mb-6">No hay vehículos que coincidan con los criterios de búsqueda.</p>
            <button id="clearFilters" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
                Limpiar filtros
            </button>
        </div>

        <div class="space-y-6">
            <?php if (empty($datos['vehiculos'])): ?>
                <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-12 text-center">
                    <div class="w-20 h-20 bg-blue-50 rounded-full flex items-center justify-center mx-auto mb-6">
                        <svg class="w-10 h-10 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-slate-900 mb-2">No tienes vehículos registrados</h3>
                    <p class="text-slate-600 mb-8">Agrega un vehículo para comenzar a gestionar toda su información y documentos.</p>
                    <button id="addFirstVehicleBtn" class="inline-flex items-center px-6 py-3 bg-blue-600 text-white font-semibold rounded-lg shadow-sm hover:bg-blue-700 focus:ring-4 focus:ring-blue-200 transition-all duration-200 transform hover:scale-105">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                        </svg>
                        Agregar mi primer vehículo
                    </button>
                </div>
            <?php else: ?>
                <?php foreach ($datos['vehiculos'] as $vehiculo): ?>
                    <div class="vehicle-card bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden hover:shadow-md transition-all duration-300 transform hover:-translate-y-1"
                        data-type="<?php echo htmlspecialchars($vehiculo['info']['tipo']); ?>"
                        data-status="<?php echo htmlspecialchars($vehiculo['tecnomecanica']['estado']); ?>">
                        
                        <div class="p-6 border-b border-slate-200">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center space-x-4">
                                    <div class="w-14 h-14 bg-gradient-to-br from-blue-500 to-blue-600 rounded-lg flex items-center justify-center text-white shadow-lg">
                                        <?php if ($vehiculo['info']['tipo'] === 'Automóvil'): ?>
                                            <svg class="w-7 h-7" fill="currentColor" viewBox="0 0 24 24">
                                                <path d="M18.92 6.01C18.72 5.42 18.16 5 17.5 5h-11c-.66 0-1.22.42-1.42 1.01L3 12v8c0 .55.45 1 1 1h1c.55 0 1-.45 1-1v-1h12v1c0 .55.45 1 1 1h1c.55 0 1-.45 1-1v-8l-2.08-5.99zM6.5 16c-.83 0-1.5-.67-1.5-1.5S5.67 13 6.5 13s1.5.67 1.5 1.5S7.33 16 6.5 16zm11 0c-.83 0-1.5-.67-1.5-1.5s.67-1.5 1.5-1.5 1.5.67 1.5 1.5-.67 1.5-1.5 1.5zM5 11l1.5-4.5h11L19 11H5z"/>
                                            </svg>
                                        <?php else: ?>
                                            <svg class="w-7 h-7" fill="currentColor" viewBox="0 0 24 24">
                                                <path d="M19.44 9.03L15.41 5H11v2h3.59l2 2H5c-2.8 0-5 2.2-5 5s2.2 5 5 5c2.46 0 4.45-1.69 4.9-4h1.65l2.77-2.77c-.17-.64-.32-1.27-.32-1.96 0-.69.15-1.32.32-1.96L19.44 9.03zM7.82 15c-.4 1.17-1.49 2-2.82 2-1.68 0-3-1.32-3-3s1.32-3 3-3c1.33 0 2.42.83 2.82 2H5v2h2.82z"/>
                                            </svg>
                                        <?php endif; ?>
                                    </div>
                                    <div>
                                        <h3 class="text-xl font-bold text-slate-900"><?php echo htmlspecialchars($vehiculo['info']['placa']); ?></h3>
                                        <p class="text-slate-600">
                                            <?php echo htmlspecialchars($vehiculo['info']['marca'] . ' ' . $vehiculo['info']['linea'] . ' ' . $vehiculo['info']['modelo']); ?>
                                        </p>
                                    </div>
                                </div>
                                <a href="<?php echo BASE_URL; ?>dashboard/gestionar-vehiculo/<?php echo htmlspecialchars($vehiculo['id']); ?>" class="inline-flex items-center px-4 py-2 border border-slate-300 text-slate-700 font-medium rounded-lg hover:bg-slate-50 transition-all duration-200 transform hover:scale-105" data-id="<?php echo htmlspecialchars($vehiculo['id']); ?>">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    </svg>
                                    Gestionar
                                </a>
                            </div>
                        </div>
                        
                        <div class="p-6 grid grid-cols-1 lg:grid-cols-3 gap-8">
                            <div class="space-y-4">
                                <h4 class="font-semibold text-slate-900 flex items-center">
                                    <svg class="w-5 h-5 mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    Información del Vehículo
                                </h4>
                                <dl class="space-y-3">
                                    <div class="flex justify-between py-2 border-b border-slate-100">
                                        <dt class="text-sm text-slate-600">Marca</dt>
                                        <dd class="text-sm font-medium text-slate-900"><?php echo htmlspecialchars($vehiculo['info']['marca']); ?></dd>
                                    </div>
                                    <div class="flex justify-between py-2 border-b border-slate-100">
                                        <dt class="text-sm text-slate-600">Modelo</dt>
                                        <dd class="text-sm font-medium text-slate-900"><?php echo htmlspecialchars($vehiculo['info']['modelo']); ?></dd>
                                    </div>
                                    <div class="flex justify-between py-2 border-b border-slate-100">
                                        <dt class="text-sm text-slate-600">Línea</dt>
                                        <dd class="text-sm font-medium text-slate-900"><?php echo htmlspecialchars($vehiculo['info']['linea']); ?></dd>
                                    </div>
                                    <div class="flex justify-between py-2 border-b border-slate-100">
                                        <dt class="text-sm text-slate-600">Color</dt>
                                        <dd class="text-sm font-medium text-slate-900"><?php echo htmlspecialchars($vehiculo['info']['color']); ?></dd>
                                    </div>
                                    <div class="flex justify-between py-2">
                                        <dt class="text-sm text-slate-600">Cilindraje</dt>
                                        <dd class="text-sm font-medium text-slate-900"><?php echo htmlspecialchars($vehiculo['info']['cilindraje']); ?> cc</dd>
                                    </div>
                                </dl>
                            </div>
                            
                            <div class="space-y-4">
                                <h4 class="font-semibold text-slate-900 flex items-center">
                                    <svg class="w-5 h-5 mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                    </svg>
                                    Propietario
                                </h4>
                                <div class="bg-slate-50 rounded-lg p-4 space-y-3">
                                    <div class="flex justify-between">
                                        <span class="text-sm text-slate-600">Nombre</span>
                                        <span class="text-sm font-medium text-slate-900"><?php echo htmlspecialchars($vehiculo['propietario']['nombre']); ?></span>
                                    </div>
                                    <div class="flex justify-between">
                                        <span class="text-sm text-slate-600">Cédula</span>
                                        <span class="text-sm font-medium text-slate-900"><?php echo htmlspecialchars($vehiculo['propietario']['cedula']); ?></span>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="space-y-4">
                                <h4 class="font-semibold text-slate-900 flex items-center">
                                    <svg class="w-5 h-5 mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    Estado de Documentos
                                </h4>
                                <div class="space-y-4">
                                    <div class="bg-slate-50 rounded-lg p-4">
                                        <div class="flex justify-between items-center mb-2">
                                            <span class="text-sm font-medium text-slate-900 flex items-center">
                                                <svg class="w-4 h-4 mr-1 text-slate-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                </svg>
                                                Tecnomecánica
                                            </span>
                                            <?php $tecnoStatusColor = $status_colors[$vehiculo['tecnomecanica']['estado']] ?? $status_colors['Sin información']; ?>
                                            <span class="px-2 py-1 rounded-full text-xs font-semibold <?php echo $tecnoStatusColor['bg'] . ' ' . $tecnoStatusColor['text']; ?>">
                                                <?php echo htmlspecialchars($vehiculo['tecnomecanica']['estado']); ?>
                                            </span>
                                        </div>
                                        <div class="w-full bg-slate-200 rounded-full h-2 overflow-hidden mb-2">
                                            <div class="<?php echo $tecnoStatusColor['progress']; ?> h-2 rounded-full transition-all duration-500" style="width: <?php echo htmlspecialchars($vehiculo['tecnomecanica']['progreso']); ?>%"></div>
                                        </div>
                                        <p class="text-xs text-slate-600">Vence: <?php echo htmlspecialchars($vehiculo['tecnomecanica']['vencimiento']); ?></p>
                                    </div>
                                    
                                    <div class="bg-slate-50 rounded-lg p-4">
                                        <div class="flex justify-between items-center mb-2">
                                            <span class="text-sm font-medium text-slate-900 flex items-center">
                                                <svg class="w-4 h-4 mr-1 text-slate-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                                </svg>
                                                SOAT
                                            </span>
                                            <?php $soatStatusColor = $status_colors[$vehiculo['soat']['estado']] ?? $status_colors['Sin información']; ?>
                                            <span class="px-2 py-1 rounded-full text-xs font-semibold <?php echo $soatStatusColor['bg'] . ' ' . $soatStatusColor['text']; ?>">
                                                <?php echo htmlspecialchars($vehiculo['soat']['estado']); ?>
                                            </span>
                                        </div>
                                        <div class="w-full bg-slate-200 rounded-full h-2 overflow-hidden mb-2">
                                            <div class="<?php echo $soatStatusColor['progress']; ?> h-2 rounded-full transition-all duration-500" style="width: <?php echo htmlspecialchars($vehiculo['soat']['progreso']); ?>%"></div>
                                        </div>
                                        <p class="text-xs text-slate-600">Vence: <?php echo htmlspecialchars($vehiculo['soat']['vencimiento']); ?></p>
                                    </div>
                                    
                                    <div class="bg-slate-50 rounded-lg p-4">
                                        <div class="flex justify-between items-center mb-2">
                                            <span class="text-sm font-medium text-slate-900 flex items-center">
                                                <svg class="w-4 h-4 mr-1 text-slate-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"></path>
                                                </svg>
                                                Semaforización
                                            </span>
                                            <?php $semafStatusColor = $status_colors[$vehiculo['semaforizacion']['estado']] ?? $status_colors['Sin información']; ?>
                                            <span class="px-2 py-1 rounded-full text-xs font-semibold <?php echo $semafStatusColor['bg'] . ' ' . $semafStatusColor['text']; ?>">
                                                <?php echo htmlspecialchars($vehiculo['semaforizacion']['estado']); ?>
                                            </span>
                                        </div>
                                        <?php if ($vehiculo['semaforizacion']['estado'] === 'Pago Pendiente'): ?>
                                            <p class="text-xs text-slate-600 mb-1">Deuda total: <span class="font-semibold text-red-600">$<?php echo number_format($vehiculo['semaforizacion']['total_deuda'], 0, ',', '.'); ?></span></p>
                                            <p class="text-xs text-slate-600">Municipios: <?php echo htmlspecialchars(implode(', ', $vehiculo['semaforizacion']['municipios'])); ?></p>
                                        <?php else: ?>
                                            <p class="text-xs text-slate-600">No se encontraron deudas pendientes</p>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>
</div>

<div id="addVehicleModal" class="modal fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center hidden">
</div>

<style>
@keyframes fadeIn {
    from { opacity: 0; transform: translateY(10px); }
    to { opacity: 1; transform: translateY(0); }
}

.vehicle-card {
    animation: fadeIn 0.3s ease-out;
}

.vehicle-card:hover {
    transform: translateY(-2px);
}

.progress-bar {
    animation: progressFill 1s ease-out;
}

@keyframes progressFill {
    from { width: 0%; }
}
</style>