<!DOCTYPE html>
<html lang="es" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $titulo ?? 'PerSoft'; ?></title>
    <meta name="description" content="<?php echo $descripcion ?? 'Sistema de consulta de tecnomecánica'; ?>">
    
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
                    fontFamily: {
                        'sans': ['Inter', 'ui-sans-serif', 'system-ui'],
                    },
                    colors: {
                        primary: {
                            50: '#ecfeff',
                            100: '#cffafe',
                            500: '#06b6d4',
                            600: '#0891b2',
                            700: '#0e7490',
                            900: '#164e63'
                        },
                        accent: {
                            400: '#34d399',
                            500: '#10b981',
                            600: '#059669'
                        }
                    },
                    animation: {
                        'fade-in': 'fadeIn 0.6s ease-out',
                        'slide-up': 'slideUp 0.4s ease-out',
                        'float': 'float 6s ease-in-out infinite'
                    }
                }
            }
        }
    </script>
    
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>assets/css/styles.css">
</head>
<body class="bg-gray-50 font-sans antialiased">
    <?php require_once ROOT_PATH . 'views/home/index.php'; ?>
    <script src="<?php echo BASE_URL; ?>assets/js/app.js"></script>
</body>
</html>