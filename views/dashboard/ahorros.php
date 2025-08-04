<div class="space-y-6">
    <div class="flex justify-between items-center">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Mis Ahorros</h1>
            <p class="text-gray-600">Planifica y gestiona tus ahorros para SOAT y Revisión Técnico Mecánica</p>
        </div>
        <button id="crearAhorroBtn" class="px-4 py-2 bg-primary-600 text-white rounded-lg hover:bg-primary-700 transition-colors">
            <i class="fas fa-plus mr-2"></i>Crear Plan de Ahorro
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

    <!-- Dashboard principal -->
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">
        <!-- Resumen y métricas -->
        <div class="lg:col-span-4 space-y-6">
            <!-- Totales -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Resumen de Ahorros</h3>
                
                <?php 
                $totalAhorrado = 0;
                $totalObjetivo = 0;
                $planesActivos = 0;
                
                foreach ($ahorros as $ahorro) {
                    $totalAhorrado += floatval($ahorro['total_ahorrado'] ?? 0);
                    $totalObjetivo += floatval($ahorro['costo']);
                    $planesActivos++;
                }
                
                $porcentajeTotal = $totalObjetivo > 0 ? ($totalAhorrado / $totalObjetivo) * 100 : 0;
                ?>
                
                <div class="grid grid-cols-2 gap-4 mb-4">
                    <div class="bg-blue-50 rounded-lg p-4">
                        <div class="text-xs text-blue-600 font-medium uppercase mb-1">Planes activos</div>
                        <div class="text-2xl font-bold text-blue-800"><?php echo $planesActivos; ?></div>
                    </div>
                    <div class="bg-green-50 rounded-lg p-4">
                        <div class="text-xs text-green-600 font-medium uppercase mb-1">Total ahorrado</div>
                        <div class="text-2xl font-bold text-green-800">$<?php echo number_format($totalAhorrado, 0, ',', '.'); ?></div>
                    </div>
                </div>
                
                <?php if ($totalObjetivo > 0): ?>
                    <div class="mb-1 flex justify-between text-xs">
                        <span class="text-gray-600">Progreso general</span>
                        <span class="font-medium"><?php echo round($porcentajeTotal); ?>%</span>
                    </div>
                    <div class="w-full bg-gray-200 rounded-full h-2.5 mb-4">
                        <div class="bg-blue-600 h-2.5 rounded-full" style="width: <?php echo min(100, $porcentajeTotal); ?>%"></div>
                    </div>
                    <div class="text-xs text-gray-500 flex justify-between">
                        <span>Meta: $<?php echo number_format($totalObjetivo, 0, ',', '.'); ?></span>
                        <span>Restante: $<?php echo number_format($totalObjetivo - $totalAhorrado, 0, ',', '.'); ?></span>
                    </div>
                <?php else: ?>
                    <div class="text-center text-gray-500 py-3">
                        <p>No tienes planes de ahorro activos</p>
                    </div>
                <?php endif; ?>
            </div>
            
            <!-- Consejos -->
            <div class="bg-gradient-to-br from-blue-500 to-indigo-600 rounded-xl shadow-md p-6 text-white">
                <div class="flex items-center mb-4">
                    <div class="bg-white/20 rounded-full p-2 mr-3">
                        <i class="fas fa-lightbulb text-yellow-300"></i>
                    </div>
                    <h3 class="text-lg font-semibold">Consejos de ahorro</h3>
                </div>
                
                <ul class="space-y-3 text-blue-50">
                    <li class="flex items-start">
                        <i class="fas fa-check-circle mt-1 mr-2 text-blue-200"></i>
                        <p class="text-sm">Guarda una cantidad fija cada mes, incluso si es pequeña.</p>
                    </li>
                    <li class="flex items-start">
                        <i class="fas fa-check-circle mt-1 mr-2 text-blue-200"></i>
                        <p class="text-sm">Configura recordatorios mensuales para realizar tus depósitos.</p>
                    </li>
                    <li class="flex items-start">
                        <i class="fas fa-check-circle mt-1 mr-2 text-blue-200"></i>
                        <p class="text-sm">Considera separar tus ahorros en una cuenta bancaria diferente.</p>
                    </li>
                </ul>
                
                <div class="mt-4 pt-4 border-t border-white/20">
                    <p class="text-xs text-blue-100">El ahorro automático te permite estar preparado para tus pagos de SOAT y Revisión Técnico Mecánica sin afectar tu presupuesto mensual.</p>
                </div>
            </div>
        </div>
        
        <!-- Listado de ahorros -->
        <div class="lg:col-span-8">
            <?php if (empty($ahorros)): ?>
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 text-center">
                    <div class="py-8">
                        <div class="inline-flex items-center justify-center w-16 h-16 bg-blue-50 rounded-full mb-4">
                            <i class="fas fa-piggy-bank text-3xl text-blue-500"></i>
                        </div>
                        <h3 class="text-xl font-medium text-gray-900 mb-2">No tienes planes de ahorro activos</h3>
                        <p class="text-gray-600 mb-6 max-w-md mx-auto">Crea tu primer plan de ahorro para estar preparado cuando llegue el momento de renovar tu SOAT o realizar la Revisión Técnico Mecánica.</p>
                        <button id="sinAhorrosBtn" class="px-6 py-3 bg-primary-600 text-white rounded-lg hover:bg-primary-700 transition-colors">
                            <i class="fas fa-plus mr-2"></i>Crear mi primer plan de ahorro
                        </button>
                    </div>
                </div>
            <?php else: ?>
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Mis Planes de Ahorro</h3>
                    
                    <div class="space-y-4">
                        <?php foreach ($ahorros as $ahorro): ?>
                            <?php
                            $tipoIcono = $ahorro['tipo_tramite'] === 'Ahorro SOAT' ? 'fa-id-card' : 'fa-car';
                            $colorClase = $ahorro['tipo_tramite'] === 'Ahorro SOAT' ? 'bg-blue-600' : 'bg-green-600';
                            $colorClaseLight = $ahorro['tipo_tramite'] === 'Ahorro SOAT' ? 'bg-blue-50 text-blue-700' : 'bg-green-50 text-green-700';
                            $fechaObjetivo = new DateTime($ahorro['fecha']);
                            $hoy = new DateTime();
                            $diasRestantes = $hoy > $fechaObjetivo ? 0 : $fechaObjetivo->diff($hoy)->days;
                            $porcentajeAhorro = ($ahorro['total_ahorrado'] ?? 0) > 0 ? (($ahorro['total_ahorrado'] ?? 0) / $ahorro['costo']) * 100 : 0;
                            $mesesRestantes = ceil($diasRestantes / 30);
                            $montoMensualRecomendado = $mesesRestantes > 0 ? ($ahorro['costo'] - ($ahorro['total_ahorrado'] ?? 0)) / $mesesRestantes : $ahorro['costo'] - ($ahorro['total_ahorrado'] ?? 0);
                            ?>
                            
                            <div class="border border-gray-200 rounded-xl overflow-hidden">
                                <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                                    <!-- Info Principal -->
                                    <div class="md:col-span-1 p-4 flex flex-col justify-between border-b md:border-b-0 md:border-r border-gray-200">
                                        <div>
                                            <div class="flex items-center">
                                                <div class="<?php echo $colorClaseLight; ?> rounded-lg p-2 mr-3">
                                                    <i class="fas <?php echo $tipoIcono; ?>"></i>
                                                </div>
                                                <h4 class="font-semibold text-gray-900"><?php echo str_replace('Ahorro ', '', $ahorro['tipo_tramite']); ?></h4>
                                            </div>
                                            <p class="text-sm text-gray-600 mt-2">Vehículo: <?php echo $ahorro['vehiculo_placa']; ?></p>
                                            <p class="text-xs text-gray-500 mt-1"><?php echo $ahorro['marca'] . ' ' . $ahorro['linea']; ?></p>
                                        </div>
                                        
                                        <div class="mt-3">
                                            <div class="bg-gray-50 rounded-lg p-2 text-center">
                                                <div class="text-xs text-gray-500">Fecha límite</div>
                                                <div class="font-semibold <?php echo $diasRestantes < 30 ? 'text-red-600' : 'text-gray-800'; ?>">
                                                    <?php echo date('d/m/Y', strtotime($ahorro['fecha'])); ?>
                                                </div>
                                                <div class="text-xs <?php echo $diasRestantes < 30 ? 'text-red-500' : 'text-gray-500'; ?>">
                                                    <?php echo $diasRestantes > 0 ? "Faltan {$diasRestantes} días" : "¡Vencido!"; ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <!-- Progreso -->
                                    <div class="md:col-span-2 p-4 flex flex-col justify-between border-b md:border-b-0 md:border-r border-gray-200">
                                        <div>
                                            <div class="flex justify-between mb-1">
                                                <div class="text-sm font-medium text-gray-900">Progreso de ahorro</div>
                                                <div class="text-sm font-medium text-gray-900"><?php echo round($porcentajeAhorro); ?>%</div>
                                            </div>
                                            
                                            <div class="w-full bg-gray-200 rounded-full h-2.5 mb-3">
                                                <div class="<?php echo $colorClase; ?> h-2.5 rounded-full" style="width: <?php echo min(100, $porcentajeAhorro); ?>%"></div>
                                            </div>
                                            
                                            <div class="grid grid-cols-2 gap-3 text-sm">
                                                <div>
                                                    <div class="text-gray-500">Objetivo</div>
                                                    <div class="font-semibold text-gray-900">$<?php echo number_format($ahorro['costo'], 0, ',', '.'); ?></div>
                                                </div>
                                                <div>
                                                    <div class="text-gray-500">Ahorrado</div>
                                                    <div class="font-semibold text-gray-900">$<?php echo number_format($ahorro['total_ahorrado'] ?? 0, 0, ',', '.'); ?></div>
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <div class="mt-3">
                                            <div class="grid grid-cols-2 gap-3 text-sm">
                                                <div>
                                                    <div class="text-gray-500">Cuota mensual</div>
                                                    <div class="font-semibold text-gray-900">$<?php echo number_format($ahorro['monto_mensual'], 0, ',', '.'); ?></div>
                                                </div>
                                                <div>
                                                    <div class="text-gray-500">Recomendado ahora</div>
                                                    <div class="font-semibold <?php echo $montoMensualRecomendado > $ahorro['monto_mensual'] ? 'text-red-600' : 'text-green-600'; ?>">
                                                        $<?php echo number_format($montoMensualRecomendado, 0, ',', '.'); ?>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <!-- Acciones -->
                                    <div class="md:col-span-1 p-4 flex flex-col justify-between">
                                        <div class="space-y-2">
                                            <button data-ahorro-id="<?php echo $ahorro['id']; ?>" class="registrarDepositoBtn w-full px-3 py-2 bg-primary-600 text-white text-sm rounded hover:bg-primary-700 transition-colors flex items-center justify-center">
                                                <i class="fas fa-plus-circle mr-1"></i>Registrar Depósito
                                            </button>
                                            
                                            <button data-ahorro-id="<?php echo $ahorro['id']; ?>" class="verHistorialBtn w-full px-3 py-2 bg-gray-200 text-gray-700 text-sm rounded hover:bg-gray-300 transition-colors flex items-center justify-center">
                                                <i class="fas fa-history mr-1"></i>Ver Historial
                                            </button>
                                            
                                            <button data-ahorro-id="<?php echo $ahorro['id']; ?>" 
                                                    data-monto-mensual="<?php echo $ahorro['monto_mensual']; ?>"
                                                    data-costo="<?php echo $ahorro['costo']; ?>"
                                                    class="editarAhorroBtn w-full px-3 py-2 border border-gray-300 text-gray-700 text-sm rounded hover:bg-gray-100 transition-colors flex items-center justify-center">
                                                <i class="fas fa-edit mr-1"></i>Editar Plan
                                            </button>
                                        </div>
                                        
                                        <?php if ($diasRestantes < 30): ?>
                                        <div class="mt-3 text-center">
                                            <div class="bg-red-50 text-red-700 rounded-lg p-2 text-xs">
                                                <i class="fas fa-exclamation-circle mr-1"></i>
                                                ¡Fecha próxima! Aumenta tus depósitos.
                                            </div>
                                        </div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                        
                        <!-- Nuevo plan -->
                        <div class="border border-gray-200 border-dashed rounded-xl p-6 flex flex-col items-center justify-center text-center">
                            <i class="fas fa-plus-circle text-3xl text-gray-400 mb-3"></i>
                            <h3 class="text-lg font-medium text-gray-700 mb-2">Crear nuevo plan</h3>
                            <p class="text-sm text-gray-500 mb-4">Configura un nuevo plan de ahorro para tus documentos</p>
                            <button id="nuevoPlanBtn" class="px-4 py-2 bg-gray-600 text-white rounded-lg hover:bg-gray-700 transition-colors">
                                Crear Plan
                            </button>
                        </div>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <!-- Tarjeta informativa -->
    <div class="bg-blue-50 border border-blue-200 rounded-xl p-6">
        <h3 class="text-lg font-semibold text-blue-900 mb-4">
            <i class="fas fa-info-circle mr-2"></i>¿Cómo funciona el ahorro?
        </h3>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 text-sm text-blue-800">
            <div class="bg-white/60 p-4 rounded-lg">
                <div class="flex items-center mb-3">
                    <div class="bg-blue-100 text-blue-700 rounded-full w-8 h-8 flex items-center justify-center mr-3">
                        <span>1</span>
                    </div>
                    <h4 class="font-medium">Crear un plan</h4>
                </div>
                <p class="text-blue-700">Define cuánto necesitas ahorrar para tu SOAT o Tecnomecánica y en qué plazo. El sistema te sugerirá una cuota mensual basada en la fecha de vencimiento.</p>
            </div>
            <div class="bg-white/60 p-4 rounded-lg">
                <div class="flex items-center mb-3">
                    <div class="bg-blue-100 text-blue-700 rounded-full w-8 h-8 flex items-center justify-center mr-3">
                        <span>2</span>
                    </div>
                    <h4 class="font-medium">Depositar regularmente</h4>
                </div>
                <p class="text-blue-700">Realiza depósitos mensuales según el plan que estableciste. Puedes subir comprobantes para llevar un mejor control de tus ahorros.</p>
            </div>
            <div class="bg-white/60 p-4 rounded-lg">
                <div class="flex items-center mb-3">
                    <div class="bg-blue-100 text-blue-700 rounded-full w-8 h-8 flex items-center justify-center mr-3">
                        <span>3</span>
                    </div>
                    <h4 class="font-medium">Alcanza tu meta</h4>
                </div>
                <p class="text-blue-700">Cuando llegue la fecha de renovación, tendrás el dinero necesario sin afectar tu presupuesto mensual. El ahorro planificado te evita preocupaciones de último momento.</p>
            </div>
        </div>
    </div>
</div>

<!-- Modal para crear plan de ahorro -->
<div id="crearAhorroModal" class="hidden fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center p-4">
    <div class="bg-white rounded-lg shadow-xl max-w-md w-full">
        <div class="border-b px-4 py-3 flex justify-between items-center">
            <h3 class="text-lg font-medium text-gray-900">Crear Plan de Ahorro</h3>
            <button class="cerrarModal text-gray-400 hover:text-gray-500">
                <i class="fas fa-times"></i>
            </button>
        </div>
        
        <form action="<?php echo BASE_URL; ?>dashboard/ahorros" method="POST" class="p-4">
            <input type="hidden" name="accion" value="crear_ahorro">
            
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-1" for="vehiculo_id">Vehículo</label>
                <select id="vehiculo_id" name="vehiculo_id" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500" required>
                    <option value="">Seleccionar vehículo</option>
                    <?php foreach ($vehiculos as $vehiculo): ?>
                        <option value="<?php echo $vehiculo['id']; ?>"><?php echo $vehiculo['info']['placa'] . ' - ' . $vehiculo['info']['marca'] . ' ' . $vehiculo['info']['linea']; ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-1" for="tipo_tramite">Tipo de Ahorro</label>
                <select id="tipo_tramite" name="tipo_tramite" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500" required>
                    <option value="">Seleccionar tipo</option>
                    <option value="Ahorro SOAT">SOAT</option>
                    <option value="Ahorro Tecnomecánica">Tecnomecánica</option>
                </select>
            </div>
            
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-1" for="fecha_objetivo">Fecha Objetivo</label>
                <input type="date" id="fecha_objetivo" name="fecha_objetivo" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500" required>
                <p class="text-xs text-gray-500 mt-1">Fecha de vencimiento de tu SOAT o Tecnomecánica</p>
            </div>
            
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-1" for="costo_estimado">Costo Estimado</label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <span class="text-gray-500">$</span>
                    </div>
                    <input type="number" id="costo_estimado" name="costo_estimado" class="w-full pl-7 pr-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500" placeholder="0" required>
                </div>
                <p class="text-xs text-gray-500 mt-1">Monto total que necesitas ahorrar</p>
            </div>
            
            <div class="mb-6">
                <label class="block text-sm font-medium text-gray-700 mb-1" for="monto_mensual">Monto Mensual</label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <span class="text-gray-500">$</span>
                    </div>
                    <input type="number" id="monto_mensual" name="monto_mensual" value="30000" class="w-full pl-7 pr-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500" required>
                </div>
                <p class="text-xs text-gray-500 mt-1">* Valor sugerido: $30,000 mensuales</p>
            </div>
            
            <div class="flex justify-end">
                <button type="button" class="cerrarModal mr-2 px-4 py-2 border border-gray-300 rounded-lg text-gray-700 bg-white hover:bg-gray-50">Cancelar</button>
                <button type="submit" class="px-4 py-2 bg-primary-600 text-white rounded-lg hover:bg-primary-700">Crear Plan</button>
            </div>
        </form>
    </div>
</div>

<!-- Modal para editar plan de ahorro -->
<div id="editarAhorroModal" class="hidden fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center p-4">
    <div class="bg-white rounded-lg shadow-xl max-w-md w-full">
        <div class="border-b px-4 py-3 flex justify-between items-center">
            <h3 class="text-lg font-medium text-gray-900">Editar Plan de Ahorro</h3>
            <button class="cerrarModal text-gray-400 hover:text-gray-500">
                <i class="fas fa-times"></i>
            </button>
        </div>
        
        <form action="<?php echo BASE_URL; ?>dashboard/ahorros" method="POST" class="p-4">
            <input type="hidden" name="accion" value="editar_ahorro">
            <input type="hidden" name="ahorro_id" id="editarAhorroId" value="">
            
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-1" for="costo_estimado_editar">Costo Estimado</label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <span class="text-gray-500">$</span>
                    </div>
                    <input type="number" id="costo_estimado_editar" name="costo_estimado" class="w-full pl-7 pr-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500" placeholder="0" required>
                </div>
                <p class="text-xs text-gray-500 mt-1">Monto total que necesitas ahorrar</p>
            </div>
            
            <div class="mb-6">
                <label class="block text-sm font-medium text-gray-700 mb-1" for="monto_mensual_editar">Monto Mensual</label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <span class="text-gray-500">$</span>
                    </div>
                    <input type="number" id="monto_mensual_editar" name="monto_mensual" class="w-full pl-7 pr-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500" required>
                </div>
                <p class="text-xs text-gray-500 mt-1">Cantidad que planeas ahorrar cada mes</p>
            </div>
            
            <div class="flex justify-end">
                <button type="button" class="cerrarModal mr-2 px-4 py-2 border border-gray-300 rounded-lg text-gray-700 bg-white hover:bg-gray-50">Cancelar</button>
                <button type="submit" class="px-4 py-2 bg-primary-600 text-white rounded-lg hover:bg-primary-700">Actualizar Plan</button>
            </div>
        </form>
    </div>
</div>

<!-- Modal para registrar depósito -->
<div id="registrarDepositoModal" class="hidden fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center p-4">
    <div class="bg-white rounded-lg shadow-xl max-w-md w-full">
        <div class="border-b px-4 py-3 flex justify-between items-center">
            <h3 class="text-lg font-medium text-gray-900">Registrar Depósito</h3>
            <button class="cerrarModal text-gray-400 hover:text-gray-500">
                <i class="fas fa-times"></i>
            </button>
        </div>
        
        <form action="<?php echo BASE_URL; ?>dashboard/ahorros" method="POST" enctype="multipart/form-data" class="p-4">
            <input type="hidden" name="accion" value="registrar_deposito">
            <input type="hidden" name="ahorro_id" id="depositoAhorroId" value="">
            
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-1" for="monto">Monto del Depósito</label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <span class="text-gray-500">$</span>
                    </div>
                    <input type="number" id="monto" name="monto" class="w-full pl-7 pr-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500" placeholder="0" required>
                </div>
            </div>
            
            <div class="mb-6">
                <label class="block text-sm font-medium text-gray-700 mb-1" for="comprobante">Comprobante (opcional)</label>
                <input type="file" id="comprobante" name="comprobante" accept="image/*,.pdf" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500">
                <p class="text-xs text-gray-500 mt-1">Puedes subir una imagen o PDF del comprobante de pago.</p>
            </div>
            
            <div class="flex justify-end">
                <button type="button" class="cerrarModal mr-2 px-4 py-2 border border-gray-300 rounded-lg text-gray-700 bg-white hover:bg-gray-50">Cancelar</button>
                <button type="submit" class="px-4 py-2 bg-primary-600 text-white rounded-lg hover:bg-primary-700">Registrar Depósito</button>
            </div>
        </form>
    </div>
</div>

<!-- Modal para historial de depósitos -->
<div id="historialModal" class="hidden fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center p-4">
    <div class="bg-white rounded-lg shadow-xl max-w-2xl w-full">
        <div class="border-b px-4 py-3 flex justify-between items-center">
            <h3 class="text-lg font-medium text-gray-900">Historial de Depósitos</h3>
            <button class="cerrarModal text-gray-400 hover:text-gray-500">
                <i class="fas fa-times"></i>
            </button>
        </div>
        
        <div class="p-4">
            <div id="historialContenido" class="max-h-96 overflow-y-auto">
                <div class="text-center py-10">
                    <i class="fas fa-spinner fa-spin text-3xl text-gray-400 mb-3"></i>
                    <p class="text-gray-500">Cargando historial...</p>
                </div>
            </div>
        </div>
        
        <div class="border-t px-4 py-3 flex justify-end">
            <button type="button" class="cerrarModal px-4 py-2 border border-gray-300 rounded-lg text-gray-700 bg-white hover:bg-gray-50">Cerrar</button>
        </div>
    </div>
</div>

<script>
    // Datos de vehículos para usar en JavaScript
    const vehiculosData = <?php echo $vehiculosData; ?>;
    
    document.addEventListener('DOMContentLoaded', function() {
        // Abrir modal de crear ahorro
        document.getElementById('crearAhorroBtn').addEventListener('click', function() {
            document.getElementById('crearAhorroModal').classList.remove('hidden');
        });
        
        // Alternativa para cuando no hay ahorros
        const sinAhorrosBtn = document.getElementById('sinAhorrosBtn');
        if (sinAhorrosBtn) {
            sinAhorrosBtn.addEventListener('click', function() {
                document.getElementById('crearAhorroModal').classList.remove('hidden');
            });
        }
        
        // Crear nuevo plan desde la tarjeta
        const nuevoPlanBtn = document.getElementById('nuevoPlanBtn');
        if (nuevoPlanBtn) {
            nuevoPlanBtn.addEventListener('click', function() {
                document.getElementById('crearAhorroModal').classList.remove('hidden');
            });
        }
        
        // Abrir modal de editar ahorro
        document.querySelectorAll('.editarAhorroBtn').forEach(function(btn) {
            btn.addEventListener('click', function() {
                const ahorroId = this.getAttribute('data-ahorro-id');
                const montoMensual = this.getAttribute('data-monto-mensual');
                const costo = this.getAttribute('data-costo');
                
                document.getElementById('editarAhorroId').value = ahorroId;
                document.getElementById('monto_mensual_editar').value = montoMensual;
                document.getElementById('costo_estimado_editar').value = costo;
                
                document.getElementById('editarAhorroModal').classList.remove('hidden');
            });
        });
        
        // Abrir modal de registrar depósito
        document.querySelectorAll('.registrarDepositoBtn').forEach(function(btn) {
            btn.addEventListener('click', function() {
                const ahorroId = this.getAttribute('data-ahorro-id');
                document.getElementById('depositoAhorroId').value = ahorroId;
                document.getElementById('registrarDepositoModal').classList.remove('hidden');
            });
        });
        
        // Abrir modal de historial
        document.querySelectorAll('.verHistorialBtn').forEach(function(btn) {
            btn.addEventListener('click', function() {
                const ahorroId = this.getAttribute('data-ahorro-id');
                document.getElementById('historialModal').classList.remove('hidden');
                
                // Cargar historial de depósitos via AJAX
                fetch('<?php echo BASE_URL; ?>api/depositos.php?ahorro_id=' + ahorroId)
                    .then(response => response.json())
                    .then(data => {
                        const contenido = document.getElementById('historialContenido');
                        
                        if (data.length === 0) {
                            contenido.innerHTML = `
                                <div class="text-center py-10">
                                    <i class="fas fa-info-circle text-3xl text-gray-400 mb-3"></i>
                                    <p class="text-gray-500">Aún no hay depósitos registrados</p>
                                </div>
                            `;
                            return;
                        }
                        
                        let html = `
                            <div class="overflow-x-auto">
                                <table class="min-w-full divide-y divide-gray-200">
                                    <thead class="bg-gray-50">
                                        <tr>
                                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Fecha</th>
                                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Monto</th>
                                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Comprobante</th>
                                        </tr>
                                    </thead>
                                    <tbody class="bg-white divide-y divide-gray-200">
                        `;
                        
                        data.forEach(deposito => {
                            const comprobanteLink = deposito.comprobante 
                                ? `<a href="${deposito.comprobante}" target="_blank" class="text-primary-600 hover:underline">Ver comprobante</a>` 
                                : 'No disponible';
                                
                            html += `
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">${new Date(deposito.fecha).toLocaleDateString()}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">$${Number(deposito.monto).toLocaleString()}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">${comprobanteLink}</td>
                                </tr>
                            `;
                        });
                        
                        html += `
                                    </tbody>
                                </table>
                            </div>
                        `;
                        
                        contenido.innerHTML = html;
                    })
                    .catch(error => {
                        document.getElementById('historialContenido').innerHTML = `
                            <div class="text-center py-10">
                                <i class="fas fa-exclamation-circle text-3xl text-red-400 mb-3"></i>
                                <p class="text-red-500">Error al cargar el historial</p>
                            </div>
                        `;
                    });
            });
        });
        
        // Cerrar modales
        document.querySelectorAll('.cerrarModal').forEach(function(btn) {
            btn.addEventListener('click', function() {
                document.getElementById('crearAhorroModal').classList.add('hidden');
                document.getElementById('editarAhorroModal').classList.add('hidden');
                document.getElementById('registrarDepositoModal').classList.add('hidden');
                document.getElementById('historialModal').classList.add('hidden');
            });
        });
        
        // Calcular monto mensual recomendado
        const fechaObjetivoInput = document.getElementById('fecha_objetivo');
        const costoEstimadoInput = document.getElementById('costo_estimado');
        const montoMensualInput = document.getElementById('monto_mensual');
        
        function calcularMontoMensual() {
            if (fechaObjetivoInput.value && costoEstimadoInput.value) {
                const fechaObjetivo = new Date(fechaObjetivoInput.value);
                const hoy = new Date();
                const diasRestantes = Math.max(0, Math.ceil((fechaObjetivo - hoy) / (1000 * 60 * 60 * 24)));
                const mesesRestantes = Math.max(1, Math.ceil(diasRestantes / 30));
                
                const costo = parseFloat(costoEstimadoInput.value);
                const montoMensual = Math.ceil(costo / mesesRestantes);
                montoMensualInput.value = montoMensual;
            }
        }
        
        fechaObjetivoInput.addEventListener('change', calcularMontoMensual);
        costoEstimadoInput.addEventListener('input', calcularMontoMensual);
        
        // Cálculo automático de fecha objetivo según tipo de trámite y vehículo
        const tipoTramiteSelect = document.getElementById('tipo_tramite');
        const vehiculoSelect = document.getElementById('vehiculo_id');
        
        function actualizarFechaYCosto() {
            const vehiculoId = vehiculoSelect.value;
            const tipoTramite = tipoTramiteSelect.value;
            
            if (vehiculoId && tipoTramite && vehiculosData[vehiculoId]) {
                const vehiculo = vehiculosData[vehiculoId];
                
                // Determinar fecha de vencimiento según tipo de trámite
                let fechaVencimiento = null;
                let costoEstimado = 0;
                
                if (tipoTramite === 'Ahorro SOAT') {
                    if (vehiculo.soat && vehiculo.soat.vencimiento) {
                        // Convertir formato DD/MM/YYYY a YYYY-MM-DD para el input date
                        const partes = vehiculo.soat.vencimiento.split('/');
                        fechaVencimiento = `${partes[2]}-${partes[1]}-${partes[0]}`;
                    }
                    
                    // Costo estimado según cilindraje
                    costoEstimado = parseInt(vehiculo.info.cilindraje) < 200 ? 450000 : 850000;
                    
                } else if (tipoTramite === 'Ahorro Tecnomecánica') {
                    if (vehiculo.tecnomecanica && vehiculo.tecnomecanica.vencimiento) {
                        // Convertir formato DD/MM/YYYY a YYYY-MM-DD para el input date
                        const partes = vehiculo.tecnomecanica.vencimiento.split('/');
                        fechaVencimiento = `${partes[2]}-${partes[1]}-${partes[0]}`;
                    }
                    
                    // Costo estimado según cilindraje/tipo
                    costoEstimado = parseInt(vehiculo.info.cilindraje) < 200 ? 180000 : 250000;
                }
                
                if (fechaVencimiento) {
                    fechaObjetivoInput.value = fechaVencimiento;
                }
                
                costoEstimadoInput.value = costoEstimado;
                calcularMontoMensual();
            }
        }
        
        vehiculoSelect.addEventListener('change', actualizarFechaYCosto);
        tipoTramiteSelect.addEventListener('change', actualizarFechaYCosto);

        // Cerrar alertas
        document.querySelectorAll('.bg-green-100 button, .bg-red-100 button').forEach(button => {
            button.addEventListener('click', function() {
                this.closest('div[role="alert"]').remove();
            });
        });
    });
</script>