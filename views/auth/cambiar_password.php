<?php
// views/auth/cambiar_password.php
$pageTitle = 'Cambiar Contraseña';
?>
<!DOCTYPE html>
<html lang="es" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $pageTitle; ?> | PerSoft</title>
    <meta name="description" content="Cambia tu contraseña temporal en PerSoft">
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
    <main class="relative min-h-screen overflow-hidden">
        <div class="absolute inset-0 -z-10">
            <div class="absolute inset-0 bg-gradient-to-br from-slate-900 via-blue-900 to-indigo-900"></div>
            <div class="absolute inset-0 bg-grid-pattern opacity-10"></div>
            <div class="absolute top-20 left-10 w-72 h-72 bg-blue-500 rounded-full filter blur-3xl opacity-20 animate-float"></div>
            <div class="absolute bottom-20 right-10 w-96 h-96 bg-indigo-500 rounded-full filter blur-3xl opacity-20 animate-float" style="animation-delay: 2s;"></div>
        </div>

        <div class="container mx-auto px-4 sm:px-6 lg:px-8 py-16 sm:py-24">
            <div class="max-w-md mx-auto">
                <div class="text-center mb-8">
                    <div class="w-20 h-20 bg-gradient-to-r from-amber-500 to-orange-500 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-key text-white text-2xl"></i>
                    </div>
                    <h1 class="text-3xl font-bold text-white mb-2">Cambiar Contraseña</h1>
                    <p class="text-gray-300">Por seguridad, debes cambiar tu contraseña temporal</p>
                </div>

                <div class="relative bg-white/10 backdrop-blur-xl rounded-3xl p-8 border border-white/20 shadow-2xl">
                    <?php if (isset($error)): ?>
                    <div class="mb-6 p-4 bg-red-500/10 border border-red-500/20 rounded-xl text-center">
                        <p class="text-red-300 text-sm font-medium">
                            <i class="fas fa-exclamation-circle mr-2"></i><?php echo htmlspecialchars($error); ?>
                        </p>
                    </div>
                    <?php endif; ?>

                    <form action="<?php echo BASE_URL; ?>auth/cambiar-password" method="post" class="space-y-6">
                        <div>
                            <label for="password_actual" class="block text-sm font-semibold text-white mb-2">
                                <i class="fas fa-lock mr-2"></i>Contraseña Actual
                            </label>
                            <div class="relative">
                                <input type="password" id="password_actual" name="password_actual" placeholder="Tu contraseña temporal" 
                                       class="w-full px-5 py-4 bg-white/10 border-2 border-white/20 rounded-xl text-white placeholder-gray-400 focus:border-cyan-400 focus:bg-white/20 transition-all backdrop-blur-sm pr-12" required>
                                <button type="button" class="absolute right-4 top-1/2 transform -translate-y-1/2 text-gray-400 hover:text-white transition-colors" 
                                        onclick="togglePasswordVisibility('password_actual', 'togglePassword1')">
                                    <i class="fas fa-eye" id="togglePassword1"></i>
                                </button>
                            </div>
                        </div>

                        <div>
                            <label for="nueva_password" class="block text-sm font-semibold text-white mb-2">
                                <i class="fas fa-key mr-2"></i>Nueva Contraseña
                            </label>
                            <div class="relative">
                                <input type="password" id="nueva_password" name="nueva_password" placeholder="Mínimo 8 caracteres" 
                                       class="w-full px-5 py-4 bg-white/10 border-2 border-white/20 rounded-xl text-white placeholder-gray-400 focus:border-cyan-400 focus:bg-white/20 transition-all backdrop-blur-sm pr-12" required>
                                <button type="button" class="absolute right-4 top-1/2 transform -translate-y-1/2 text-gray-400 hover:text-white transition-colors" 
                                        onclick="togglePasswordVisibility('nueva_password', 'togglePassword2')">
                                    <i class="fas fa-eye" id="togglePassword2"></i>
                                </button>
                            </div>
                        </div>

                        <div>
                            <label for="confirmar_password" class="block text-sm font-semibold text-white mb-2">
                                <i class="fas fa-check-double mr-2"></i>Confirmar Nueva Contraseña
                            </label>
                            <div class="relative">
                                <input type="password" id="confirmar_password" name="confirmar_password" placeholder="Repite la nueva contraseña" 
                                       class="w-full px-5 py-4 bg-white/10 border-2 border-white/20 rounded-xl text-white placeholder-gray-400 focus:border-cyan-400 focus:bg-white/20 transition-all backdrop-blur-sm pr-12" required>
                                <button type="button" class="absolute right-4 top-1/2 transform -translate-y-1/2 text-gray-400 hover:text-white transition-colors" 
                                        onclick="togglePasswordVisibility('confirmar_password', 'togglePassword3')">
                                    <i class="fas fa-eye" id="togglePassword3"></i>
                                </button>
                            </div>
                        </div>

                        <div class="glass rounded-xl p-4">
                            <p class="text-gray-300 text-sm">
                                <i class="fas fa-info-circle text-cyan-400 mr-2"></i>
                                Tu nueva contraseña debe tener al menos 8 caracteres y ser fácil de recordar.
                            </p>
                        </div>

                        <button type="submit" class="w-full px-6 py-4 bg-gradient-to-r from-cyan-500 to-blue-500 rounded-xl font-bold text-white transition-all hover:scale-[1.02] hover:shadow-xl hover:shadow-cyan-500/50">
                            <i class="fas fa-save mr-2"></i>Cambiar Contraseña
                        </button>
                    </form>
                </div>

                <div class="text-center mt-6">
                    <p class="text-gray-400 text-sm">
                        <i class="fas fa-shield-alt text-cyan-400 mr-1"></i>
                        Este paso es obligatorio por tu seguridad
                    </p>
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

        // Validación en tiempo real
        document.getElementById('confirmar_password').addEventListener('input', function() {
            const nueva = document.getElementById('nueva_password').value;
            const confirmar = this.value;
            
            if (confirmar && nueva !== confirmar) {
                this.classList.add('border-red-500');
                this.classList.remove('border-white/20');
            } else {
                this.classList.remove('border-red-500');
                this.classList.add('border-white/20');
            }
        });
    </script>
</body>
</html>