<div class="space-y-6">
    <div class="flex justify-between items-center">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Mis Recordatorios</h1>
            <p class="text-gray-600">Gestiona recordatorios para mantenimientos y vencimientos</p>
        </div>
        <button id="crearRecordatorioBtn" class="px-4 py-2 bg-primary-600 text-white rounded-lg hover:bg-primary-700 transition-colors">
            <i class="fas fa-plus mr-2"></i>Crear Recordatorio
        </button>
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
                <button class="ml-auto -mx-1.5 -my-1.5 bg-green-50 text-green-500 rounded-md p-1.5 focus:outline-none" onclick="this.parentElement.parentElement.remove()">
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
                <button class="ml-auto -mx-1.5 -my-1.5 bg-red-50 text-red-500 rounded-md p-1.5 focus:outline-none" onclick="this.parentElement.parentElement.remove()">
                    <span class="sr-only">Cerrar</span>
                    <i class="fas fa-times"></i>
                </button>
            </div>
        </div>
        <?php unset($_SESSION['error_message']); ?>
    <?php endif; ?>

    <!-- Dashboard principal -->
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">
        <!-- Panel lateral -->
        <div class="lg:col-span-4 space-y-6">
            <!-- Resumen de recordatorios -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Resumen</h3>
                
                <?php 
                $recordatoriosPendientes = 0;
                $recordatoriosProximos = 0; // próximos 7 días
                $recordatoriosCompletados = 0;
                
                $hoy = new DateTime();
                $proximaSemana = (new DateTime())->add(new DateInterval('P7D'));
                
                foreach ($recordatorios as $recordatorio) {
                    $fechaRecordatorio = new DateTime($recordatorio['fecha_recordatorio']);
                    
                    if ($recordatorio['estado'] === 'pendiente') {
                        $recordatoriosPendientes++;
                        
                        if ($fechaRecordatorio >= $hoy && $fechaRecordatorio <= $proximaSemana) {
                            $recordatoriosProximos++;
                        }
                    } elseif ($recordatorio['estado'] === 'completado') {
                        $recordatoriosCompletados++;
                    }
                }
                ?>
                
                <div class="grid grid-cols-2 gap-4 mb-4">
                    <div class="bg-yellow-50 rounded-lg p-4 text-center">
                        <div class="text-xs text-yellow-600 font-medium uppercase mb-1">Pendientes</div>
                        <div class="text-2xl font-bold text-yellow-700"><?php echo $recordatoriosPendientes; ?></div>
                    </div>
                    <div class="bg-green-50 rounded-lg p-4 text-center">
                        <div class="text-xs text-green-600 font-medium uppercase mb-1">Completados</div>
                        <div class="text-2xl font-bold text-green-700"><?php echo $recordatoriosCompletados; ?></div>
                    </div>
                </div>
                
                <?php if ($recordatoriosProximos > 0): ?>
                    <div class="bg-blue-50 text-blue-700 rounded-lg p-3 text-sm flex items-start">
                        <i class="fas fa-bell mt-0.5 mr-2"></i>
                        <div>
                            <strong>Próximos recordatorios:</strong> Tienes <?php echo $recordatoriosProximos; ?> recordatorio<?php echo $recordatoriosProximos > 1 ? 's' : ''; ?> en los próximos 7 días.
                        </div>
                    </div>
                <?php endif; ?>
            </div>
            
            <!-- Filtros -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Filtros</h3>
                
                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Estado</label>
                        <div class="space-y-2">
                            <label class="inline-flex items-center">
                                <input type="radio" name="filtroEstado" value="todos" class="h-4 w-4 text-primary-600 border-gray-300 rounded" checked>
                                <span class="ml-2 text-sm text-gray-700">Todos</span>
                            </label>
                            <br>
                            <label class="inline-flex items-center">
                                <input type="radio" name="filtroEstado" value="pendiente" class="h-4 w-4 text-primary-600 border-gray-300 rounded">
                                <span class="ml-2 text-sm text-gray-700">Pendientes</span>
                            </label>
                            <br>
                            <label class="inline-flex items-center">
                                <input type="radio" name="filtroEstado" value="completado" class="h-4 w-4 text-primary-600 border-gray-300 rounded">
                                <span class="ml-2 text-sm text-gray-700">Completados</span>
                            </label>
                            <br>
                            <label class="inline-flex items-center">
                                <input type="radio" name="filtroEstado" value="cancelado" class="h-4 w-4 text-primary-600 border-gray-300 rounded">
                                <span class="ml-2 text-sm text-gray-700">Cancelados</span>
                            </label>
                        </div>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Vehículo</label>
                        <select id="filtroVehiculo" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500">
                            <option value="">Todos los vehículos</option>
                            <option value="sin_vehiculo">Sin vehículo asignado</option>
                            <?php foreach ($vehiculos as $vehiculo): ?>
                                <option value="<?php echo $vehiculo['id']; ?>"><?php echo $vehiculo['info']['placa']; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Período</label>
                        <select id="filtroPeriodo" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500">
                            <option value="">Todos</option>
                            <option value="hoy">Hoy</option>
                            <option value="semana">Esta semana</option>
                            <option value="mes">Este mes</option>
                            <option value="anio">Este año</option>
                        </select>
                    </div>
                    
                    <button id="aplicarFiltros" class="w-full px-3 py-2 bg-gray-600 text-white text-sm rounded hover:bg-gray-700 transition-colors flex items-center justify-center">
                        <i class="fas fa-filter mr-1"></i>Aplicar filtros
                    </button>
                </div>
            </div>
            
            <!-- Ideas de recordatorios -->
            <div class="bg-gradient-to-br from-indigo-500 to-purple-600 rounded-xl shadow-md p-6 text-white">
                <div class="flex items-center mb-4">
                    <div class="bg-white/20 rounded-full p-2 mr-3">
                        <i class="fas fa-lightbulb text-yellow-300"></i>
                    </div>
                    <h3 class="text-lg font-semibold">Ideas de recordatorios</h3>
                </div>
                
                <ul class="space-y-3 text-indigo-50">
                    <li class="flex items-start">
                        <i class="fas fa-check-circle mt-1 mr-2 text-indigo-200"></i>
                        <p class="text-sm">Vencimiento del extintor</p>
                    </li>
                    <li class="flex items-start">
                        <i class="fas fa-check-circle mt-1 mr-2 text-indigo-200"></i>
                        <p class="text-sm">Cambio de aceite</p>
                    </li>
                    <li class="flex items-start">
                        <i class="fas fa-check-circle mt-1 mr-2 text-indigo-200"></i>
                        <p class="text-sm">Cambio de filtros</p>
                    </li>
                    <li class="flex items-start">
                        <i class="fas fa-check-circle mt-1 mr-2 text-indigo-200"></i>
                        <p class="text-sm">Rotación de llantas</p>
                    </li>
                    <li class="flex items-start">
                        <i class="fas fa-check-circle mt-1 mr-2 text-indigo-200"></i>
                        <p class="text-sm">Alineación y balanceo</p>
                    </li>
                </ul>
                
                <button id="crearRapidoBtn" class="mt-4 w-full px-3 py-2 bg-white/20 hover:bg-white/30 text-white text-sm rounded transition-colors">
                    <i class="fas fa-bolt mr-1"></i>Crear rápido
                </button>
            </div>
        </div>
        
        <!-- Listado de recordatorios -->
        <div class="lg:col-span-8">
            <?php if (empty($recordatorios)): ?>
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 text-center">
                    <div class="py-8">
                        <div class="inline-flex items-center justify-center w-16 h-16 bg-blue-50 rounded-full mb-4">
                            <i class="fas fa-bell text-3xl text-blue-500"></i>
                        </div>
                        <h3 class="text-xl font-medium text-gray-900 mb-2">No tienes recordatorios</h3>
                        <p class="text-gray-600 mb-6 max-w-md mx-auto">Crea tu primer recordatorio para mantenimientos, vencimientos o cualquier evento importante relacionado con tus vehículos.</p>
                        <button id="sinRecordatoriosBtn" class="px-6 py-3 bg-primary-600 text-white rounded-lg hover:bg-primary-700 transition-colors">
                            <i class="fas fa-plus mr-2"></i>Crear mi primer recordatorio
                        </button>
                    </div>
                </div>
            <?php else: ?>
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="text-lg font-semibold text-gray-900">Listado de Recordatorios</h3>
                        <div class="flex items-center space-x-2">
                            <span class="text-sm text-gray-500">Vista:</span>
                            <button class="p-2 bg-gray-100 text-gray-700 rounded-md active" data-view="list">
                                <i class="fas fa-list"></i>
                            </button>
                            <button class="p-2 bg-gray-100 text-gray-700 rounded-md" data-view="calendar">
                                <i class="fas fa-calendar-alt"></i>
                            </button>
                        </div>
                    </div>
                    
                    <div id="listaRecordatorios" class="space-y-4">
                        <?php foreach ($recordatorios as $recordatorio): ?>
                            <?php
                            $fechaRecordatorio = new DateTime($recordatorio['fecha_recordatorio']);
                            $hoy = new DateTime();
                            $diasDiferencia = $hoy->diff($fechaRecordatorio)->days;
                            $esPasado = $fechaRecordatorio < $hoy;
                            
                            // Definir clases de colores según estado y fechas
                            if ($recordatorio['estado'] === 'completado') {
                                $bgColor = 'bg-green-50';
                                $borderColor = 'border-green-200';
                                $indicatorColor = 'bg-green-500';
                            } elseif ($recordatorio['estado'] === 'cancelado') {
                                $bgColor = 'bg-gray-50';
                                $borderColor = 'border-gray-200';
                                $indicatorColor = 'bg-gray-500';
                            } elseif ($esPasado) {
                                $bgColor = 'bg-red-50';
                                $borderColor = 'border-red-200';
                                $indicatorColor = 'bg-red-500';
                            } elseif ($diasDiferencia <= 7) {
                                $bgColor = 'bg-yellow-50';
                                $borderColor = 'border-yellow-200';
                                $indicatorColor = 'bg-yellow-500';
                            } else {
                                $bgColor = 'bg-blue-50';
                                $borderColor = 'border-blue-200';
                                $indicatorColor = 'bg-blue-500';
                            }
                            
                            $frecuenciaText = '';
                            switch ($recordatorio['frecuencia']) {
                                case 'una_vez':
                                    $frecuenciaText = 'Una vez';
                                    break;
                                case 'diario':
                                    $frecuenciaText = 'Diario';
                                    break;
                                case 'semanal':
                                    $frecuenciaText = 'Semanal';
                                    break;
                                case 'mensual':
                                    $frecuenciaText = 'Mensual';
                                    break;
                                case 'anual':
                                    $frecuenciaText = 'Anual';
                                    break;
                            }
                            
                            $iconoEstado = '';
                            switch ($recordatorio['estado']) {
                                case 'pendiente':
                                    $iconoEstado = '<i class="fas fa-clock text-yellow-500"></i>';
                                    break;
                                case 'completado':
                                    $iconoEstado = '<i class="fas fa-check-circle text-green-500"></i>';
                                    break;
                                case 'cancelado':
                                    $iconoEstado = '<i class="fas fa-times-circle text-gray-500"></i>';
                                    break;
                            }
                            ?>
                            
                            <div class="recordatorio-item border <?php echo $borderColor; ?> <?php echo $bgColor; ?> rounded-xl overflow-hidden" 
                                 data-estado="<?php echo $recordatorio['estado']; ?>"
                                 data-vehiculo="<?php echo $recordatorio['vehiculo_id'] ?: 'sin_vehiculo'; ?>">
                                <div class="flex flex-col md:flex-row">
                                    <!-- Indicador de estado (barra lateral) -->
                                    <div class="w-full md:w-1 h-1 md:h-auto <?php echo $indicatorColor; ?>"></div>
                                    
                                    <!-- Contenido principal -->
                                    <div class="flex-1 p-4">
                                        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                                            <!-- Información principal -->
                                            <div class="md:col-span-2">
                                                <div class="flex items-start">
                                                    <div class="flex-shrink-0 mt-1">
                                                        <?php echo $iconoEstado; ?>
                                                    </div>
                                                    <div class="ml-3">
                                                        <h4 class="font-semibold text-gray-900"><?php echo htmlspecialchars($recordatorio['titulo']); ?></h4>
                                                        <?php if (!empty($recordatorio['descripcion'])): ?>
                                                            <p class="text-sm text-gray-600 mt-1"><?php echo htmlspecialchars($recordatorio['descripcion']); ?></p>
                                                        <?php endif; ?>
                                                        
                                                        <?php if (!empty($recordatorio['vehiculo_placa'])): ?>
                                                            <div class="mt-2 inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                                                <i class="fas fa-car mr-1"></i>
                                                                <?php echo $recordatorio['vehiculo_placa']; ?>
                                                            </div>
                                                        <?php endif; ?>
                                                    </div>
                                                </div>
                                            </div>
                                            
                                            <!-- Fechas y detalles -->
                                            <div class="flex flex-col justify-center">
                                                <div class="text-sm text-gray-600">
                                                    <div class="flex items-center mb-1">
                                                        <i class="fas fa-calendar-alt w-5 text-center mr-1"></i>
                                                        <span>Recordatorio: <?php echo date('d/m/Y', strtotime($recordatorio['fecha_recordatorio'])); ?></span>
                                                    </div>
                                                    <div class="flex items-center">
                                                        <i class="fas fa-redo-alt w-5 text-center mr-1"></i>
                                                        <span>Frecuencia: <?php echo $frecuenciaText; ?></span>
                                                    </div>
                                                </div>
                                                
                                                <?php if ($recordatorio['estado'] === 'pendiente'): ?>
                                                    <?php if ($esPasado): ?>
                                                        <div class="mt-2 text-sm text-red-600">
                                                            <i class="fas fa-exclamation-circle mr-1"></i>
                                                            Vencido hace <?php echo $diasDiferencia; ?> día(s)
                                                        </div>
                                                    <?php elseif ($diasDiferencia <= 7): ?>
                                                        <div class="mt-2 text-sm text-yellow-600">
                                                            <i class="fas fa-exclamation-triangle mr-1"></i>
                                                            Faltan <?php echo $diasDiferencia; ?> día(s)
                                                        </div>
                                                    <?php endif; ?>
                                                <?php endif; ?>
                                            </div>
                                            
                                            <!-- Acciones -->
                                            <div class="flex items-center justify-end space-x-2">
                                                <?php if ($recordatorio['estado'] === 'pendiente'): ?>
                                                    <form action="<?php echo BASE_URL; ?>dashboard/recordatorios" method="POST" class="inline-block">
                                                        <input type="hidden" name="accion" value="cambiar_estado">
                                                        <input type="hidden" name="recordatorio_id" value="<?php echo $recordatorio['id']; ?>">
                                                        <input type="hidden" name="estado" value="completado">
                                                        <button type="submit" class="px-3 py-1.5 bg-green-500 text-white text-sm rounded hover:bg-green-600 transition-colors">
                                                            <i class="fas fa-check mr-1"></i>Completar
                                                        </button>
                                                    </form>
                                                <?php endif; ?>
                                                
                                                <div class="relative inline-block text-left">
                                                    <button type="button" class="px-2 py-1.5 border border-gray-300 text-gray-700 text-sm rounded hover:bg-gray-100 transition-colors dropdown-toggle">
                                                        <i class="fas fa-ellipsis-v"></i>
                                                    </button>
                                                    <div class="dropdown-menu hidden absolute right-0 mt-2 w-48 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5 z-10">
                                                        <div class="py-1" role="menu" aria-orientation="vertical">
                                                            <button data-recordatorio-id="<?php echo $recordatorio['id']; ?>" class="editarRecordatorioBtn block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 w-full text-left" role="menuitem">
                                                                <i class="fas fa-edit mr-2"></i>Editar
                                                            </button>
                                                            
                                                            <?php if ($recordatorio['estado'] === 'pendiente'): ?>
                                                                <form action="<?php echo BASE_URL; ?>dashboard/recordatorios" method="POST">
                                                                    <input type="hidden" name="accion" value="cambiar_estado">
                                                                    <input type="hidden" name="recordatorio_id" value="<?php echo $recordatorio['id']; ?>">
                                                                    <input type="hidden" name="estado" value="cancelado">
                                                                    <button type="submit" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 w-full text-left" role="menuitem">
                                                                        <i class="fas fa-ban mr-2"></i>Cancelar
                                                                    </button>
                                                                </form>
                                                            <?php endif; ?>
                                                            
                                                            <form action="<?php echo BASE_URL; ?>dashboard/recordatorios" method="POST" onsubmit="return confirm('¿Estás seguro de eliminar este recordatorio?');">
                                                                <input type="hidden" name="accion" value="cambiar_estado">
                                                                <input type="hidden" name="recordatorio_id" value="<?php echo $recordatorio['id']; ?>">
                                                                <input type="hidden" name="estado" value="eliminar">
                                                                <button type="submit" class="block px-4 py-2 text-sm text-red-700 hover:bg-red-100 w-full text-left" role="menuitem">
                                                                    <i class="fas fa-trash-alt mr-2"></i>Eliminar
                                                                </button>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                    
                    <div id="calendarioRecordatorios" class="hidden mt-4">
                        <div class="bg-gray-100 rounded-lg p-4">
                            <p class="text-center text-gray-500">Vista de calendario próximamente</p>
                        </div>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<!-- Modal para crear recordatorio -->
<div id="crearRecordatorioModal" class="hidden fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center p-4">
    <div class="bg-white rounded-lg shadow-xl max-w-md w-full">
        <div class="border-b px-4 py-3 flex justify-between items-center">
            <h3 class="text-lg font-medium text-gray-900">Crear Recordatorio</h3>
            <button class="cerrarModal text-gray-400 hover:text-gray-500">
                <i class="fas fa-times"></i>
            </button>
        </div>
        
        <form action="<?php echo BASE_URL; ?>dashboard/recordatorios" method="POST" class="p-4">
            <input type="hidden" name="accion" value="crear_recordatorio">
            
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-1" for="titulo">Título *</label>
                <input type="text" id="titulo" name="titulo" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500" required>
            </div>
            
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-1" for="descripcion">Descripción</label>
                <textarea id="descripcion" name="descripcion" rows="3" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500"></textarea>
            </div>
            
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-1" for="vehiculo_id">Vehículo (opcional)</label>
                <select id="vehiculo_id" name="vehiculo_id" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500">
                    <option value="">Seleccionar vehículo</option>
                    <?php foreach ($vehiculos as $vehiculo): ?>
                        <option value="<?php echo $vehiculo['id']; ?>"><?php echo $vehiculo['info']['placa'] . ' - ' . $vehiculo['info']['marca'] . ' ' . $vehiculo['info']['linea']; ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1" for="fecha_inicio">Fecha de inicio *</label>
                    <input type="date" id="fecha_inicio" name="fecha_inicio" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500" required value="<?php echo date('Y-m-d'); ?>">
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1" for="fecha_recordatorio">Fecha de recordatorio *</label>
                    <input type="date" id="fecha_recordatorio" name="fecha_recordatorio" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500" required>
                </div>
            </div>
            
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-1" for="frecuencia">Frecuencia</label>
                <select id="frecuencia" name="frecuencia" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500">
                    <option value="una_vez">Una vez</option>
                    <option value="diario">Diario</option>
                    <option value="semanal">Semanal</option>
                    <option value="mensual">Mensual</option>
                    <option value="anual">Anual</option>
                </select>
            </div>
            
            <div class="mb-6">
                <label class="block text-sm font-medium text-gray-700 mb-1">Notificaciones</label>
                <div class="space-y-2">
                    <label class="inline-flex items-center">
                        <input type="checkbox" name="notificacion_email" class="h-4 w-4 text-primary-600 border-gray-300 rounded" checked>
                        <span class="ml-2 text-sm text-gray-700">Recibir notificación por email</span>
                    </label>
                    <br>
                    <label class="inline-flex items-center">
                        <input type="checkbox" name="notificacion_sms" class="h-4 w-4 text-primary-600 border-gray-300 rounded">
                        <span class="ml-2 text-sm text-gray-700">Recibir notificación por SMS</span>
                    </label>
                </div>
            </div>
            
            <div class="flex justify-end">
                <button type="button" class="cerrarModal mr-2 px-4 py-2 border border-gray-300 rounded-lg text-gray-700 bg-white hover:bg-gray-50">Cancelar</button>
                <button type="submit" class="px-4 py-2 bg-primary-600 text-white rounded-lg hover:bg-primary-700">Crear Recordatorio</button>
            </div>
        </form>
    </div>
</div>

<!-- Modal para editar recordatorio -->
<div id="editarRecordatorioModal" class="hidden fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center p-4">
    <div class="bg-white rounded-lg shadow-xl max-w-md w-full">
        <div class="border-b px-4 py-3 flex justify-between items-center">
            <h3 class="text-lg font-medium text-gray-900">Editar Recordatorio</h3>
            <button class="cerrarModal text-gray-400 hover:text-gray-500">
                <i class="fas fa-times"></i>
            </button>
        </div>
        
        <form action="<?php echo BASE_URL; ?>dashboard/recordatorios" method="POST" class="p-4">
            <input type="hidden" name="accion" value="editar_recordatorio">
            <input type="hidden" name="recordatorio_id" id="editarRecordatorioId">
            
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-1" for="titulo_editar">Título *</label>
                <input type="text" id="titulo_editar" name="titulo" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500" required>
            </div>
            
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-1" for="descripcion_editar">Descripción</label>
                <textarea id="descripcion_editar" name="descripcion" rows="3" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500"></textarea>
            </div>
            
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-1" for="vehiculo_id_editar">Vehículo (opcional)</label>
                <select id="vehiculo_id_editar" name="vehiculo_id" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500">
                    <option value="">Seleccionar vehículo</option>
                    <?php foreach ($vehiculos as $vehiculo): ?>
                        <option value="<?php echo $vehiculo['id']; ?>"><?php echo $vehiculo['info']['placa'] . ' - ' . $vehiculo['info']['marca'] . ' ' . $vehiculo['info']['linea']; ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1" for="fecha_inicio_editar">Fecha de inicio *</label>
                    <input type="date" id="fecha_inicio_editar" name="fecha_inicio" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500" required>
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1" for="fecha_recordatorio_editar">Fecha de recordatorio *</label>
                    <input type="date" id="fecha_recordatorio_editar" name="fecha_recordatorio" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500" required>
                </div>
            </div>
            
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-1" for="frecuencia_editar">Frecuencia</label>
                <select id="frecuencia_editar" name="frecuencia" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500">
                    <option value="una_vez">Una vez</option>
                    <option value="diario">Diario</option>
                    <option value="semanal">Semanal</option>
                    <option value="mensual">Mensual</option>
                    <option value="anual">Anual</option>
                </select>
            </div>
            
            <div class="mb-6">
                <label class="block text-sm font-medium text-gray-700 mb-1">Notificaciones</label>
                <div class="space-y-2">
                    <label class="inline-flex items-center">
                        <input type="checkbox" id="notificacion_email_editar" name="notificacion_email" class="h-4 w-4 text-primary-600 border-gray-300 rounded">
                        <span class="ml-2 text-sm text-gray-700">Recibir notificación por email</span>
                    </label>
                    <br>
                    <label class="inline-flex items-center">
                        <input type="checkbox" id="notificacion_sms_editar" name="notificacion_sms" class="h-4 w-4 text-primary-600 border-gray-300 rounded">
                        <span class="ml-2 text-sm text-gray-700">Recibir notificación por SMS</span>
                    </label>
                </div>
            </div>
            
            <div class="flex justify-end">
                <button type="button" class="cerrarModal mr-2 px-4 py-2 border border-gray-300 rounded-lg text-gray-700 bg-white hover:bg-gray-50">Cancelar</button>
                <button type="submit" class="px-4 py-2 bg-primary-600 text-white rounded-lg hover:bg-primary-700">Actualizar Recordatorio</button>
            </div>
        </form>
    </div>
</div>

<!-- Modal para crear recordatorio rápido -->
<div id="crearRapidoModal" class="hidden fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center p-4">
    <div class="bg-white rounded-lg shadow-xl max-w-md w-full">
        <div class="border-b px-4 py-3 flex justify-between items-center">
            <h3 class="text-lg font-medium text-gray-900">Crear Recordatorio Rápido</h3>
            <button class="cerrarModal text-gray-400 hover:text-gray-500">
                <i class="fas fa-times"></i>
            </button>
        </div>
        
        <div class="p-4">
            <p class="text-sm text-gray-600 mb-4">Selecciona un tipo de recordatorio predefinido para crear rápidamente:</p>
            
            <div class="space-y-2 mb-6">
                <button data-tipo="extintor" class="tipo-rapido w-full text-left px-4 py-3 border border-gray-200 rounded-lg hover:bg-gray-50 transition-colors flex items-center">
                    <div class="bg-red-100 rounded-full p-2 mr-3">
                        <i class="fas fa-fire-extinguisher text-red-500"></i>
                    </div>
                    <div>
                        <div class="font-medium">Vencimiento del extintor</div>
                        <div class="text-xs text-gray-500">Recordatorio anual para renovar el extintor</div>
                    </div>
                </button>
                
                <button data-tipo="aceite" class="tipo-rapido w-full text-left px-4 py-3 border border-gray-200 rounded-lg hover:bg-gray-50 transition-colors flex items-center">
                    <div class="bg-yellow-100 rounded-full p-2 mr-3">
                        <i class="fas fa-oil-can text-yellow-600"></i>
                    </div>
                    <div>
                        <div class="font-medium">Cambio de aceite</div>
                        <div class="text-xs text-gray-500">Cada 5,000 km o 6 meses</div>
                    </div>
                </button>
                
                <button data-tipo="filtros" class="tipo-rapido w-full text-left px-4 py-3 border border-gray-200 rounded-lg hover:bg-gray-50 transition-colors flex items-center">
                    <div class="bg-blue-100 rounded-full p-2 mr-3">
                        <i class="fas fa-filter text-blue-500"></i>
                    </div>
                    <div>
                        <div class="font-medium">Cambio de filtros</div>
                        <div class="text-xs text-gray-500">Filtro de aire, aceite y combustible</div>
                    </div>
                </button>
                
                <button data-tipo="llantas" class="tipo-rapido w-full text-left px-4 py-3 border border-gray-200 rounded-lg hover:bg-gray-50 transition-colors flex items-center">
                    <div class="bg-gray-100 rounded-full p-2 mr-3">
                        <i class="fas fa-cog text-gray-600"></i>
                    </div>
                    <div>
                        <div class="font-medium">Rotación de llantas</div>
                        <div class="text-xs text-gray-500">Cada 10,000 km o 12 meses</div>
                    </div>
                </button>
                
                <button data-tipo="alineacion" class="tipo-rapido w-full text-left px-4 py-3 border border-gray-200 rounded-lg hover:bg-gray-50 transition-colors flex items-center">
                    <div class="bg-purple-100 rounded-full p-2 mr-3">
                        <i class="fas fa-car text-purple-500"></i>
                    </div>
                    <div>
                        <div class="font-medium">Alineación y balanceo</div>
                        <div class="text-xs text-gray-500">Cada 15,000 km o cuando se sienta vibración</div>
                    </div>
                </button>
            </div>
            
            <div class="border-t pt-4">
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-1" for="vehiculo_id_rapido">Seleccionar vehículo *</label>
                    <select id="vehiculo_id_rapido" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500" required>
                        <option value="">Seleccionar vehículo</option>
                        <?php foreach ($vehiculos as $vehiculo): ?>
                            <option value="<?php echo $vehiculo['id']; ?>"><?php echo $vehiculo['info']['placa'] . ' - ' . $vehiculo['info']['marca'] . ' ' . $vehiculo['info']['linea']; ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                
                <form id="formRapido" action="<?php echo BASE_URL; ?>dashboard/recordatorios" method="POST">
                    <input type="hidden" name="accion" value="crear_recordatorio">
                    <input type="hidden" name="vehiculo_id" id="rapido_vehiculo_id">
                    <input type="hidden" name="titulo" id="rapido_titulo">
                    <input type="hidden" name="descripcion" id="rapido_descripcion">
                    <input type="hidden" name="fecha_inicio" id="rapido_fecha_inicio" value="<?php echo date('Y-m-d'); ?>">
                    <input type="hidden" name="fecha_recordatorio" id="rapido_fecha_recordatorio">
                    <input type="hidden" name="frecuencia" id="rapido_frecuencia">
                    <input type="hidden" name="notificacion_email" value="1">
                    
                    <div class="flex justify-end">
                        <button type="button" class="cerrarModal mr-2 px-4 py-2 border border-gray-300 rounded-lg text-gray-700 bg-white hover:bg-gray-50">Cancelar</button>
                        <button type="submit" id="submitRapido" class="px-4 py-2 bg-primary-600 text-white rounded-lg hover:bg-primary-700" disabled>Crear Recordatorio</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Abrir modal de crear recordatorio
        document.getElementById('crearRecordatorioBtn').addEventListener('click', function() {
            document.getElementById('crearRecordatorioModal').classList.remove('hidden');
        });
        
        // Alternativa para cuando no hay recordatorios
        const sinRecordatoriosBtn = document.getElementById('sinRecordatoriosBtn');
        if (sinRecordatoriosBtn) {
            sinRecordatoriosBtn.addEventListener('click', function() {
                document.getElementById('crearRecordatorioModal').classList.remove('hidden');
            });
        }
        
        // Abrir modal de crear rápido
        document.getElementById('crearRapidoBtn').addEventListener('click', function() {
            document.getElementById('crearRapidoModal').classList.remove('hidden');
        });
        
        // Manejar selección de tipo rápido
        document.querySelectorAll('.tipo-rapido').forEach(function(btn) {
            btn.addEventListener('click', function() {
                const tipo = this.getAttribute('data-tipo');
                const vehiculoId = document.getElementById('vehiculo_id_rapido').value;
                
                if (!vehiculoId) {
                    alert('Por favor, selecciona un vehículo primero');
                    return;
                }
                
                // Remover clase seleccionada de todos los botones
                document.querySelectorAll('.tipo-rapido').forEach(function(b) {
                    b.classList.remove('ring-2', 'ring-primary-500');
                });
                
                // Añadir clase seleccionada a este botón
                this.classList.add('ring-2', 'ring-primary-500');
                
                // Establecer valores según el tipo
                const hoy = new Date();
                let fechaRecordatorio = new Date();
                let titulo = '';
                let descripcion = '';
                let frecuencia = '';
                
                switch (tipo) {
                    case 'extintor':
                        fechaRecordatorio.setFullYear(hoy.getFullYear() + 1);
                        titulo = 'Vencimiento del extintor';
                        descripcion = 'Recordatorio para revisar y renovar el extintor del vehículo.';
                        frecuencia = 'anual';
                        break;
                    case 'aceite':
                        fechaRecordatorio.setMonth(hoy.getMonth() + 6);
                        titulo = 'Cambio de aceite';
                        descripcion = 'Recordatorio para realizar el cambio de aceite y filtro de aceite.';
                        frecuencia = 'mensual';
                        break;
                    case 'filtros':
                        fechaRecordatorio.setMonth(hoy.getMonth() + 6);
                        titulo = 'Cambio de filtros';
                        descripcion = 'Recordatorio para revisar y cambiar los filtros de aire, aceite y combustible.';
                        frecuencia = 'mensual';
                        break;
                    case 'llantas':
                        fechaRecordatorio.setMonth(hoy.getMonth() + 12);
                        titulo = 'Rotación de llantas';
                        descripcion = 'Recordatorio para realizar la rotación de llantas para un desgaste uniforme.';
                        frecuencia = 'anual';
                        break;
                    case 'alineacion':
                        fechaRecordatorio.setMonth(hoy.getMonth() + 12);
                        titulo = 'Alineación y balanceo';
                        descripcion = 'Recordatorio para realizar la alineación y balanceo de las llantas.';
                        frecuencia = 'anual';
                        break;
                }
                
                // Formatear fechas para el input date (YYYY-MM-DD)
                const fechaRecordatorioStr = fechaRecordatorio.toISOString().split('T')[0];
                
                // Actualizar campos ocultos
                document.getElementById('rapido_vehiculo_id').value = vehiculoId;
                document.getElementById('rapido_titulo').value = titulo;
                document.getElementById('rapido_descripcion').value = descripcion;
                document.getElementById('rapido_fecha_recordatorio').value = fechaRecordatorioStr;
                document.getElementById('rapido_frecuencia').value = frecuencia;
                
                // Habilitar botón de envío
                document.getElementById('submitRapido').disabled = false;
            });
        });
        
        // Cuando cambia el vehículo en el modal rápido
        document.getElementById('vehiculo_id_rapido').addEventListener('change', function() {
            // Deseleccionar todos los tipos
            document.querySelectorAll('.tipo-rapido').forEach(function(b) {
                b.classList.remove('ring-2', 'ring-primary-500');
            });
            
            // Deshabilitar botón de envío
            document.getElementById('submitRapido').disabled = true;
        });
        
        // Abrir modal de editar recordatorio
        document.querySelectorAll('.editarRecordatorioBtn').forEach(function(btn) {
            btn.addEventListener('click', function() {
                const recordatorioId = this.getAttribute('data-recordatorio-id');
                
                // Hacer una petición AJAX para obtener los datos del recordatorio
                fetch('<?php echo BASE_URL; ?>api/recordatorio.php?id=' + recordatorioId)
                    .then(response => response.json())
                    .then(data => {
                        document.getElementById('editarRecordatorioId').value = data.id;
                        document.getElementById('titulo_editar').value = data.titulo;
                        document.getElementById('descripcion_editar').value = data.descripcion || '';
                        document.getElementById('vehiculo_id_editar').value = data.vehiculo_id || '';
                        document.getElementById('fecha_inicio_editar').value = data.fecha_inicio;
                        document.getElementById('fecha_recordatorio_editar').value = data.fecha_recordatorio;
                        document.getElementById('frecuencia_editar').value = data.frecuencia;
                        document.getElementById('notificacion_email_editar').checked = data.notificacion_email == 1;
                        document.getElementById('notificacion_sms_editar').checked = data.notificacion_sms == 1;
                        
                        document.getElementById('editarRecordatorioModal').classList.remove('hidden');
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        alert('Error al cargar los datos del recordatorio');
                    });
            });
        });
        
        // Cerrar modales
        document.querySelectorAll('.cerrarModal').forEach(function(btn) {
            btn.addEventListener('click', function() {
                document.getElementById('crearRecordatorioModal').classList.add('hidden');
                document.getElementById('editarRecordatorioModal').classList.add('hidden');
                document.getElementById('crearRapidoModal').classList.add('hidden');
            });
        });
        
        // Mostrar/ocultar menús desplegables
        document.querySelectorAll('.dropdown-toggle').forEach(function(toggle) {
            toggle.addEventListener('click', function(e) {
                e.stopPropagation();
                const menu = this.nextElementSibling;
                menu.classList.toggle('hidden');
                
                // Cerrar otros menús abiertos
                document.querySelectorAll('.dropdown-menu').forEach(function(m) {
                    if (m !== menu) {
                        m.classList.add('hidden');
                    }
                });
            });
        });
        
        // Cerrar menús al hacer clic fuera
        document.addEventListener('click', function() {
            document.querySelectorAll('.dropdown-menu').forEach(function(menu) {
                menu.classList.add('hidden');
            });
        });
        
        // Cambiar entre vista de lista y calendario
        document.querySelectorAll('[data-view]').forEach(function(btn) {
            btn.addEventListener('click', function() {
                const view = this.getAttribute('data-view');
                
                // Quitar clase activa de todos los botones
                document.querySelectorAll('[data-view]').forEach(function(b) {
                    b.classList.remove('active', 'bg-gray-200');
                    b.classList.add('bg-gray-100');
                });
                
                // Añadir clase activa a este botón
                this.classList.add('active', 'bg-gray-200');
                this.classList.remove('bg-gray-100');
                
                // Mostrar la vista correspondiente
                if (view === 'list') {
                    document.getElementById('listaRecordatorios').classList.remove('hidden');
                    document.getElementById('calendarioRecordatorios').classList.add('hidden');
                } else if (view === 'calendar') {
                    document.getElementById('listaRecordatorios').classList.add('hidden');
                    document.getElementById('calendarioRecordatorios').classList.remove('hidden');
                }
            });
        });
        
        // Filtrar recordatorios
        document.getElementById('aplicarFiltros').addEventListener('click', function() {
            const filtroEstado = document.querySelector('input[name="filtroEstado"]:checked').value;
            const filtroVehiculo = document.getElementById('filtroVehiculo').value;
            const filtroPeriodo = document.getElementById('filtroPeriodo').value;
            
            const items = document.querySelectorAll('.recordatorio-item');
            
            items.forEach(function(item) {
                const estado = item.getAttribute('data-estado');
                const vehiculo = item.getAttribute('data-vehiculo');
                let mostrar = true;
                
                // Filtro de estado
                if (filtroEstado !== 'todos' && estado !== filtroEstado) {
                    mostrar = false;
                }
                
                // Filtro de vehículo
                if (filtroVehiculo && filtroVehiculo !== vehiculo) {
                    mostrar = false;
                }
                
                // Filtro de período (simulado - en una implementación real se haría con fechas)
                if (filtroPeriodo) {
                    // Aquí se implementaría la lógica para filtrar por período
                }
                
                if (mostrar) {
                    item.classList.remove('hidden');
                } else {
                    item.classList.add('hidden');
                }
            });
        });
    });
</script>