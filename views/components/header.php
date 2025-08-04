<!-- header.php -->
<header class="fixed w-full top-0 z-50 navbar-blur transition-all duration-500" id="navbar">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Barra superior con info de contacto (oculta en móvil) -->
        <div class="hidden lg:block border-b border-gray-200/20">
            <div class="flex justify-between items-center py-2 text-sm">
                <div class="flex items-center space-x-6 text-gray-600">
                    <a href="tel:+573001234567" class="flex items-center hover:text-blue-600 transition-colors">
                        <i class="fas fa-phone-alt mr-2 text-blue-600"></i>
                        <span>300 123 4567</span>
                    </a>
                    <a href="mailto:info@persoft.com" class="flex items-center hover:text-blue-600 transition-colors">
                        <i class="fas fa-envelope mr-2 text-blue-600"></i>
                        <span>info@persoft.com</span>
                    </a>
                </div>
                <div class="flex items-center space-x-4">
                    <a href="#" class="text-gray-600 hover:text-blue-600 transition-all hover:scale-110">
                        <i class="fab fa-facebook-f"></i>
                    </a>
                    <a href="#" class="text-gray-600 hover:text-blue-600 transition-all hover:scale-110">
                        <i class="fab fa-instagram"></i>
                    </a>
                    <a href="#" class="text-gray-600 hover:text-green-600 transition-all hover:scale-110">
                        <i class="fab fa-whatsapp"></i>
                    </a>
                </div>
            </div>
        </div>

        <!-- Navegación principal -->
        <nav class="flex justify-between items-center h-16 lg:h-20">
            <!-- Logo -->
            <div class="flex items-center">
                <a href="<?php echo BASE_URL; ?>" class="flex items-center space-x-3 group">
                    <div class="relative">
                        <div class="absolute inset-0 bg-gradient-to-r from-blue-600 to-indigo-700 rounded-2xl blur-lg opacity-75 group-hover:opacity-100 transition-opacity"></div>
                        <div class="relative w-12 h-12 bg-gradient-to-r from-blue-600 to-indigo-700 rounded-2xl flex items-center justify-center transform group-hover:scale-110 transition-transform">
                            <i class="fas fa-car text-white text-xl"></i>
                        </div>
                    </div>
                    <div>
                        <span class="text-2xl font-bold bg-gradient-to-r from-blue-600 to-indigo-700 bg-clip-text text-transparent block">PerSoft</span>
                        <span class="text-xs text-gray-500 hidden sm:block">Tecnomecánica Digital</span>
                    </div>
                </a>
            </div>

            <!-- Desktop Menu -->
            <div class="hidden lg:flex items-center space-x-1">
                <a href="#inicio" class="nav-link group px-5 py-2 rounded-lg hover:bg-blue-50 transition-all">
                    <span class="text-gray-700 group-hover:text-blue-600 font-medium">Inicio</span>
                </a>
                
                <!-- Dropdown Servicios -->
                <div class="relative group">
                    <button class="nav-link flex items-center px-5 py-2 rounded-lg hover:bg-blue-50 transition-all">
                        <span class="text-gray-700 group-hover:text-blue-600 font-medium">Servicios</span>
                        <i class="fas fa-chevron-down ml-2 text-xs text-gray-400 group-hover:text-blue-600 transition-transform group-hover:rotate-180"></i>
                    </button>
                    <div class="absolute top-full left-0 mt-2 w-64 bg-white rounded-2xl shadow-xl opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-300 transform group-hover:translate-y-0 translate-y-2 border border-gray-100">
                        <div class="p-2">
                            <a href="#tecnomecanica" class="flex items-center px-4 py-3 rounded-lg hover:bg-blue-50 transition-colors group/item">
                                <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center mr-3 group-hover/item:bg-blue-200 transition-colors">
                                    <i class="fas fa-tools text-blue-600"></i>
                                </div>
                                <div>
                                    <span class="block font-semibold text-gray-800">Tecnomecánica</span>
                                    <span class="text-xs text-gray-500">Agenda tu revisión</span>
                                </div>
                            </a>
                            <a href="#soat" class="flex items-center px-4 py-3 rounded-lg hover:bg-blue-50 transition-colors group/item">
                                <div class="w-10 h-10 bg-cyan-100 rounded-lg flex items-center justify-center mr-3 group-hover/item:bg-cyan-200 transition-colors">
                                    <i class="fas fa-file-contract text-cyan-600"></i>
                                </div>
                                <div>
                                    <span class="block font-semibold text-gray-800">SOAT</span>
                                    <span class="text-xs text-gray-500">Compra en línea</span>
                                </div>
                            </a>
                            <a href="#app" class="flex items-center px-4 py-3 rounded-lg hover:bg-blue-50 transition-colors group/item">
                                <div class="w-10 h-10 bg-indigo-100 rounded-lg flex items-center justify-center mr-3 group-hover/item:bg-indigo-200 transition-colors">
                                    <i class="fas fa-mobile-alt text-indigo-600"></i>
                                </div>
                                <div>
                                    <span class="block font-semibold text-gray-800">App Móvil</span>
                                    <span class="text-xs text-gray-500">iOS y Android</span>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>

                <a href="#como-funciona" class="nav-link group px-5 py-2 rounded-lg hover:bg-blue-50 transition-all">
                    <span class="text-gray-700 group-hover:text-blue-600 font-medium">¿Cómo funciona?</span>
                </a>
                
                <a href="#precios" class="nav-link group px-5 py-2 rounded-lg hover:bg-blue-50 transition-all">
                    <span class="text-gray-700 group-hover:text-blue-600 font-medium">Precios</span>
                </a>
                
                <a href="#contacto" class="nav-link group px-5 py-2 rounded-lg hover:bg-blue-50 transition-all">
                    <span class="text-gray-700 group-hover:text-blue-600 font-medium">Contacto</span>
                </a>
            </div>

            <!-- CTA Buttons Desktop -->
            <!-- CTA Buttons Desktop -->
            <div class="hidden lg:flex items-center space-x-3">
            <a href="<?php echo BASE_URL; ?>auth/login" class="px-5 py-2.5 text-gray-700 font-medium hover:text-blue-600 transition-colors">
                Iniciar Sesión
            </a>
            <a href="<?php echo BASE_URL; ?>auth/register" class="px-6 py-3 bg-gradient-to-r from-blue-600 to-indigo-700 text-white font-bold rounded-xl hover:from-blue-700 hover:to-indigo-800 transform hover:scale-105 transition-all duration-300 shadow-lg hover:shadow-xl flex items-center space-x-2">
                <span>Registrarse</span>
                <i class="fas fa-arrow-right text-sm"></i>
            </a>
        </div>

            <!-- Mobile Menu Button -->
            <button id="mobile-menu-btn" class="lg:hidden relative w-10 h-10 flex items-center justify-center rounded-lg hover:bg-gray-100 transition-colors">
                <div class="w-6 flex flex-col justify-center">
                    <span class="mobile-menu-line bg-gray-700 h-0.5 w-full rounded-full transition-all duration-300 ease-out"></span>
                    <span class="mobile-menu-line bg-gray-700 h-0.5 w-full rounded-full transition-all duration-300 ease-out mt-1.5"></span>
                    <span class="mobile-menu-line bg-gray-700 h-0.5 w-full rounded-full transition-all duration-300 ease-out mt-1.5"></span>
                </div>
            </button>
        </nav>
    </div>

    <!-- Mobile Menu -->
    <div id="mobile-menu" class="lg:hidden fixed inset-x-0 top-0 h-screen bg-white transform translate-x-full transition-transform duration-300 ease-in-out z-50">
        <div class="flex flex-col h-full">
            <!-- Mobile Menu Header -->
            <div class="flex justify-between items-center p-4 border-b border-gray-200">
                <div class="flex items-center space-x-3">
                    <div class="w-10 h-10 bg-gradient-to-r from-blue-600 to-indigo-700 rounded-xl flex items-center justify-center">
                        <i class="fas fa-car text-white"></i>
                    </div>
                    <span class="text-xl font-bold bg-gradient-to-r from-blue-600 to-indigo-700 bg-clip-text text-transparent">PerSoft</span>
                </div>
                <button id="close-mobile-menu" class="w-10 h-10 flex items-center justify-center rounded-lg hover:bg-gray-100 transition-colors">
                    <i class="fas fa-times text-gray-600 text-xl"></i>
                </button>
            </div>

            <!-- Mobile Menu Content -->
            <div class="flex-1 overflow-y-auto">
                <div class="px-4 py-6 space-y-2">
                    <a href="#inicio" class="mobile-nav-link flex items-center px-4 py-3 rounded-xl hover:bg-blue-50 transition-colors">
                        <i class="fas fa-home w-5 text-blue-600 mr-3"></i>
                        <span class="font-medium text-gray-800">Inicio</span>
                    </a>

                    <!-- Mobile Servicios Accordion -->
                    <div class="mobile-dropdown">
                        <button class="w-full flex items-center justify-between px-4 py-3 rounded-xl hover:bg-blue-50 transition-colors">
                            <div class="flex items-center">
                                <i class="fas fa-concierge-bell w-5 text-blue-600 mr-3"></i>
                                <span class="font-medium text-gray-800">Servicios</span>
                            </div>
                            <i class="fas fa-chevron-down text-gray-400 transition-transform mobile-dropdown-icon"></i>
                        </button>
                        <div class="mobile-dropdown-content hidden pl-12 pr-4 space-y-1 mt-1">
                            <a href="#tecnomecanica" class="block py-2 text-gray-600 hover:text-blue-600 transition-colors">Tecnomecánica</a>
                            <a href="#soat" class="block py-2 text-gray-600 hover:text-blue-600 transition-colors">SOAT</a>
                            <a href="#app" class="block py-2 text-gray-600 hover:text-blue-600 transition-colors">App Móvil</a>
                        </div>
                    </div>

                    <a href="#como-funciona" class="mobile-nav-link flex items-center px-4 py-3 rounded-xl hover:bg-blue-50 transition-colors">
                        <i class="fas fa-question-circle w-5 text-blue-600 mr-3"></i>
                        <span class="font-medium text-gray-800">¿Cómo funciona?</span>
                    </a>

                    <a href="#precios" class="mobile-nav-link flex items-center px-4 py-3 rounded-xl hover:bg-blue-50 transition-colors">
                        <i class="fas fa-tags w-5 text-blue-600 mr-3"></i>
                        <span class="font-medium text-gray-800">Precios</span>
                    </a>

                    <a href="#contacto" class="mobile-nav-link flex items-center px-4 py-3 rounded-xl hover:bg-blue-50 transition-colors">
                        <i class="fas fa-envelope w-5 text-blue-600 mr-3"></i>
                        <span class="font-medium text-gray-800">Contacto</span>
                    </a>
                </div>

                <!-- Mobile Contact Info -->
                <div class="px-4 py-6 border-t border-gray-200">
                    <h3 class="text-sm font-semibold text-gray-500 uppercase tracking-wider mb-4">Contacto</h3>
                    <div class="space-y-3">
                        <a href="tel:+573001234567" class="flex items-center text-gray-600 hover:text-blue-600 transition-colors">
                            <i class="fas fa-phone-alt mr-3 text-blue-500"></i>
                            <span>300 123 4567</span>
                        </a>
                        <a href="mailto:info@persoft.com" class="flex items-center text-gray-600 hover:text-blue-600 transition-colors">
                            <i class="fas fa-envelope mr-3 text-blue-500"></i>
                            <span>info@persoft.com</span>
                        </a>
                    </div>
                </div>
            </div>

       <div class="p-4 border-t border-gray-200 space-y-3">
            <a href="<?php echo BASE_URL; ?>auth/login" class="block w-full py-3 text-blue-600 font-medium border-2 border-blue-600 rounded-xl hover:bg-blue-50 transition-colors text-center">
                Iniciar Sesión
            </a>
            <a href="<?php echo BASE_URL; ?>auth/register" class="block w-full py-3 bg-gradient-to-r from-blue-600 to-indigo-700 text-white font-bold rounded-xl hover:from-blue-700 hover:to-indigo-800 transition-all text-center">
                Registrarse Gratis
            </a>
        </div>
        </div>
    </div>

    <!-- Mobile Menu Overlay -->
    <div id="mobile-menu-overlay" class="lg:hidden fixed inset-0 bg-black/50 opacity-0 invisible transition-all duration-300 z-40"></div>
</header>

<style>
.navbar-blur {
    background: rgba(255, 255, 255, 0.95);
    backdrop-filter: blur(10px);
    border-bottom: 1px solid rgba(229, 231, 235, 0.3);
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const mobileMenuBtn = document.getElementById('mobile-menu-btn');
    const closeMobileMenu = document.getElementById('close-mobile-menu');
    const mobileMenu = document.getElementById('mobile-menu');
    const mobileMenuOverlay = document.getElementById('mobile-menu-overlay');
    const mobileDropdowns = document.querySelectorAll('.mobile-dropdown');

    function toggleMobileMenu() {
        const isOpen = !mobileMenu.classList.contains('translate-x-full');
        
        if (!isOpen) {
            mobileMenu.classList.remove('translate-x-full');
            mobileMenuOverlay.classList.remove('opacity-0', 'invisible');
            document.body.style.overflow = 'hidden';
            
            const lines = mobileMenuBtn.querySelectorAll('.mobile-menu-line');
            lines[0].style.transform = 'rotate(45deg) translateY(6px)';
            lines[1].style.opacity = '0';
            lines[2].style.transform = 'rotate(-45deg) translateY(-6px)';
        } else {
            closeMobileMenuFunc();
        }
    }

    function closeMobileMenuFunc() {
        mobileMenu.classList.add('translate-x-full');
        mobileMenuOverlay.classList.add('opacity-0', 'invisible');
        document.body.style.overflow = '';
        
        const lines = mobileMenuBtn.querySelectorAll('.mobile-menu-line');
        lines[0].style.transform = '';
        lines[1].style.opacity = '';
        lines[2].style.transform = '';
    }

    mobileMenuBtn.addEventListener('click', toggleMobileMenu);
    closeMobileMenu.addEventListener('click', closeMobileMenuFunc);
    mobileMenuOverlay.addEventListener('click', closeMobileMenuFunc);

    mobileDropdowns.forEach(dropdown => {
        const button = dropdown.querySelector('button');
        const content = dropdown.querySelector('.mobile-dropdown-content');
        const icon = dropdown.querySelector('.mobile-dropdown-icon');

        button.addEventListener('click', () => {
            content.classList.toggle('hidden');
            icon.classList.toggle('rotate-180');
        });
    });

    const mobileNavLinks = document.querySelectorAll('.mobile-nav-link, .mobile-dropdown-content a');
    mobileNavLinks.forEach(link => {
        link.addEventListener('click', closeMobileMenuFunc);
    });

    let lastScroll = 0;
    const navbar = document.getElementById('navbar');

    window.addEventListener('scroll', () => {
        const currentScroll = window.pageYOffset;

        if (currentScroll > 100) {
            navbar.classList.add('shadow-lg');
        } else {
            navbar.classList.remove('shadow-lg');
        }

        if (currentScroll > lastScroll && currentScroll > 100) {
            navbar.style.transform = 'translateY(-100%)';
        } else {
            navbar.style.transform = 'translateY(0)';
        }

        lastScroll = currentScroll;
    });
});
</script>