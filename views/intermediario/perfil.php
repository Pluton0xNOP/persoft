<?php
// views/intermediario/perfil.php
?>
<div class="min-h-screen bg-gradient-to-br from-slate-50 to-slate-100 py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-slate-900 mb-2">Perfil de Intermediario</h1>
            <p class="text-slate-600">Gestiona tu información personal, datos de negocio y seguridad</p>
        </div>

        <?php if (isset($_SESSION['success_message'])): ?>
            <div class="mb-6 bg-emerald-50 border border-emerald-200 rounded-lg p-4">
                <div class="flex items-center">
                    <svg class="w-5 h-5 text-emerald-500 mr-3" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                    </svg>
                    <p class="text-emerald-800 font-medium"><?php echo $_SESSION['success_message']; ?></p>
                </div>
            </div>
            <?php unset($_SESSION['success_message']); ?>
        <?php endif; ?>

        <?php if (isset($_SESSION['error_message'])): ?>
            <div class="mb-6 bg-red-50 border border-red-200 rounded-lg p-4">
                <div class="flex items-center">
                    <svg class="w-5 h-5 text-red-500 mr-3" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path>
                    </svg>
                    <p class="text-red-800 font-medium"><?php echo $_SESSION['error_message']; ?></p>
                </div>
            </div>
            <?php unset($_SESSION['error_message']); ?>
        <?php endif; ?>

        <div class="grid grid-cols-1 xl:grid-cols-3 gap-8">
            <div class="xl:col-span-1">
                <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-6 sticky top-8">
                    <div class="text-center mb-6">
                        <div class="w-24 h-24 bg-gradient-to-br from-blue-500 to-indigo-600 rounded-full flex items-center justify-center mx-auto mb-4 text-white shadow-lg">
                            <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                            </svg>
                        </div>
                        <h2 class="text-2xl font-bold text-slate-900 mb-1"><?php echo htmlspecialchars($intermediario['nombre_negocio']); ?></h2>
                        <p class="text-sm text-slate-600">Intermediario Registrado</p>
                    </div>
                    
                    <div class="space-y-4">
                        <div class="border-b border-slate-200 pb-4">
                            <h3 class="font-semibold text-slate-900 mb-3">Estadísticas</h3>
                            <div class="space-y-3">
                                <div class="flex justify-between">
                                    <span class="text-sm text-slate-600">Comisión Actual</span>
                                    <span class="text-sm font-medium text-emerald-600"><?php echo htmlspecialchars($intermediario['porcentaje_comision']); ?>%</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-sm text-slate-600">Cotizaciones</span>
                                    <span class="text-sm font-medium text-slate-900"><?php echo htmlspecialchars($estadisticas['total_cotizaciones'] ?? 0); ?></span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-sm text-slate-600">Conversiones</span>
                                    <span class="text-sm font-medium text-slate-900"><?php echo htmlspecialchars($estadisticas['total_conversiones'] ?? 0); ?></span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-sm text-slate-600">Tasa de Conversión</span>
                                    <span class="text-sm font-medium text-slate-900"><?php echo htmlspecialchars($estadisticas['tasa_conversion'] ?? '0'); ?>%</span>
                                </div>
                            </div>
                        </div>
                        
                        <div>
                            <p class="text-sm text-slate-600 mb-1">Saldo Disponible:</p>
                            <p class="font-semibold text-emerald-600 text-xl">$<?php echo number_format($intermediario['saldo_actual'] ?? 0, 0, ',', '.'); ?></p>
                            <a href="<?php echo BASE_URL; ?>intermediario/transacciones" class="mt-4 block w-full py-3 bg-blue-50 text-blue-700 text-center font-semibold rounded-lg hover:bg-blue-100 transition-colors border border-blue-200">
                                Ver Transacciones
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="xl:col-span-2 space-y-8">
                <div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden">
                    <div class="px-6 py-4 border-b border-slate-200 bg-slate-50">
                        <h2 class="text-xl font-semibold text-slate-900 flex items-center">
                            <svg class="w-5 h-5 mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                            </svg>
                            Información Personal
                        </h2>
                    </div>
                    <form method="POST" action="<?php echo BASE_URL; ?>intermediario/perfil" class="p-6">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                            <div>
                                <label for="nombres" class="block text-sm font-semibold text-slate-900 mb-2">Nombres</label>
                                <input type="text" id="nombres" name="nombres" 
                                    class="w-full px-4 py-3 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200" 
                                    value="<?php echo htmlspecialchars($usuario['nombres'] ?? ''); ?>">
                            </div>
                            <div>
                                <label for="apellidos" class="block text-sm font-semibold text-slate-900 mb-2">Apellidos</label>
                                <input type="text" id="apellidos" name="apellidos" 
                                    class="w-full px-4 py-3 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200" 
                                    value="<?php echo htmlspecialchars($usuario['apellidos'] ?? ''); ?>">
                            </div>
                        </div>
                        
                        <div class="mb-6">
                            <label for="email" class="block text-sm font-semibold text-slate-900 mb-2">Correo Electrónico</label>
                            <div class="relative">
                                <input type="email" id="email" name="email" 
                                    class="w-full px-4 py-3 border border-slate-300 rounded-lg bg-slate-50 text-slate-600 cursor-not-allowed" 
                                    value="<?php echo htmlspecialchars($usuario['email'] ?? ''); ?>" readonly>
                                <div class="absolute inset-y-0 right-0 pr-3 flex items-center">
                                    <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                                    </svg>
                                </div>
                            </div>
                        </div>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                            <div>
                                <label for="celular" class="block text-sm font-semibold text-slate-900 mb-2">Celular</label>
                                <input type="tel" id="celular" name="celular" 
                                    class="w-full px-4 py-3 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200" 
                                    value="<?php echo htmlspecialchars($usuario['celular'] ?? ''); ?>">
                            </div>
                            <div>
                                <label for="tipo_documento" class="block text-sm font-semibold text-slate-900 mb-2">Tipo de Documento</label>
                                <div class="relative">
                                    <select id="tipo_documento" name="tipo_documento" 
                                        class="w-full px-4 py-3 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 appearance-none bg-white">
                                        <option value="CC" <?php echo ($intermediario['tipo_documento'] ?? '') === 'CC' ? 'selected' : ''; ?>>Cédula de Ciudadanía</option>
                                        <option value="NIT" <?php echo ($intermediario['tipo_documento'] ?? '') === 'NIT' ? 'selected' : ''; ?>>NIT</option>
                                        <option value="CE" <?php echo ($intermediario['tipo_documento'] ?? '') === 'CE' ? 'selected' : ''; ?>>Cédula de Extranjería</option>
                                    </select>
                                    <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                        <svg class="w-5 h-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                        </svg>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="flex justify-end">
                            <button type="submit" name="update_profile" 
                                class="inline-flex items-center px-6 py-3 bg-blue-600 text-white font-semibold rounded-lg shadow-sm hover:bg-blue-700 focus:ring-4 focus:ring-blue-200 transition-all duration-200 transform hover:scale-105">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                </svg>
                                Guardar Cambios
                            </button>
                        </div>
                    </form>
                </div>

                <div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden">
                    <div class="px-6 py-4 border-b border-slate-200 bg-slate-50">
                        <h2 class="text-xl font-semibold text-slate-900 flex items-center">
                            <svg class="w-5 h-5 mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                            </svg>
                            Información del Negocio
                        </h2>
                    </div>
                    <form method="POST" action="<?php echo BASE_URL; ?>intermediario/perfil" class="p-6">
                        <div class="mb-6">
                            <label for="nombre_negocio" class="block text-sm font-semibold text-slate-900 mb-2">Nombre del Negocio</label>
                            <input type="text" id="nombre_negocio" name="nombre_negocio" 
                                class="w-full px-4 py-3 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200" 
                                value="<?php echo htmlspecialchars($intermediario['nombre_negocio'] ?? ''); ?>">
                        </div>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                            <div>
                                <label for="numero_documento" class="block text-sm font-semibold text-slate-900 mb-2">Número de Documento</label>
                                <input type="text" id="numero_documento" name="numero_documento" 
                                    class="w-full px-4 py-3 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200" 
                                    value="<?php echo htmlspecialchars($intermediario['numero_documento'] ?? ''); ?>">
                            </div>
                            <div>
                                <label for="telefono_negocio" class="block text-sm font-semibold text-slate-900 mb-2">Teléfono del Negocio</label>
                                <input type="tel" id="telefono_negocio" name="telefono_negocio" 
                                    class="w-full px-4 py-3 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200" 
                                    value="<?php echo htmlspecialchars($intermediario['telefono_negocio'] ?? ''); ?>">
                            </div>
                        </div>
                        
                        <div class="mb-6">
                            <label for="direccion" class="block text-sm font-semibold text-slate-900 mb-2">Dirección</label>
                            <input type="text" id="direccion" name="direccion" 
                                class="w-full px-4 py-3 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200" 
                                value="<?php echo htmlspecialchars($intermediario['direccion'] ?? ''); ?>">
                        </div>
                        
                        <div class="flex justify-end">
                            <button type="submit" name="update_business" 
                                class="inline-flex items-center px-6 py-3 bg-blue-600 text-white font-semibold rounded-lg shadow-sm hover:bg-blue-700 focus:ring-4 focus:ring-blue-200 transition-all duration-200 transform hover:scale-105">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                </svg>
                                Guardar Cambios
                            </button>
                        </div>
                    </form>
                </div>

                <div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden">
                    <div class="px-6 py-4 border-b border-slate-200 bg-slate-50">
                        <h2 class="text-xl font-semibold text-slate-900 flex items-center">
                            <svg class="w-5 h-5 mr-2 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            Información Bancaria
                        </h2>
                    </div>
                    <form method="POST" action="<?php echo BASE_URL; ?>intermediario/perfil" class="p-6">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                            <div>
                                <label for="entidad_bancaria" class="block text-sm font-semibold text-slate-900 mb-2">Entidad Bancaria</label>
                                <input type="text" id="entidad_bancaria" name="entidad_bancaria" 
                                    class="w-full px-4 py-3 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200" 
                                    value="<?php echo htmlspecialchars($intermediario['entidad_bancaria'] ?? ''); ?>">
                            </div>
                            <div>
                                <label for="cuenta_bancaria" class="block text-sm font-semibold text-slate-900 mb-2">Número de Cuenta</label>
                                <input type="text" id="cuenta_bancaria" name="cuenta_bancaria" 
                                    class="w-full px-4 py-3 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200" 
                                    value="<?php echo htmlspecialchars($intermediario['cuenta_bancaria'] ?? ''); ?>">
                            </div>
                        </div>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                            <div>
                                <label for="tipo_cuenta" class="block text-sm font-semibold text-slate-900 mb-2">Tipo de Cuenta</label>
                                <div class="relative">
                                    <select id="tipo_cuenta" name="tipo_cuenta" 
                                        class="w-full px-4 py-3 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 appearance-none bg-white">
                                        <option value="ahorros" <?php echo ($intermediario['tipo_cuenta'] ?? '') === 'ahorros' ? 'selected' : ''; ?>>Cuenta de Ahorros</option>
                                        <option value="corriente" <?php echo ($intermediario['tipo_cuenta'] ?? '') === 'corriente' ? 'selected' : ''; ?>>Cuenta Corriente</option>
                                    </select>
                                    <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                        <svg class="w-5 h-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                        </svg>
                                    </div>
                                </div>
                            </div>
                            <div>
                                <label for="metodo_pago_alt" class="block text-sm font-semibold text-slate-900 mb-2">Método de Pago Alternativo</label>
                                <div class="relative">
                                    <select id="metodo_pago_alt" name="metodo_pago_alt" 
                                        class="w-full px-4 py-3 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 appearance-none bg-white">
                                        <option value="">Ninguno</option>
                                        <option value="nequi" <?php echo ($intermediario['metodo_pago_alt'] ?? '') === 'nequi' ? 'selected' : ''; ?>>Nequi</option>
                                        <option value="daviplata" <?php echo ($intermediario['metodo_pago_alt'] ?? '') === 'daviplata' ? 'selected' : ''; ?>>Daviplata</option>
                                    </select>
                                    <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                        <svg class="w-5 h-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                        </svg>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="flex justify-end">
                            <button type="submit" name="update_banking" 
                                class="inline-flex items-center px-6 py-3 bg-blue-600 text-white font-semibold rounded-lg shadow-sm hover:bg-blue-700 focus:ring-4 focus:ring-blue-200 transition-all duration-200 transform hover:scale-105">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                </svg>
                                Guardar Cambios
                            </button>
                        </div>
                    </form>
                </div>

                <div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden">
                    <div class="px-6 py-4 border-b border-slate-200 bg-slate-50">
                        <h2 class="text-xl font-semibold text-slate-900 flex items-center">
                            <svg class="w-5 h-5 mr-2 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                            </svg>
                            Cambiar Contraseña
                        </h2>
                    </div>
                    <form method="POST" action="<?php echo BASE_URL; ?>intermediario/perfil" class="p-6">
                        <div class="space-y-6">
                            <div>
                                <label for="current_password" class="block text-sm font-semibold text-slate-900 mb-2">Contraseña Actual</label>
                                <div class="relative">
                                    <input type="password" id="current_password" name="current_password" 
                                        class="w-full px-4 py-3 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200">
                                    <button type="button" class="absolute inset-y-0 right-0 pr-3 flex items-center toggle-password" data-target="current_password">
                                        <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                        </svg>
                                    </button>
                                </div>
                            </div>
                            
                            <div>
                                <label for="new_password" class="block text-sm font-semibold text-slate-900 mb-2">Nueva Contraseña</label>
                                <div class="relative">
                                    <input type="password" id="new_password" name="new_password" 
                                        class="w-full px-4 py-3 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200">
                                    <button type="button" class="absolute inset-y-0 right-0 pr-3 flex items-center toggle-password" data-target="new_password">
                                        <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                        </svg>
                                    </button>
                                </div>
                                <p class="mt-1 text-xs text-slate-600">Mínimo 8 caracteres, incluye letras y números</p>
                            </div>
                            
                            <div>
                                <label for="confirm_password" class="block text-sm font-semibold text-slate-900 mb-2">Confirmar Nueva Contraseña</label>
                                <div class="relative">
                                  <input type="password" id="confirm_password" name="confirm_password" 
                                        class="w-full px-4 py-3 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200">
                                    <button type="button" class="absolute inset-y-0 right-0 pr-3 flex items-center toggle-password" data-target="confirm_password">
                                        <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                        </svg>
                                    </button>
                                </div>
                            </div>
                        </div>
                        
                        <div class="mt-8 flex justify-end">
                            <button type="submit" name="update_password" 
                                class="inline-flex items-center px-6 py-3 bg-slate-800 text-white font-semibold rounded-lg hover:bg-slate-900 focus:ring-4 focus:ring-slate-300 transition-all duration-200 transform hover:scale-105">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                                </svg>
                                Cambiar Contraseña
                            </button>
                        </div>
                    </form>
                </div>
                
                <div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden">
                    <div class="px-6 py-4 border-b border-slate-200 bg-slate-50">
                        <h2 class="text-xl font-semibold text-slate-900 flex items-center">
                            <svg class="w-5 h-5 mr-2 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                            </svg>
                            Dar de Baja Cuenta de Intermediario
                        </h2>
                    </div>
                    <div class="p-6">
                        <div class="bg-red-50 border border-red-200 rounded-lg p-4 mb-6">
                            <div class="flex">
                                <svg class="w-5 h-5 text-red-500 mr-3 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path>
                                </svg>
                                <div>
                                    <h3 class="text-red-800 font-medium mb-2">Advertencia: Acción Irreversible</h3>
                                    <p class="text-sm text-red-700">Al dar de baja tu cuenta de intermediario, se eliminará tu perfil de intermediario, historial de cotizaciones y comisiones pendientes. Esta acción no puede deshacerse.</p>
                                </div>
                            </div>
                        </div>
                        
                        <button id="darBajaBtn" class="w-full inline-flex items-center justify-center px-6 py-3 bg-red-600 text-white font-semibold rounded-lg hover:bg-red-700 focus:ring-4 focus:ring-red-200 transition-all duration-200">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                            </svg>
                            Dar de Baja Cuenta de Intermediario
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal para confirmar baja -->
<div id="confirmarBajaModal" class="hidden fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center p-4">
    <div class="bg-white rounded-lg shadow-xl max-w-md w-full">
        <div class="px-6 py-4 border-b border-slate-200 flex justify-between items-center">
            <h3 class="text-lg font-medium text-slate-900">Confirmar Baja de Cuenta</h3>
            <button id="cerrarBajaModal" class="text-slate-400 hover:text-slate-500">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
        </div>
        <form method="POST" action="<?php echo BASE_URL; ?>intermediario/dar_baja" class="p-6">
            <div class="mb-6">
                <p class="text-slate-700 mb-4">Por favor, confirma que deseas dar de baja tu cuenta de intermediario ingresando tu contraseña:</p>
                <div class="relative">
                    <input type="password" id="password_confirmacion" name="password_confirmacion" required
                        class="w-full px-4 py-3 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200">
                    <button type="button" class="absolute inset-y-0 right-0 pr-3 flex items-center toggle-password" data-target="password_confirmacion">
                        <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                        </svg>
                    </button>
                </div>
            </div>
            <div class="bg-red-50 border border-red-200 rounded-lg p-4 mb-6">
                <div class="flex items-start">
                    <div class="flex-shrink-0">
                        <svg class="h-5 w-5 text-red-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                        </svg>
                    </div>
                    <div class="ml-3">
                        <h3 class="text-sm font-medium text-red-800">Esta acción es permanente</h3>
                        <div class="mt-2 text-sm text-red-700">
                            <p>Al confirmar, perderás acceso a:</p>
                            <ul class="list-disc pl-5 space-y-1 mt-2">
                                <li>Tu perfil de intermediario</li>
                                <li>Historial de cotizaciones</li>
                                <li>Comisiones pendientes</li>
                                <li>Datos bancarios asociados</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <div class="flex justify-end space-x-3">
                <button type="button" id="cancelarBajaBtn" class="px-4 py-2 border border-slate-300 rounded-lg text-slate-700 hover:bg-slate-50">
                    Cancelar
                </button>
                <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700">
                    Confirmar Baja
                </button>
            </div>
        </form>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Toggle de contraseñas
    const toggleButtons = document.querySelectorAll('.toggle-password');
    
    toggleButtons.forEach(button => {
        button.addEventListener('click', function() {
            const targetId = this.dataset.target;
            const passwordInput = document.getElementById(targetId);
            const isPassword = passwordInput.type === 'password';
            
            passwordInput.type = isPassword ? 'text' : 'password';
            
            const icon = this.querySelector('svg');
            if (isPassword) {
                icon.innerHTML = `
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.878 9.878L3 3m6.878 6.878L21 21"></path>
                `;
            } else {
                icon.innerHTML = `
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                `;
            }
        });
    });

    // Validación de contraseñas
    const newPasswordInput = document.getElementById('new_password');
    const confirmPasswordInput = document.getElementById('confirm_password');
    
    function validatePasswords() {
        if (confirmPasswordInput.value && newPasswordInput.value !== confirmPasswordInput.value) {
            confirmPasswordInput.setCustomValidity('Las contraseñas no coinciden');
        } else {
            confirmPasswordInput.setCustomValidity('');
        }
    }
    
    if (newPasswordInput && confirmPasswordInput) {
        newPasswordInput.addEventListener('input', validatePasswords);
        confirmPasswordInput.addEventListener('input', validatePasswords);
    }
    
    // Modal de dar de baja
    const darBajaBtn = document.getElementById('darBajaBtn');
    const confirmarBajaModal = document.getElementById('confirmarBajaModal');
    const cerrarBajaModal = document.getElementById('cerrarBajaModal');
    const cancelarBajaBtn = document.getElementById('cancelarBajaBtn');
    
    if (darBajaBtn) {
        darBajaBtn.addEventListener('click', function() {
            confirmarBajaModal.classList.remove('hidden');
        });
    }
    
    if (cerrarBajaModal) {
        cerrarBajaModal.addEventListener('click', function() {
            confirmarBajaModal.classList.add('hidden');
        });
    }
    
    if (cancelarBajaBtn) {
        cancelarBajaBtn.addEventListener('click', function() {
            confirmarBajaModal.classList.add('hidden');
        });
    }
    
    // Cerrar modal al hacer clic fuera
    window.addEventListener('click', function(event) {
        if (event.target === confirmarBajaModal) {
            confirmarBajaModal.classList.add('hidden');
        }
    });
});
</script>

<style>
@keyframes fadeIn {
    from { opacity: 0; transform: translateY(10px); }
    to { opacity: 1; transform: translateY(0); }
}

.bg-white {
    animation: fadeIn 0.4s ease-out;
}

.transform {
    transition: transform 0.2s ease-in-out;
}

.sticky {
    position: sticky;
}

input:focus {
    box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
}

.toggle-password:hover svg {
    color: #475569;
}
</style>