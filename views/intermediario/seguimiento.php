<?php // views/intermediario/seguimiento.php ?>

<div class="space-y-6">
    <div class="flex justify-between items-center">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Seguimiento de Clientes</h1>
            <p class="text-gray-600">Gestiona recordatorios para seguimiento de cotizaciones y clientes</p>
        </div>
        <button id="crearSeguimientoBtn" class="px-4 py-2 bg-primary-600 text-white rounded-lg hover:bg-primary-700 transition-colors">
            <i class="fas fa-plus mr-2"></i>Crear Seguimiento
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
            <!-- Resumen de seguimientos -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Resumen</h3>
                
                <?php 
                $seguimientosPendientes = 0;
                $seguimientosProximos = 0; // próximos 3 días
                $seguimientosCompletados = 0;
                
                $hoy = new DateTime();
                $proximosDias = (new DateTime())->add(new DateInterval('P3D'));
                
                foreach ($seguimientos as $seguimiento) {
                    $fechaSeguimiento = new DateTime($seguimiento['fecha_recordatorio']);
                    
                    if ($seguimiento['estado'] === 'pendiente') {
                        $seguimientosPendientes++;
                        
                        if ($fechaSeguimiento >= $hoy && $fechaSeguimiento <= $proximosDias) {
                            $seguimientosProximos++;
                        }
                    } elseif ($seguimiento['estado'] === 'completado') {
                        $seguimientosCompletados++;
                    }
                }
                ?>
                
                <div class="grid grid-cols-2 gap-4 mb-4">
                    <div class="bg-yellow-50 rounded-lg p-4 text-center">
                        <div class="text-xs text-yellow-600 font-medium uppercase mb-1">Pendientes</div>
                        <div class="text-2xl font-bold text-yellow-700"><?php echo $seguimientosPendientes; ?></div>
                    </div>
                    <div class="bg-green-50 rounded-lg p-4 text-center">
                        <div class="text-xs text-green-600 font-medium uppercase mb-1">Completados</div>
                        <div class="text-2xl font-bold text-green-700"><?php echo $seguimientosCompletados; ?></div>
                    </div>
                </div>
                
                <?php if ($seguimientosProximos > 0): ?>
                    <div class="bg-blue-50 text-blue-700 rounded-lg p-3 text-sm flex items-start">
                        <i class="fas fa-bell mt-0.5 mr-2"></i>
                        <div>
                            <strong>Próximos seguimientos:</strong> Tienes <?php echo $seguimientosProximos; ?> seguimiento<?php echo $seguimientosProximos > 1 ? 's' : ''; ?> en los próximos 3 días.
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
                        <label class="block text-sm font-medium text-gray-700 mb-1">Tipo</label>
                        <select id="filtroTipo" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500">
                            <option value="">Todos los tipos</option>
                            <option value="cotizacion">Seguimiento de cotización</option>
                            <option value="renovacion">Recordatorio de renovación</option>
                            <option value="cumpleanos">Cumpleaños de cliente</option>
                            <option value="otro">Otro tipo</option>
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
            
            <!-- Ideas de seguimiento -->
            <div class="bg-gradient-to-br from-blue-500 to-indigo-600 rounded-xl shadow-md p-6 text-white">
                <div class="flex items-center mb-4">
                    <div class="bg-white/20 rounded-full p-2 mr-3">
                        <i class="fas fa-lightbulb text-yellow-300"></i>
                    </div>
                    <h3 class="text-lg font-semibold">Ideas de seguimiento</h3>
                </div>
                
                <ul class="space-y-3 text-blue-50">
                    <li class="flex items-start">
                        <i class="fas fa-check-circle mt-1 mr-2 text-blue-200"></i>
                        <p class="text-sm">Seguimiento de cotización (3 días)</p>
                    </li>
                    <li class="flex items-start">
                        <i class="fas fa-check-circle mt-1 mr-2 text-blue-200"></i>
                        <p class="text-sm">Recordatorio de renovación</p>
                    </li>
                    <li class="flex items-start">
                        <i class="fas fa-check-circle mt-1 mr-2 text-blue-200"></i>
                        <p class="text-sm">Cumpleaños de cliente</p>
                    </li>
                    <li class="flex items-start">
                        <i class="fas fa-check-circle mt-1 mr-2 text-blue-200"></i>
                        <p class="text-sm">Seguimiento post-venta</p>
                    </li>
                    <li class="flex items-start">
                        <i class="fas fa-check-circle mt-1 mr-2 text-blue-200"></i>
                        <p class="text-sm">Vencimiento de pólizas</p>
                    </li>
                </ul>
                
                <button id="crearRapidoBtn" class="mt-4 w-full px-3 py-2 bg-white/20 hover:bg-white/30 text-white text-sm rounded transition-colors">
                    <i class="fas fa-bolt mr-1"></i>Crear rápido
                </button>
            </div>
        </div>
        
        <!-- Listado de seguimientos -->
        <div class="lg:col-span-8">
            <?php if (empty($seguimientos)): ?>
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 text-center">
                    <div class="py-8">
                        <div class="inline-flex items-center justify-center w-16 h-16 bg-blue-50 rounded-full mb-4">
                            <i class="fas fa-user-clock text-3xl text-blue-500"></i>
                        </div>
                        <h3 class="text-xl font-medium text-gray-900 mb-2">No tienes seguimientos</h3>
                        <p class="text-gray-600 mb-6 max-w-md mx-auto">Crea tu primer seguimiento para gestionar tus contactos con clientes y convertir más cotizaciones en ventas.</p>
                        <button id="sinSeguimientosBtn" class="px-6 py-3 bg-primary-600 text-white rounded-lg hover:bg-primary-700 transition-colors">
                            <i class="fas fa-plus mr-2"></i>Crear mi primer seguimiento
                        </button>
                    </div>
                </div>
            <?php else: ?>
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="text-lg font-semibold text-gray-900">Listado de Seguimientos</h3>
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
                    
                    <div id="listaSeguimientos" class="space-y-4">
                        <?php foreach ($seguimientos as $seguimiento): ?>
                            <?php
                            $fechaSeguimiento = new DateTime($seguimiento['fecha_recordatorio']);
                            $hoy = new DateTime();
                            $diasDiferencia = $hoy->diff($fechaSeguimiento)->days;
                            $esPasado = $fechaSeguimiento < $hoy;
                            
                            // Definir clases de colores según estado y fechas
                            if ($seguimiento['estado'] === 'completado') {
                                $bgColor = 'bg-green-50';
                                $borderColor = 'border-green-200';
                                $indicatorColor = 'bg-green-500';
                            } elseif ($seguimiento['estado'] === 'cancelado') {
                                $bgColor = 'bg-gray-50';
                                $borderColor = 'border-gray-200';
                                $indicatorColor = 'bg-gray-500';
                            } elseif ($esPasado) {
                                $bgColor = 'bg-red-50';
                                $borderColor = 'border-red-200';
                                $indicatorColor = 'bg-red-500';
                            } elseif ($diasDiferencia <= 3) {
                                $bgColor = 'bg-yellow-50';
                                $borderColor = 'border-yellow-200';
                                $indicatorColor = 'bg-yellow-500';
                            } else {
                                $bgColor = 'bg-blue-50';
                                $borderColor = 'border-blue-200';
                                $indicatorColor = 'bg-blue-500';
                            }
                            
                            $frecuenciaText = '';
                            switch ($seguimiento['frecuencia']) {
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
                            switch ($seguimiento['estado']) {
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

                            $iconoTipo = '';
                            switch ($seguimiento['tipo']) {
                                case 'cotizacion':
                                    $iconoTipo = '<i class="fas fa-file-invoice-dollar"></i>';
                                    break;
                                case 'renovacion':
                                    $iconoTipo = '<i class="fas fa-sync-alt"></i>';
                                    break;
                                case 'cumpleanos':
                                    $iconoTipo = '<i class="fas fa-birthday-cake"></i>';
                                    break;
                                case 'post_venta':
                                    $iconoTipo = '<i class="fas fa-headset"></i>';
                                    break;
                                default:
                                    $iconoTipo = '<i class="fas fa-tag"></i>';
                            }
                            ?>
                            
                            <div class="seguimiento-item border <?php echo $borderColor; ?> <?php echo $bgColor; ?> rounded-xl overflow-hidden" 
                                 data-estado="<?php echo $seguimiento['estado']; ?>"
                                 data-tipo="<?php echo $seguimiento['tipo']; ?>">
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
                                                        <h4 class="font-semibold text-gray-900"><?php echo htmlspecialchars($seguimiento['titulo']); ?></h4>
                                                        <?php if (!empty($seguimiento['descripcion'])): ?>
                                                            <p class="text-sm text-gray-600 mt-1"><?php echo htmlspecialchars($seguimiento['descripcion']); ?></p>
                                                        <?php endif; ?>
                                                        
                                                        <div class="mt-2 inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                                            <?php echo $iconoTipo; ?>
                                                            <span class="ml-1"><?php echo ucfirst(str_replace('_', ' ', $seguimiento['tipo'])); ?></span>
                                                        </div>
                                                        
                                                        <?php if (!empty($seguimiento['cliente_nombre'])): ?>
                                                            <div class="mt-1 inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                                                <i class="fas fa-user mr-1"></i>
                                                                <?php echo $seguimiento['cliente_nombre']; ?>
                                                            </div>
                                                        <?php endif; ?>
                                                        
                                                        <?php if (!empty($seguimiento['cotizacion_id'])): ?>
                                                            <div class="mt-1 inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-purple-100 text-purple-800">
                                                                <i class="fas fa-file-invoice-dollar mr-1"></i>
                                                                Cotización #<?php echo $seguimiento['cotizacion_id']; ?>
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
                                                        <span>Seguimiento: <?php echo date('d/m/Y', strtotime($seguimiento['fecha_recordatorio'])); ?></span>
                                                    </div>
                                                    <div class="flex items-center">
                                                        <i class="fas fa-redo-alt w-5 text-center mr-1"></i>
                                                        <span>Frecuencia: <?php echo $frecuenciaText; ?></span>
                                                    </div>
                                                </div>
                                                
                                                <?php if ($seguimiento['estado'] === 'pendiente'): ?>
                                                    <?php if ($esPasado): ?>
                                                        <div class="mt-2 text-sm text-red-600">
                                                            <i class="fas fa-exclamation-circle mr-1"></i>
                                                            Vencido hace <?php echo $diasDiferencia; ?> día(s)
                                                        </div>
                                                    <?php elseif ($diasDiferencia <= 3): ?>
                                                        <div class="mt-2 text-sm text-yellow-600">
                                                            <i class="fas fa-exclamation-triangle mr-1"></i>
                                                            Faltan <?php echo $diasDiferencia; ?> día(s)
                                                        </div>
                                                    <?php endif; ?>
                                                <?php endif; ?>
                                            </div>
                                            
                                            <!-- Acciones -->
                                            <div class="flex items-center justify-end space-x-2">
                                                <?php if ($seguimiento['estado'] === 'pendiente'): ?>
                                                    <form action="<?php echo BASE_URL; ?>intermediario/seguimiento" method="POST" class="inline-block">
                                                        <input type="hidden" name="accion" value="cambiar_estado">
                                                        <input type="hidden" name="seguimiento_id" value="<?php echo $seguimiento['id']; ?>">
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
                                                            <button data-seguimiento-id="<?php echo $seguimiento['id']; ?>" class="editarSeguimientoBtn block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 w-full text-left" role="menuitem">
                                                                <i class="fas fa-edit mr-2"></i>Editar
                                                            </button>
                                                            
                                                            <?php if (!empty($seguimiento['cotizacion_id'])): ?>
                                                                <a href="<?php echo BASE_URL; ?>intermediario/gestionar_cotizacion/<?php echo $seguimiento['cotizacion_id']; ?>" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 w-full text-left" role="menuitem">
                                                                    <i class="fas fa-file-invoice-dollar mr-2"></i>Ver Cotización
                                                                </a>
                                                            <?php endif; ?>
                                                            
                                                            <?php if ($seguimiento['estado'] === 'pendiente'): ?>
                                                                <form action="<?php echo BASE_URL; ?>intermediario/seguimiento" method="POST">
                                                                    <input type="hidden" name="accion" value="cambiar_estado">
                                                                    <input type="hidden" name="seguimiento_id" value="<?php echo $seguimiento['id']; ?>">
                                                                    <input type="hidden" name="estado" value="cancelado">
                                                                    <button type="submit" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 w-full text-left" role="menuitem">
                                                                        <i class="fas fa-ban mr-2"></i>Cancelar
                                                                    </button>
                                                                </form>
                                                            <?php endif; ?>
                                                            
                                                            <form action="<?php echo BASE_URL; ?>intermediario/seguimiento" method="POST" onsubmit="return confirm('¿Estás seguro de eliminar este seguimiento?');">
                                                                <input type="hidden" name="accion" value="cambiar_estado">
                                                                <input type="hidden" name="seguimiento_id" value="<?php echo $seguimiento['id']; ?>">
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
                    
                    <div id="calendarioSeguimientos" class="hidden mt-4">
                        <div class="bg-gray-100 rounded-lg p-4">
                            <p class="text-center text-gray-500">Vista de calendario próximamente</p>
                        </div>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<!-- Modal para crear seguimiento -->
<div id="crearSeguimientoModal" class="hidden fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center p-4">
    <div class="bg-white rounded-lg shadow-xl max-w-md w-full">
        <div class="border-b px-4 py-3 flex justify-between items-center">
            <h3 class="text-lg font-medium text-gray-900">Crear Seguimiento</h3>
            <button class="cerrarModal text-gray-400 hover:text-gray-500">
                <i class="fas fa-times"></i>
            </button>
        </div>
        
        <form action="<?php echo BASE_URL; ?>intermediario/seguimiento" method="POST" class="p-4">
            <input type="hidden" name="accion" value="crear_seguimiento">
            
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-1" for="titulo">Título *</label>
                <input type="text" id="titulo" name="titulo" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500" required>
            </div>
            
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-1" for="tipo">Tipo de Seguimiento *</label>
                <select id="tipo" name="tipo" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500" required>
                    <option value="">Seleccionar tipo</option>
                    <option value="cotizacion">Seguimiento de cotización</option>
                    <option value="renovacion">Recordatorio de renovación</option>
                    <option value="cumpleanos">Cumpleaños de cliente</option>
                    <option value="post_venta">Seguimiento post-venta</option>
                    <option value="otro">Otro</option>
                </select>
            </div>
            
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-1" for="descripcion">Descripción</label>
                <textarea id="descripcion" name="descripcion" rows="3" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500"></textarea>
            </div>
            
            <div class="mb-4" id="cotizacionContainer" style="display: none;">
                <label class="block text-sm font-medium text-gray-700 mb-1" for="cotizacion_id">Cotización relacionada</label>
               <select id="cotizacion_id" name="cotizacion_id" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500">
                    <option value="">Seleccionar cotización</option>
                    <?php foreach ($cotizaciones as $cotizacion): ?>
                        <option value="<?php echo $cotizacion['id']; ?>">
                            #<?php echo $cotizacion['id']; ?> - <?php echo $cotizacion['producto']; ?> - <?php echo $cotizacion['nombre_cliente']; ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-1" for="cliente_nombre">Nombre del Cliente</label>
                <input type="text" id="cliente_nombre" name="cliente_nombre" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500">
            </div>
            
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-1" for="cliente_telefono">Teléfono del Cliente</label>
                <input type="tel" id="cliente_telefono" name="cliente_telefono" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500">
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1" for="fecha_inicio">Fecha de inicio *</label>
                    <input type="date" id="fecha_inicio" name="fecha_inicio" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500" required value="<?php echo date('Y-m-d'); ?>">
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1" for="fecha_recordatorio">Fecha de seguimiento *</label>
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
                <button type="submit" class="px-4 py-2 bg-primary-600 text-white rounded-lg hover:bg-primary-700">Crear Seguimiento</button>
            </div>
        </form>
    </div>
</div>

<!-- Modal para editar seguimiento -->
<div id="editarSeguimientoModal" class="hidden fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center p-4">
    <div class="bg-white rounded-lg shadow-xl max-w-md w-full">
        <div class="border-b px-4 py-3 flex justify-between items-center">
            <h3 class="text-lg font-medium text-gray-900">Editar Seguimiento</h3>
            <button class="cerrarModal text-gray-400 hover:text-gray-500">
                <i class="fas fa-times"></i>
            </button>
        </div>
        
        <form action="<?php echo BASE_URL; ?>intermediario/seguimiento" method="POST" class="p-4">
            <input type="hidden" name="accion" value="editar_seguimiento">
            <input type="hidden" name="seguimiento_id" id="editarSeguimientoId">
            
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-1" for="titulo_editar">Título *</label>
                <input type="text" id="titulo_editar" name="titulo" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500" required>
            </div>
            
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-1" for="tipo_editar">Tipo de Seguimiento *</label>
                <select id="tipo_editar" name="tipo" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500" required>
                    <option value="">Seleccionar tipo</option>
                    <option value="cotizacion">Seguimiento de cotización</option>
                    <option value="renovacion">Recordatorio de renovación</option>
                    <option value="cumpleanos">Cumpleaños de cliente</option>
                    <option value="post_venta">Seguimiento post-venta</option>
                    <option value="otro">Otro</option>
                </select>
            </div>
            
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-1" for="descripcion_editar">Descripción</label>
                <textarea id="descripcion_editar" name="descripcion" rows="3" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500"></textarea>
            </div>
            
            <div class="mb-4" id="cotizacionContainer_editar">
                <label class="block text-sm font-medium text-gray-700 mb-1" for="cotizacion_id_editar">Cotización relacionada</label>
                <select id="cotizacion_id_editar" name="cotizacion_id" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500">
                    <option value="">Seleccionar cotización</option>
                    <?php foreach ($cotizaciones as $cotizacion): ?>
                        <option value="<?php echo $cotizacion['id']; ?>">
                            #<?php echo $cotizacion['id']; ?> - <?php echo $cotizacion['producto']; ?> - <?php echo $cotizacion['nombre_cliente']; ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-1" for="cliente_nombre_editar">Nombre del Cliente</label>
                <input type="text" id="cliente_nombre_editar" name="cliente_nombre" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500">
            </div>
            
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-1" for="cliente_telefono_editar">Teléfono del Cliente</label>
                <input type="tel" id="cliente_telefono_editar" name="cliente_telefono" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500">
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1" for="fecha_inicio_editar">Fecha de inicio *</label>
                    <input type="date" id="fecha_inicio_editar" name="fecha_inicio" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500" required>
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1" for="fecha_recordatorio_editar">Fecha de seguimiento *</label>
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
                <button type="submit" class="px-4 py-2 bg-primary-600 text-white rounded-lg hover:bg-primary-700">Actualizar Seguimiento</button>
            </div>
        </form>
    </div>
</div>

<!-- Modal para crear seguimiento rápido -->
<div id="crearRapidoModal" class="hidden fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center p-4">
    <div class="bg-white rounded-lg shadow-xl max-w-md w-full">
        <div class="border-b px-4 py-3 flex justify-between items-center">
            <h3 class="text-lg font-medium text-gray-900">Crear Seguimiento Rápido</h3>
            <button class="cerrarModal text-gray-400 hover:text-gray-500">
                <i class="fas fa-times"></i>
            </button>
        </div>
        
        <div class="p-4">
            <p class="text-sm text-gray-600 mb-4">Selecciona un tipo de seguimiento predefinido para crear rápidamente:</p>
            
            <div class="space-y-2 mb-6">
                <button data-tipo="cotizacion" class="tipo-rapido w-full text-left px-4 py-3 border border-gray-200 rounded-lg hover:bg-gray-50 transition-colors flex items-center">
                    <div class="bg-blue-100 rounded-full p-2 mr-3">
                        <i class="fas fa-file-invoice-dollar text-blue-500"></i>
                    </div>
                    <div>
                        <div class="font-medium">Seguimiento de cotización</div>
                        <div class="text-xs text-gray-500">Seguimiento a los 3 días de enviar una cotización</div>
                    </div>
                </button>
                
                <button data-tipo="renovacion" class="tipo-rapido w-full text-left px-4 py-3 border border-gray-200 rounded-lg hover:bg-gray-50 transition-colors flex items-center">
                    <div class="bg-green-100 rounded-full p-2 mr-3">
                        <i class="fas fa-sync-alt text-green-500"></i>
                    </div>
                    <div>
                        <div class="font-medium">Recordatorio de renovación</div>
                        <div class="text-xs text-gray-500">Recordatorio 30 días antes del vencimiento</div>
                    </div>
                </button>
                
                <button data-tipo="cumpleanos" class="tipo-rapido w-full text-left px-4 py-3 border border-gray-200 rounded-lg hover:bg-gray-50 transition-colors flex items-center">
                    <div class="bg-red-100 rounded-full p-2 mr-3">
                        <i class="fas fa-birthday-cake text-red-500"></i>
                    </div>
                    <div>
                        <div class="font-medium">Cumpleaños de cliente</div>
                        <div class="text-xs text-gray-500">Recordatorio anual para felicitar al cliente</div>
                    </div>
                </button>
                
                <button data-tipo="post_venta" class="tipo-rapido w-full text-left px-4 py-3 border border-gray-200 rounded-lg hover:bg-gray-50 transition-colors flex items-center">
                    <div class="bg-purple-100 rounded-full p-2 mr-3">
                        <i class="fas fa-headset text-purple-500"></i>
                    </div>
                    <div>
                        <div class="font-medium">Seguimiento post-venta</div>
                        <div class="text-xs text-gray-500">Seguimiento a los 15 días de una compra</div>
                    </div>
                </button>
                
                <button data-tipo="vencimiento" class="tipo-rapido w-full text-left px-4 py-3 border border-gray-200 rounded-lg hover:bg-gray-50 transition-colors flex items-center">
                    <div class="bg-yellow-100 rounded-full p-2 mr-3">
                        <i class="fas fa-exclamation-triangle text-yellow-500"></i>
                    </div>
                    <div>
                        <div class="font-medium">Vencimiento de póliza</div>
                        <div class="text-xs text-gray-500">Aviso para renovación de documento</div>
                    </div>
                </button>
            </div>
            
            <div class="border-t pt-4" id="rapido_cotizacion_container" style="display: none;">
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-1" for="cotizacion_id_rapido">Seleccionar cotización *</label>
                    <select id="cotizacion_id_rapido" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500">
                        <option value="">Seleccionar cotización</option>
                        <?php foreach ($cotizaciones as $cotizacion): ?>
                            <option value="<?php echo $cotizacion['id']; ?>" 
                                    data-cliente="<?php echo htmlspecialchars($cotizacion['nombre_cliente']); ?>" 
                                    data-telefono="<?php echo htmlspecialchars($cotizacion['telefono_cliente']); ?>">
                                #<?php echo $cotizacion['id']; ?> - <?php echo $cotizacion['producto']; ?> - <?php echo $cotizacion['nombre_cliente']; ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>
            
            <div class="border-t pt-4" id="rapido_cliente_container" style="display: none;">
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-1" for="cliente_nombre_rapido">Nombre del cliente *</label>
                    <input type="text" id="cliente_nombre_rapido" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500">
                </div>
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-1" for="cliente_telefono_rapido">Teléfono del cliente</label>
                    <input type="tel" id="cliente_telefono_rapido" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500">
                </div>
            </div>
            
            <form id="formRapido" action="<?php echo BASE_URL; ?>intermediario/seguimiento" method="POST">
                <input type="hidden" name="accion" value="crear_seguimiento">
                <input type="hidden" name="tipo" id="rapido_tipo">
                <input type="hidden" name="cotizacion_id" id="rapido_cotizacion_id">
                <input type="hidden" name="cliente_nombre" id="rapido_cliente_nombre_hidden">
                <input type="hidden" name="cliente_telefono" id="rapido_cliente_telefono_hidden">
                <input type="hidden" name="titulo" id="rapido_titulo">
                <input type="hidden" name="descripcion" id="rapido_descripcion">
                <input type="hidden" name="fecha_inicio" id="rapido_fecha_inicio" value="<?php echo date('Y-m-d'); ?>">
                <input type="hidden" name="fecha_recordatorio" id="rapido_fecha_recordatorio">
                <input type="hidden" name="frecuencia" id="rapido_frecuencia">
                <input type="hidden" name="notificacion_email" value="1">
                
                <div class="flex justify-end">
                    <button type="button" class="cerrarModal mr-2 px-4 py-2 border border-gray-300 rounded-lg text-gray-700 bg-white hover:bg-gray-50">Cancelar</button>
                    <button type="submit" id="submitRapido" class="px-4 py-2 bg-primary-600 text-white rounded-lg hover:bg-primary-700" disabled>Crear Seguimiento</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Mostrar/ocultar campo de cotización según tipo
        const tipoSelect = document.getElementById('tipo');
        const cotizacionContainer = document.getElementById('cotizacionContainer');
        
        if (tipoSelect) {
            tipoSelect.addEventListener('change', function() {
                if (this.value === 'cotizacion') {
                    cotizacionContainer.style.display = 'block';
                } else {
                    cotizacionContainer.style.display = 'none';
                }
            });
        }
        
        // Abrir modal de crear seguimiento
        document.getElementById('crearSeguimientoBtn').addEventListener('click', function() {
            document.getElementById('crearSeguimientoModal').classList.remove('hidden');
        });
        
        // Alternativa para cuando no hay seguimientos
        const sinSeguimientosBtn = document.getElementById('sinSeguimientosBtn');
        if (sinSeguimientosBtn) {
            sinSeguimientosBtn.addEventListener('click', function() {
                document.getElementById('crearSeguimientoModal').classList.remove('hidden');
            });
        }
        
        // Abrir modal de crear rápido
        document.getElementById('crearRapidoBtn').addEventListener('click', function() {
            document.getElementById('crearRapidoModal').classList.remove('hidden');
        });
        
        // Cuando se selecciona una cotización en el modal rápido
        const cotizacionRapidoSelect = document.getElementById('cotizacion_id_rapido');
        if (cotizacionRapidoSelect) {
            cotizacionRapidoSelect.addEventListener('change', function() {
                const option = this.options[this.selectedIndex];
                if (option && option.value) {
                    const clienteNombre = option.getAttribute('data-cliente');
                    const clienteTelefono = option.getAttribute('data-telefono');
                    
                    document.getElementById('rapido_cotizacion_id').value = option.value;
                    document.getElementById('rapido_cliente_nombre_hidden').value = clienteNombre;
                    document.getElementById('rapido_cliente_telefono_hidden').value = clienteTelefono;
                    
                    // Habilitar botón de envío
                    document.getElementById('submitRapido').disabled = false;
                } else {
                    document.getElementById('submitRapido').disabled = true;
                }
            });
        }
        
        // Cuando se ingresa un nombre de cliente en el modal rápido
        const clienteNombreRapido = document.getElementById('cliente_nombre_rapido');
        const clienteTelefonoRapido = document.getElementById('cliente_telefono_rapido');
        
        if (clienteNombreRapido) {
            clienteNombreRapido.addEventListener('input', function() {
                document.getElementById('rapido_cliente_nombre_hidden').value = this.value;
                if (this.value) {
                    document.getElementById('submitRapido').disabled = false;
                } else {
                    document.getElementById('submitRapido').disabled = true;
                }
            });
        }
        
        if (clienteTelefonoRapido) {
            clienteTelefonoRapido.addEventListener('input', function() {
                document.getElementById('rapido_cliente_telefono_hidden').value = this.value;
            });
        }
        
        // Manejar selección de tipo rápido
        document.querySelectorAll('.tipo-rapido').forEach(function(btn) {
            btn.addEventListener('click', function() {
                const tipo = this.getAttribute('data-tipo');
                
                // Remover clase seleccionada de todos los botones
                document.querySelectorAll('.tipo-rapido').forEach(function(b) {
                    b.classList.remove('ring-2', 'ring-primary-500');
                });
                
                // Añadir clase seleccionada a este botón
                this.classList.add('ring-2', 'ring-primary-500');
                
                // Ocultar todos los contenedores específicos
                document.getElementById('rapido_cotizacion_container').style.display = 'none';
                document.getElementById('rapido_cliente_container').style.display = 'none';
                
                // Establecer valores según el tipo
                const hoy = new Date();
                let fechaRecordatorio = new Date();
                let titulo = '';
                let descripcion = '';
                let frecuencia = 'una_vez';
                
                switch (tipo) {
                    case 'cotizacion':
                        fechaRecordatorio.setDate(hoy.getDate() + 3);
                        titulo = 'Seguimiento de cotización';
                        descripcion = 'Contactar al cliente para conocer si está interesado en la cotización enviada.';
                        document.getElementById('rapido_cotizacion_container').style.display = 'block';
                        document.getElementById('submitRapido').disabled = true;
                        break;
                    case 'renovacion':
                        fechaRecordatorio.setDate(hoy.getDate() + 30);
                        titulo = 'Recordatorio de renovación';
                        descripcion = 'Contactar al cliente para recordarle la renovación próxima de su póliza.';
                        document.getElementById('rapido_cliente_container').style.display = 'block';
                        document.getElementById('submitRapido').disabled = true;
                        break;
                    case 'cumpleanos':
                        titulo = 'Cumpleaños de cliente';
                        descripcion = 'Felicitar al cliente por su cumpleaños.';
                        frecuencia = 'anual';
                        document.getElementById('rapido_cliente_container').style.display = 'block';
                        document.getElementById('submitRapido').disabled = true;
                        break;
                    case 'post_venta':
                        fechaRecordatorio.setDate(hoy.getDate() + 15);
                        titulo = 'Seguimiento post-venta';
                        descripcion = 'Contactar al cliente para verificar su satisfacción con el producto adquirido.';
                        document.getElementById('rapido_cliente_container').style.display = 'block';
                        document.getElementById('submitRapido').disabled = true;
                        break;
                    case 'vencimiento':
                        fechaRecordatorio.setDate(hoy.getDate() + 30);
                        titulo = 'Vencimiento de póliza';
                        descripcion = 'Recordatorio para contactar al cliente sobre el vencimiento de su póliza.';
                        document.getElementById('rapido_cliente_container').style.display = 'block';
                        document.getElementById('submitRapido').disabled = true;
                        break;
                }
                
                // Formatear fechas para el input date (YYYY-MM-DD)
                const fechaRecordatorioStr = fechaRecordatorio.toISOString().split('T')[0];
                
                // Actualizar campos ocultos
                document.getElementById('rapido_tipo').value = tipo;
                document.getElementById('rapido_titulo').value = titulo;
                document.getElementById('rapido_descripcion').value = descripcion;
                document.getElementById('rapido_fecha_recordatorio').value = fechaRecordatorioStr;
                document.getElementById('rapido_frecuencia').value = frecuencia;
            });
        });
        
        // Abrir modal de editar seguimiento
        document.querySelectorAll('.editarSeguimientoBtn').forEach(function(btn) {
            btn.addEventListener('click', function() {
                const seguimientoId = this.getAttribute('data-seguimiento-id');
                
                // Hacer una petición AJAX para obtener los datos del seguimiento
                fetch('<?php echo BASE_URL; ?>api/seguimiento.php?id=' + seguimientoId)
                    .then(response => response.json())
                    .then(data => {
                        document.getElementById('editarSeguimientoId').value = data.id;
                        document.getElementById('titulo_editar').value = data.titulo;
                        document.getElementById('tipo_editar').value = data.tipo;
                        document.getElementById('descripcion_editar').value = data.descripcion || '';
                        document.getElementById('cotizacion_id_editar').value = data.cotizacion_id || '';
                        document.getElementById('cliente_nombre_editar').value = data.cliente_nombre || '';
                        document.getElementById('cliente_telefono_editar').value = data.cliente_telefono || '';
                        document.getElementById('fecha_inicio_editar').value = data.fecha_inicio;
                        document.getElementById('fecha_recordatorio_editar').value = data.fecha_recordatorio;
                        document.getElementById('frecuencia_editar').value = data.frecuencia;
                        document.getElementById('notificacion_email_editar').checked = data.notificacion_email == 1;
                        document.getElementById('notificacion_sms_editar').checked = data.notificacion_sms == 1;
                        
                        // Mostrar/ocultar campo de cotización según tipo
                        if (data.tipo === 'cotizacion') {
                            document.getElementById('cotizacionContainer_editar').style.display = 'block';
                        } else {
                            document.getElementById('cotizacionContainer_editar').style.display = 'none';
                        }
                        
                        document.getElementById('editarSeguimientoModal').classList.remove('hidden');
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        alert('Error al cargar los datos del seguimiento');
                    });
            });
        });
        
        // Mostrar/ocultar campo de cotización al editar
        const tipoEditarSelect = document.getElementById('tipo_editar');
        const cotizacionEditarContainer = document.getElementById('cotizacionContainer_editar');
        
        if (tipoEditarSelect) {
            tipoEditarSelect.addEventListener('change', function() {
                if (this.value === 'cotizacion') {
                    cotizacionEditarContainer.style.display = 'block';
                } else {
                    cotizacionEditarContainer.style.display = 'none';
                }
            });
        }
        
        // Cerrar modales
        document.querySelectorAll('.cerrarModal').forEach(function(btn) {
            btn.addEventListener('click', function() {
                document.getElementById('crearSeguimientoModal').classList.add('hidden');
                document.getElementById('editarSeguimientoModal').classList.add('hidden');
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
                    document.getElementById('listaSeguimientos').classList.remove('hidden');
                    document.getElementById('calendarioSeguimientos').classList.add('hidden');
                } else if (view === 'calendar') {
                    document.getElementById('listaSeguimientos').classList.add('hidden');
                    document.getElementById('calendarioSeguimientos').classList.remove('hidden');
                }
            });
        });
        
        // Filtrar seguimientos
        document.getElementById('aplicarFiltros').addEventListener('click', function() {
            const filtroEstado = document.querySelector('input[name="filtroEstado"]:checked').value;
            const filtroTipo = document.getElementById('filtroTipo').value;
            const filtroPeriodo = document.getElementById('filtroPeriodo').value;
            
            const items = document.querySelectorAll('.seguimiento-item');
            
            items.forEach(function(item) {
                const estado = item.getAttribute('data-estado');
                const tipo = item.getAttribute('data-tipo');
                let mostrar = true;
                
                // Filtro de estado
                if (filtroEstado !== 'todos' && estado !== filtroEstado) {
                    mostrar = false;
                }
                
                // Filtro de tipo
                if (filtroTipo && tipo !== filtroTipo) {
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
        
        // Establecer fecha de recordatorio por defecto (3 días después)
        const fechaInicio = document.getElementById('fecha_inicio');
        const fechaRecordatorio = document.getElementById('fecha_recordatorio');
        
        if (fechaInicio && fechaRecordatorio) {
            const hoy = new Date();
            const tresDiasDespues = new Date();
            tresDiasDespues.setDate(hoy.getDate() + 3);
            
            // Formatear para input date (YYYY-MM-DD)
            const tresDiasDespuesStr = tresDiasDespues.toISOString().split('T')[0];
            fechaRecordatorio.value = tresDiasDespuesStr;
            
            // Actualizar fecha de recordatorio cuando cambia fecha de inicio
            fechaInicio.addEventListener('change', function() {
                const inicio = new Date(this.value);
                const recordatorio = new Date(inicio);
                recordatorio.setDate(inicio.getDate() + 3);
                
                // Formatear para input date (YYYY-MM-DD)
                const recordatorioStr = recordatorio.toISOString().split('T')[0];
                fechaRecordatorio.value = recordatorioStr;
            });
        }
    });
</script>