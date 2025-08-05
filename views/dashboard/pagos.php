
<?php
// views/dashboard/pagos.php
$status_classes = [
    'Pagado' => 'bg-emerald-100 text-emerald-800',
    'Pendiente' => 'bg-amber-100 text-amber-800',
    'Vencido' => 'bg-red-100 text-red-800',
];
?>
<div class="min-h-screen bg-gradient-to-br from-slate-50 to-slate-100 py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-slate-900 mb-2">Centro de Pagos</h1>
            <p class="text-slate-600">Consulta y gestiona el historial de pagos de tus servicios y productos.</p>
        </div>

        <div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden">
            <div class="p-6 border-b border-slate-200">
                <h2 class="text-lg font-semibold text-slate-900">Historial de Transacciones</h2>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead>
                        <tr class="border-b border-slate-200 bg-slate-50">
                            <th class="text-left py-3 px-6 font-semibold text-slate-700">Concepto</th>
                            <th class="text-left py-3 px-6 font-semibold text-slate-700">Fecha</th>
                            <th class="text-right py-3 px-6 font-semibold text-slate-700">Monto</th>
                            <th class="text-center py-3 px-6 font-semibold text-slate-700">Estado</th>
                            <th class="text-center py-3 px-6 font-semibold text-slate-700">Acción</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        <?php if (empty($pagos)): ?>
                            <tr>
                                <td colspan="5" class="text-center py-16 text-slate-500">
                                    <div class="w-20 h-20 bg-slate-100 rounded-full flex items-center justify-center mx-auto mb-4">
                                        <svg class="w-10 h-10 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path></svg>
                                    </div>
                                    No tienes transacciones registradas.
                                </td>
                            </tr>
                        <?php else: ?>
                            <?php foreach($pagos as $pago): ?>
                                <tr class="hover:bg-slate-50 transition-colors">
                                    <td class="py-4 px-6 font-medium text-slate-900"><?php echo htmlspecialchars($pago['concepto']); ?></td>
                                    <td class="py-4 px-6 text-slate-600"><?php echo htmlspecialchars((new DateTime($pago['fecha']))->format('d/m/Y')); ?></td>
                                    <td class="py-4 px-6 text-right font-mono text-slate-800">$<?php echo htmlspecialchars(number_format($pago['monto'], 0, ',', '.')); ?></td>
                                    <td class="py-4 px-6 text-center">
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold <?php echo $status_classes[$pago['estado']] ?? 'bg-slate-100 text-slate-800'; ?>">
                                            <?php echo htmlspecialchars($pago['estado']); ?>
                                        </span>
                                    </td>
                                    <td class="py-4 px-6 text-center">
                                        <?php if($pago['estado'] === 'Pendiente'): ?>
                                            <button class="px-4 py-1.5 bg-blue-600 text-white text-xs font-semibold rounded-full hover:bg-blue-700 transition-colors">
                                                Pagar ahora
                                            </button>
                                        <?php else: ?>
                                            <a href="#" class="text-slate-400 hover:text-blue-600 transition-colors" title="Descargar Recibo">
                                                <svg class="w-6 h-6 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                                            </a>
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