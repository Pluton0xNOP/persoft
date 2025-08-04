<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $datos['titulo'] ?? 'PerSoft Dashboard'; ?> | PerSoft</title>
    
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: { 'sans': ['Inter', 'sans-serif'] },
                    colors: {
                        primary: { DEFAULT: '#0891b2', '50': '#ecfeff', '100': '#cffafe', '200': '#a5f3fc', '300': '#67e8f9', '400': '#22d3ee', '500': '#06b6d4', '600': '#0891b2', '700': '#0e7490', '800': '#155e75', '900': '#164e63' },
                        neutral: { '50': '#f8fafc', '100': '#f1f5f9', '200': '#e2e8f0', '300': '#cbd5e1', '400': '#94a3b8', '500': '#64748b', '600': '#475569', '700': '#334155', '800': '#1e293b', '900': '#0f172a' }
                    }
                }
            }
        }
    </script>
    <style>
        ::-webkit-scrollbar { width: 8px; }
        ::-webkit-scrollbar-track { background: #f1f5f9; }
        ::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 10px; }
        ::-webkit-scrollbar-thumb:hover { background: #94a3b8; }
        .sidebar-item-active { background-color: #ecfeff; color: #0891b2; font-weight: 600; }
    </style>
</head>
<body class="bg-neutral-100">

    <div class="flex h-screen">
        <?php 
        // RUTA CORREGIDA: Verifica que tengas el archivo sidebar.php en esta ubicación
        require_once ROOT_PATH . 'views/dashboard/partials/sidebar.php'; 
        ?>

        <div class="flex-1 flex flex-col overflow-hidden">
            <?php 
            // RUTA CORREGIDA: Verifica que tengas el archivo topbar.php en esta ubicación
            require_once ROOT_PATH . 'views/dashboard/partials/topbar.php'; 
            ?>

            <main class="flex-1 overflow-x-hidden overflow-y-auto bg-neutral-100">
                <div class="container mx-auto px-6 py-8">
                    <?php 
                    // Esta línea carga el contenido principal (ej: vehiculos.php)
                    require_once ROOT_PATH . $view_content_path; 
                    ?>
                </div>
            </main>
        </div>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="<?php echo BASE_URL; ?>assets/js/dashboard.js"></script>
</body>
</html>