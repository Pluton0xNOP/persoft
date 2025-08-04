<?php
// views/dashboard/multas.php
$status_classes = [
    'Pendiente' => 'bg-amber-100 text-amber-800',
    'Pendiente Curso' => 'bg-sky-100 text-sky-800',
    'Cobro coactivo' => 'bg-red-100 text-red-800',
    'Pagada' => 'bg-emerald-100 text-emerald-800',
];
$cantidadMultas = count($multas);
?>

<div class="min-h-screen bg-gradient-to-br from-slate-50 to-slate-100 py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-slate-900 mb-2">Mis Multas</h1>
            <p class="text-slate-600">Consulta el historial de multas y comparendos de tus vehículos.</p>
        </div>

        <?php if (!empty($multas)): ?>
        <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-6 mb-8">
            <div class="flex flex-col md:flex-row justify-between items-center space-y-4 md:space-y-0">
                <div class="flex items-center space-x-3">
                    <div class="w-12 h-12 bg-amber-100 rounded-full flex items-center justify-center">
                        <svg class="w-6 h-6 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                    </div>
                    <div>
                        <p class="text-slate-500 text-sm">Total de Multas</p>
                        <p class="text-2xl font-bold text-slate-900"><?php echo count($multas); ?></p>
                    </div>
                </div>
                <div class="h-12 w-px bg-slate-200 hidden md:block"></div>
                <div class="flex items-center space-x-3">
                     <div class="w-12 h-12 bg-red-100 rounded-full flex items-center justify-center">
                        <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"></path></svg>
                    </div>
                    <div>
                        <p class="text-slate-500 text-sm">Deuda Total</p>
                        <p class="text-2xl font-bold text-red-600 font-mono">$<?php echo number_format($totalDeuda, 0, ',', '.'); ?></p>
                    </div>
                </div>
                <button class="px-6 py-3 bg-blue-600 text-white font-semibold rounded-lg hover:bg-blue-700 transition-colors shadow-sm">
                    Pagar Todas las Multas
                </button>
            </div>
        </div>
        <?php endif; ?>

        <div class="space-y-6">
            <?php if ($cantidadMultas === 0): ?>
                <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-12 text-center">
                    <div class="w-20 h-20 bg-emerald-50 rounded-full flex items-center justify-center mx-auto mb-6">
                         <svg class="w-10 h-10 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>
                    <h3 class="text-xl font-bold text-slate-900 mb-2">¡Todo en Orden!</h3>
                    <p class="text-slate-600">No se encontraron multas o comparendos pendientes.</p>
                </div>
            <?php else: ?>
                <?php foreach($multas as $multa): ?>
                    <div class="bg-white rounded-xl shadow-sm border border-slate-200">
                        <div class="p-5 border-b border-slate-100 flex justify-between items-center">
                            <div>
                                <p class="font-bold text-slate-900 text-lg">Comparendo N°: <?php echo htmlspecialchars($multa['numeroComparendo']); ?></p>
                                <p class="text-sm text-slate-500">Vehículo con placa <span class="font-semibold text-slate-700"><?php echo htmlspecialchars($multa['placa']); ?></span></p>
                            </div>
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold <?php echo $status_classes[$multa['estadoComparendo']] ?? 'bg-slate-100 text-slate-800'; ?>">
                                <?php echo htmlspecialchars($multa['estadoComparendo']); ?>
                            </span>
                        </div>
                        <div class="p-5 grid grid-cols-1 md:grid-cols-3 gap-6">
                             <div>
                                <p class="text-xs text-slate-500 mb-1">Organismo de Tránsito</p>
                                <p class="font-medium text-slate-800"><?php echo htmlspecialchars($multa['organismoTransito']); ?></p>
                            </div>
                            <div>
                                <p class="text-xs text-slate-500 mb-1">Fecha de Infracción</p>
                                <p class="font-medium text-slate-800">
                                    <?php
                                        $fechaObj = DateTime::createFromFormat('d/m/Y H:i:s', $multa['fechaComparendo']);
                                        if ($fechaObj) { echo htmlspecialchars($fechaObj->format('d/m/Y H:i')); } 
                                        else { echo 'Fecha inválida'; }
                                    ?>
                                </p>
                            </div>
                            <div>
                                <p class="text-xs text-slate-500 mb-1">Valor a Pagar</p>
                                <p class="font-bold text-xl text-red-600 font-mono">$<?php echo htmlspecialchars(number_format($multa['valorPagar'], 0, ',', '.')); ?></p>
                            </div>
                        </div>
                         <div class="p-4 bg-slate-50 border-t border-slate-100 text-right">
                             <button type="button" class="ver-detalles-btn text-blue-600 font-semibold text-sm hover:underline" data-multa='<?php echo json_encode($multa); ?>'>
                                Ver detalles y pagar
                             </button>
                         </div>
                    </div>
                <?php endforeach; ?>
                
                <?php if($totalPaginas > 1): ?>
                <nav class="flex items-center justify-between pt-4" aria-label="Pagination">
                    <a href="<?php echo BASE_URL; ?>dashboard/multas?page=<?php echo $paginaActual - 1; ?>" class="px-4 py-2 text-sm font-medium text-slate-600 bg-white rounded-lg hover:bg-slate-50 <?php echo ($paginaActual <= 1) ? 'pointer-events-none opacity-50' : ''; ?>">
                        Anterior
                    </a>
                    <div class="hidden md:flex">
                        <?php for($i = 1; $i <= $totalPaginas; $i++): ?>
                            <a href="<?php echo BASE_URL; ?>dashboard/multas?page=<?php echo $i; ?>" class="px-4 py-2 text-sm font-medium rounded-lg <?php echo ($i == $paginaActual) ? 'bg-blue-600 text-white' : 'text-slate-600 bg-white hover:bg-slate-50'; ?>">
                                <?php echo $i; ?>
                            </a>
                        <?php endfor; ?>
                    </div>
                    <a href="<?php echo BASE_URL; ?>dashboard/multas?page=<?php echo $paginaActual + 1; ?>" class="px-4 py-2 text-sm font-medium text-slate-600 bg-white rounded-lg hover:bg-slate-50 <?php echo ($paginaActual >= $totalPaginas) ? 'pointer-events-none opacity-50' : ''; ?>">
                        Siguiente
                    </a>
                </nav>
                <?php endif; ?>

            <?php endif; ?>
        </div>
    </div>
</div>

<div id="detalles-modal" class="fixed inset-0 z-50 hidden items-center justify-center bg-black bg-opacity-50 transition-opacity" aria-labelledby="modal-title" role="dialog" aria-modal="true">
    <div class="relative w-full max-w-2xl transform rounded-xl bg-white text-left shadow-xl transition-all">
        <div class="bg-white px-6 pt-5 pb-4 sm:p-6 sm:pb-4 rounded-t-xl">
            <div class="flex items-start justify-between">
                <div>
                    <h3 class="text-xl font-bold leading-6 text-slate-900" id="modal-title">Detalles del Comparendo</h3>
                    <p class="mt-1 text-sm text-slate-500" id="modal-numero-comparendo"></p>
                </div>
                <button type="button" id="close-modal-btn" class="rounded-md bg-white text-slate-400 hover:text-slate-500 focus:outline-none">
                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" /></svg>
                </button>
            </div>
            <div class="mt-6 border-t border-slate-200 pt-4">
                <dl class="grid grid-cols-1 gap-x-4 gap-y-6 sm:grid-cols-2" id="modal-body">
                </dl>
            </div>
        </div>
        <div class="bg-slate-50 px-4 py-4 sm:px-6 rounded-b-xl flex flex-col sm:flex-row-reverse gap-3">
            <button type="button" class="inline-flex w-full justify-center rounded-md bg-blue-600 px-4 py-2 text-base font-semibold text-white shadow-sm hover:bg-blue-700 sm:ml-3 sm:w-auto transition-colors">Pagar Multa</button>
            <button type="button" id="cancel-modal-btn" class="inline-flex w-full justify-center rounded-md bg-white px-4 py-2 text-base font-semibold text-slate-900 shadow-sm ring-1 ring-inset ring-slate-300 hover:bg-slate-50 sm:w-auto transition-colors">Cancelar</button>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const modal = document.getElementById('detalles-modal');
    const closeModalBtn = document.getElementById('close-modal-btn');
    const cancelModalBtn = document.getElementById('cancel-modal-btn');
    const modalTitle = document.getElementById('modal-title');
    const modalNumeroComparendo = document.getElementById('modal-numero-comparendo');
    const modalBody = document.getElementById('modal-body');
    const detailButtons = document.querySelectorAll('.ver-detalles-btn');

    const openModal = (multaData) => {
        modalNumeroComparendo.textContent = `N° ${multaData.numeroComparendo || 'No disponible'}`;

        let detailsHtml = `
            <div class="sm:col-span-1">
                <dt class="text-sm font-medium text-slate-500">Placa</dt>
                <dd class="mt-1 text-sm text-slate-900 font-semibold">${multaData.placa}</dd>
            </div>
            <div class="sm:col-span-1">
                <dt class="text-sm font-medium text-slate-500">Valor a Pagar</dt>
                <dd class="mt-1 text-lg font-bold text-red-600">$${new Intl.NumberFormat('es-CO').format(multaData.valorPagar)}</dd>
            </div>
            <div class="sm:col-span-2">
                <dt class="text-sm font-medium text-slate-500">Infracción</dt>
                <dd class="mt-1 text-sm text-slate-900">${multaData.infracciones[0].descripcionInfraccion}</dd>
            </div>
        `;

        if (multaData.proyeccion && multaData.proyeccion.length > 0) {
            detailsHtml += `<div class="sm:col-span-2 border-t border-slate-200 pt-4 mt-4">
                                <dt class="text-sm font-medium text-slate-700 mb-2">Proyección y Descuentos</dt>`;
            multaData.proyeccion.forEach(p => {
                const fechaProyeccion = p.fecha ? new Date(p.fecha.replace(/(\d{2})\/(\d{2})\/(\d{4})/, '$2/$1/$3')).toLocaleDateString('es-CO', { year: 'numeric', month: 'long', day: 'numeric'}) : 'N/A';
                detailsHtml += `<div class="mb-2 p-2 bg-slate-50 rounded-lg">
                                    <p class="font-semibold text-slate-800">${p.descripcion}</p>
                                    <p class="text-sm text-slate-600">Hasta el ${fechaProyeccion} - Valor: $${new Intl.NumberFormat('es-CO').format(p.valor)}</p>
                                </div>`;
            });
            detailsHtml += `</div>`;
        }

        modalBody.innerHTML = detailsHtml;
        modal.classList.remove('hidden');
        modal.classList.add('flex');
    };

    const closeModal = () => {
        modal.classList.add('hidden');
        modal.classList.remove('flex');
    };

    detailButtons.forEach(button => {
        button.addEventListener('click', function() {
            const multaData = JSON.parse(this.dataset.multa);
            openModal(multaData);
        });
    });

    closeModalBtn.addEventListener('click', closeModal);
    cancelModalBtn.addEventListener('click', closeModal);
    modal.addEventListener('click', function(event) {
        if (event.target === modal) {
            closeModal();
        }
    });
});
</script>