<header class="sticky top-0 z-20 bg-white/80 backdrop-blur-lg border-b border-slate-200 animate-fade-in-down">
    <div class="px-4 sm:px-6 lg:px-8">
        <div class="flex h-20 items-center justify-between">

            <div class="flex items-center space-x-4">
                <button type="button" class="p-2 text-slate-500 rounded-full hover:bg-slate-100 hover:text-slate-800 focus:outline-none md:hidden" id="mobile-menu-button-header">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path></svg>
                </button>

                <div class="hidden md:block">
                    <h1 class="text-xl font-bold text-slate-800">
                        <?php
                            $url = $_GET['url'] ?? 'dashboard';
                            if ($url === 'dashboard') {
                                echo 'Dashboard';
                            } elseif (strpos($url, 'dashboard/vehiculos') !== false) {
                                echo 'Mis Vehículos';
                            } elseif (strpos($url, 'dashboard/gestionar-vehiculo') !== false) {
                                echo 'Ficha del Vehículo';
                            } elseif (strpos($url, 'dashboard/perfil') !== false) {
                                echo 'Mi Perfil';
                            } else {
                                echo 'PerSoft';
                            }
                        ?>
                    </h1>
                    <p class="text-sm text-slate-500">Hola de nuevo, <?php echo htmlspecialchars($datos['usuario']['nombre'] ?? 'Usuario'); ?> 👋</p>
                </div>
            </div>

            <div class="flex items-center space-x-2 sm:space-x-4">
                <div class="hidden md:block">
                    <div class="relative">
                        <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                            <svg class="h-5 w-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                        </div>
                        <input type="text" placeholder="Buscar..." class="w-48 lg:w-64 rounded-full border border-slate-300 bg-slate-50 py-2.5 pl-10 pr-4 text-sm focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition-all duration-300">
                    </div>
                </div>

                <div class="relative">
                    <button type="button" class="header-button" data-menu-button="notifications-menu">
                        <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path></svg>
                        <span class="absolute top-1.5 right-1.5 flex h-2.5 w-2.5">
                            <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-red-400 opacity-75"></span>
                            <span class="relative inline-flex rounded-full h-2.5 w-2.5 bg-red-500 border-2 border-white"></span>
                        </span>
                    </button>
                    
                    <div class="dropdown-menu hidden" id="notifications-menu">
                        <div class="p-4 border-b border-slate-200">
                            <div class="flex justify-between items-center">
                                <h3 class="text-md font-semibold text-slate-800">Notificaciones</h3>
                                <button type="button" class="text-xs text-blue-600 hover:underline font-medium">Marcar leídas</button>
                            </div>
                        </div>
                        <div class="max-h-80 overflow-y-auto">
                            <a href="#" class="notification-item">
                                <div class="notification-icon bg-amber-100 text-amber-600">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                </div>
                                <div class="w-0 flex-1">
                                    <p class="text-sm font-medium text-slate-900">SOAT próximo a vencer</p>
                                    <p class="text-sm text-slate-500">Tu SOAT del vehículo ABC-123 vence en 10 días.</p>
                                    <p class="mt-1 text-xs text-slate-400">Hace 2 horas</p>
                                </div>
                            </a>
                            <a href="#" class="notification-item">
                                <div class="notification-icon bg-emerald-100 text-emerald-600">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                </div>
                                <div class="w-0 flex-1">
                                    <p class="text-sm font-medium text-slate-900">Pago exitoso</p>
                                    <p class="text-sm text-slate-500">Tu pago de semaforización fue procesado.</p>
                                    <p class="mt-1 text-xs text-slate-400">Ayer</p>
                                </div>
                            </a>
                        </div>
                        <div class="p-2 border-t border-slate-200 bg-slate-50 rounded-b-xl">
                            <a href="#" class="block text-center text-xs text-blue-600 font-semibold hover:underline">Ver todas las notificaciones</a>
                        </div>
                    </div>
                </div>
                
                <div class="h-8 w-px bg-slate-200 hidden sm:block"></div>

                <div class="relative">
                    <button type="button" class="flex items-center space-x-2 rounded-full p-1 pr-3 hover:bg-slate-100 transition-colors" data-menu-button="user-menu">
                        <img class="h-9 w-9 rounded-full object-cover" src="https://ui-avatars.com/api/?name=<?php echo urlencode($datos['usuario']['nombre'] ?? 'U'); ?>&background=random&color=fff&font-size=0.5" alt="Avatar de usuario">
                        <div class="text-left hidden sm:block">
                             <div class="text-sm font-semibold text-slate-800 capitalize"><?php echo strtolower($datos['usuario']['nombre'] ?? 'Usuario'); ?></div>
                             <div class="text-xs text-slate-500">Plan Premium</div>
                        </div>
                        <svg class="h-4 w-4 text-slate-400 hidden sm:block" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                    </button>

                    <div class="dropdown-menu hidden w-56" id="user-menu">
                        <div class="p-2 border-b border-slate-100">
                             <p class="text-sm font-semibold text-slate-800 truncate capitalize"><?php echo strtolower($datos['usuario']['nombre'] ?? 'Usuario'); ?></p>
                             <p class="text-xs text-slate-500 truncate"><?php echo $datos['usuario']['email'] ?? 'email@ejemplo.com'; ?></p>
                        </div>
                        <div class="p-1">
                            <a href="<?php echo BASE_URL; ?>dashboard/perfil" class="dropdown-item">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                                <span>Mi Perfil</span>
                            </a>
                            <a href="<?php echo BASE_URL; ?>dashboard/configuracion" class="dropdown-item">
                               <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                                <span>Configuración</span>
                            </a>
                        </div>
                        <div class="p-1 border-t border-slate-100">
                             <a href="<?php echo BASE_URL; ?>auth/logout" class="dropdown-item text-red-600 hover:bg-red-50 hover:text-red-700">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                                <span>Cerrar Sesión</span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>

<style>
    .header-button {
        position: relative;
        display: flex;
        align-items: center;
        justify-content: center;
        width: 44px;
        height: 44px;
        border-radius: 9999px;
        color: #64748b;
        transition: all 0.2s ease-in-out;
    }
    .header-button:hover {
        background-color: #f1f5f9;
        color: #1e293b;
    }

    .dropdown-menu {
        position: absolute;
        right: 0;
        margin-top: 0.5rem;
        width: 20rem;
        transform-origin: top right;
        background-color: #ffffff;
        border-radius: 0.75rem;
        box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
        border: 1px solid #e2e8f0;
    }

    .dropdown-item {
        display: flex;
        align-items: center;
        padding: 0.5rem 0.75rem;
        border-radius: 0.5rem;
        font-size: 0.875rem;
        font-weight: 500;
        color: #334155;
        transition: all 0.15s ease-in-out;
    }
    .dropdown-item:hover {
        background-color: #f1f5f9;
        color: #1e293b;
    }

    .notification-item {
        display: flex;
        padding: 1rem;
        gap: 0.75rem;
        transition: background-color 0.15s ease-in-out;
    }
    .notification-item:not(:last-child) {
        border-bottom: 1px solid #f1f5f9;
    }
    .notification-item:hover {
        background-color: #f8fafc;
    }
    .notification-icon {
        flex-shrink: 0;
        height: 2.5rem;
        width: 2.5rem;
        border-radius: 9999px;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    
    .dropdown-menu.hidden {
        animation: fadeOutScale 0.2s ease-out forwards;
    }
    .dropdown-menu:not(.hidden) {
        animation: fadeInScale 0.2s ease-out forwards;
    }

    @keyframes fadeInScale {
        from { opacity: 0; transform: scale(0.95); }
        to { opacity: 1; transform: scale(1); }
    }
    @keyframes fadeOutScale {
        from { opacity: 1; transform: scale(1); }
        to { opacity: 0; transform: scale(0.95); pointer-events: none; }
    }
    @keyframes fade-in-down {
        from { opacity: 0; transform: translateY(-10px); }
        to { opacity: 1; transform: translateY(0); }
    }
    .animate-fade-in-down {
        animation: fade-in-down 0.5s ease-out;
    }
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    function setupMenu(buttonId, menuId) {
        const button = document.querySelector(`[data-menu-button="${menuId}"]`);
        const menu = document.getElementById(menuId);

        if (!button || !menu) return;

        button.addEventListener('click', (event) => {
            event.stopPropagation();
            const isHidden = menu.classList.contains('hidden');
            document.querySelectorAll('.dropdown-menu').forEach(m => {
                if(m.id !== menuId) m.classList.add('hidden');
            });
            menu.classList.toggle('hidden', !isHidden);
        });
    }

    setupMenu('notifications-menu-button', 'notifications-menu');
    setupMenu('user-menu-button', 'user-menu');

    document.addEventListener('click', (event) => {
        document.querySelectorAll('.dropdown-menu').forEach(menu => {
            if (!menu.contains(event.target)) {
                 menu.classList.add('hidden');
            }
        });
    });

    const mobileMenuButton = document.getElementById('mobile-menu-button-header');
    const sidebar = document.querySelector('aside');
    if (mobileMenuButton && sidebar) {
        mobileMenuButton.addEventListener('click', () => {
            sidebar.classList.toggle('!translate-x-0');
        });
    }
});
</script>