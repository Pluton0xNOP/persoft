<!-- views/dashboard/partials/sidebar.php -->
<aside class="group fixed inset-y-0 left-0 z-30 w-64 transform-gpu bg-slate-50 transition-all duration-300 ease-in-out md:relative md:translate-x-0 border-r border-slate-200">
    <div class="flex h-20 items-center justify-center px-6 border-b border-slate-200">
        <a href="<?php echo BASE_URL; ?>" class="flex items-center space-x-2">
            <svg class="w-8 h-8 text-blue-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12.75 3.03v.568c0 .334.148.65.405.864l1.068.89c.442.369.535 1.01.216 1.49l-.51.766a2.25 2.25 0 01-1.161.886l-.143.048a1.125 1.125 0 01-1.276-.71M12.75 3.03h.008v.008h-.008V3.03z" />
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 21.75v-3.375c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21.75M12 21.75c-2.306 0-4.18-1.874-4.18-4.18v-2.35c0-.621.504-1.125 1.125-1.125h2.25C11.496 14.1 12 13.596 12 12.975V9.75c0-.621-.504-1.125-1.125-1.125H8.625c-.621 0-1.125.504-1.125 1.125v2.35c0 .621-.504 1.125-1.125 1.125H4.125C1.82 16.2 0 14.374 0 12.075v-2.7c0-2.306 1.82-4.18 4.125-4.18H6.9c.621 0 1.125-.504 1.125-1.125V3.03c0-1.657 1.343-3 3-3s3 1.343 3 3v.375c0 .621.504 1.125 1.125 1.125h2.25c.621 0 1.125.504 1.125 1.125v2.35c0 2.306-1.82 4.18-4.125 4.18h-2.25c-.621 0-1.125.504-1.125 1.125v3.375z" />
            </svg>
            <span class="text-2xl font-bold text-slate-800 tracking-wide">PerSoft</span>
        </a>
    </div>

    <div class="flex h-full flex-col justify-between overflow-y-auto p-4">
        <div>
            <div class="mb-6 p-3 bg-slate-100 rounded-xl">
                <div class="flex items-center space-x-4">
                    <div class="flex-shrink-0">
                        <img class="h-11 w-11 rounded-full object-cover" src="https://ui-avatars.com/api/?name=<?php echo urlencode($usuario['nombres'] ?? 'Usuario'); ?>&background=random&color=fff&font-size=0.5" alt="Avatar de usuario">
                    </div>
                    <div>
                        <div class="font-semibold text-slate-800 capitalize"><?php echo strtolower($usuario['nombres'] ?? 'Usuario'); ?></div>
                        <div class="text-xs text-slate-500">Plan Premium</div>
                    </div>
                </div>
            </div>
            
            <nav class="space-y-4">
                <div>
                    <h3 class="px-3 text-xs font-semibold uppercase text-slate-400">Principal</h3>
                    <ul class="mt-2 space-y-1">
                        <li>
                            <a href="<?php echo BASE_URL; ?>dashboard" class="sidebar-item <?php echo (!isset($_GET['url']) || $_GET['url'] === 'dashboard' || $_GET['url'] === 'dashboard/') ? 'sidebar-item-active' : 'sidebar-item-inactive'; ?>">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M3 14h18m-9-4v8m-7 0h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"></path></svg>
                                <span>Dashboard</span>
                            </a>
                        </li>
                        <li>
                            <a href="<?php echo BASE_URL; ?>dashboard/vehiculos" class="sidebar-item <?php echo (strpos($_GET['url'], 'dashboard/vehiculos') !== false || strpos($_GET['url'], 'dashboard/gestionar-vehiculo') !== false) ? 'sidebar-item-active' : 'sidebar-item-inactive'; ?>">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                <span>Mis Vehículos</span>
                            </a>
                        </li>
                        <li>
                            <a href="<?php echo BASE_URL; ?>dashboard/pagos" class="sidebar-item <?php echo (strpos($_GET['url'], 'dashboard/pagos') !== false) ? 'sidebar-item-active' : 'sidebar-item-inactive'; ?>">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path></svg>
                                <span>Pagos</span>
                            </a>
                        </li>
                        <li>
                            <a href="<?php echo BASE_URL; ?>dashboard/multas" class="sidebar-item <?php echo (strpos($_GET['url'], 'dashboard/multas') !== false) ? 'sidebar-item-active' : 'sidebar-item-inactive'; ?>">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                                <span>Multas</span>
                            </a>
                        </li>
                        <li>
                            <a href="<?php echo BASE_URL; ?>dashboard/tramites" class="sidebar-item <?php echo (strpos($_GET['url'], 'dashboard/tramites') !== false) ? 'sidebar-item-active' : 'sidebar-item-inactive'; ?>">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                                <span>Historial de Trámites</span>
                            </a>
                        </li>
                        <li>
                            <a href="<?php echo BASE_URL; ?>dashboard/ahorros" class="sidebar-item <?php echo (strpos($_GET['url'], 'dashboard/ahorros') !== false) ? 'sidebar-item-active' : 'sidebar-item-inactive'; ?> flex justify-between">
                                <div class="flex items-center space-x-3">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    <span>Mis Ahorros</span>
                                </div>
                                <span class="bg-blue-100 text-blue-600 text-xs font-semibold px-2.5 py-0.5 rounded-full">Nuevo</span>
                            </a>
                        </li>
                        <li>
                            <a href="<?php echo BASE_URL; ?>dashboard/recordatorios" class="sidebar-item <?php echo (strpos($_GET['url'], 'dashboard/recordatorios') !== false) ? 'sidebar-item-active' : 'sidebar-item-inactive'; ?> flex justify-between">
                                <div class="flex items-center space-x-3">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path>
                                    </svg>
                                    <span>Recordatorios</span>
                                </div>
                                <span class="bg-blue-100 text-blue-600 text-xs font-semibold px-2.5 py-0.5 rounded-full">Nuevo</span>
                            </a>
                        </li>
                        <li>
                            <a href="<?php echo BASE_URL; ?>dashboard/referidos" class="sidebar-item <?php echo (strpos($_GET['url'], 'dashboard/referidos') !== false) ? 'sidebar-item-active' : 'sidebar-item-inactive'; ?>">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                                <span>Referidos</span>
                            </a>
                        </li>
                       <li>
                            <a href="<?php echo BASE_URL; ?>dashboard/centros-servicio" class="sidebar-item <?php echo (strpos($_GET['url'], 'dashboard/centros-servicio') !== false) ? 'sidebar-item-active' : 'sidebar-item-inactive'; ?> flex justify-between">
                                <div class="flex items-center space-x-3">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                                    <span>Centros de Servicio</span>
                                </div>
                                <span class="bg-blue-100 text-blue-600 text-xs font-semibold px-2.5 py-0.5 rounded-full">Nuevo</span>
                            </a>
                        </li>
                    </ul>
                </div>

                <div>
                    <h3 class="px-3 text-xs font-semibold uppercase text-slate-400">Cuenta</h3>
                    <ul class="mt-2 space-y-1">
                        <li>
                            <a href="<?php echo BASE_URL; ?>dashboard/perfil" class="sidebar-item <?php echo (strpos($_GET['url'], 'dashboard/perfil') !== false) ? 'sidebar-item-active' : 'sidebar-item-inactive'; ?>">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                                <span>Mi Perfil</span>
                            </a>
                        </li>
                        <li>
                            <a href="<?php echo BASE_URL; ?>dashboard/configuracion" class="sidebar-item <?php echo (strpos($_GET['url'], 'dashboard/configuracion') !== false) ? 'sidebar-item-active' : 'sidebar-item-inactive'; ?>">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                                <span>Configuración</span>
                            </a>
                        </li>
                    </ul>
                </div>

                <div>
                    <h3 class="px-3 text-xs font-semibold uppercase text-slate-400">Soporte</h3>
                     <ul class="mt-2 space-y-1">
                        <li>
                            <a href="#" class="sidebar-item sidebar-item-inactive">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.546-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                <span>Ayuda y Soporte</span>
                            </a>
                        </li>
                     </ul>
                </div>
            </nav>
        </div>

        <div class="mt-6 space-y-2">
            <div class="upgrade-banner relative bg-gradient-to-tr from-blue-600 to-blue-800 rounded-xl p-4 text-white overflow-hidden">
                <div class="absolute -top-4 -right-4 w-20 h-20 bg-white/10 rounded-full"></div>
                <div class="absolute -bottom-8 -left-2 w-24 h-24 bg-white/5 rounded-full"></div>
                
                <div class="relative z-10">
                     <div class="bg-white/20 rounded-full w-10 h-10 flex items-center justify-center mb-3">
                        <svg class="w-6 h-6 text-yellow-300" fill="currentColor" viewBox="0 0 20 20"><path d="M5 3a2 2 0 00-2 2v2a2 2 0 002 2h2a2 2 0 002-2V5a2 2 0 00-2-2H5zM5 11a2 2 0 00-2 2v2a2 2 0 002 2h2a2 2 0 002-2v-2a2 2 0 00-2-2H5zM11 5a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V5zM11 13a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path></svg>
                     </div>
                    <h4 class="font-bold text-sm">Plan Premium</h4>
                    <p class="text-xs text-blue-100 mt-1 mb-3">Accede a todas las funciones y descuentos exclusivos.</p>
                    <div class="text-xs font-semibold bg-yellow-300 text-blue-900 rounded-full px-3 py-1 text-center">Vence: 15/06/2026</div>
                </div>
            </div>
            
            <a href="<?php echo BASE_URL; ?>auth/logout" class="sidebar-item text-red-600 hover:bg-red-50 hover:text-red-700">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                <span>Cerrar Sesión</span>
            </a>
        </div>
    </div>
</aside>
<style>
    .sidebar-item {
        display: flex;
        align-items: center;
        padding: 0.75rem;
        font-size: 0.875rem;
        font-weight: 500;
        border-radius: 0.75rem;
        transition: all 0.2s ease-in-out;
        transform: scale(1);
        gap: 0.75rem;
    }

    .sidebar-item-active {
        background-color: #3b82f6;
        color: #ffffff;
        box-shadow: 0 4px 14px 0 rgba(59, 130, 246, 0.3);
    }
    .sidebar-item-active svg {
        color: #ffffff;
    }

    .sidebar-item-inactive {
        color: #475569;
    }
    .sidebar-item-inactive:hover {
        background-color: #f1f5f9;
        color: #1e293b;
        transform: scale(1.02);
    }

    @keyframes slideIn {
        from { transform: translateX(-100%); opacity: 0; }
        to { transform: translateX(0); opacity: 1; }
    }
    aside {
        animation: slideIn 0.5s cubic-bezier(0.25, 0.46, 0.45, 0.94) forwards;
    }

    @keyframes fadeInItem {
        from { opacity: 0; transform: translateY(10px); }
        to { opacity: 1; transform: translateY(0); }
    }
    
    .sidebar-item, .upgrade-banner {
        animation: fadeInItem 0.5s ease-out forwards;
        opacity: 0;
    }

    nav > div:nth-of-type(1) ul li:nth-child(1) a { animation-delay: 0.1s; }
    nav > div:nth-of-type(1) ul li:nth-child(2) a { animation-delay: 0.15s; }
    nav > div:nth-of-type(1) ul li:nth-child(3) a { animation-delay: 0.2s; }
    nav > div:nth-of-type(1) ul li:nth-child(4) a { animation-delay: 0.25s; }
    nav > div:nth-of-type(1) ul li:nth-child(5) a { animation-delay: 0.3s; }
    nav > div:nth-of-type(1) ul li:nth-child(6) a { animation-delay: 0.35s; }
    nav > div:nth-of-type(1) ul li:nth-child(7) a { animation-delay: 0.4s; }

    nav > div:nth-of-type(2) ul li:nth-child(1) a { animation-delay: 0.45s; }
    nav > div:nth-of-type(2) ul li:nth-child(2) a { animation-delay: 0.5s; }

    nav > div:nth-of-type(3) ul li:nth-child(1) a { animation-delay: 0.55s; }
    
    .upgrade-banner { animation-delay: 0.6s; }
</style>