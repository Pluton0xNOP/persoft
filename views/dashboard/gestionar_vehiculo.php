<?php
//gestionar_vehiculo.php
?>


<?php $v = $datos['vehiculo']; ?>

<div class="min-h-screen bg-gradient-to-br from-slate-50 to-slate-100 py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <nav class="mb-6">
            <a href="<?php echo BASE_URL; ?>dashboard/vehiculos" class="inline-flex items-center text-sm text-blue-600 hover:text-blue-800 font-medium transition-colors">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                Volver a Mis Vehículos
            </a>
        </nav>

        <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-6 mb-8">
            <div class="flex items-center justify-between">
                <div class="flex items-center space-x-6">
                    <div class="w-20 h-20 bg-gradient-to-br from-blue-500 to-blue-600 rounded-xl flex items-center justify-center text-white shadow-lg">
                        <?php if ($v['clase_vehiculo'] === 'MOTOCICLETA'): ?>
                            <svg class="w-10 h-10" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M19.44 9.03L15.41 5H11v2h3.59l2 2H5c-2.8 0-5 2.2-5 5s2.2 5 5 5c2.46 0 4.45-1.69 4.9-4h1.65l2.77-2.77c-.17-.64-.32-1.27-.32-1.96 0-.69.15-1.32.32-1.96L19.44 9.03zM7.82 15c-.4 1.17-1.49 2-2.82 2-1.68 0-3-1.32-3-3s1.32-3 3-3c1.33 0 2.42.83 2.82 2H5v2h2.82z"/>
                            </svg>
                        <?php else: ?>
                            <svg class="w-10 h-10" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M18.92 6.01C18.72 5.42 18.16 5 17.5 5h-11c-.66 0-1.22.42-1.42 1.01L3 12v8c0 .55.45 1 1 1h1c.55 0 1-.45 1-1v-1h12v1c0 .55.45 1 1 1h1c.55 0 1-.45 1-1v-8l-2.08-5.99zM6.5 16c-.83 0-1.5-.67-1.5-1.5S5.67 13 6.5 13s1.5.67 1.5 1.5S7.33 16 6.5 16zm11 0c-.83 0-1.5-.67-1.5-1.5s.67-1.5 1.5-1.5 1.5.67 1.5 1.5-.67 1.5-1.5 1.5zM5 11l1.5-4.5h11L19 11H5z"/>
                            </svg>
                        <?php endif; ?>
                    </div>
                    <div>
                        <h1 class="text-3xl font-bold text-slate-900 mb-1"><?php echo htmlspecialchars($v['placa']); ?></h1>
                        <p class="text-slate-600 text-lg"><?php echo htmlspecialchars($v['marca'] . ' ' . $v['linea'] . ' ' . $v['modelo']); ?></p>
                    </div>
                </div>
                <button class="inline-flex items-center px-4 py-2.5 bg-red-600 text-white font-medium rounded-lg hover:bg-red-700 focus:ring-4 focus:ring-red-200 transition-all duration-200 transform hover:scale-105">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                    </svg>
                    Eliminar Vehículo
                </button>
            </div>
        </div>

        <div class="grid grid-cols-1 xl:grid-cols-4 gap-8">
            <div class="xl:col-span-3 space-y-8">
                <div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden">
                    <div class="px-6 py-4 border-b border-slate-200 bg-slate-50">
                        <h2 class="text-xl font-semibold text-slate-900 flex items-center">
                            <svg class="w-5 h-5 mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                            Historial de SOAT
                        </h2>
                    </div>
                    <div class="p-6">
                        <div class="overflow-x-auto">
                            <table class="w-full">
                                <thead>
                                    <tr class="border-b border-slate-200">
                                        <th class="text-left py-3 px-4 font-semibold text-slate-700">Póliza</th>
                                        <th class="text-left py-3 px-4 font-semibold text-slate-700">Entidad</th>
                                        <th class="text-left py-3 px-4 font-semibold text-slate-700">Vencimiento</th>
                                        <th class="text-left py-3 px-4 font-semibold text-slate-700">Estado</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-slate-100">
                                    <?php foreach($v['historial_soat'] as $soat): ?>
                                        <tr class="hover:bg-slate-50 transition-colors">
                                            <td class="py-4 px-4 font-medium text-slate-900"><?php echo htmlspecialchars($soat['no_poliza']); ?></td>
                                            <td class="py-4 px-4 text-slate-700"><?php echo htmlspecialchars($soat['entidad_expide']); ?></td>
                                            <td class="py-4 px-4 text-slate-700"><?php echo (new DateTime($soat['fecha_vencimiento']))->format('d/m/Y'); ?></td>
                                            <td class="py-4 px-4">
                                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold <?php echo $soat['estado'] === 'VIGENTE' ? 'bg-emerald-100 text-emerald-700' : 'bg-red-100 text-red-700'; ?>">
                                                    <?php if ($soat['estado'] === 'VIGENTE'): ?>
                                                        <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                                        </svg>
                                                    <?php else: ?>
                                                        <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                            <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                                                        </svg>
                                                    <?php endif; ?>
                                                    <?php echo htmlspecialchars($soat['estado']); ?>
                                                </span>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden">
                    <div class="px-6 py-4 border-b border-slate-200 bg-slate-50">
                        <h2 class="text-xl font-semibold text-slate-900 flex items-center">
                            <svg class="w-5 h-5 mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            Historial de Tecnomecánica
                        </h2>
                    </div>
                    <div class="p-6">
                        <div class="overflow-x-auto">
                            <table class="w-full">
                                <thead>
                                    <tr class="border-b border-slate-200">
                                        <th class="text-left py-3 px-4 font-semibold text-slate-700">Certificado</th>
                                        <th class="text-left py-3 px-4 font-semibold text-slate-700">CDA</th>
                                        <th class="text-left py-3 px-4 font-semibold text-slate-700">Vigencia</th>
                                        <th class="text-left py-3 px-4 font-semibold text-slate-700">Estado</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-slate-100">
                                    <?php foreach($v['historial_rtm'] as $rtm): ?>
                                        <tr class="hover:bg-slate-50 transition-colors">
                                            <td class="py-4 px-4 font-medium text-slate-900"><?php echo htmlspecialchars($rtm['nro_certificado']); ?></td>
                                            <td class="py-4 px-4 text-slate-700"><?php echo htmlspecialchars($rtm['cda_expide']); ?></td>
                                            <td class="py-4 px-4 text-slate-700"><?php echo (new DateTime($rtm['fecha_vigente']))->format('d/m/Y'); ?></td>
                                            <td class="py-4 px-4">
                                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold <?php echo $rtm['vigente'] === 'SI' ? 'bg-emerald-100 text-emerald-700' : 'bg-red-100 text-red-700'; ?>">
                                                    <?php if ($rtm['vigente'] === 'SI'): ?>
                                                        <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                                        </svg>
                                                    <?php else: ?>
                                                        <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                            <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                                                        </svg>
                                                    <?php endif; ?>
                                                    <?php echo $rtm['vigente'] === 'SI' ? 'VIGENTE' : 'NO VIGENTE'; ?>
                                                </span>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden">
                    <div class="px-6 py-4 border-b border-slate-200 bg-slate-50">
                        <h2 class="text-xl font-semibold text-slate-900 flex items-center">
                            <svg class="w-5 h-5 mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"></path>
                            </svg>
                            Deudas de Semaforización
                        </h2>
                    </div>
                    <div class="p-6">
                        <?php if(empty($v['historial_semaforizacion'])): ?>
                            <div class="text-center py-8">
                                <div class="w-16 h-16 bg-emerald-100 rounded-full flex items-center justify-center mx-auto mb-4">
                                    <svg class="w-8 h-8 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                </div>
                                <h3 class="text-lg font-semibold text-slate-900 mb-2">Sin deudas pendientes</h3>
                                <p class="text-slate-600">No se encontraron deudas de semaforización para este vehículo.</p>
                            </div>
                        <?php else: ?>
                            <div class="overflow-x-auto">
                                <table class="w-full">
                                    <thead>
                                        <tr class="border-b border-slate-200">
                                            <th class="text-left py-3 px-4 font-semibold text-slate-700">Municipio</th>
                                            <th class="text-left py-3 px-4 font-semibold text-slate-700">Año</th>
                                            <th class="text-right py-3 px-4 font-semibold text-slate-700">Valor</th>
                                        </tr>
                                    </thead>
                                    <tbody class="divide-y divide-slate-100">
                                        <?php $totalDeudaSemaf = 0; ?>
                                        <?php foreach($v['historial_semaforizacion'] as $semaforo): ?>
                                            <?php $totalDeudaSemaf += $semaforo['total_tarifa']; ?>
                                            <tr class="hover:bg-slate-50 transition-colors">
                                                <td class="py-4 px-4 font-medium text-slate-900"><?php echo htmlspecialchars($semaforo['municipio']); ?></td>
                                                <td class="py-4 px-4 text-slate-700"><?php echo htmlspecialchars($semaforo['anno']); ?></td>
                                                <td class="py-4 px-4 text-right font-mono font-semibold text-red-600">$<?php echo number_format($semaforo['total_tarifa'], 0, ',', '.'); ?></td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                    <tfoot>
                                        <tr class="border-t-2 border-slate-300 bg-slate-50">
                                            <td class="py-4 px-4 font-bold text-slate-900" colspan="2">Total Deuda</td>
                                            <td class="py-4 px-4 text-right font-mono font-bold text-red-700 text-lg">$<?php echo number_format($totalDeudaSemaf, 0, ',', '.'); ?></td>
                                        </tr>
                                    </tfoot>
                                </table>
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
                            Información General
                        </h2>
                    </div>
                    <div class="p-6">
                        <dl class="space-y-4">
                            <div class="flex justify-between items-center py-2 border-b border-slate-100">
                                <dt class="text-sm text-slate-600">Estado</dt>
                                <dd class="inline-flex items-center px-2 py-1 rounded-full text-xs font-semibold bg-emerald-100 text-emerald-700">
                                    <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                    </svg>
                                    <?php echo htmlspecialchars($v['estado']); ?>
                                </dd>
                            </div>
                            <div class="flex justify-between py-2 border-b border-slate-100">
                                <dt class="text-sm text-slate-600">Licencia Tránsito</dt>
                                <dd class="text-sm font-medium text-slate-900"><?php echo htmlspecialchars($v['licencia_transito']); ?></dd>
                            </div>
                            <div class="flex justify-between py-2 border-b border-slate-100">
                                <dt class="text-sm text-slate-600">Fecha Matrícula</dt>
                                <dd class="text-sm font-medium text-slate-900"><?php echo (new DateTime($v['fecha_matricula']))->format('d/m/Y'); ?></dd>
                            </div>
                            <div class="flex justify-between py-2 border-b border-slate-100">
                                <dt class="text-sm text-slate-600">No. Motor</dt>
                                <dd class="text-sm font-medium text-slate-900 font-mono"><?php echo htmlspecialchars($v['no_motor']); ?></dd>
                            </div>
                            <div class="flex justify-between py-2 border-b border-slate-100">
                                <dt class="text-sm text-slate-600">No. Chasis</dt>
                                <dd class="text-sm font-medium text-slate-900 font-mono"><?php echo htmlspecialchars($v['no_chasis']); ?></dd>
                            </div>
                            <div class="flex justify-between py-2 border-b border-slate-100">
                                <dt class="text-sm text-slate-600">Tipo Servicio</dt>
                                <dd class="text-sm font-medium text-slate-900"><?php echo htmlspecialchars($v['tipo_servicio']); ?></dd>
                            </div>
                            <div class="flex justify-between py-2 border-b border-slate-100">
                                <dt class="text-sm text-slate-600">Combustible</dt>
                                <dd class="text-sm font-medium text-slate-900"><?php echo htmlspecialchars($v['tipo_combustible']); ?></dd>
                            </div>
                            <div class="flex justify-between py-2 border-b border-slate-100">
                                <dt class="text-sm text-slate-600">Pasajeros</dt>
                                <dd class="text-sm font-medium text-slate-900"><?php echo htmlspecialchars($v['pasajeros_sentados']); ?></dd>
                            </div>
                            <div class="flex justify-between py-2">
                                <dt class="text-sm text-slate-600">Tránsito</dt>
                                <dd class="text-sm font-medium text-slate-900 text-right"><?php echo htmlspecialchars($v['organismo_transito']); ?></dd>
                            </div>
                        </dl>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

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