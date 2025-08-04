<!-- hero.php -->
<section id="inicio" class="relative min-h-screen overflow-hidden">
    <!-- Fondo complejo con múltiples capas -->
    <div class="absolute inset-0">
        <!-- Gradiente base -->
        <div class="absolute inset-0 bg-gradient-to-br from-slate-900 via-blue-900 to-indigo-900"></div>
        
        <!-- Patrón de grid -->
        <div class="absolute inset-0 bg-grid-pattern opacity-10"></div>
        
        <!-- Orbes de luz flotantes -->
        <div class="absolute top-20 left-10 w-72 h-72 bg-blue-500 rounded-full filter blur-3xl opacity-20 animate-float"></div>
        <div class="absolute bottom-20 right-10 w-96 h-96 bg-indigo-500 rounded-full filter blur-3xl opacity-20 animate-float" style="animation-delay: 2s;"></div>
        <div class="absolute top-1/2 left-1/3 w-64 h-64 bg-cyan-500 rounded-full filter blur-3xl opacity-20 animate-float" style="animation-delay: 4s;"></div>
        
        <!-- Partículas animadas -->
        <div class="particles absolute inset-0"></div>
        
        <!-- Overlay con gradiente -->
        <div class="absolute inset-0 bg-gradient-to-t from-black/50 via-transparent to-transparent"></div>
    </div>

    <!-- Formas geométricas decorativas -->
    <div class="absolute inset-0 overflow-hidden">
        <div class="absolute -top-40 -right-40 w-80 h-80 border border-white/10 rounded-full"></div>
        <div class="absolute -top-20 -right-20 w-80 h-80 border border-white/5 rounded-full"></div>
        <div class="absolute -bottom-40 -left-40 w-80 h-80 border border-white/10 rounded-full"></div>
    </div>

    <!-- Contenido principal -->
    <div class="relative container mx-auto px-4 sm:px-6 lg:px-8 pt-24 pb-12">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 lg:gap-12 items-center min-h-[calc(100vh-6rem)]">
            
            <!-- Columna izquierda - Contenido -->
            <div class="text-white space-y-6 lg:space-y-8 animate-fade-in">
                <!-- Badge animado -->
                <div class="inline-flex items-center px-4 py-2 glass rounded-full text-sm font-medium animate-pulse-custom">
                    <span class="relative flex h-2 w-2 mr-2">
                        <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-green-400 opacity-75"></span>
                        <span class="relative inline-flex rounded-full h-2 w-2 bg-green-500"></span>
                    </span>
                    <span>🎉 Más de 10,000 usuarios activos</span>
                </div>

                <!-- Título principal -->
                <div class="space-y-4">
                    <h1 class="text-4xl sm:text-5xl lg:text-6xl xl:text-7xl font-black leading-tight">
                        <span class="block">Tu Tecnomecánica</span>
                        <span class="block text-transparent bg-clip-text bg-gradient-to-r from-cyan-400 via-blue-400 to-indigo-400 animate-gradient">
                            En 3 Clicks
                        </span>
                    </h1>
                    <p class="text-lg sm:text-xl lg:text-2xl text-gray-300 max-w-2xl leading-relaxed">
                        Encuentra el mejor CDA, compara precios en tiempo real y agenda tu cita sin filas ni esperas
                    </p>
                </div>

                <!-- Features - Cards uniformes -->
                <div class="grid grid-cols-2 sm:grid-cols-4 gap-4">
                    <div class="glass rounded-xl p-4 text-center hover-lift h-20 flex flex-col justify-center">
                        <div class="text-xl lg:text-2xl font-bold text-cyan-400">500+</div>
                        <div class="text-xs text-gray-300 leading-tight">CDAs Certificados</div>
                    </div>
                    <div class="glass rounded-xl p-4 text-center hover-lift h-20 flex flex-col justify-center">
                        <div class="text-xl lg:text-2xl font-bold text-blue-400">24/7</div>
                        <div class="text-xs text-gray-300 leading-tight">Disponibilidad</div>
                    </div>
                    <div class="glass rounded-xl p-4 text-center hover-lift h-20 flex flex-col justify-center">
                        <div class="text-xl lg:text-2xl font-bold text-indigo-400">98%</div>
                        <div class="text-xs text-gray-300 leading-tight">Satisfacción</div>
                    </div>
                    <div class="glass rounded-xl p-4 text-center hover-lift h-20 flex flex-col justify-center">
                        <div class="text-xl lg:text-2xl font-bold text-purple-400">-30%</div>
                        <div class="text-xs text-gray-300 leading-tight">Descuentos</div>
                    </div>
                </div>

                <!-- CTAs -->
                <div class="flex flex-col sm:flex-row gap-4 pt-4">
                    <button class="group relative px-8 py-4 bg-gradient-to-r from-cyan-500 to-blue-500 rounded-xl font-bold text-white overflow-hidden transition-all hover:scale-105 hover:shadow-2xl hover:shadow-cyan-500/50">
                        <span class="relative z-10 flex items-center justify-center">
                            <i class="fas fa-play mr-2"></i>
                            Ver Demo
                        </span>
                        <div class="absolute inset-0 bg-gradient-to-r from-blue-500 to-indigo-500 opacity-0 group-hover:opacity-100 transition-opacity"></div>
                    </button>
                    
                    <button class="px-8 py-4 glass border border-white/30 rounded-xl font-bold text-white hover:bg-white/10 transition-all hover:scale-105 hover:border-white/50">
                        <i class="fas fa-info-circle mr-2"></i>
                        Más Información
                    </button>
                </div>

                <!-- Trust badges -->
                <div class="flex flex-wrap items-center gap-6 pt-4">
                    <img src="https://via.placeholder.com/100x40/ffffff/1e40af?text=ONAC" alt="ONAC" class="h-8 opacity-70 hover:opacity-100 transition-opacity">
                    <img src="https://via.placeholder.com/120x40/ffffff/1e40af?text=MinTransporte" alt="MinTransporte" class="h-8 opacity-70 hover:opacity-100 transition-opacity">
                    <img src="https://via.placeholder.com/100x40/ffffff/1e40af?text=ISO+9001" alt="ISO 9001" class="h-8 opacity-70 hover:opacity-100 transition-opacity">
                </div>
            </div>

            <!-- Columna derecha - Formulario -->
            <div class="relative lg:pl-8">
                <!-- Decoración detrás del formulario -->
                <div class="absolute inset-0 bg-gradient-to-r from-cyan-500/20 to-indigo-500/20 blur-3xl"></div>
                
                <!-- Formulario -->
                <div class="relative bg-white/10 backdrop-blur-xl rounded-3xl p-6 sm:p-8 lg:p-10 border border-white/20 shadow-2xl hover-glow">
                    <!-- Header del formulario -->
                    <div class="text-center mb-8">
                        <div class="inline-flex items-center justify-center w-16 h-16 bg-gradient-to-r from-cyan-500 to-blue-500 rounded-2xl mb-4 animate-pulse-custom">
                            <i class="fas fa-search text-white text-2xl"></i>
                        </div>
                        <h2 class="text-2xl sm:text-3xl font-bold text-white mb-2">
                            Consulta Rápida
                        </h2>
                        <p class="text-gray-300">Ingresa los datos de tu vehículo</p>
                    </div>

                    <!-- Progress bar -->
                    <div class="flex items-center justify-center mb-8">
                        <div class="flex items-center space-x-2">
                            <div class="step-indicator active">
                                <span>1</span>
                            </div>
                            <div class="w-12 h-1 bg-white/20 rounded-full overflow-hidden">
                                <div class="step-line"></div>
                            </div>
                            <div class="step-indicator">
                                <span>2</span>
                            </div>
                            <div class="w-12 h-1 bg-white/20 rounded-full overflow-hidden">
                                <div class="step-line"></div>
                            </div>
                            <div class="step-indicator">
                                <span>3</span>
                            </div>
                        </div>
                    </div>

                    <!-- Formulario steps -->
                    <form id="consultaForm" class="space-y-6">
                        <!-- Step 1: Placa -->
                        <div id="step-1" class="space-y-6 animate-fade-in">
                            <div>
                                <label class="block text-sm font-semibold text-white mb-3">
                                    <i class="fas fa-car mr-2"></i>Placa del vehículo
                                </label>
                                <div class="relative group">
                                    <input type="text" 
                                           id="placa" 
                                           placeholder="ABC123" 
                                           class="w-full px-6 py-4 bg-white/10 border-2 border-white/20 rounded-xl text-white placeholder-gray-400 focus:border-cyan-400 focus:bg-white/20 transition-all text-lg font-bold uppercase tracking-wider text-center backdrop-blur-sm"
                                           maxlength="6" 
                                           required>
                                    <div class="absolute inset-0 rounded-xl bg-gradient-to-r from-cyan-500 to-blue-500 opacity-0 group-hover:opacity-10 transition-opacity pointer-events-none"></div>
                                </div>
                                <p class="text-xs text-gray-400 mt-2 text-center">
                                    <i class="fas fa-info-circle mr-1"></i>
                                    Sin espacios ni guiones
                                </p>
                            </div>
                            
                            <button type="button" 
                                    onclick="nextStep()" 
                                    class="w-full group relative px-6 py-4 bg-gradient-to-r from-cyan-500 to-blue-500 rounded-xl font-bold text-white overflow-hidden transition-all hover:scale-[1.02] hover:shadow-xl hover:shadow-cyan-500/50">
                                <span class="relative z-10 flex items-center justify-center">
                                    <i class="fas fa-search mr-2"></i>
                                    Buscar Vehículo
                                </span>
                                <div class="absolute inset-0 bg-gradient-to-r from-blue-500 to-indigo-500 opacity-0 group-hover:opacity-100 transition-opacity"></div>
                            </button>
                        </div>

                        <!-- Step 2: Documento -->
                        <div id="step-2" class="hidden space-y-6">
                            <div class="glass-dark rounded-xl p-6 space-y-4">
                                <h3 class="font-bold text-white mb-4 flex items-center">
                                    <i class="fas fa-user-circle mr-2 text-cyan-400"></i>
                                    Datos del Propietario
                                </h3>
                                
                                <div class="grid grid-cols-2 gap-4">
                                    <label class="flex items-center space-x-3 cursor-pointer group">
                                        <input type="radio" name="tipo_documento" value="CC" class="sr-only peer" checked>
                                        <div class="w-5 h-5 border-2 border-white/30 rounded-full peer-checked:border-cyan-400 peer-checked:bg-cyan-400 transition-all"></div>
                                        <span class="text-white text-sm">Cédula</span>
                                    </label>
                                    <label class="flex items-center space-x-3 cursor-pointer group">
                                        <input type="radio" name="tipo_documento" value="NIT" class="sr-only peer">
                                        <div class="w-5 h-5 border-2 border-white/30 rounded-full peer-checked:border-cyan-400 peer-checked:bg-cyan-400 transition-all"></div>
                                        <span class="text-white text-sm">NIT</span>
                                    </label>
                                </div>
                                
                                <input type="text" 
                                       id="documento" 
                                       placeholder="Número de documento" 
                                       class="w-full px-4 py-3 bg-white/10 border-2 border-white/20 rounded-lg text-white placeholder-gray-400 focus:border-cyan-400 transition-all backdrop-blur-sm" 
                                       required>
                            </div>
                            
                            <div class="flex gap-3">
                                <button type="button" 
                                        onclick="previousStep()" 
                                        class="flex-1 px-4 py-3 glass border border-white/30 rounded-xl font-medium text-white hover:bg-white/10 transition-all">
                                    <i class="fas fa-arrow-left mr-2"></i>
                                    Atrás
                                </button>
                                <button type="button" 
                                        onclick="nextStep()" 
                                        class="flex-1 px-4 py-3 bg-gradient-to-r from-cyan-500 to-blue-500 rounded-xl font-bold text-white hover:shadow-lg transition-all">
                                    Continuar
                                    <i class="fas fa-arrow-right ml-2"></i>
                                </button>
                            </div>
                        </div>

                        <!-- Step 3: Ubicación -->
                        <div id="step-3" class="hidden space-y-6">
                            <div class="glass-dark rounded-xl p-6 space-y-4">
                                <h3 class="font-bold text-white mb-4 flex items-center">
                                    <i class="fas fa-map-marker-alt mr-2 text-cyan-400"></i>
                                    Tu Ubicación
                                </h3>
                                
                                <select id="departamento" class="w-full px-4 py-3 bg-white/10 border-2 border-white/20 rounded-lg text-white focus:border-cyan-400 transition-all backdrop-blur-sm appearance-none cursor-pointer">
                                    <option value="" class="bg-gray-800">Selecciona departamento</option>
                                    <option value="cundinamarca" class="bg-gray-800">Cundinamarca</option>
                                    <option value="antioquia" class="bg-gray-800">Antioquia</option>
                                    <option value="valle" class="bg-gray-800">Valle del Cauca</option>
                                    <option value="atlantico" class="bg-gray-800">Atlántico</option>
                                </select>
                                
                                <select id="ciudad" class="w-full px-4 py-3 bg-white/10 border-2 border-white/20 rounded-lg text-white focus:border-cyan-400 transition-all backdrop-blur-sm appearance-none cursor-pointer" disabled>
                                    <option value="" class="bg-gray-800">Primero selecciona departamento</option>
                                </select>
                            </div>
                            
                            <div class="flex gap-3">
                                <button type="button" 
                                        onclick="previousStep()" 
                                        class="flex-1 px-4 py-3 glass border border-white/30 rounded-xl font-medium text-white hover:bg-white/10 transition-all">
                                    <i class="fas fa-arrow-left mr-2"></i>
                                    Atrás
                                </button>
                                <button type="button" 
                                        onclick="showResults()" 
                                        id="buscarCDAs"
                                        class="flex-1 group relative px-4 py-3 bg-gradient-to-r from-green-500 to-emerald-500 rounded-xl font-bold text-white overflow-hidden transition-all hover:scale-[1.02] hover:shadow-xl hover:shadow-green-500/50 disabled:opacity-50 disabled:cursor-not-allowed disabled:hover:scale-100" 
                                        disabled>
                                    <span class="relative z-10 flex items-center justify-center">
                                        <i class="fas fa-map-marked-alt mr-2"></i>
                                        Buscar CDAs
                                    </span>
                                    <div class="absolute inset-0 bg-gradient-to-r from-emerald-500 to-cyan-500 opacity-0 group-hover:opacity-100 transition-opacity"></div>
                                </button>
                            </div>
                        </div>
                    </form>

                    <!-- Garantías - Cards uniformes -->
                    <div class="mt-8 pt-6 border-t border-white/10">
                        <div class="grid grid-cols-3 gap-4">
                            <div class="group text-center h-16 flex flex-col justify-center">
                                <i class="fas fa-shield-alt text-xl text-cyan-400 mb-1 group-hover:scale-110 transition-transform"></i>
                                <p class="text-xs text-gray-300 leading-tight">100% Seguro</p>
                            </div>
                            <div class="group text-center h-16 flex flex-col justify-center">
                                <i class="fas fa-bolt text-xl text-yellow-400 mb-1 group-hover:scale-110 transition-transform"></i>
                                <p class="text-xs text-gray-300 leading-tight">Respuesta Inmediata</p>
                            </div>
                            <div class="group text-center h-16 flex flex-col justify-center">
                                <i class="fas fa-certificate text-xl text-green-400 mb-1 group-hover:scale-110 transition-transform"></i>
                                <p class="text-xs text-gray-300 leading-tight">CDAs Certificados</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Floating elements -->
                <div class="absolute -top-4 -right-4 w-24 h-24 bg-gradient-to-r from-cyan-500 to-blue-500 rounded-full opacity-20 blur-2xl animate-pulse"></div>
                <div class="absolute -bottom-4 -left-4 w-32 h-32 bg-gradient-to-r from-indigo-500 to-purple-500 rounded-full opacity-20 blur-2xl animate-pulse" style="animation-delay: 1s;"></div>
            </div>
        </div>
    </div>

    <!-- Scroll indicator -->
    <div class="absolute bottom-8 left-1/2 transform -translate-x-1/2 text-white text-center animate-bounce">
        <p class="text-sm mb-2 opacity-70">Descubre más</p>
        <i class="fas fa-chevron-down text-2xl"></i>
    </div>
</section>

<!-- Estilos adicionales para el hero -->
<style>
/* Patrón de grid para el fondo */
.bg-grid-pattern {
    background-image: 
        linear-gradient(rgba(255, 255, 255, 0.05) 1px, transparent 1px),
        linear-gradient(90deg, rgba(255, 255, 255, 0.05) 1px, transparent 1px);
    background-size: 50px 50px;
}

/* Partículas animadas */
.particles {
    background-image: 
        radial-gradient(circle at 20% 80%, rgba(120, 200, 255, 0.3) 0%, transparent 50%),
        radial-gradient(circle at 80% 20%, rgba(255, 119, 200, 0.3) 0%, transparent 50%),
        radial-gradient(circle at 40% 40%, rgba(200, 120, 255, 0.3) 0%, transparent 50%);
}

/* Animaciones */
@keyframes float {
    0%, 100% { transform: translateY(0px); }
    50% { transform: translateY(-20px); }
}

.animate-float {
    animation: float 6s ease-in-out infinite;
}

@keyframes gradient {
    0%, 100% { background-position: 0% 50%; }
    50% { background-position: 100% 50%; }
}

.animate-gradient {
    background-size: 200% 200%;
    animation: gradient 3s ease infinite;
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

/* Glass effects */
.glass {
    background: rgba(255, 255, 255, 0.1);
    backdrop-filter: blur(10px);
    border: 1px solid rgba(255, 255, 255, 0.2);
}

.glass-dark {
    background: rgba(0, 0, 0, 0.2);
    backdrop-filter: blur(10px);
    border: 1px solid rgba(255, 255, 255, 0.1);
}

.hover-lift {
    transition: transform 0.3s ease, box-shadow 0.3s ease;
}

.hover-lift:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 25px rgba(0, 0, 0, 0.3);
}

.hover-glow:hover {
    box-shadow: 0 0 30px rgba(59, 130, 246, 0.3);
}

/* Step indicators */
.step-indicator {
    width: 2.5rem;
    height: 2.5rem;
    border-radius: 50%;
    background: rgba(255, 255, 255, 0.1);
    border: 2px solid rgba(255, 255, 255, 0.3);
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-weight: bold;
    transition: all 0.3s;
}

.step-indicator.active {
    background: linear-gradient(135deg, #06b6d4 0%, #3b82f6 100%);
    border-color: transparent;
    transform: scale(1.1);
}

.step-line {
    height: 100%;
    width: 0%;
    background: linear-gradient(90deg, #06b6d4 0%, #3b82f6 100%);
    transition: width 0.3s;
}

.step-indicator.active ~ .step-line {
    width: 100%;
}

/* Select custom arrow */
select {
    background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 24 24' stroke='rgba(255,255,255,0.7)'%3E%3Cpath stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M19 9l-7 7-7-7'%3E%3C/path%3E%3C/svg%3E");
    background-repeat: no-repeat;
    background-position: right 1rem center;
    background-size: 1.5rem;
    padding-right: 3rem;
}
</style>

<!-- Script para las funciones del hero -->
<script>
let currentStep = 1;

function nextStep() {
    if (currentStep < 3) {
        document.getElementById(`step-${currentStep}`).classList.add('hidden');
        currentStep++;
        document.getElementById(`step-${currentStep}`).classList.remove('hidden');
        updateStepIndicators();
        
        // Habilitar botón buscar en step 3
        if (currentStep === 3) {
            document.getElementById('buscarCDAs').disabled = false;
        }
    }
}

function previousStep() {
    if (currentStep > 1) {
        document.getElementById(`step-${currentStep}`).classList.add('hidden');
        currentStep--;
        document.getElementById(`step-${currentStep}`).classList.remove('hidden');
        updateStepIndicators();
    }
}

function updateStepIndicators() {
    document.querySelectorAll('.step-indicator').forEach((indicator, index) => {
        if (index < currentStep) {
            indicator.classList.add('active');
        } else {
            indicator.classList.remove('active');
        }
    });
}

function showResults() {
    alert('Función de búsqueda de CDAs - Aquí se mostrarían los resultados');
}

// Inicializar
document.addEventListener('DOMContentLoaded', function() {
    updateStepIndicators();
    
    // Manejar selección de departamento
    document.getElementById('departamento').addEventListener('change', function() {
        const ciudad = document.getElementById('ciudad');
        ciudad.disabled = false;
        ciudad.innerHTML = '<option value="" class="bg-gray-800">Selecciona ciudad</option>';
        
        // Aquí podrías agregar las ciudades según el departamento
        if (this.value === 'cundinamarca') {
            ciudad.innerHTML += '<option value="bogota" class="bg-gray-800">Bogotá</option>';
            ciudad.innerHTML += '<option value="soacha" class="bg-gray-800">Soacha</option>';
        }
        // Agregar más departamentos según necesites
    });
});
</script>