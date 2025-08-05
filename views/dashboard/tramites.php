<?php
// views/dashboard/tramites.php
$status_map = [
    'Completado' => ['icon' => 'check-circle', 'color' => 'emerald', 'bg' => 'bg-emerald-100', 'text' => 'text-emerald-700'],
    'En Proceso' => ['icon' => 'clock', 'color' => 'blue', 'bg' => 'bg-blue-100', 'text' => 'text-blue-700'],
    'Cancelado' => ['icon' => 'x-circle', 'color' => 'red', 'bg' => 'bg-red-100', 'text' => 'text-red-700']
];

$type_icon_map = [
    'Tecnomecánica' => 'cog',
    'Pago SOAT' => 'document-text',
    'Pago Semaforización' => 'currency-dollar',
    'Ahorro Programado' => 'savings',
    'Otro' => 'document'
];
?>

<div class="min-h-screen bg-gradient-to-br from-slate-50 to-slate-100 py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="mb-8">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-3xl font-bold text-slate-900 mb-2">Historial de Trámites</h1>
                    <p class="text-slate-600">Consulta todos los servicios que has solicitado con PerSoft</p>
                </div>
                <button id="addTramiteBtn" class="inline-flex items-center px-6 py-3 bg-blue-600 text-white font-semibold rounded-lg shadow-sm hover:bg-blue-700 focus:ring-4 focus:ring-blue-200 transition-all duration-200 transform hover:scale-105">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                    </svg>
                    Nuevo Trámite
                </button>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden">
            <div class="p-6 border-b border-slate-200 bg-slate-50">
                <div class="flex space-x-1" id="tramites-tabs">
                    <button data-tab="todos" class="px-4 py-2.5 text-sm font-semibold rounded-lg text-white bg-blue-600 transition-all duration-200">
                        Todos
                    </button>
                    <button data-tab="en proceso" class="px-4 py-2.5 text-sm font-semibold rounded-lg text-slate-600 hover:bg-slate-100 hover:text-slate-900 transition-all duration-200">
                        En Proceso
                    </button>
                    <button data-tab="completado" class="px-4 py-2.5 text-sm font-semibold rounded-lg text-slate-600 hover:bg-slate-100 hover:text-slate-900 transition-all duration-200">
                        Completados
                    </button>
                    <button data-tab="cancelado" class="px-4 py-2.5 text-sm font-semibold rounded-lg text-slate-600 hover:bg-slate-100 hover:text-slate-900 transition-all duration-200">
                        Cancelados
                    </button>
                </div>
            </div>

            <div class="divide-y divide-slate-200" id="tramites-list">
                <?php if (empty($datos['tramites'])): ?>
                    <div class="p-12 text-center">
                        <div class="w-16 h-16 bg-slate-100 rounded-full flex items-center justify-center mx-auto mb-4">
                            <svg class="w-8 h-8 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                        </div>
                        <h3 class="text-lg font-semibold text-slate-900 mb-2">Sin trámites registrados</h3>
                        <p class="text-slate-600">Aún no has registrado ningún trámite.</p>
                    </div>
                <?php else: ?>
                    <?php foreach($datos['tramites'] as $tramite): ?>
                        <div class="p-6 hover:bg-slate-50 transition-all duration-200 tramites-item" data-status="<?php echo strtolower($tramite['estado']); ?>">
                            <div class="flex items-center space-x-6">
                                <div class="w-12 h-12 bg-gradient-to-br from-blue-500 to-blue-600 rounded-xl flex-shrink-0 flex items-center justify-center text-white shadow-lg">
                                    <?php
                                    $iconName = $type_icon_map[$tramite['tipo_tramite']] ?? 'document';
                                    switch($iconName):
                                        case 'cog': ?>
                                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                            </svg>
                                        <?php break; case 'document-text': ?>
                                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                            </svg>
                                        <?php break; case 'currency-dollar': ?>
                                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"></path>
                                            </svg>
                                        <?php break; case 'savings': ?>
                                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"></path>
                                            </svg>
                                        <?php break; default: ?>
                                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                            </svg>
                                    <?php endswitch; ?>
                                </div>
                                
                                <div class="flex-1 grid grid-cols-1 lg:grid-cols-5 gap-4 lg:gap-6 items-start lg:items-center">
                                    <div class="lg:col-span-1">
                                        <h3 class="font-bold text-slate-900 mb-1"><?php echo htmlspecialchars($tramite['tipo_tramite']); ?></h3>
                                        <p class="text-sm text-slate-600">Vehículo: <span class="font-medium"><?php echo htmlspecialchars($tramite['vehiculo_placa']); ?></span></p>
                                    </div>
                                    
                                    <div class="lg:col-span-1">
                                        <p class="text-sm text-slate-600 mb-1">Fecha</p>
                                        <p class="font-medium text-slate-900"><?php echo (new DateTime($tramite['fecha']))->format('d/m/Y'); ?></p>
                                    </div>
                                    
                                    <div class="lg:col-span-1">
                                        <p class="text-sm text-slate-600 mb-1">Estado</p>
                                        <div class="inline-flex items-center">
                                            <?php $statusInfo = $status_map[$tramite['estado']]; ?>
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
                                                <?php endswitch; ?>
                                                <?php echo htmlspecialchars($tramite['estado']); ?>
                                            </span>
                                        </div>
                                    </div>
                                    
                                    <div class="lg:col-span-1">
                                        <p class="text-sm text-slate-600 mb-1">Costo</p>
                                        <p class="font-bold text-slate-900 text-lg">$<?php echo number_format($tramite['costo'], 0, ',', '.'); ?></p>
                                    </div>
                                    
                                    <div class="lg:col-span-1 flex justify-start lg:justify-end space-x-2">
                                        <button class="inline-flex items-center justify-center w-10 h-10 border border-slate-300 rounded-lg text-slate-600 hover:bg-slate-100 hover:text-blue-600 transition-all duration-200 transform hover:scale-105">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                            </svg>
                                        </button>
                                        <?php if ($tramite['estado'] === 'Completado'): ?>
                                            <button class="inline-flex items-center justify-center w-10 h-10 bg-slate-800 text-white rounded-lg hover:bg-slate-900 transition-all duration-200 transform hover:scale-105">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                                </svg>
                                            </button>
                                        <?php endif; ?>
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

<div id="addTramiteModal" class="modal fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center hidden">
    <div class="modal-content bg-white rounded-xl shadow-xl w-full max-w-md mx-4 transform transition-all duration-300">
        <div class="px-6 py-4 border-b border-slate-200 bg-slate-50 rounded-t-xl">
            <div class="flex justify-between items-center">
                <h3 class="text-xl font-bold text-slate-900">Registrar Nuevo Trámite</h3>
                <button onclick="closeModal('addTramiteModal')" class="modal-close text-slate-500 hover:text-slate-700 p-1 rounded-lg hover:bg-slate-100 transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
        </div>
        
        <form id="addTramiteForm" action="<?php echo BASE_URL; ?>dashboard/crear-tramite" method="POST" class="p-6">
            <div class="space-y-6">
                <div>
                    <label for="vehiculo_id" class="block text-sm font-semibold text-slate-900 mb-2">Vehículo</label>
                    <select id="vehiculo_id" name="vehiculo_id" class="w-full px-4 py-3 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors" required>
                        <option value="">Selecciona un vehículo</option>
                        <?php if(isset($datos['vehiculos'])): foreach($datos['vehiculos'] as $vehiculo): ?>
                            <option value="<?php echo $vehiculo['id']; ?>"><?php echo htmlspecialchars($vehiculo['info']['placa'] . ' - ' . $vehiculo['info']['marca']); ?></option>
                        <?php endforeach; endif; ?>
                    </select>
                </div>
                
                <div>
                    <label for="tipo_tramite" class="block text-sm font-semibold text-slate-900 mb-2">Tipo de Trámite</label>
                    <select id="tipo_tramite" name="tipo_tramite" class="w-full px-4 py-3 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors" required>
                        <option value="Pago SOAT">Pago SOAT</option>
                        <option value="Tecnomecánica">Tecnomecánica</option>
                        <option value="Pago Semaforización">Pago Semaforización</option>
                        <option value="Ahorro Programado">Ahorro Programado</option>
                        <option value="Otro">Otro</option>
                    </select>
                </div>
                
                <div>
                    <label for="costo" class="block text-sm font-semibold text-slate-900 mb-2">Costo</label>
                    <div class="relative">
                        <span class="absolute left-3 top-3 text-slate-500">$</span>
                        <input type="number" id="costo" name="costo" class="w-full pl-8 pr-4 py-3 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors" placeholder="250,000" required>
                    </div>
                </div>
                
                <div>
                    <label for="fecha" class="block text-sm font-semibold text-slate-900 mb-2">Fecha del Trámite</label>
                    <input type="date" id="fecha" name="fecha" value="<?php echo date('Y-m-d'); ?>" class="w-full px-4 py-3 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors" required>
                </div>
            </div>
            
            <div class="mt-8 flex justify-end space-x-3">
                <button type="button" onclick="closeModal('addTramiteModal')" class="px-6 py-3 border border-slate-300 text-slate-700 font-medium rounded-lg hover:bg-slate-50 transition-colors">
                    Cancelar
                </button>
                <button type="submit" class="px-6 py-3 bg-blue-600 text-white font-semibold rounded-lg hover:bg-blue-700 focus:ring-4 focus:ring-blue-200 transition-all duration-200 transform hover:scale-105">
                    Registrar Trámite
                </button>
            </div>
        </form>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const addTramiteBtn = document.getElementById('addTramiteBtn');
    const tabs = document.querySelectorAll('[data-tab]');
    const tramiteItems = document.querySelectorAll('.tramites-item');

    if (addTramiteBtn) {
        addTramiteBtn.addEventListener('click', function() {
            document.getElementById('addTramiteModal').classList.remove('hidden');
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
            
            tramiteItems.forEach(item => {
                if (targetTab === 'todos' || item.dataset.status.includes(targetTab)) {
                    item.style.display = 'block';
                } else {
                    item.style.display = 'none';
                }
            });
        });
    });

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

.tramites-item {
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