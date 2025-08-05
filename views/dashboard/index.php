
<?php
//dashboard/index.php
?>

<div class="min-h-screen bg-gradient-to-br from-slate-50 to-slate-100 py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-6 mb-8">
            <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-6 hover:shadow-md transition-all duration-300">
                <div class="flex items-center space-x-4">
                    <div class="w-14 h-14 bg-gradient-to-br from-red-500 to-red-600 rounded-xl flex items-center justify-center text-white shadow-lg">
                        <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                    </div>
                    <div>
                        <p class="text-sm text-slate-600 font-medium">Vence Tecnomecánica</p>
                        <p class="text-2xl font-bold text-slate-900">
                            <?php echo isset($alertas['tecnomecanica']['dias_restantes']) ? abs($alertas['tecnomecanica']['dias_restantes']) : '0'; ?>
                            <span class="text-sm font-normal text-slate-600">días</span>
                        </p>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-6 hover:shadow-md transition-all duration-300">
                <div class="flex items-center space-x-4">
                    <div class="w-14 h-14 bg-gradient-to-br from-amber-500 to-amber-600 rounded-xl flex items-center justify-center text-white shadow-lg">
                        <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                    </div>
                    <div>
                        <p class="text-sm text-slate-600 font-medium">Vence SOAT</p>
                        <p class="text-2xl font-bold text-slate-900">
                             <?php echo isset($alertas['soat']['dias_restantes']) ? abs($alertas['soat']['dias_restantes']) : '0'; ?>
                            <span class="text-sm font-normal text-slate-600">días</span>
                        </p>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-6 hover:shadow-md transition-all duration-300">
                <div class="flex items-center space-x-4">
                    <div class="w-14 h-14 bg-gradient-to-br from-blue-500 to-blue-600 rounded-xl flex items-center justify-center text-white shadow-lg">
                        <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v3m0 0v3m0-3h3m-3 0H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>
                    <div>
                        <p class="text-sm text-slate-600 font-medium">Comparendos</p>
                        <p class="text-2xl font-bold text-slate-900">0</p>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-6 hover:shadow-md transition-all duration-300">
                <div class="flex items-center space-x-4">
                    <div class="w-14 h-14 bg-gradient-to-br from-emerald-500 to-emerald-600 rounded-xl flex items-center justify-center text-white shadow-lg">
                        <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"></path></svg>
                    </div>
                    <div>
                        <p class="text-sm text-slate-600 font-medium">Puntos PerSoft</p>
                        <p class="text-2xl font-bold text-slate-900"><?php echo number_format($usuario['puntos'] ?? 0); ?></p>
                    </div>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 xl:grid-cols-3 gap-8">
            <div class="xl:col-span-2 space-y-8">
                <?php if (isset($vehiculo) && $vehiculo): ?>
                    <div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden">
                        <div class="px-6 py-4 border-b border-slate-200 bg-slate-50/50">
                            <h2 class="text-xl font-semibold text-slate-900 flex items-center">
                                <svg class="w-5 h-5 mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path></svg>
                                Detalles de tu Vehículo Principal
                            </h2>
                        </div>
                        <div class="p-6">
                            <div class="grid grid-cols-2 md:grid-cols-3 gap-6">
                                <div class="space-y-1"><p class="text-sm text-slate-600">Placa</p><p class="font-semibold text-slate-900"><?php echo $vehiculo['placa'] ?? 'N/A'; ?></p></div>
                                <div class="space-y-1"><p class="text-sm text-slate-600">Marca</p><p class="font-semibold text-slate-900"><?php echo $vehiculo['marca'] ?? 'N/A'; ?></p></div>
                                <div class="space-y-1"><p class="text-sm text-slate-600">Modelo</p><p class="font-semibold text-slate-900"><?php echo $vehiculo['modelo'] ?? 'N/A'; ?></p></div>
                                <div class="space-y-1"><p class="text-sm text-slate-600">Línea</p><p class="font-semibold text-slate-900"><?php echo $vehiculo['linea'] ?? 'N/A'; ?></p></div>
                                <div class="space-y-1"><p class="text-sm text-slate-600">Color</p><p class="font-semibold text-slate-900"><?php echo $vehiculo['color'] ?? 'N/A'; ?></p></div>
                                <div class="space-y-1"><p class="text-sm text-slate-600">Clase</p><p class="font-semibold text-slate-900"><?php echo $vehiculo['clase'] ?? 'N/A'; ?></p></div>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden">
                        <div class="px-6 py-4 border-b border-slate-200 bg-slate-50/50">
                            <h2 class="text-xl font-semibold text-slate-900 flex items-center">
                                <svg class="w-5 h-5 mr-2 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                                Alertas Importantes
                            </h2>
                        </div>
                        <div class="p-6 space-y-4">
                            <?php $tieneAlertas = false; ?>
                            <?php if (isset($alertas['tecnomecanica']) && $alertas['tecnomecanica']['estado'] === 'Vencido'): $tieneAlertas = true; ?>
                                <div class="bg-red-50 border border-red-200 rounded-lg p-4 flex items-center justify-between">
                                    <div class="flex items-center"><div class="flex-shrink-0"><svg class="w-5 h-5 text-red-500" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path></svg></div><div class="ml-3 flex-1"><h3 class="text-sm font-semibold text-red-800">Tu Tecnomecánica está VENCIDA</h3><p class="text-sm text-red-700 mt-1">Venció el <?php echo $alertas['tecnomecanica']['vencimiento']; ?>.</p></div></div>
                                    <button class="inline-flex items-center px-3 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-red-600 hover:bg-red-700">Agendar</button>
                                </div>
                            <?php elseif (isset($alertas['tecnomecanica']) && $alertas['tecnomecanica']['estado'] === 'Próximo a Vencer'): $tieneAlertas = true; ?>
                                <div class="bg-amber-50 border border-amber-200 rounded-lg p-4 flex items-center justify-between">
                                    <div class="flex items-center"><div class="flex-shrink-0"><svg class="w-5 h-5 text-amber-500" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path></svg></div><div class="ml-3 flex-1"><h3 class="text-sm font-semibold text-amber-800">Tu Tecnomecánica está próxima a vencer</h3><p class="text-sm text-amber-700 mt-1">Vence en <?php echo $alertas['tecnomecanica']['dias_restantes']; ?> días.</p></div></div>
                                    <button class="inline-flex items-center px-3 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-amber-600 hover:bg-amber-700">Agendar</button>
                                </div>
                            <?php endif; ?>

                            <?php if (isset($alertas['soat']) && $alertas['soat']['estado'] === 'Vencido'): $tieneAlertas = true; ?>
                                <div class="bg-red-50 border border-red-200 rounded-lg p-4 flex items-center justify-between">
                                    <div class="flex items-center"><div class="flex-shrink-0"><svg class="w-5 h-5 text-red-500" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path></svg></div><div class="ml-3 flex-1"><h3 class="text-sm font-semibold text-red-800">Tu SOAT está VENCIDO</h3><p class="text-sm text-red-700 mt-1">Venció el <?php echo $alertas['soat']['vencimiento']; ?>.</p></div></div>
                                    <button class="inline-flex items-center px-3 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-red-600 hover:bg-red-700">Renovar</button>
                                </div>
                            <?php elseif (isset($alertas['soat']) && $alertas['soat']['estado'] === 'Próximo a Vencer'): $tieneAlertas = true; ?>
                                 <div class="bg-amber-50 border border-amber-200 rounded-lg p-4 flex items-center justify-between">
                                    <div class="flex items-center"><div class="flex-shrink-0"><svg class="w-5 h-5 text-amber-500" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path></svg></div><div class="ml-3 flex-1"><h3 class="text-sm font-semibold text-amber-800">Tu SOAT está próximo a vencer</h3><p class="text-sm text-amber-700 mt-1">Vence en <?php echo $alertas['soat']['dias_restantes']; ?> días.</p></div></div>
                                    <button class="inline-flex items-center px-3 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-amber-600 hover:bg-amber-700">Renovar</button>
                                </div>
                            <?php endif; ?>

                            <?php if (!$tieneAlertas): ?>
                                <div class="bg-emerald-50 border border-emerald-200 rounded-lg p-4 flex items-center"><div class="flex-shrink-0"><svg class="w-5 h-5 text-emerald-500" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg></div><div class="ml-3"><p class="text-sm font-medium text-emerald-800">¡Todo en orden!</p><p class="text-sm text-emerald-700 mt-1">No tienes alertas urgentes.</p></div></div>
                            <?php endif; ?>
                        </div>
                    </div>
                <?php else: ?>
                    <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-12 text-center">
                        <div class="w-20 h-20 bg-blue-100 rounded-full flex items-center justify-center mx-auto mb-6"><svg class="w-10 h-10 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg></div>
                        <h3 class="text-xl font-bold text-slate-900 mb-2">Bienvenido a PerSoft</h3>
                        <p class="text-slate-600 mb-6">Aún no has agregado vehículos. ¡Ve a la sección 'Mis Vehículos' para empezar!</p>
                        <a href="<?php echo BASE_URL; ?>dashboard/vehiculos" class="inline-flex items-center px-4 py-2 bg-blue-600 text-white font-medium rounded-lg hover:bg-blue-700 transition-colors"><svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>Agregar Vehículo</a>
                    </div>
                <?php endif; ?>
            </div>

            <div class="space-y-8">
                <div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden">
                    <div class="px-6 py-4 border-b border-slate-200 bg-slate-50/50">
                        <h2 class="text-lg font-semibold text-slate-900 flex items-center">
                            <svg class="w-5 h-5 mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path></svg>
                            Proyección de Pagos (6 meses)
                        </h2>
                    </div>
                    <div class="p-4 md:p-6">
                        <div class="h-64">
                            <canvas id="proyeccionPagosChart"></canvas>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden">
                    <div class="px-6 py-4 border-b border-slate-200 bg-slate-50/50">
                        <h2 class="text-lg font-semibold text-slate-900 flex items-center">
                            <svg class="w-5 h-5 mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                            CDAs Cercanos Recomendados
                        </h2>
                    </div>
                    <div class="p-6 space-y-3">
                        <?php if(isset($cda_cercanos)): foreach ($cda_cercanos as $cda): ?>
                            <div class="flex items-center justify-between p-3 bg-slate-50 rounded-lg hover:bg-slate-100 transition-colors">
                                <div class="flex-1"><p class="font-semibold text-slate-900"><?php echo $cda['nombre']; ?></p><p class="text-sm text-slate-600"><?php echo $cda['direccion']; ?></p></div>
                                <div class="flex items-center text-sm"><svg class="w-4 h-4 mr-1 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path></svg><span class="font-semibold text-blue-600"><?php echo $cda['distancia']; ?></span></div>
                            </div>
                        <?php endforeach; endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    const proyeccionData = <?php echo json_encode($proyeccion_pagos ?? ['labels' => [], 'data' => []]); ?>;
    const ctx = document.getElementById('proyeccionPagosChart');

    if (ctx && proyeccionData.labels && proyeccionData.data) {
        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: proyeccionData.labels,
                datasets: [{
                    label: 'Monto a Pagar',
                    data: proyeccionData.data,
                    backgroundColor: 'rgba(59, 130, 246, 0.5)',
                    borderColor: 'rgb(59, 130, 246)',
                    borderWidth: 2,
                    borderRadius: 8,
                    hoverBackgroundColor: 'rgba(59, 130, 246, 0.8)'
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                animation: { duration: 1000, easing: 'easeInOutQuart' },
                plugins: {
                    legend: { display: false },
                    tooltip: {
                        enabled: true, backgroundColor: '#1e293b', titleFont: { size: 14, weight: 'bold' },
                        bodyFont: { size: 12 }, padding: 12, cornerRadius: 8, boxPadding: 4,
                        callbacks: {
                            label: function(context) {
                                const value = context.parsed.y;
                                return new Intl.NumberFormat('es-CO', { style: 'currency', currency: 'COP', minimumFractionDigits: 0 }).format(value);
                            }
                        }
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        grid: { color: '#e2e8f0', borderDash: [3, 5], drawBorder: false },
                        ticks: {
                            color: '#64748b', font: { size: 12 },
                            callback: function(value, index, values) {
                                if (value >= 1000000) return '$' + (value / 1000000) + 'M';
                                if (value >= 1000) return '$' + (value / 1000) + 'K';
                                return '$' + value;
                            }
                        }
                    },
                    x: {
                        grid: { display: false },
                        ticks: { color: '#334155', font: { size: 12, weight: '500' } }
                    }
                }
            }
        });
    }
});
</script>
<style>
@keyframes fadeIn { from { opacity: 0; transform: translateY(10px); } to { opacity: 1; transform: translateY(0); } }
.grid > div { animation: fadeIn 0.5s ease-out forwards; }
.hover\:shadow-md:hover { transform: translateY(-2px); box-shadow: 0 4px 6px -1px rgb(0 0 0 / 0.1), 0 2px 4px -2px rgb(0 0 0 / 0.1); }
</style>