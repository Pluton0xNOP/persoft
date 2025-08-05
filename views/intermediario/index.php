<?php //views/intermediario/index.php ?>

                <?php if (isset($_SESSION['error_message'])): ?>
                    <div class="mb-6 bg-red-50 border border-red-200 text-red-800 rounded-lg p-4">
                        <div class="flex items-start">
                            <svg class="w-5 h-5 mr-2 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <p><?php echo $_SESSION['error_message']; ?></p>
                        </div>
                    </div>
                    <?php unset($_SESSION['error_message']); ?>
                <?php endif; ?>

                <form method="POST" action="<?php echo BASE_URL; ?>intermediario/registro" class="space-y-6">
                    <div>
                        <label for="nombre_negocio" class="block text-sm font-medium text-gray-700 mb-1">Nombre del Negocio *</label>
                        <input type="text" id="nombre_negocio" name="nombre_negocio" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        <p class="mt-1 text-sm text-gray-500">Nombre con el que se identificará tu negocio</p>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="tipo_documento" class="block text-sm font-medium text-gray-700 mb-1">Tipo de Documento *</label>
                            <select id="tipo_documento" name="tipo_documento" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                <option value="CC">Cédula de Ciudadanía</option>
                                <option value="NIT">NIT</option>
                                <option value="CE">Cédula de Extranjería</option>
                            </select>
                        </div>
                        <div>
                            <label for="numero_documento" class="block text-sm font-medium text-gray-700 mb-1">Número de Documento *</label>
                            <input type="text" id="numero_documento" name="numero_documento" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        </div>
                    </div>

                    <div>
                        <label for="direccion" class="block text-sm font-medium text-gray-700 mb-1">Dirección</label>
                        <input type="text" id="direccion" name="direccion" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                    </div>

                    <div>
                        <label for="telefono_negocio" class="block text-sm font-medium text-gray-700 mb-1">Teléfono del Negocio</label>
                        <input type="tel" id="telefono_negocio" name="telefono_negocio" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                    </div>

                    <div class="border-t border-gray-200 pt-6">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Información Bancaria</h3>
                        <p class="text-sm text-gray-500 mb-4">Esta información será utilizada para realizar los pagos de tus comisiones.</p>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="entidad_bancaria" class="block text-sm font-medium text-gray-700 mb-1">Entidad Bancaria</label>
                                <input type="text" id="entidad_bancaria" name="entidad_bancaria" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                            </div>
                            <div>
                                <label for="cuenta_bancaria" class="block text-sm font-medium text-gray-700 mb-1">Número de Cuenta</label>
                                <input type="text" id="cuenta_bancaria" name="cuenta_bancaria" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                            </div>
                        </div>
                    </div>

                    <div class="border-t border-gray-200 pt-6 flex justify-end">
                        <a href="<?php echo BASE_URL; ?>dashboard" class="px-6 py-2 border border-gray-300 rounded-lg text-gray-700 mr-4 hover:bg-gray-50">Cancelar</a>
                        <button type="submit" class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">Registrarse como Intermediario</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>