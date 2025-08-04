<?php
$pageTitle = 'Iniciar Sesión / Registrarse';
?>
<!DOCTYPE html>
<html lang="es" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $pageTitle; ?> | PerSoft</title>
    <meta name="description" content="Accede a tu cuenta o regístrate en PerSoft para gestionar tus trámites vehiculares">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script>
        window.BASE_URL = '<?php echo BASE_URL; ?>';
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: { 'sans': ['Inter', 'ui-sans-serif', 'system-ui'], },
                    colors: {
                        primary: { '50': '#ecfeff', '100': '#cffafe', '500': '#06b6d4', '600': '#0891b2', '700': '#0e7490', '900': '#164e63' },
                        accent: { '400': '#34d399', '500': '#10b981', '600': '#059669' }
                    },
                    backgroundImage: {
                        'gradient-radial': 'radial-gradient(var(--tw-gradient-stops))',
                        'grid-pattern': 'linear-gradient(rgba(255, 255, 255, 0.05) 1px, transparent 1px), linear-gradient(90deg, rgba(255, 255, 255, 0.05) 1px, transparent 1px)'
                    },
                    animation: { 'fade-in': 'fadeIn 0.6s ease-out', 'slide-up': 'slideUp 0.4s ease-out', 'float': 'float 6s ease-in-out infinite' }
                }
            }
        }
    </script>
    <style>
        @keyframes fadeIn { from { opacity: 0; transform: translateY(20px); } to { opacity: 1; transform: translateY(0); } }
        @keyframes slideUp { from { opacity: 0; transform: translateY(20px); } to { opacity: 1; transform: translateY(0); } }
        @keyframes float { 0%, 100% { transform: translateY(0px); } 50% { transform: translateY(-20px); } }
        .bg-grid-pattern { background-image: linear-gradient(rgba(255, 255, 255, 0.05) 1px, transparent 1px), linear-gradient(90deg, rgba(255, 255, 255, 0.05) 1px, transparent 1px); background-size: 50px 50px; }
        .glass { background: rgba(255, 255, 255, 0.1); backdrop-filter: blur(10px); border: 1px solid rgba(255, 255, 255, 0.2); }
    </style>
</head>
<body class="bg-gray-50 font-sans antialiased">
    <div id="loading-overlay" class="fixed inset-0 bg-slate-900/80 z-50 flex items-center justify-center backdrop-blur-sm transition-opacity duration-300" style="display: none;">
        <div class="bg-white p-8 rounded-xl shadow-xl max-w-md w-full text-center">
            <div class="animate-spin mb-4 mx-auto h-12 w-12 text-blue-600">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
            </div>
            <h3 class="text-xl font-bold text-slate-900 mb-2">Procesando tu registro</h3>
            <p class="text-slate-600 mb-4">Estamos consultando la información de tu vehículo y verificando tus datos. Este proceso puede tardar unos segundos.</p>
            <div class="w-full bg-slate-200 rounded-full h-2.5">
                <div id="progress-bar" class="bg-blue-600 h-2.5 rounded-full" style="width: 10%"></div>
            </div>
        </div>
    </div>
    <?php require_once ROOT_PATH . 'views/components/header.php'; ?>
    <main class="relative min-h-screen overflow-hidden pt-20">
        <div class="absolute inset-0 -z-10">
            <div class="absolute inset-0 bg-gradient-to-br from-slate-900 via-blue-900 to-indigo-900"></div>
            <div class="absolute inset-0 bg-grid-pattern opacity-10"></div>
            <div class="absolute top-20 left-10 w-72 h-72 bg-blue-500 rounded-full filter blur-3xl opacity-20 animate-float"></div>
            <div class="absolute bottom-20 right-10 w-96 h-96 bg-indigo-500 rounded-full filter blur-3xl opacity-20 animate-float" style="animation-delay: 2s;"></div>
            <div class="absolute top-1/2 left-1/3 w-64 h-64 bg-cyan-500 rounded-full filter blur-3xl opacity-20 animate-float" style="animation-delay: 4s;"></div>
        </div>
        <div class="container mx-auto px-4 sm:px-6 lg:px-8 py-16 sm:py-24">
            <div class="max-w-6xl mx-auto">
                <div class="text-center mb-10">
                    <h1 class="text-3xl sm:text-4xl lg:text-5xl font-black text-white mb-4">
                        <?php echo $isLoginActive ? 'Bienvenido de Nuevo' : 'Únete a PerSoft'; ?>
                    </h1>
                    <p class="text-lg text-gray-300 max-w-2xl mx-auto">
                        <?php echo $isLoginActive ? 'Accede a tu cuenta para gestionar tus trámites vehiculares' : 'Crea tu cuenta y disfruta de todos nuestros servicios digitales'; ?>
                    </p>
                </div>
                <div class="grid grid-cols-1 lg:grid-cols-5 gap-8 lg:gap-12">
                    <div class="lg:col-span-2 hidden lg:flex flex-col justify-center">
                        <div class="relative glass rounded-3xl p-8 border border-white/20 shadow-xl">
                            <h3 class="text-2xl font-bold text-white mb-4 text-center"><?php echo $isLoginActive ? 'Gestiona tus Trámites' : '¿Por qué Registrarte?'; ?></h3>
                            <ul class="space-y-4 text-gray-300">
                                <li class="flex items-start"><i class="fas fa-check-circle text-cyan-400 mt-1 mr-3"></i><span><?php echo $isLoginActive ? 'Accede a tu historial de trámites vehiculares' : 'Recibe notificaciones y recordatorios de vencimientos'; ?></span></li>
                                <li class="flex items-start"><i class="fas fa-check-circle text-cyan-400 mt-1 mr-3"></i><span><?php echo $isLoginActive ? 'Obtén recordatorios de vencimientos' : 'Ahorra tiempo con tus datos pre-cargados'; ?></span></li>
                                <li class="flex items-start"><i class="fas fa-check-circle text-cyan-400 mt-1 mr-3"></i><span><?php echo $isLoginActive ? 'Descarga certificados digitales' : 'Obtén descuentos exclusivos'; ?></span></li>
                                <li class="flex items-start"><i class="fas fa-check-circle text-cyan-400 mt-1 mr-3"></i><span><?php echo $isLoginActive ? 'Gestiona múltiples vehículos' : 'Gestiona todos tus vehículos en un solo lugar'; ?></span></li>
                            </ul>
                        </div>
                    </div>
                    <div class="lg:col-span-3">
                        <div class="relative bg-white/10 backdrop-blur-xl rounded-3xl p-6 sm:p-8 lg:p-10 border border-white/20 shadow-2xl">
                            <div class="flex mb-8 bg-white/5 rounded-xl p-1">
                                <a href="<?php echo BASE_URL; ?>auth/login" class="w-1/2 py-3 rounded-lg font-medium text-center transition-all <?php echo $isLoginActive ? 'bg-gradient-to-r from-cyan-500 to-blue-500 text-white shadow-lg' : 'text-gray-300 hover:text-white'; ?>">Iniciar Sesión</a>
                                <a href="<?php echo BASE_URL; ?>auth/register" class="w-1/2 py-3 rounded-lg font-medium text-center transition-all <?php echo !$isLoginActive ? 'bg-gradient-to-r from-cyan-500 to-blue-500 text-white shadow-lg' : 'text-gray-300 hover:text-white'; ?>">Registrarse</a>
                            </div>

                            <?php if (isset($error)): ?>
                            <div class="mb-6 p-4 bg-red-500/10 border border-red-500/20 rounded-xl text-center">
                                <p class="text-red-300 text-sm font-medium"><i class="fas fa-exclamation-circle mr-2"></i><?php echo htmlspecialchars($error); ?></p>
                            </div>
                            <?php endif; ?>

                            <?php if ($isLoginActive): ?>
                            <form action="<?php echo BASE_URL; ?>auth/login" method="post" class="space-y-6">
                                <div>
                                    <label for="email" class="block text-sm font-semibold text-white mb-2"><i class="fas fa-envelope mr-2"></i>Correo Electrónico</label>
                                    <input type="email" id="email" name="email" placeholder="tucorreo@ejemplo.com" class="w-full px-5 py-4 bg-white/10 border-2 border-white/20 rounded-xl text-white placeholder-gray-400 focus:border-cyan-400 focus:bg-white/20 transition-all backdrop-blur-sm" required>
                                </div>
                                <div>
                                    <label for="password" class="block text-sm font-semibold text-white mb-2"><i class="fas fa-lock mr-2"></i>Contraseña</label>
                                    <div class="relative">
                                        <input type="password" id="password" name="password" placeholder="••••••••" class="w-full px-5 py-4 bg-white/10 border-2 border-white/20 rounded-xl text-white placeholder-gray-400 focus:border-cyan-400 focus:bg-white/20 transition-all backdrop-blur-sm pr-12" required>
                                        <button type="button" class="absolute right-4 top-1/2 transform -translate-y-1/2 text-gray-400 hover:text-white transition-colors" onclick="togglePasswordVisibility('password', 'togglePassword')"><i class="fas fa-eye" id="togglePassword"></i></button>
                                    </div>
                                </div>
                                <div class="flex items-center justify-between">
                                    <label class="flex items-center text-sm text-gray-300"><input type="checkbox" name="remember" class="mr-2 h-4 w-4 rounded border-gray-300 text-cyan-500 focus:ring-cyan-500">Recordarme</label>
                                    <a href="#" class="text-sm text-cyan-400 hover:text-cyan-300 transition-colors">¿Olvidaste tu contraseña?</a>
                                </div>
                                <button type="submit" class="w-full px-6 py-4 bg-gradient-to-r from-cyan-500 to-blue-500 rounded-xl font-bold text-white transition-all hover:scale-[1.02] hover:shadow-xl hover:shadow-cyan-500/50 mt-6">Iniciar Sesión</button>
                                <p class="text-center text-sm text-gray-400 mt-6">¿No tienes cuenta? <a href="<?php echo BASE_URL; ?>auth/register" class="text-cyan-400 hover:text-cyan-300 transition-colors font-medium">Regístrate ahora</a></p>
                            </form>
                            <?php else: ?>
                            <form id="registerForm" action="<?php echo BASE_URL; ?>auth/register" method="post" class="space-y-6">
                                <input type="hidden" name="ref" value="<?php echo htmlspecialchars($_GET['ref'] ?? '', ENT_QUOTES, 'UTF-8'); ?>">
                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                                    <div>
                                        <label for="nombres" class="block text-sm font-semibold text-white mb-2"><i class="fas fa-user mr-2"></i>Nombres</label>
                                        <input type="text" id="nombres" name="nombres" placeholder="Tus nombres" class="w-full px-5 py-4 bg-white/10 border-2 border-white/20 rounded-xl text-white placeholder-gray-400 focus:border-cyan-400 focus:bg-white/20 transition-all backdrop-blur-sm" required>
                                    </div>
                                    <div>
                                        <label for="apellidos" class="block text-sm font-semibold text-white mb-2"><i class="fas fa-user mr-2"></i>Apellidos</label>
                                        <input type="text" id="apellidos" name="apellidos" placeholder="Tus apellidos" class="w-full px-5 py-4 bg-white/10 border-2 border-white/20 rounded-xl text-white placeholder-gray-400 focus:border-cyan-400 focus:bg-white/20 transition-all backdrop-blur-sm" required>
                                    </div>
                                </div>
                                <div>
                                    <label for="email_register" class="block text-sm font-semibold text-white mb-2"><i class="fas fa-envelope mr-2"></i>Correo Electrónico</label>
                                    <input type="email" id="email_register" name="email" placeholder="tucorreo@ejemplo.com" class="w-full px-5 py-4 bg-white/10 border-2 border-white/20 rounded-xl text-white placeholder-gray-400 focus:border-cyan-400 focus:bg-white/20 transition-all backdrop-blur-sm" required>
                                </div>
                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                                    <div>
                                        <label for="cedula" class="block text-sm font-semibold text-white mb-2"><i class="fas fa-id-card mr-2"></i>Cédula</label>
                                        <input type="text" id="cedula" name="cedula" placeholder="Número de cédula" class="w-full px-5 py-4 bg-white/10 border-2 border-white/20 rounded-xl text-white placeholder-gray-400 focus:border-cyan-400 focus:bg-white/20 transition-all backdrop-blur-sm" required>
                                    </div>
                                    <div>
                                        <label for="placa" class="block text-sm font-semibold text-white mb-2"><i class="fas fa-car mr-2"></i>Placa Vehículo</label>
                                        <input type="text" id="placa" name="placa" placeholder="ABC123" class="w-full px-5 py-4 bg-white/10 border-2 border-white/20 rounded-xl text-white placeholder-gray-400 focus:border-cyan-400 focus:bg-white/20 transition-all backdrop-blur-sm" required>
                                    </div>
                                </div>
                                <div>
                                    <label for="celular" class="block text-sm font-semibold text-white mb-2"><i class="fas fa-mobile-alt mr-2"></i>Número Celular</label>
                                    <input type="tel" id="celular" name="celular" placeholder="300 123 4567" class="w-full px-5 py-4 bg-white/10 border-2 border-white/20 rounded-xl text-white placeholder-gray-400 focus:border-cyan-400 focus:bg-white/20 transition-all backdrop-blur-sm" required>
                                </div>
                                <div class="flex items-center">
                                    <label class="flex items-start text-sm text-gray-300">
                                        <input type="checkbox" name="terminos" class="mt-1 mr-3 h-4 w-4 rounded border-gray-300 text-cyan-500 focus:ring-cyan-500" required>
                                        <span>Acepto los <a href="#" class="text-cyan-400 hover:text-cyan-300">Términos</a> y la <a href="#" class="text-cyan-400 hover:text-cyan-300">Política de Privacidad</a></span>
                                    </label>
                                </div>
                                <button type="submit" class="w-full px-6 py-4 bg-gradient-to-r from-cyan-500 to-blue-500 rounded-xl font-bold text-white transition-all hover:scale-[1.02] hover:shadow-xl hover:shadow-cyan-500/50 mt-6">Crear Cuenta</button>
                                <p class="text-center text-sm text-gray-400 mt-6">¿Ya tienes cuenta? <a href="<?php echo BASE_URL; ?>auth/login" class="text-cyan-400 hover:text-cyan-300 font-medium">Inicia sesión</a></p>
                            </form>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
    <script>
        function togglePasswordVisibility(inputId, iconId) {
            const passwordInput = document.getElementById(inputId);
            const icon = document.getElementById(iconId);
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                icon.classList.remove('fa-eye');
                icon.classList.add('fa-eye-slash');
            } else {
                passwordInput.type = 'password';
                icon.classList.remove('fa-eye-slash');
                icon.classList.add('fa-eye');
            }
        }
        
        document.addEventListener('DOMContentLoaded', function() {
            const loadingOverlay = document.getElementById('loading-overlay');
            const progressBar = document.getElementById('progress-bar');
            const registerForm = document.getElementById('registerForm');
            
            if (registerForm) {
                registerForm.addEventListener('submit', function(e) {
                    if (registerForm.checkValidity()) {
                        loadingOverlay.style.display = 'flex';
                        simulateProgress();
                    }
                });
            }
            
            function simulateProgress() {
                let width = 10;
                const interval = setInterval(function() {
                    if (width >= 90) {
                        clearInterval(interval);
                    } else {
                        width += Math.random() * 8;
                        if (width > 90) width = 90;
                        progressBar.style.width = width + '%';
                    }
                }, 1000);
                
                setTimeout(function() {
                    if (loadingOverlay.style.display === 'flex') {
                        loadingOverlay.style.display = 'none';
                        alert("El proceso está tardando más de lo habitual. Por favor, intenta nuevamente.");
                        location.reload();
                    }
                }, 60000);
            }
        });
    </script>
</body>
</html>