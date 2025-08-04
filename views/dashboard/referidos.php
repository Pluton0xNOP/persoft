<div class="space-y-8">
    <h1 class="text-3xl font-bold text-slate-800">Programa de Referidos</h1>

    <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-200">
        <h2 class="text-xl font-semibold text-slate-700 mb-2">Tu Link de Referido</h2>
        <p class="text-slate-500 mb-4">Comparte este link con tus amigos. ¡Cuando se registren, ganarás un punto!</p>
        
        <div class="flex items-center space-x-2 bg-slate-100 p-3 rounded-lg">
            <input type="text" id="referral-link" value="<?php echo htmlspecialchars($link_referido, ENT_QUOTES, 'UTF-8'); ?>" class="flex-grow bg-transparent text-slate-700 font-mono text-sm border-0 focus:ring-0 p-0" readonly>
            <button id="copy-button" class="bg-blue-600 text-white text-sm font-semibold px-4 py-2 rounded-lg hover:bg-blue-700 transition-colors">Copiar</button>
        </div>
        <div id="copy-feedback" class="text-sm text-green-600 mt-2 opacity-0 transition-opacity">¡Copiado al portapapeles!</div>
    </div>

    <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-200">
        <div class="flex items-center justify-between mb-6">
            <h2 class="text-xl font-semibold text-slate-700">Tus Referidos</h2>
            <div class="bg-blue-100 text-blue-700 font-bold text-lg px-4 py-2 rounded-full">
                <?php echo htmlspecialchars($usuario['puntos'] ?? 0, ENT_QUOTES, 'UTF-8'); ?> Puntos
            </div>
        </div>

        <?php if (empty($referidos)): ?>
            <div class="text-center py-10 border-2 border-dashed border-slate-200 rounded-lg">
                <p class="text-slate-500">Aún no tienes referidos.</p>
                <p class="text-slate-400 text-sm mt-1">¡Empieza a compartir tu link!</p>
            </div>
        <?php else: ?>
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-slate-200">
                    <thead class="bg-slate-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">Nombre</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">Email</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">Fecha de Registro</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-slate-200">
                        <?php foreach ($referidos as $referido): ?>
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-slate-800"><?php echo htmlspecialchars($referido['nombres'], ENT_QUOTES, 'UTF-8'); ?></td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-500"><?php echo htmlspecialchars($referido['email'], ENT_QUOTES, 'UTF-8'); ?></td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-500"><?php echo date('d/m/Y', strtotime($referido['created_at'])); ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php endif; ?>
    </div>
</div>

<script>
document.getElementById('copy-button').addEventListener('click', function() {
    const linkInput = document.getElementById('referral-link');
    const feedback = document.getElementById('copy-feedback');
    
    navigator.clipboard.writeText(linkInput.value).then(function() {
        feedback.style.opacity = '1';
        setTimeout(() => {
            feedback.style.opacity = '0';
        }, 2000);
    }, function(err) {
        console.error('Error al copiar: ', err);
    });
});
</script>