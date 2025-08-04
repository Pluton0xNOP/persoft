<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Footer Moderno PerSoft</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: {
                            50: '#eff6ff',
                            100: '#dbeafe',
                            200: '#bfdbfe',
                            300: '#93c5fd',
                            400: '#60a5fa',
                            500: '#3b82f6',
                            600: '#272a6d',
                            700: '#1d4ed8',
                            800: '#1e40af',
                            900: '#1e3a8a'
                        },
                        secondary: {
                            50: '#f8fafc',
                            100: '#f1f5f9',
                            200: '#e2e8f0',
                            300: '#cbd5e1',
                            400: '#94a3b8',
                            500: '#64748b',
                            600: '#4f6bbf',
                            700: '#334155',
                            800: '#1e293b',
                            900: '#0f172a'
                        },
                        accent: {
                            50: '#ecfdf5',
                            100: '#d1fae5',
                            200: '#a7f3d0',
                            300: '#6ee7b7',
                            400: '#34d399',
                            500: '#10b981',
                            600: '#7e9eed',
                            700: '#047857',
                            800: '#065f46',
                            900: '#064e3b'
                        },
                        neutral: {
                            50: '#fafafa',
                            100: '#f5f5f5',
                            200: '#e5e5e5',
                            300: '#d4d4d4',
                            400: '#a3a3a3',
                            500: '#737373',
                            600: '#d6d5e0',
                            700: '#404040',
                            800: '#262626',
                            900: '#171717'
                        }
                    },
                    backgroundImage: {
                        'gradient-radial': 'radial-gradient(var(--tw-gradient-stops))',
                        'grid-pattern': 'linear-gradient(rgba(255, 255, 255, 0.1) 1px, transparent 1px), linear-gradient(90deg, rgba(255, 255, 255, 0.1) 1px, transparent 1px)'
                    }
                }
            }
        }
    </script>
    <style>
        .bg-grid-pattern {
            background-image: 
                linear-gradient(rgba(255, 255, 255, 0.05) 1px, transparent 1px),
                linear-gradient(90deg, rgba(255, 255, 255, 0.05) 1px, transparent 1px);
            background-size: 50px 50px;
        }

        @keyframes float {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-20px); }
        }

        .animate-float {
            animation: float 6s ease-in-out infinite;
        }

        @keyframes glow {
            0%, 100% { box-shadow: 0 0 20px rgba(59, 130, 246, 0.3); }
            50% { box-shadow: 0 0 40px rgba(59, 130, 246, 0.6); }
        }

        .animate-glow {
            animation: glow 3s ease-in-out infinite;
        }

        .glass {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }

        .pricing-card:hover {
            transform: translateY(-10px) scale(1.02);
        }

        .pricing-card {
            transition: all 0.3s ease;
        }

        .pricing-popular {
            position: relative;
            border: 2px solid #60a5fa;
        }

        .pricing-popular::before {
            content: "POPULAR";
            position: absolute;
            top: -12px;
            left: 50%;
            transform: translateX(-50%);
            background: linear-gradient(135deg, #3b82f6, #60a5fa);
            color: white;
            padding: 4px 16px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: bold;
            letter-spacing: 1px;
        }
    </style>
</head>
<body class="bg-gray-100">

<section class="py-24 bg-gradient-to-br from-primary-50 to-accent-50">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-16">
            <div class="inline-flex items-center justify-center px-4 py-2 bg-primary-100 rounded-full mb-4">
                <i class="fas fa-dollar-sign text-primary-600 mr-2"></i>
                <span class="text-primary-600 font-semibold">Planes y Precios</span>
            </div>
            <h2 class="text-3xl sm:text-4xl lg:text-5xl font-black text-gray-900 mb-4">
                Elige el <span class="bg-gradient-to-r from-primary-600 to-accent-600 bg-clip-text text-transparent">Plan Perfecto</span>
            </h2>
            <p class="text-lg text-gray-600 max-w-3xl mx-auto">
                Tecnomecánica sin complicaciones. Precios transparentes y servicios de calidad certificada.
            </p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8 max-w-6xl mx-auto">
            <div class="pricing-card bg-white rounded-3xl p-8 shadow-xl hover:shadow-2xl">
                <div class="text-center mb-8">
                    <div class="w-16 h-16 bg-gradient-to-br from-secondary-500 to-secondary-600 rounded-2xl flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-car text-white text-2xl"></i>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-900 mb-2">Básico</h3>
                    <p class="text-gray-600 mb-6">Perfecto para propietarios de un vehículo</p>
                    <div class="mb-6">
                        <span class="text-4xl font-black text-gray-900">$89.000</span>
                        <span class="text-gray-600 ml-2">COP</span>
                    </div>
                </div>
                
                <ul class="space-y-4 mb-8">
                    <li class="flex items-center">
                        <i class="fas fa-check text-green-500 mr-3"></i>
                        <span class="text-gray-700">Tecnomecánica estándar</span>
                    </li>
                    <li class="flex items-center">
                        <i class="fas fa-check text-green-500 mr-3"></i>
                        <span class="text-gray-700">Certificado digital</span>
                    </li>
                    <li class="flex items-center">
                        <i class="fas fa-check text-green-500 mr-3"></i>
                        <span class="text-gray-700">Recordatorio por email</span>
                    </li>
                    <li class="flex items-center">
                        <i class="fas fa-check text-green-500 mr-3"></i>
                        <span class="text-gray-700">Soporte básico</span>
                    </li>
                </ul>

                <button class="w-full py-4 px-6 bg-gradient-to-r from-secondary-500 to-secondary-600 text-white font-bold rounded-xl hover:from-secondary-600 hover:to-secondary-700 transform hover:scale-105 transition-all duration-300">
                    <i class="fas fa-shopping-cart mr-2"></i>
                    Contratar Ahora
                </button>
            </div>

            <div class="pricing-card pricing-popular bg-white rounded-3xl p-8 shadow-xl hover:shadow-2xl">
                <div class="text-center mb-8">
                    <div class="w-16 h-16 bg-gradient-to-br from-primary-500 to-primary-600 rounded-2xl flex items-center justify-center mx-auto mb-4 animate-glow">
                        <i class="fas fa-crown text-white text-2xl"></i>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-900 mb-2">Premium</h3>
                    <p class="text-gray-600 mb-6">La opción más elegida por empresas</p>
                    <div class="mb-6">
                        <span class="text-4xl font-black text-primary-600">$129.000</span>
                        <span class="text-gray-600 ml-2">COP</span>
                        <div class="text-sm text-green-600 font-semibold">Ahorra 15%</div>
                    </div>
                </div>
                
                <ul class="space-y-4 mb-8">
                    <li class="flex items-center">
                        <i class="fas fa-check text-green-500 mr-3"></i>
                        <span class="text-gray-700">Todo del plan básico</span>
                    </li>
                    <li class="flex items-center">
                        <i class="fas fa-check text-green-500 mr-3"></i>
                        <span class="text-gray-700">Prioridad en la agenda</span>
                    </li>
                    <li class="flex items-center">
                        <i class="fas fa-check text-green-500 mr-3"></i>
                        <span class="text-gray-700">SOAT incluido</span>
                    </li>
                    <li class="flex items-center">
                        <i class="fas fa-check text-green-500 mr-3"></i>
                        <span class="text-gray-700">Soporte 24/7</span>
                    </li>
                    <li class="flex items-center">
                        <i class="fas fa-check text-green-500 mr-3"></i>
                        <span class="text-gray-700">Garantía extendida</span>
                    </li>
                </ul>

                <button class="w-full py-4 px-6 bg-gradient-to-r from-primary-500 to-primary-600 text-white font-bold rounded-xl hover:from-primary-600 hover:to-primary-700 transform hover:scale-105 transition-all duration-300 shadow-lg">
                    <i class="fas fa-star mr-2"></i>
                    Contratar Premium
                </button>
            </div>

            <div class="pricing-card bg-white rounded-3xl p-8 shadow-xl hover:shadow-2xl">
                <div class="text-center mb-8">
                    <div class="w-16 h-16 bg-gradient-to-br from-accent-500 to-accent-600 rounded-2xl flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-building text-white text-2xl"></i>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-900 mb-2">Empresarial</h3>
                    <p class="text-gray-600 mb-6">Para flotas y múltiples vehículos</p>
                    <div class="mb-6">
                        <span class="text-4xl font-black text-gray-900">$199.000</span>
                        <span class="text-gray-600 ml-2">COP</span>
                        <div class="text-sm text-accent-600 font-semibold">Por vehículo</div>
                    </div>
                </div>
                
                <ul class="space-y-4 mb-8">
                    <li class="flex items-center">
                        <i class="fas fa-check text-green-500 mr-3"></i>
                        <span class="text-gray-700">Todo del plan premium</span>
                    </li>
                    <li class="flex items-center">
                        <i class="fas fa-check text-green-500 mr-3"></i>
                        <span class="text-gray-700">Gestión de flota</span>
                    </li>
                    <li class="flex items-center">
                        <i class="fas fa-check text-green-500 mr-3"></i>
                        <span class="text-gray-700">Reportes detallados</span>
                    </li>
                    <li class="flex items-center">
                        <i class="fas fa-check text-green-500 mr-3"></i>
                        <span class="text-gray-700">Descuentos por volumen</span>
                    </li>
                    <li class="flex items-center">
                        <i class="fas fa-check text-green-500 mr-3"></i>
                        <span class="text-gray-700">Gestor dedicado</span>
                    </li>
                </ul>

                <button class="w-full py-4 px-6 bg-gradient-to-r from-accent-500 to-accent-600 text-white font-bold rounded-xl hover:from-accent-600 hover:to-accent-700 transform hover:scale-105 transition-all duration-300">
                    <i class="fas fa-handshake mr-2"></i>
                    Contactar Ventas
                </button>
            </div>
        </div>

        <div class="text-center mt-12">
            <p class="text-gray-600 mb-6">¿Necesitas un plan personalizado?</p>
            <button class="px-8 py-3 border-2 border-primary-600 text-primary-600 font-bold rounded-xl hover:bg-primary-600 hover:text-white transition-all duration-300">
                Hablar con un Especialista
            </button>
        </div>
    </div>
</section>

<footer class="relative bg-gradient-to-b from-gray-900 to-black text-white overflow-hidden">
    <div class="absolute inset-0">
        <div class="absolute top-0 left-1/4 w-96 h-96 bg-primary-600/20 rounded-full filter blur-3xl animate-float"></div>
        <div class="absolute bottom-0 right-1/4 w-96 h-96 bg-secondary-600/20 rounded-full filter blur-3xl animate-float" style="animation-delay: 2s;"></div>
    </div>

    <div class="relative border-b border-gray-800">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8 py-12">
            <div class="max-w-4xl mx-auto">
                <div class="bg-gradient-to-r from-primary-600 to-secondary-600 rounded-3xl p-8 md:p-12 relative overflow-hidden">
                    <div class="absolute inset-0 bg-grid-pattern opacity-10"></div>
                    
                    <div class="relative grid md:grid-cols-2 gap-8 items-center">
                        <div>
                            <h3 class="text-2xl md:text-3xl font-bold mb-4">
                                🎁 Obtén 20% de Descuento
                            </h3>
                            <p class="text-white/90 mb-4">
                                Suscríbete y recibe ofertas exclusivas, recordatorios de vencimientos y tips para tu vehículo.
                            </p>
                            <div class="flex items-center space-x-2 text-sm">
                                <i class="fas fa-check-circle text-green-400"></i>
                                <span>Sin spam, solo información útil</span>
                            </div>
                        </div>
                        
                        <div>
                            <form class="space-y-4">
                                <div class="relative">
                                    <input type="email" 
                                           placeholder="tu@email.com" 
                                           class="w-full px-6 py-4 bg-white/10 backdrop-blur-sm border border-white/20 rounded-xl text-white placeholder-gray-300 focus:outline-none focus:border-white/40 transition-all">
                                    <button type="submit" 
                                            class="absolute right-2 top-2 px-6 py-2 bg-white text-primary-600 rounded-lg font-semibold hover:bg-gray-100 transition-all">
                                        Suscribir
                                    </button>
                                </div>
                                <p class="text-xs text-white/70">
                                    Al suscribirte aceptas nuestros <a href="#" class="underline hover:text-white">términos y condiciones</a>
                                </p>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="relative container mx-auto px-4 sm:px-6 lg:px-8 py-16">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-8 lg:gap-12">
            
            <div class="lg:col-span-2">
                <div class="flex items-center space-x-3 mb-6">
                    <div class="w-12 h-12 bg-gradient-to-r from-primary-600 to-secondary-600 rounded-xl flex items-center justify-center">
                        <i class="fas fa-car text-white text-xl"></i>
                    </div>
                    <span class="text-2xl font-bold">PerSoft</span>
                </div>
                
                <p class="text-gray-400 mb-6 leading-relaxed">
                    La plataforma líder en Colombia para agendar tu revisión tecnomecánica. 
                    Simplificamos los trámites vehiculares para que ahorres tiempo y dinero.
                </p>

                <div class="flex flex-wrap gap-3 mb-6">
                    <a href="#" class="inline-block hover:scale-105 transition-transform">
                        <img src="https://upload.wikimedia.org/wikipedia/commons/3/3c/Download_on_the_App_Store_Badge.svg" 
                             alt="App Store" 
                             class="h-12">
                    </a>
                    <a href="#" class="inline-block hover:scale-105 transition-transform">
                        <img src="https://upload.wikimedia.org/wikipedia/commons/7/78/Google_Play_Store_badge_EN.svg" 
                             alt="Google Play" 
                             class="h-12">
                    </a>
                </div>

                <div class="flex items-center space-x-4">
                    <a href="#" class="w-10 h-10 bg-gray-800 hover:bg-primary-600 rounded-lg flex items-center justify-center transition-all hover:scale-110">
                        <i class="fab fa-facebook-f"></i>
                    </a>
                    <a href="#" class="w-10 h-10 bg-gray-800 hover:bg-primary-600 rounded-lg flex items-center justify-center transition-all hover:scale-110">
                        <i class="fab fa-instagram"></i>
                    </a>
                    <a href="#" class="w-10 h-10 bg-gray-800 hover:bg-primary-600 rounded-lg flex items-center justify-center transition-all hover:scale-110">
                        <i class="fab fa-twitter"></i>
                    </a>
                    <a href="#" class="w-10 h-10 bg-gray-800 hover:bg-green-600 rounded-lg flex items-center justify-center transition-all hover:scale-110">
                        <i class="fab fa-whatsapp"></i>
                    </a>
                    <a href="#" class="w-10 h-10 bg-gray-800 hover:bg-red-600 rounded-lg flex items-center justify-center transition-all hover:scale-110">
                        <i class="fab fa-youtube"></i>
                    </a>
                </div>
            </div>

            <div>
                <h4 class="font-bold text-lg mb-6 flex items-center">
                    <div class="w-1 h-6 bg-primary-500 mr-3"></div>
                    Servicios
                </h4>
                <ul class="space-y-3">
                    <li>
                        <a href="#" class="text-gray-400 hover:text-white transition-colors flex items-center group">
                            <i class="fas fa-chevron-right text-xs mr-2 text-gray-600 group-hover:text-primary-500 transition-colors"></i>
                            Tecnomecánica
                        </a>
                    </li>
                    <li>
                        <a href="#" class="text-gray-400 hover:text-white transition-colors flex items-center group">
                            <i class="fas fa-chevron-right text-xs mr-2 text-gray-600 group-hover:text-primary-500 transition-colors"></i>
                            SOAT Online
                        </a>
                    </li>
                    <li>
                        <a href="#" class="text-gray-400 hover:text-white transition-colors flex items-center group">
                            <i class="fas fa-chevron-right text-xs mr-2 text-gray-600 group-hover:text-primary-500 transition-colors"></i>
                            Consultar Comparendos
                        </a>
                    </li>
                    <li>
                        <a href="#" class="text-gray-400 hover:text-white transition-colors flex items-center group">
                            <i class="fas fa-chevron-right text-xs mr-2 text-gray-600 group-hover:text-primary-500 transition-colors"></i>
                            Historial Vehicular
                        </a>
                    </li>
                    <li>
                        <a href="#" class="text-gray-400 hover:text-white transition-colors flex items-center group">
                            <i class="fas fa-chevron-right text-xs mr-2 text-gray-600 group-hover:text-primary-500 transition-colors"></i>
                            CDAs Asociados
                        </a>
                    </li>
                </ul>
            </div>

            <div>
                <h4 class="font-bold text-lg mb-6 flex items-center">
                    <div class="w-1 h-6 bg-secondary-500 mr-3"></div>
                    Soporte
                </h4>
                <ul class="space-y-3">
                    <li>
                        <a href="#" class="text-gray-400 hover:text-white transition-colors flex items-center group">
                            <i class="fas fa-chevron-right text-xs mr-2 text-gray-600 group-hover:text-secondary-500 transition-colors"></i>
                            Centro de Ayuda
                        </a>
                    </li>
                    <li>
                        <a href="#" class="text-gray-400 hover:text-white transition-colors flex items-center group">
                            <i class="fas fa-chevron-right text-xs mr-2 text-gray-600 group-hover:text-secondary-500 transition-colors"></i>
                            Preguntas Frecuentes
                        </a>
                    </li>
                    <li>
                        <a href="#" class="text-gray-400 hover:text-white transition-colors flex items-center group">
                            <i class="fas fa-chevron-right text-xs mr-2 text-gray-600 group-hover:text-secondary-500 transition-colors"></i>
                            Contacto
                        </a>
                    </li>
                    <li>
                        <a href="#" class="text-gray-400 hover:text-white transition-colors flex items-center group">
                            <i class="fas fa-chevron-right text-xs mr-2 text-gray-600 group-hover:text-secondary-500 transition-colors"></i>
                            Blog
                        </a>
                    </li>
                    <li>
                        <a href="#" class="text-gray-400 hover:text-white transition-colors flex items-center group">
                            <i class="fas fa-chevron-right text-xs mr-2 text-gray-600 group-hover:text-secondary-500 transition-colors"></i>
                            Trabaja con Nosotros
                        </a>
                    </li>
                </ul>
            </div>

            <div>
                <h4 class="font-bold text-lg mb-6 flex items-center">
                    <div class="w-1 h-6 bg-accent-500 mr-3"></div>
                    Contacto
                </h4>
                <ul class="space-y-4">
                    <li class="flex items-start space-x-3 group">
                        <i class="fas fa-map-marker-alt text-accent-500 mt-1"></i>
                        <div>
                            <p class="text-gray-400 group-hover:text-white transition-colors">
                                Calle 100 #15-20, Oficina 502<br>
                                Bogotá D.C., Colombia
                            </p>
                        </div>
                    </li>
                    <li class="flex items-center space-x-3 group">
                        <i class="fas fa-phone-alt text-accent-500"></i>
                        <a href="tel:+573001234567" class="text-gray-400 group-hover:text-white transition-colors">
                            +57 300 123 4567
                        </a>
                    </li>
                    <li class="flex items-center space-x-3 group">
                        <i class="fas fa-envelope text-accent-500"></i>
                        <a href="mailto:info@persoft.com.co" class="text-gray-400 group-hover:text-white transition-colors">
                            info@persoft.com.co
                        </a>
                    </li>
                    <li class="flex items-start space-x-3">
                        <i class="fas fa-clock text-accent-500 mt-1"></i>
                        <div class="text-gray-400">
                            <p>Lun - Vie: 8:00 AM - 6:00 PM</p>
                            <p>Sábados: 8:00 AM - 1:00 PM</p>
                        </div>
                    </li>
                </ul>
            </div>
        </div>

        <div class="mt-12 pt-12 border-t border-gray-800">
            <div class="flex flex-wrap items-center justify-center gap-8">
                <img src="https://via.placeholder.com/100x50/374151/9ca3af?text=ONAC" 
                     alt="ONAC" 
                     class="h-12 opacity-50 hover:opacity-100 transition-opacity">
                <img src="https://via.placeholder.com/120x50/374151/9ca3af?text=MinTransporte" 
                     alt="MinTransporte" 
                     class="h-12 opacity-50 hover:opacity-100 transition-opacity">
                <img src="https://via.placeholder.com/100x50/374151/9ca3af?text=ISO+9001" 
                     alt="ISO 9001" 
                     class="h-12 opacity-50 hover:opacity-100 transition-opacity">
                <img src="https://via.placeholder.com/100x50/374151/9ca3af?text=Vigilado" 
                     alt="SuperTransporte" 
                     class="h-12 opacity-50 hover:opacity-100 transition-opacity">
            </div>
        </div>
    </div>

    <div class="relative border-t border-gray-800 bg-black/50">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8 py-6">
            <div class="flex flex-col md:flex-row justify-between items-center space-y-4 md:space-y-0">
                <div class="text-center md:text-left">
                    <p class="text-gray-400 text-sm">
                        © 2025 PerSoft. Todos los derechos reservados. NIT: 900.123.456-7
                    </p>
                </div>
                
                <div class="flex flex-wrap items-center justify-center gap-6 text-sm">
                    <a href="#" class="text-gray-400 hover:text-white transition-colors">
                        Términos y Condiciones
                    </a>
                    <span class="text-gray-600">•</span>
                    <a href="#" class="text-gray-400 hover:text-white transition-colors">
                        Política de Privacidad
                    </a>
                    <span class="text-gray-600">•</span>
                    <a href="#" class="text-gray-400 hover:text-white transition-colors">
                        Política de Cookies
                    </a>
                    <span class="text-gray-600">•</span>
                    <a href="#" class="text-gray-400 hover:text-white transition-colors">
                        Mapa del Sitio
                    </a>
                </div>
            </div>
        </div>
    </div>

    <button id="back-to-top" 
            class="fixed bottom-8 right-8 w-12 h-12 bg-gradient-to-r from-primary-600 to-secondary-600 text-white rounded-full shadow-lg hover:shadow-xl transform hover:scale-110 transition-all opacity-0 invisible z-40">
        <i class="fas fa-arrow-up"></i>
    </button>
</footer>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const backToTopButton = document.getElementById('back-to-top');
    
    window.addEventListener('scroll', function() {
        if (window.pageYOffset > 300) {
            backToTopButton.classList.remove('opacity-0', 'invisible');
            backToTopButton.classList.add('opacity-100', 'visible');
        } else {
            backToTopButton.classList.add('opacity-0', 'invisible');
            backToTopButton.classList.remove('opacity-100', 'visible');
        }
    });
    
    backToTopButton.addEventListener('click', function() {
        window.scrollTo({
            top: 0,
            behavior: 'smooth'
        });
    });
});
</script>

</body>
</html>