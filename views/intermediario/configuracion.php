<div class="min-h-screen bg-gradient-to-br from-slate-50 to-slate-100 py-8">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-slate-900 mb-2">Configuración de Intermediario</h1>
            <p class="text-slate-600">Personaliza tus preferencias de negocio, notificaciones y cuenta</p>
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

        <form method="POST" action="<?php echo BASE_URL; ?>intermediario/configuracion" class="space-y-8">
            <div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden">
                <div class="px-6 py-4 border-b border-slate-200 bg-slate-50">
                    <div class="flex items-center">
                        <svg class="w-5 h-5 mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                        </svg>
                        <h2 class="text-xl font-semibold text-slate-900">Información de Negocio</h2>
                    </div>
                    <p class="text-sm text-slate-600 mt-1">Actualiza los datos de tu negocio como intermediario</p>
                </div>
                <div class="p-6 space-y-4">
                    <div>
                        <label for="nombre_negocio" class="block text-sm font-semibold text-slate-900 mb-2">Nombre del Negocio</label>
                        <input type="text" id="nombre_negocio" name="nombre_negocio" value="<?php echo $intermediario['nombre_negocio'] ?? ''; ?>" class="w-full px-4 py-3 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200">
                    </div>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label for="direccion" class="block text-sm font-semibold text-slate-900 mb-2">Dirección</label>
                            <input type="text" id="direccion" name="direccion" value="<?php echo $intermediario['direccion'] ?? ''; ?>" class="w-full px-4 py-3 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200">
                        </div>
                        
                        <div>
                            <label for="telefono_negocio" class="block text-sm font-semibold text-slate-900 mb-2">Teléfono del Negocio</label>
                            <input type="tel" id="telefono_negocio" name="telefono_negocio" value="<?php echo $intermediario['telefono_negocio'] ?? ''; ?>" class="w-full px-4 py-3 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200">
                        </div>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden">
                <div class="px-6 py-4 border-b border-slate-200 bg-slate-50">
                    <div class="flex items-center">
                        <svg class="w-5 h-5 mr-2 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <h2 class="text-xl font-semibold text-slate-900">Información Bancaria</h2>
                    </div>
                    <p class="text-sm text-slate-600 mt-1">Actualiza los datos para recibir tus comisiones</p>
                </div>
                <div class="p-6 space-y-4">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label for="entidad_bancaria" class="block text-sm font-semibold text-slate-900 mb-2">Entidad Bancaria</label>
                            <input type="text" id="entidad_bancaria" name="entidad_bancaria" value="<?php echo $intermediario['entidad_bancaria'] ?? ''; ?>" class="w-full px-4 py-3 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200">
                        </div>
                        
                        <div>
                            <label for="cuenta_bancaria" class="block text-sm font-semibold text-slate-900 mb-2">Número de Cuenta</label>
                            <input type="text" id="cuenta_bancaria" name="cuenta_bancaria" value="<?php echo $intermediario['cuenta_bancaria'] ?? ''; ?>" class="w-full px-4 py-3 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200">
                        </div>
                    </div>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label for="tipo_cuenta" class="block text-sm font-semibold text-slate-900 mb-2">Tipo de Cuenta</label>
                            <select id="tipo_cuenta" name="tipo_cuenta" class="w-full px-4 py-3 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 appearance-none bg-white">
                                <option value="ahorros" <?php echo ($intermediario['tipo_cuenta'] ?? '') === 'ahorros' ? 'selected' : ''; ?>>Cuenta de Ahorros</option>
                                <option value="corriente" <?php echo ($intermediario['tipo_cuenta'] ?? '') === 'corriente' ? 'selected' : ''; ?>>Cuenta Corriente</option>
                            </select>
                        </div>
                        
                        <div>
                            <label for="metodo_pago_alt" class="block text-sm font-semibold text-slate-900 mb-2">Método de Pago Alternativo</label>
                            <select id="metodo_pago_alt" name="metodo_pago_alt" class="w-full px-4 py-3 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 appearance-none bg-white">
                                <option value="">Ninguno</option>
                                <option value="nequi" <?php echo ($intermediario['metodo_pago_alt'] ?? '') === 'nequi' ? 'selected' : ''; ?>>Nequi</option>
                                <option value="daviplata" <?php echo ($intermediario['metodo_pago_alt'] ?? '') === 'daviplata' ? 'selected' : ''; ?>>Daviplata</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden">
                <div class="px-6 py-4 border-b border-slate-200 bg-slate-50">
                    <div class="flex items-center">
                        <svg class="w-5 h-5 mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-5 5v-5zM4 19v-2a3 3 0 013-3h1m0-4a3 3 0 106 0m3 11V9a2 2 0 00-2-2H7a2 2 0 00-2 2v10a2 2 0 002 2h6a2 2 0 002-2z"></path>
                        </svg>
                        <h2 class="text-xl font-semibold text-slate-900">Preferencias de Notificación</h2>
                    </div>
                    <p class="text-sm text-slate-600 mt-1">Elige cómo y cuándo quieres recibir nuestras comunicaciones</p>
                </div>
                <div class="p-6 divide-y divide-slate-200">
                    <div class="flex items-center justify-between py-4 first:pt-0 last:pb-0">
                        <div class="flex items-start space-x-3">
                            <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center flex-shrink-0">
                                <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 7.89a2 2 0 002.83 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                                </svg>
                            </div>
                            <div>
                                <p class="font-semibold text-slate-900">Alertas de Cotizaciones por Email</p>
                                <p class="text-sm text-slate-600">Notificaciones cuando tus cotizaciones sean aprobadas o estén por expirar</p>
                            </div>
                        </div>
                        <label class="relative inline-flex items-center cursor-pointer">
                            <input type="checkbox" name="email_cotizaciones" class="sr-only peer" <?php echo ($datos['settings']['notifications']['email_cotizaciones'] ?? true) ? 'checked' : ''; ?>>
                            <div class="w-11 h-6 bg-slate-200 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-0.5 after:left-[2px] after:bg-white after:border-slate-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-600 peer-focus:ring-4 peer-focus:ring-blue-200"></div>
                        </label>
                    </div>
                    
                    <div class="flex items-center justify-between py-4">
                        <div class="flex items-start space-x-3">
                            <div class="w-10 h-10 bg-green-100 rounded-lg flex items-center justify-center flex-shrink-0">
                                <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                            <div>
                                <p class="font-semibold text-slate-900">Notificaciones de Pagos</p>
                                <p class="text-sm text-slate-600">Recibe alertas cuando se acrediten comisiones a tu cuenta</p>
                            </div>
                        </div>
                        <label class="relative inline-flex items-center cursor-pointer">
                            <input type="checkbox" name="email_pagos" class="sr-only peer" <?php echo ($datos['settings']['notifications']['email_pagos'] ?? true) ? 'checked' : ''; ?>>
                            <div class="w-11 h-6 bg-slate-200 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-0.5 after:left-[2px] after:bg-white after:border-slate-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-600 peer-focus:ring-4 peer-focus:ring-blue-200"></div>
                        </label>
                    </div>
                    
                    <div class="flex items-center justify-between py-4">
                        <div class="flex items-start space-x-3">
                            <div class="w-10 h-10 bg-emerald-100 rounded-lg flex items-center justify-center flex-shrink-0">
                                <svg class="w-5 h-5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                                </svg>
                            </div>
                            <div>
                                <p class="font-semibold text-slate-900">Promociones y Novedades por Email</p>
                                <p class="text-sm text-slate-600">Entérate de nuevos productos y oportunidades de negocio</p>
                            </div>
                        </div>
                        <label class="relative inline-flex items-center cursor-pointer">
                            <input type="checkbox" name="email_promociones" class="sr-only peer" <?php echo ($datos['settings']['notifications']['email_promociones'] ?? false) ? 'checked' : ''; ?>>
                            <div class="w-11 h-6 bg-slate-200 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-0.5 after:left-[2px] after:bg-white after:border-slate-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-600 peer-focus:ring-4 peer-focus:ring-blue-200"></div>
                        </label>
                    </div>
                    
                    <div class="flex items-center justify-between py-4">
                        <div class="flex items-start space-x-3">
                            <div class="w-10 h-10 bg-amber-100 rounded-lg flex items-center justify-center flex-shrink-0">
                                <svg class="w-5 h-5 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
                                </svg>
                            </div>
                            <div>
                                <p class="font-semibold text-slate-900">Recordatorios por SMS</p>
                                <p class="text-sm text-slate-600">Recibe alertas urgentes directamente en tu celular</p>
                            </div>
                        </div>
                        <label class="relative inline-flex items-center cursor-pointer">
                            <input type="checkbox" name="sms_alertas" class="sr-only peer" <?php echo ($datos['settings']['notifications']['sms_alertas'] ?? false) ? 'checked' : ''; ?>>
                            <div class="w-11 h-6 bg-slate-200 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-0.5 after:left-[2px] after:bg-white after:border-slate-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-600 peer-focus:ring-4 peer-focus:ring-blue-200"></div>
                        </label>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden">
                <div class="px-6 py-4 border-b border-slate-200 bg-slate-50">
                    <div class="flex items-center">
                        <svg class="w-5 h-5 mr-2 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21a4 4 0 01-4-4V5a2 2 0 012-2h4a2 2 0 012 2v12a4 4 0 01-4 4zM21 5a2 2 0 00-2-2h-4a2 2 0 00-2 2v12a4 4 0 004 4h4a2 2 0 002-2V5z"></path>
                        </svg>
                        <h2 class="text-xl font-semibold text-slate-900">Apariencia e Idioma</h2>
                    </div>
                    <p class="text-sm text-slate-600 mt-1">Personaliza la interfaz de la plataforma</p>
                </div>
                <div class="p-6 space-y-6">
                    <div>
                        <label class="block text-sm font-semibold text-slate-900 mb-4">Tema</label>
                        <div class="grid grid-cols-3 gap-4">
                            <label class="relative p-4 border-2 rounded-lg cursor-pointer text-center transition-all duration-200 hover:border-slate-300 <?php echo ($datos['settings']['appearance'] ?? 'system') === 'light' ? 'border-blue-500 bg-blue-50' : 'border-slate-200'; ?>">
                                <input type="radio" name="appearance" value="light" class="sr-only" <?php echo ($datos['settings']['appearance'] ?? 'system') === 'light' ? 'checked' : ''; ?>>
                                <div class="w-10 h-10 bg-gradient-to-br from-yellow-400 to-orange-500 rounded-lg flex items-center justify-center mx-auto mb-2">
                                    <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 2a1 1 0 011 1v1a1 1 0 11-2 0V3a1 1 0 011-1zm4 8a4 4 0 11-8 0 4 4 0 018 0zm-.464 4.95l.707.707a1 1 0 001.414-1.414l-.707-.707a1 1 0 00-1.414 1.414zm2.12-10.607a1 1 0 010 1.414l-.706.707a1 1 0 11-1.414-1.414l.707-.707a1 1 0 011.414 0zM17 11a1 1 0 100-2h-1a1 1 0 100 2h1zm-7 4a1 1 0 011 1v1a1 1 0 11-2 0v-1a1 1 0 011-1zM5.05 6.464A1 1 0 106.465 5.05l-.708-.707a1 1 0 00-1.414 1.414l.707.707zm1.414 8.486l-.707.707a1 1 0 01-1.414-1.414l.707-.707a1 1 0 011.414 1.414zM4 11a1 1 0 100-2H3a1 1 0 000 2h1z" clip-rule="evenodd"></path>
                                    </svg>
                                </div>
                                <span class="block text-sm font-medium text-slate-700">Claro</span>
                                <?php if (($datos['settings']['appearance'] ?? 'system') === 'light'): ?>
                                    <div class="absolute top-2 right-2">
                                        <svg class="w-5 h-5 text-blue-500" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                        </svg>
                                    </div>
                                <?php endif; ?>
                            </label>
                            
                            <label class="relative p-4 border-2 rounded-lg cursor-pointer text-center transition-all duration-200 hover:border-slate-300 <?php echo ($datos['settings']['appearance'] ?? 'system') === 'dark' ? 'border-blue-500 bg-blue-50' : 'border-slate-200'; ?>">
                                <input type="radio" name="appearance" value="dark" class="sr-only" <?php echo ($datos['settings']['appearance'] ?? 'system') === 'dark' ? 'checked' : ''; ?>>
                                <div class="w-10 h-10 bg-gradient-to-br from-slate-600 to-slate-800 rounded-lg flex items-center justify-center mx-auto mb-2">
                                    <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M17.293 13.293A8 8 0 016.707 2.707a8.001 8.001 0 1010.586 10.586z"></path>
                                    </svg>
                                </div>
                                <span class="block text-sm font-medium text-slate-700">Oscuro</span>
                                <?php if (($datos['settings']['appearance'] ?? 'system') === 'dark'): ?>
                                    <div class="absolute top-2 right-2">
                                        <svg class="w-5 h-5 text-blue-500" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                        </svg>
                                    </div>
                                <?php endif; ?>
                            </label>
                            
                            <label class="relative p-4 border-2 rounded-lg cursor-pointer text-center transition-all duration-200 hover:border-slate-300 <?php echo ($datos['settings']['appearance'] ?? 'system') === 'system' ? 'border-blue-500 bg-blue-50' : 'border-slate-200'; ?>">
                                <input type="radio" name="appearance" value="system" class="sr-only" <?php echo ($datos['settings']['appearance'] ?? 'system') === 'system' ? 'checked' : ''; ?>>
                                <div class="w-10 h-10 bg-gradient-to-br from-blue-500 to-purple-600 rounded-lg flex items-center justify-center mx-auto mb-2">
                                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                                    </svg>
                                </div>
                                <span class="block text-sm font-medium text-slate-700">Automático</span>
                                <?php if (($datos['settings']['appearance'] ?? 'system') === 'system'): ?>
                                    <div class="absolute top-2 right-2">
                                        <svg class="w-5 h-5 text-blue-500" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                        </svg>
                                    </div>
                                <?php endif; ?>
                            </label>
                        </div>
                    </div>
                    
                    <div>
                        <label for="language" class="block text-sm font-semibold text-slate-900 mb-2">Idioma</label>
                        <div class="relative">
                            <select id="language" name="language" class="w-full px-4 py-3 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 appearance-none bg-white">
                                <option value="es-CO" <?php echo ($datos['settings']['language'] ?? 'es-CO') === 'es-CO' ? 'selected' : ''; ?>>🇨🇴 Español (Colombia)</option>
                                <option value="en-US" <?php echo ($datos['settings']['language'] ?? 'es-CO') === 'en-US' ? 'selected' : ''; ?>>🇺🇸 English (USA)</option>
                            </select>
                            <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                                <svg class="w-5 h-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                </svg>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

           <div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden">
                <div class="px-6 py-4 border-b border-slate-200 bg-slate-50">
                    <div class="flex items-center">
                        <svg class="w-5 h-5 mr-2 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                        </svg>
                        <h2 class="text-xl font-semibold text-slate-900">Datos y Privacidad</h2>
                    </div>
                    <p class="text-sm text-slate-600 mt-1">Gestiona tu información y conoce nuestras políticas</p>
                </div>
                <div class="p-6 space-y-4">
                    <div class="flex items-center justify-between p-4 bg-slate-50 rounded-lg">
                        <div class="flex items-center space-x-3">
                            <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center">
                                <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                </svg>
                            </div>
                            <div>
                                <p class="font-semibold text-slate-900">Términos de Intermediario</p>
                                <p class="text-sm text-slate-600">Revisa los términos y condiciones para intermediarios</p>
                            </div>
                        </div>
                        <a href="#" class="text-blue-600 hover:text-blue-700 font-medium transition-colors">
                            Ver Documento
                        </a>
                    </div>
                    
                    <div class="flex items-center justify-between p-4 bg-slate-50 rounded-lg">
                        <div class="flex items-center space-x-3">
                            <div class="w-10 h-10 bg-indigo-100 rounded-lg flex items-center justify-center">
                                <svg class="w-5 h-5 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                                </svg>
                            </div>
                            <div>
                                <p class="font-semibold text-slate-900">Política de Privacidad</p>
                                <p class="text-sm text-slate-600">Conoce cómo protegemos tu información</p>
                            </div>
                        </div>
                        <a href="#" class="text-blue-600 hover:text-blue-700 font-medium transition-colors">
                            Ver Documento
                        </a>
                    </div>
                    
                    <button type="button" class="w-full flex items-center justify-between p-4 bg-slate-50 rounded-lg hover:bg-slate-100 transition-colors group">
                        <div class="flex items-center space-x-3">
                            <div class="w-10 h-10 bg-emerald-100 rounded-lg flex items-center justify-center">
                                <svg class="w-5 h-5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                </svg>
                            </div>
                            <div class="text-left">
                                <p class="font-semibold text-slate-900">Descargar historial de comisiones</p>
                                <p class="text-sm text-slate-600">Obtén un informe detallado de tus comisiones</p>
                            </div>
                        </div>
                        <svg class="w-5 h-5 text-slate-400 group-hover:text-slate-600 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                        </svg>
                    </button>
                    
                    <button type="button" id="cambiarPasswordBtn" class="w-full flex items-center justify-between p-4 bg-blue-50 rounded-lg hover:bg-blue-100 transition-colors group">
                        <div class="flex items-center space-x-3">
                            <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center">
                                <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z"></path>
                                </svg>
                            </div>
                            <div class="text-left">
                                <p class="font-semibold text-blue-700">Cambiar contraseña</p>
                                <p class="text-sm text-blue-600">Actualiza tu contraseña de acceso</p>
                            </div>
                        </div>
                        <svg class="w-5 h-5 text-blue-400 group-hover:text-blue-600 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                        </svg>
                    </button>
                    
                    <button type="button" class="w-full flex items-center justify-between p-4 bg-red-50 rounded-lg hover:bg-red-100 transition-colors group">
                        <div class="flex items-center space-x-3">
                            <div class="w-10 h-10 bg-red-100 rounded-lg flex items-center justify-center">
                                <svg class="w-5 h-5 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                </svg>
                            </div>
                            <div class="text-left">
                                <p class="font-semibold text-red-700">Dar de baja cuenta de intermediario</p>
                                <p class="text-sm text-red-600">Esta acción no se puede deshacer</p>
                            </div>
                        </div>
                        <svg class="w-5 h-5 text-red-400 group-hover:text-red-600 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                        </svg>
                    </button>
                </div>
            </div>
            
            <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-6">
                <div class="flex justify-end">
                    <button type="submit" class="inline-flex items-center px-8 py-3 bg-blue-600 text-white font-semibold rounded-lg shadow-sm hover:bg-blue-700 focus:ring-4 focus:ring-blue-200 transition-all duration-200 transform hover:scale-105">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        Guardar Cambios
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- Modal para cambiar contraseña -->
<div id="cambiarPasswordModal" class="hidden fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center p-4">
    <div class="bg-white rounded-lg shadow-xl max-w-md w-full">
        <div class="px-6 py-4 border-b border-slate-200">
            <div class="flex items-center justify-between">
                <h3 class="text-xl font-semibold text-slate-900">Cambiar Contraseña</h3>
                <button type="button" class="text-slate-400 hover:text-slate-500" id="cerrarPasswordModal">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
        </div>
        <form action="<?php echo BASE_URL; ?>intermediario/cambiar_password" method="POST" class="p-6">
            <div class="space-y-4">
                <div>
                    <label for="password_actual" class="block text-sm font-medium text-slate-700 mb-1">Contraseña Actual</label>
                    <input type="password" id="password_actual" name="password_actual" required class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                </div>
                <div>
                    <label for="nueva_password" class="block text-sm font-medium text-slate-700 mb-1">Nueva Contraseña</label>
                    <input type="password" id="nueva_password" name="nueva_password" required minlength="8" class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                    <p class="mt-1 text-xs text-slate-500">Mínimo 8 caracteres, debe incluir letras y números</p>
                </div>
                <div>
                    <label for="confirmar_password" class="block text-sm font-medium text-slate-700 mb-1">Confirmar Nueva Contraseña</label>
                    <input type="password" id="confirmar_password" name="confirmar_password" required minlength="8" class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                </div>
            </div>
            <div class="mt-6 flex justify-end space-x-3">
                <button type="button" id="cancelarPasswordBtn" class="px-4 py-2 border border-slate-300 rounded-lg text-slate-700 hover:bg-slate-50">
                    Cancelar
                </button>
                <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                    Cambiar Contraseña
                </button>
            </div>
        </form>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const themeOptions = document.querySelectorAll('input[name="appearance"]');
    const toggleSwitches = document.querySelectorAll('input[type="checkbox"]');
    
    // Manejo del tema
    themeOptions.forEach(option => {
        option.addEventListener('change', function() {
            const labels = document.querySelectorAll('label[for], label:has(input[name="appearance"])');
            labels.forEach(label => {
                if (label.querySelector('input[name="appearance"]')) {
                    if (label.querySelector('input').checked) {
                        label.classList.add('border-blue-500', 'bg-blue-50');
                        label.classList.remove('border-slate-200');
                    } else {
                        label.classList.remove('border-blue-500', 'bg-blue-50');
                        label.classList.add('border-slate-200');
                    }
                }
            });
        });
    });
    
    // Manejo de los toggles
    toggleSwitches.forEach(toggle => {
        toggle.addEventListener('change', function() {
            const slider = this.nextElementSibling;
            if (this.checked) {
                slider.classList.add('peer-checked:bg-blue-600');
            }
        });
    });
    
    // Modal de cambio de contraseña
    const cambiarPasswordBtn = document.getElementById('cambiarPasswordBtn');
    const cambiarPasswordModal = document.getElementById('cambiarPasswordModal');
    const cerrarPasswordModal = document.getElementById('cerrarPasswordModal');
    const cancelarPasswordBtn = document.getElementById('cancelarPasswordBtn');
    
    if (cambiarPasswordBtn) {
        cambiarPasswordBtn.addEventListener('click', function() {
            cambiarPasswordModal.classList.remove('hidden');
        });
    }
    
    if (cerrarPasswordModal) {
        cerrarPasswordModal.addEventListener('click', function() {
            cambiarPasswordModal.classList.add('hidden');
        });
    }
    
    if (cancelarPasswordBtn) {
        cancelarPasswordBtn.addEventListener('click', function() {
            cambiarPasswordModal.classList.add('hidden');
        });
    }
    
    // Validación de contraseñas
    const nuevaPasswordInput = document.getElementById('nueva_password');
    const confirmarPasswordInput = document.getElementById('confirmar_password');
    
    if (confirmarPasswordInput) {
        confirmarPasswordInput.addEventListener('input', function() {
            if (this.value !== nuevaPasswordInput.value) {
                this.setCustomValidity('Las contraseñas no coinciden');
            } else {
                this.setCustomValidity('');
            }
        });
    }
    
    if (nuevaPasswordInput) {
        nuevaPasswordInput.addEventListener('input', function() {
            if (confirmarPasswordInput.value && this.value !== confirmarPasswordInput.value) {
                confirmarPasswordInput.setCustomValidity('Las contraseñas no coinciden');
            } else {
                confirmarPasswordInput.setCustomValidity('');
            }
        });
    }
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

input[type="checkbox"]:checked + div {
    background-color: #2563eb;
}

input[type="checkbox"]:focus + div {
    box-shadow: 0 0 0 4px rgba(59, 130, 246, 0.2);
}

select {
    background-image: none;
}

.group:hover .group-hover\:text-slate-600 {
    color: #475569;
}

.group:hover .group-hover\:text-red-600 {
    color: #dc2626;
}
</style>