<?php
// views/auth/confirmacion.php
$pageTitle = 'Registro Exitoso';
$email = $_SESSION['email_registro'] ?? '';
unset($_SESSION['registro_exitoso']);
unset($_SESSION['email_registro']);
?>

<!DOCTYPE html>
<html lang="es" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $pageTitle; ?> | PerSoft</title>
    
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- [Aquí el mismo script y estilos que en auth.php] -->
</head>

<body class="bg-gray-50 font-sans antialiased">
    <?php require_once ROOT_PATH . 'views/components/header.php'; ?>
    
    <main class="relative min-h-screen overflow-hidden pt-20">
        <div class="absolute inset-0 -z-10">
            <div class="absolute inset-0 bg-gradient-to-br from-slate-900 via-blue-900 to-indigo-900"></div>
            <div class="absolute inset-0 bg-grid-pattern opacity-10"></div>
        </div>
        
        <div class="container mx-auto px-4 sm:px-6 lg:px-8 py-16 sm:py-24">
            <div class="max-w-2xl mx-auto">
                <div class="relative">
                    <div class="absolute inset-0 bg-gradient-to-r from-cyan-500/20 to-indigo-500/20 blur-3xl"></div>
                    <div class="relative bg-white/10 backdrop-blur-xl rounded-3xl p-8 sm:p-10 border border-white/20 shadow-2xl text-center">
                        <div class="w-20 h-20 bg-gradient-to-r from-green-500 to-teal-500 rounded-full flex items-center justify-center mx-auto mb-6">
                            <i class="fas fa-check text-white text-3xl"></i>
                        </div>
                        
                        <h1 class="text-3xl font-bold text-white mb-4">¡Registro Exitoso!</h1>
                        
                        <p class="text-gray-300 mb-6">
                            Hemos enviado tu contraseña al correo <span class="text-white font-semibold"><?php echo htmlspecialchars($email); ?></span>. 
                            Por favor revisa tu bandeja de entrada (y la carpeta de spam) para acceder a tu cuenta.
                        </p>
                        
                        <div class="glass rounded-xl p-6 mb-8">
                            <p class="text-white">
                                <i class="fas fa-info-circle text-cyan-400 mr-2"></i>
                                Una vez inicies sesión, te recomendamos cambiar tu contraseña por una que sea fácil de recordar para ti.
                            </p>
                        </div>
                        
                        <div class="flex flex-col sm:flex-row gap-4">
                            <a href="<?php echo BASE_URL; ?>auth/login" class="px-6 py-4 bg-gradient-to-r from-cyan-500 to-blue-500 rounded-xl font-bold text-white hover:shadow-lg hover:shadow-cyan-500/50 transition-all text-center flex-1">
                                <i class="fas fa-sign-in-alt mr-2"></i>
                                Iniciar Sesión
                            </a>
                            <a href="<?php echo BASE_URL; ?>" class="px-6 py-4 glass border border-white/30 rounded-xl font-bold text-white hover:bg-white/10 transition-all text-center flex-1">
                                <i class="fas fa-home mr-2"></i>
                                Ir a Inicio
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
    
    <?php require_once ROOT_PATH . 'views/components/footer.php'; ?>
</body>
</html>