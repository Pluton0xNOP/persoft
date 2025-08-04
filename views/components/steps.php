<!-- steps.php -->
<section id="como-funciona" class="py-20 relative overflow-hidden bg-gradient-to-b from-gray-50 to-white">
    <!-- Elementos decorativos de fondo -->
    <div class="absolute inset-0">
        <div class="absolute top-20 right-0 w-96 h-96 bg-blue-100 rounded-full filter blur-3xl opacity-30"></div>
        <div class="absolute bottom-0 left-0 w-96 h-96 bg-indigo-100 rounded-full filter blur-3xl opacity-30"></div>
    </div>

    <div class="container mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        <!-- Header de la sección -->
        <div class="text-center mb-16 animate-fade-in">
            <div class="inline-flex items-center justify-center px-4 py-2 bg-blue-100 rounded-full mb-4">
                <i class="fas fa-route text-blue-600 mr-2"></i>
                <span class="text-blue-600 font-semibold">Proceso Simple</span>
            </div>
            <h2 class="text-3xl sm:text-4xl lg:text-5xl font-black text-gray-900 mb-4">
                ¿Cómo <span class="bg-gradient-to-r from-blue-600 to-indigo-700 bg-clip-text text-transparent">Agendar tu Tecnomecánica?</span>
            </h2>
            <p class="text-lg text-gray-600 max-w-3xl mx-auto">
                En solo 3 simples pasos podrás agendar tu revisión tecnomecánica sin complicaciones
            </p>
        </div>

        <!-- Steps Container -->
        <div class="relative">
            <!-- Línea conectora para desktop -->
            <div class="hidden lg:block absolute top-24 left-0 right-0 h-1 bg-gradient-to-r from-blue-200 via-indigo-200 to-cyan-200 rounded-full"></div>

            <!-- Steps Grid -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8 lg:gap-12">
                <!-- Step 1 -->
                <div class="relative group">
                    <div class="text-center">
                        <!-- Icono circular -->
                        <div class="relative inline-block mb-6">
                            <div class="absolute inset-0 bg-gradient-to-r from-blue-500 to-blue-600 rounded-full blur-xl opacity-50 group-hover:opacity-75 transition-opacity"></div>
                            <div class="relative w-24 h-24 bg-gradient-to-r from-blue-500 to-blue-600 rounded-full flex items-center justify-center transform group-hover:scale-110 transition-all duration-300 shadow-lg">
                                <i class="fas fa-mobile-alt text-white text-3xl"></i>
                            </div>
                            <!-- Número del paso -->
                            <div class="absolute -top-2 -right-2 w-8 h-8 bg-white rounded-full flex items-center justify-center shadow-lg border-2 border-blue-500">
                                <span class="text-blue-600 font-bold">1</span>
                            </div>
                        </div>

                        <!-- Contenido -->
                        <div class="bg-white rounded-2xl p-6 shadow-lg hover:shadow-xl transition-all duration-300 transform hover:-translate-y-2 min-h-[280px] flex flex-col justify-between">
                            <div>
                                <h3 class="text-xl font-bold text-gray-900 mb-3">
                                    Descarga la App PerSoft
                                </h3>
                                <p class="text-gray-600 mb-6">
                                    Disponible gratis en App Store y Google Play. Instalación en menos de 1 minuto.
                                </p>
                            </div>
                            <div class="flex justify-center gap-3 mt-auto">
                                <img src="https://via.placeholder.com/120x40/000000/ffffff?text=App+Store" 
                                     alt="App Store" 
                                     class="h-10 cursor-pointer hover:scale-105 transition-transform">
                                <img src="https://via.placeholder.com/120x40/000000/ffffff?text=Google+Play" 
                                     alt="Google Play" 
                                     class="h-10 cursor-pointer hover:scale-105 transition-transform">
                            </div>
                        </div>

                        <!-- Flecha animada (solo desktop) -->
                        <div class="hidden md:block absolute top-20 -right-16 text-blue-300">
                            <i class="fas fa-arrow-right text-3xl animate-pulse"></i>
                        </div>
                    </div>
                </div>

                <!-- Step 2 -->
                <div class="relative group">
                    <div class="text-center">
                        <!-- Icono circular -->
                        <div class="relative inline-block mb-6">
                            <div class="absolute inset-0 bg-gradient-to-r from-indigo-500 to-indigo-600 rounded-full blur-xl opacity-50 group-hover:opacity-75 transition-opacity"></div>
                            <div class="relative w-24 h-24 bg-gradient-to-r from-indigo-500 to-indigo-600 rounded-full flex items-center justify-center transform group-hover:scale-110 transition-all duration-300 shadow-lg">
                                <i class="fas fa-search-location text-white text-3xl"></i>
                            </div>
                            <!-- Número del paso -->
                            <div class="absolute -top-2 -right-2 w-8 h-8 bg-white rounded-full flex items-center justify-center shadow-lg border-2 border-indigo-500">
                                <span class="text-indigo-600 font-bold">2</span>
                            </div>
                        </div>

                        <!-- Contenido -->
                        <div class="bg-white rounded-2xl p-6 shadow-lg hover:shadow-xl transition-all duration-300 transform hover:-translate-y-2 min-h-[280px] flex flex-col justify-between">
                            <div>
                                <h3 class="text-xl font-bold text-gray-900 mb-3">
                                    Encuentra CDAs Certificados
                                </h3>
                                <p class="text-gray-600 mb-6">
                                    Busca entre más de 500 centros certificados. Compara precios, horarios y calificaciones.
                                </p>
                            </div>
                            <!-- Mini mapa ilustrativo -->
                            <div class="bg-gradient-to-br from-blue-50 to-indigo-50 rounded-lg h-24 flex items-center justify-center relative overflow-hidden group/map mt-auto">
                                <div class="relative">
                                    <i class="fas fa-map-marked-alt text-3xl text-gray-400"></i>
                                    <div class="absolute -top-2 -right-2 w-3 h-3 bg-green-500 rounded-full animate-ping"></div>
                                    <div class="absolute bottom-2 left-2 w-3 h-3 bg-blue-500 rounded-full animate-ping" style="animation-delay: 0.5s;"></div>
                                    <div class="absolute top-4 right-4 w-3 h-3 bg-red-500 rounded-full animate-ping" style="animation-delay: 1s;"></div>
                                </div>
                            </div>
                        </div>

                        <!-- Flecha animada (solo desktop) -->
                        <div class="hidden md:block absolute top-20 -right-16 text-indigo-300">
                            <i class="fas fa-arrow-right text-3xl animate-pulse"></i>
                        </div>
                    </div>
                </div>

                <!-- Step 3 -->
                <div class="relative group">
                    <div class="text-center">
                        <!-- Icono circular -->
                        <div class="relative inline-block mb-6">
                            <div class="absolute inset-0 bg-gradient-to-r from-cyan-500 to-cyan-600 rounded-full blur-xl opacity-50 group-hover:opacity-75 transition-opacity"></div>
                            <div class="relative w-24 h-24 bg-gradient-to-r from-cyan-500 to-cyan-600 rounded-full flex items-center justify-center transform group-hover:scale-110 transition-all duration-300 shadow-lg">
                                <i class="fas fa-calendar-check text-white text-3xl"></i>
                            </div>
                            <!-- Número del paso -->
                            <div class="absolute -top-2 -right-2 w-8 h-8 bg-white rounded-full flex items-center justify-center shadow-lg border-2 border-cyan-500">
                                <span class="text-cyan-600 font-bold">3</span>
                            </div>
                        </div>

                        <!-- Contenido -->
                        <div class="bg-white rounded-2xl p-6 shadow-lg hover:shadow-xl transition-all duration-300 transform hover:-translate-y-2 min-h-[280px] flex flex-col justify-between">
                            <div>
                                <h3 class="text-xl font-bold text-gray-900 mb-3">
                                    Agenda y ¡Listo!
                                </h3>
                                <p class="text-gray-600 mb-6">
                                    Selecciona fecha y hora. Recibe confirmación inmediata y recordatorios automáticos.
                                </p>
                            </div>
                            <!-- Calendario mini -->
                            <div class="bg-gradient-to-br from-green-50 to-emerald-50 rounded-lg p-4 mt-auto">
                                <div class="flex items-center justify-center space-x-2 text-green-600">
                                    <i class="fas fa-check-circle text-2xl"></i>
                                    <span class="font-semibold">Confirmación Instantánea</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Features adicionales con cards uniformes -->
        <div class="mt-20 grid grid-cols-1 md:grid-cols-4 gap-6">
            <div class="text-center group">
                <div class="w-16 h-16 bg-gradient-to-r from-blue-100 to-blue-200 rounded-2xl flex items-center justify-center mx-auto mb-4 group-hover:scale-110 transition-transform">
                    <i class="fas fa-shield-alt text-blue-600 text-2xl"></i>
                </div>
                <h4 class="font-semibold text-gray-900 mb-2 h-6 flex items-center justify-center">100% Seguro</h4>
                <p class="text-sm text-gray-600 h-10 flex items-center justify-center">Todos tus datos están protegidos</p>
            </div>
            
            <div class="text-center group">
                <div class="w-16 h-16 bg-gradient-to-r from-indigo-100 to-indigo-200 rounded-2xl flex items-center justify-center mx-auto mb-4 group-hover:scale-110 transition-transform">
                    <i class="fas fa-clock text-indigo-600 text-2xl"></i>
                </div>
                <h4 class="font-semibold text-gray-900 mb-2 h-6 flex items-center justify-center">Ahorra Tiempo</h4>
                <p class="text-sm text-gray-600 h-10 flex items-center justify-center">Sin filas ni esperas innecesarias</p>
            </div>
            
            <div class="text-center group">
                <div class="w-16 h-16 bg-gradient-to-r from-cyan-100 to-cyan-200 rounded-2xl flex items-center justify-center mx-auto mb-4 group-hover:scale-110 transition-transform">
                    <i class="fas fa-piggy-bank text-cyan-600 text-2xl"></i>
                </div>
                <h4 class="font-semibold text-gray-900 mb-2 h-6 flex items-center justify-center">Mejores Precios</h4>
                <p class="text-sm text-gray-600 h-10 flex items-center justify-center">Compara y ahorra hasta 30%</p>
            </div>
            
            <div class="text-center group">
                <div class="w-16 h-16 bg-gradient-to-r from-green-100 to-green-200 rounded-2xl flex items-center justify-center mx-auto mb-4 group-hover:scale-110 transition-transform">
                    <i class="fas fa-certificate text-green-600 text-2xl"></i>
                </div>
                <h4 class="font-semibold text-gray-900 mb-2 h-6 flex items-center justify-center">CDAs Certificados</h4>
                <p class="text-sm text-gray-600 h-10 flex items-center justify-center">Solo centros autorizados ONAC</p>
            </div>
        </div>
    </div>
</section>

<!-- Sección de Soluciones -->
<section class="py-20 bg-gradient-to-br from-blue-600 via-indigo-600 to-cyan-600 text-white relative overflow-hidden">
    <!-- Patrón de fondo -->
    <div class="absolute inset-0 opacity-10">
        <div class="absolute inset-0 bg-grid-pattern"></div>
    </div>

    <!-- Formas decorativas -->
    <div class="absolute top-0 right-0 w-64 h-64 bg-white/10 rounded-full filter blur-3xl animate-float"></div>
    <div class="absolute bottom-0 left-0 w-96 h-96 bg-white/10 rounded-full filter blur-3xl animate-float" style="animation-delay: 2s;"></div>

    <div class="container mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
            <!-- Contenido -->
            <div class="space-y-8">
                <div>
                    <div class="inline-flex items-center px-4 py-2 bg-white/20 backdrop-blur-sm rounded-full mb-6">
                        <i class="fas fa-rocket text-white mr-2"></i>
                        <span class="font-semibold">Soluciones Rápidas</span>
                    </div>
                    <h2 class="text-3xl sm:text-4xl lg:text-5xl font-black mb-6">
                        SOLUCIONES A LA <span class="text-yellow-300">VELOCIDAD</span> QUE NECESITAS
                    </h2>
                    <p class="text-xl opacity-90 mb-8">
                        Todo lo que necesitas para tu vehículo en un solo lugar
                    </p>
                </div>

                <!-- Cards de servicios con altura uniforme -->
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                    <!-- SOAT Card -->
                    <div class="glass backdrop-blur-md rounded-2xl p-6 border border-white/20 hover:bg-white/10 transition-all group min-h-[180px] flex flex-col">
                        <div class="flex items-start space-x-4 flex-1">
                            <div class="w-14 h-14 bg-gradient-to-r from-yellow-400 to-orange-500 rounded-xl flex items-center justify-center flex-shrink-0 group-hover:scale-110 transition-transform">
                                <i class="fas fa-file-contract text-white text-xl"></i>
                            </div>
                            <div class="flex-1 flex flex-col justify-between h-full">
                                <div>
                                    <h3 class="text-xl font-bold mb-2">SOAT Digital</h3>
                                    <p class="text-sm opacity-80 mb-4">
                                        Compra tu SOAT en segundos. Descuentos exclusivos hasta 10%.
                                    </p>
                                </div>
                                <button class="inline-flex items-center text-yellow-300 font-semibold hover:text-yellow-200 transition-colors mt-auto">
                                    <span>Comprar Ahora</span>
                                    <i class="fas fa-arrow-right ml-2 transform group-hover:translate-x-1 transition-transform"></i>
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- APP Card -->
                    <div class="glass backdrop-blur-md rounded-2xl p-6 border border-white/20 hover:bg-white/10 transition-all group min-h-[180px] flex flex-col">
                        <div class="flex items-start space-x-4 flex-1">
                            <div class="w-14 h-14 bg-gradient-to-r from-cyan-400 to-blue-500 rounded-xl flex items-center justify-center flex-shrink-0 group-hover:scale-110 transition-transform">
                                <i class="fas fa-mobile-alt text-white text-xl"></i>
                            </div>
                            <div class="flex-1 flex flex-col justify-between h-full">
                                <div>
                                    <h3 class="text-xl font-bold mb-2">App Móvil</h3>
                                    <p class="text-sm opacity-80 mb-4">
                                        Gestiona todo desde tu celular. Alertas y recordatorios automáticos.
                                    </p>
                                </div>
                                <button class="inline-flex items-center text-cyan-300 font-semibold hover:text-cyan-200 transition-colors mt-auto">
                                    <span>Descargar App</span>
                                    <i class="fas fa-download ml-2 transform group-hover:translate-y-1 transition-transform"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Stats con altura uniforme -->
                <div class="grid grid-cols-3 gap-4 pt-8 border-t border-white/20">
                    <div class="text-center h-16 flex flex-col justify-center">
                        <div class="text-2xl lg:text-3xl font-bold text-yellow-300">50K+</div>
                        <div class="text-xs lg:text-sm opacity-70">Usuarios Activos</div>
                    </div>
                    <div class="text-center h-16 flex flex-col justify-center">
                        <div class="text-2xl lg:text-3xl font-bold text-cyan-300">4.9★</div>
                        <div class="text-xs lg:text-sm opacity-70">Calificación</div>
                    </div>
                    <div class="text-center h-16 flex flex-col justify-center">
                        <div class="text-2xl lg:text-3xl font-bold text-green-300">24/7</div>
                        <div class="text-xs lg:text-sm opacity-70">Soporte</div>
                    </div>
                </div>
            </div>

            <!-- Imagen o ilustración -->
            <div class="relative lg:pl-12">
                <div class="relative">
                    <!-- Efecto glow detrás de la imagen -->
                    <div class="absolute inset-0 bg-gradient-to-r from-yellow-500/30 to-cyan-500/30 blur-3xl"></div>
                    
                    <!-- Imagen principal -->
                    <div class="relative bg-white/10 backdrop-blur-sm rounded-3xl p-8 border border-white/20">
                        <img src="https://images.unsplash.com/photo-1558618666-fcd25c85cd64?w=600&h=400&fit=crop" 
                             alt="Mujer feliz conduciendo" 
                             class="rounded-2xl shadow-2xl w-full">
                        
                        <!-- Badge flotante -->
                        <div class="absolute -top-4 -right-4 bg-green-500 text-white px-4 py-2 rounded-full font-bold shadow-lg animate-pulse-custom">
                            <i class="fas fa-check mr-2"></i>
                            Verificado ONAC
                        </div>
                        
                        <!-- Card flotante con estadística -->
                        <div class="absolute -bottom-6 -left-6 bg-white rounded-xl p-4 shadow-xl">
                            <div class="flex items-center space-x-3">
                                <div class="w-12 h-12 bg-gradient-to-r from-blue-500 to-indigo-500 rounded-lg flex items-center justify-center">
                                    <i class="fas fa-chart-line text-white"></i>
                                </div>
                                <div>
                                    <div class="text-2xl font-bold text-gray-900">98%</div>
                                    <div class="text-xs text-gray-600">Satisfacción</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<style>
/* Patrón de grid para el fondo */
.bg-grid-pattern {
    background-image: 
        linear-gradient(rgba(255, 255, 255, 0.05) 1px, transparent 1px),
        linear-gradient(90deg, rgba(255, 255, 255, 0.05) 1px, transparent 1px);
    background-size: 50px 50px;
}

/* Animaciones */
@keyframes float {
    0%, 100% { transform: translateY(0px); }
    50% { transform: translateY(-20px); }
}

.animate-float {
    animation: float 6s ease-in-out infinite;
}

@keyframes fadeIn {
    from { opacity: 0; transform: translateY(30px); }
    to { opacity: 1; transform: translateY(0); }
}

.animate-fade-in {
    animation: fadeIn 1s ease-out;
}

@keyframes pulseCustom {
    0%, 100% { transform: scale(1); }
    50% { transform: scale(1.05); }
}

.animate-pulse-custom {
    animation: pulseCustom 2s ease-in-out infinite;
}

/* Glass effect */
.glass {
    background: rgba(255, 255, 255, 0.1);
    backdrop-filter: blur(10px);
    border: 1px solid rgba(255, 255, 255, 0.2);
}
</style>