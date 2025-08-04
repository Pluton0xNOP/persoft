// app.js - Archivo principal de JavaScript
document.addEventListener('DOMContentLoaded', function() {
    initializeApp();
});

// Variables globales
let currentStep = 1;
const totalSteps = 3;
let isFormValid = false;

// Inicialización principal
function initializeApp() {
    console.log('🚀 Iniciando PerSoft App...');
    
    // Inicializar todos los componentes
    setupScrollEffects();
    setupProgressiveForm();
    setupDepartmentCities();
    setupAnimations();
    setupTooltips();
    setupLazyLoading();
    
    // Inicializar AOS (Animate On Scroll) si está disponible
    if (typeof AOS !== 'undefined') {
        AOS.init({
            duration: 800,
            easing: 'ease-in-out',
            once: true,
            offset: 100
        });
    }
    
    console.log('✅ App inicializada correctamente');
}

// Configuración del formulario progresivo
function setupProgressiveForm() {
    const placaInput = document.getElementById('placa');
    const documentoInput = document.getElementById('documento');
    const departamentoSelect = document.getElementById('departamento');
    const ciudadSelect = document.getElementById('ciudad');
    
    if (!placaInput || !documentoInput || !departamentoSelect || !ciudadSelect) {
        console.warn('⚠️ Elementos del formulario no encontrados');
        return;
    }
    
    // Configurar eventos de entrada
    placaInput.addEventListener('input', function(e) {
        this.value = this.value.toUpperCase().replace(/[^A-Z0-9]/g, '');
        
        // Formatear placa automáticamente
        if (this.value.length > 3) {
            const letters = this.value.substring(0, 3);
            const numbers = this.value.substring(3, 6);
            this.value = letters + numbers;
        }
        
        validateStep(1);
        updateProgressBar();
    });
    
    // Agregar efecto de máquina de escribir al placeholder
    animatePlaceholder(placaInput, 'ABC123');
    
    documentoInput.addEventListener('input', function(e) {
        // Solo permitir números
        this.value = this.value.replace(/[^0-9]/g, '');
        
        // Formatear con puntos cada 3 dígitos
        if (this.value.length > 3) {
            this.value = formatNumber(this.value);
        }
        
        validateStep(2);
    });
    
    departamentoSelect.addEventListener('change', function() {
        setupCities();
        validateStep(3);
        
        // Animar el select de ciudades
        const ciudadContainer = ciudadSelect.parentElement;
        ciudadContainer.classList.add('animate-pulse-custom');
        setTimeout(() => {
            ciudadContainer.classList.remove('animate-pulse-custom');
        }, 1000);
    });
    
    ciudadSelect.addEventListener('change', function() {
        validateStep(3);
    });
    
    // Validación en tiempo real
    setupFormValidation();
}

// Sistema de validación del formulario
function setupFormValidation() {
    const form = document.getElementById('consultaForm');
    if (!form) return;
    
    form.addEventListener('submit', function(e) {
        e.preventDefault();
        
        if (!isFormValid) {
            showNotification('Por favor completa todos los campos correctamente', 'error');
            shakeForm();
            return;
        }
        
        // Si todo está bien, mostrar resultados
        showResults();
    });
}

// Validar cada paso
function validateStep(step) {
    let isValid = false;
    
    switch(step) {
        case 1:
            const placa = document.getElementById('placa').value;
            isValid = /^[A-Z]{3}[0-9]{3}$/.test(placa);
            
            // Mostrar feedback visual
            const placaInput = document.getElementById('placa');
            if (placa.length > 0) {
                if (isValid) {
                    placaInput.classList.add('border-green-500');
                    placaInput.classList.remove('border-red-500');
                    showInputFeedback(placaInput, true);
                } else {
                    placaInput.classList.add('border-red-500');
                    placaInput.classList.remove('border-green-500');
                    showInputFeedback(placaInput, false);
                }
            }
            break;
            
        case 2:
            const documento = document.getElementById('documento').value.replace(/\./g, '');
            isValid = documento.length >= 7 && documento.length <= 10;
            
            const docInput = document.getElementById('documento');
            if (documento.length > 0) {
                if (isValid) {
                    docInput.classList.add('border-green-500');
                    docInput.classList.remove('border-red-500');
                } else {
                    docInput.classList.add('border-red-500');
                    docInput.classList.remove('border-green-500');
                }
            }
            break;
            
        case 3:
            const departamento = document.getElementById('departamento').value;
            const ciudad = document.getElementById('ciudad').value;
            const btn = document.getElementById('buscarCDAs');
            
            isValid = departamento && ciudad;
            
            if (btn) {
                if (isValid) {
                    btn.disabled = false;
                    btn.classList.remove('opacity-50', 'cursor-not-allowed');
                    btn.classList.add('hover:scale-[1.02]', 'hover:shadow-xl');
                } else {
                    btn.disabled = true;
                    btn.classList.add('opacity-50', 'cursor-not-allowed');
                    btn.classList.remove('hover:scale-[1.02]', 'hover:shadow-xl');
                }
            }
            break;
    }
    
    isFormValid = isValid;
    return isValid;
}

// Avanzar al siguiente paso
function nextStep() {
    if (!validateStep(currentStep)) {
        showNotification('Por favor completa todos los campos requeridos', 'error');
        shakeForm();
        return;
    }
    
    const currentStepEl = document.getElementById(`step-${currentStep}`);
    const nextStepNum = currentStep + 1;
    const nextStepEl = document.getElementById(`step-${nextStepNum}`);
    
    if (!currentStepEl || !nextStepEl) return;
    
    // Animación de salida
    currentStepEl.classList.add('animate-fade-out');
    
    setTimeout(() => {
        currentStepEl.classList.add('hidden');
        currentStepEl.classList.remove('animate-fade-out');
        
        // Animación de entrada
        nextStepEl.classList.remove('hidden');
        nextStepEl.classList.add('animate-fade-in');
        
        currentStep = nextStepNum;
        updateStepIndicators();
        updateProgressBar();
        
        // Focus en el primer input del nuevo paso
        const firstInput = nextStepEl.querySelector('input, select');
        if (firstInput) {
            setTimeout(() => firstInput.focus(), 300);
        }
        
        showNotification('¡Perfecto! Continuemos con el siguiente paso', 'success');
    }, 300);
}

// Retroceder al paso anterior
function previousStep() {
    if (currentStep <= 1) return;
    
    const currentStepEl = document.getElementById(`step-${currentStep}`);
    const prevStepNum = currentStep - 1;
    const prevStepEl = document.getElementById(`step-${prevStepNum}`);
    
    if (!currentStepEl || !prevStepEl) return;
    
    currentStepEl.classList.add('animate-fade-out');
    
    setTimeout(() => {
        currentStepEl.classList.add('hidden');
        currentStepEl.classList.remove('animate-fade-out');
        
        prevStepEl.classList.remove('hidden');
        prevStepEl.classList.add('animate-fade-in');
        
        currentStep = prevStepNum;
        updateStepIndicators();
        updateProgressBar();
    }, 300);
}

// Actualizar indicadores de pasos
function updateStepIndicators() {
    document.querySelectorAll('.step-indicator').forEach((indicator, index) => {
        const stepNum = index + 1;
        
        if (stepNum < currentStep) {
            indicator.classList.add('completed');
            indicator.innerHTML = '<i class="fas fa-check text-sm"></i>';
        } else if (stepNum === currentStep) {
            indicator.classList.add('active');
            indicator.classList.remove('completed');
            indicator.innerHTML = `<span>${stepNum}</span>`;
        } else {
            indicator.classList.remove('active', 'completed');
            indicator.innerHTML = `<span>${stepNum}</span>`;
        }
    });
    
    // Actualizar líneas de progreso
    document.querySelectorAll('.step-line').forEach((line, index) => {
        if (index < currentStep - 1) {
            line.style.width = '100%';
        } else {
            line.style.width = '0%';
        }
    });
}

// Actualizar barra de progreso
function updateProgressBar() {
    const progress = (currentStep / totalSteps) * 100;
    const progressBar = document.querySelector('.progress-bar');
    
    if (progressBar) {
        progressBar.style.width = `${progress}%`;
    }
}

// Configurar departamentos y ciudades
function setupDepartmentCities() {
    window.cities = {
        cundinamarca: ['Bogotá', 'Soacha', 'Chía', 'Zipaquirá', 'Facatativá', 'Mosquera', 'Madrid', 'Funza', 'Cajicá', 'Sibaté'],
        antioquia: ['Medellín', 'Bello', 'Itagüí', 'Envigado', 'Rionegro', 'Sabaneta', 'La Estrella', 'Caldas', 'Copacabana', 'Girardota'],
        valle: ['Cali', 'Palmira', 'Buenaventura', 'Cartago', 'Tuluá', 'Buga', 'Jamundí', 'Yumbo', 'Florida', 'Pradera'],
        atlantico: ['Barranquilla', 'Soledad', 'Malambo', 'Puerto Colombia', 'Sabanagrande', 'Galapa', 'Baranoa', 'Polonuevo', 'Usiacurí', 'Juan de Acosta'],
        santander: ['Bucaramanga', 'Floridablanca', 'Girón', 'Piedecuesta', 'Barrancabermeja', 'San Gil', 'Socorro', 'Málaga', 'Vélez', 'Barbosa'],
        bolivar: ['Cartagena', 'Magangué', 'Turbaco', 'Arjona', 'El Carmen de Bolívar', 'San Juan Nepomuceno', 'Santa Rosa', 'Mompós', 'Simití', 'Achí']
    };
}

// Configurar ciudades según departamento
function setupCities() {
    const departamento = document.getElementById('departamento').value;
    const ciudadSelect = document.getElementById('ciudad');
    
    if (!ciudadSelect) return;
    
    // Limpiar opciones anteriores con animación
    ciudadSelect.style.opacity = '0.5';
    ciudadSelect.innerHTML = '<option value="" class="bg-gray-800">Selecciona tu ciudad</option>';
    
    if (departamento && window.cities[departamento]) {
        window.cities[departamento].forEach((city, index) => {
            setTimeout(() => {
                const option = document.createElement('option');
                option.value = city.toLowerCase().replace(/\s+/g, '-');
                option.textContent = city;
                option.className = 'bg-gray-800';
                ciudadSelect.appendChild(option);
                
                if (index === window.cities[departamento].length - 1) {
                    ciudadSelect.style.opacity = '1';
                    ciudadSelect.disabled = false;
                }
            }, index * 50);
        });
    } else {
        ciudadSelect.disabled = true;
        ciudadSelect.style.opacity = '1';
    }
}

// Mostrar resultados
function showResults() {

    const departamento = document.getElementById("departamento").value;
    const ciudad = document.getElementById("ciudad").value;
    console.log("Simulando búsqueda para:", ciudad, departamento);

    // Aquí puedes simular el resultado, mostrar una sección o redirigir
    document.getElementById("resultadosSimulados").style.display = "block";
    const departamentoText = departamento.options[departamento.selectedIndex].text;
    
    // Actualizar texto de resultado
    const ciudadResultado = document.getElementById('ciudadResultado');
    if (ciudadResultado) {
        ciudadResultado.textContent = ciudadText;
    }
    
    // Datos de CDAs mejorados
    const cdasData = [
        {
            name: 'CDA Premium AutoCheck',
            address: 'Av. El Dorado #45-67, Fontibón',
            rating: 4.9,
            reviews: 234,
            price: 185000,
            originalPrice: 220000,
            badge: 'MÁS POPULAR',
            badgeColor: 'bg-gradient-to-r from-green-500 to-emerald-500',
            time: '30 min',
            image: 'https://images.unsplash.com/photo-1625047509168-a7026f36de04?w=400&h=300&fit=crop',
            features: ['Certificado ONAC', 'Parqueadero gratis', 'WiFi', 'Sala de espera A/C'],
            availability: 'Disponible ahora',
            availabilityColor: 'text-green-500'
        },
        {
            name: 'Centro Diagnóstico Rápido',
            address: 'Calle 26 #68-45, Zona Industrial',
            rating: 4.7,
            reviews: 189,
            price: 195000,
            originalPrice: 230000,
            badge: 'MEJOR PRECIO',
            badgeColor: 'bg-gradient-to-r from-blue-500 to-cyan-500',
            time: '25 min',
            image: 'https://images.unsplash.com/photo-1632823471565-1ecdf5c6da7e?w=400&h=300&fit=crop',
            features: ['Revisión express', 'Domingos abierto', 'App móvil', 'Pago PSE'],
            availability: '2 turnos disponibles',
            availabilityColor: 'text-yellow-500'
        },
        {
            name: 'TecnoAutos 360°',
            address: 'Carrera 50 #12-34, Centro',
            rating: 4.8,
            reviews: 312,
            price: 200000,
            originalPrice: 240000,
            badge: 'PREMIUM',
            badgeColor: 'bg-gradient-to-r from-purple-500 to-pink-500',
            time: '35 min',
            image: 'https://images.unsplash.com/photo-1580273916550-e323be2ae537?w=400&h=300&fit=crop',
            features: ['Tecnología avanzada', '15 años experiencia', 'Garantía extendida', 'Café gratis'],
            availability: 'Última cita hoy',
            availabilityColor: 'text-red-500'
        }
    ];
    
    const cdasList = document.getElementById('cdasList');
    if (!cdasList) return;
    
    // Limpiar lista anterior
    cdasList.innerHTML = '';
    
    // Mostrar loading
    showLoading(cdasList);
    
    // Simular carga de datos
    setTimeout(() => {
        cdasList.innerHTML = '';
        
        cdasData.forEach((cda, index) => {
            const cdaCard = createCDACard(cda, index);
            cdasList.appendChild(cdaCard);
        });
        
        // Mostrar sección de resultados
        const resultadosSection = document.getElementById('resultados');
        if (resultadosSection) {
            resultadosSection.classList.remove('hidden');
            resultadosSection.scrollIntoView({ behavior: 'smooth', block: 'start' });
        }
        
        showNotification(`¡Encontramos ${cdasData.length} CDAs disponibles en ${ciudadText}!`, 'success');
    }, 1500);
}

// Crear tarjeta de CDA
function createCDACard(cda, index) {
    const cdaCard = document.createElement('div');
    cdaCard.className = 'bg-white rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-300 overflow-hidden transform hover:-translate-y-2 opacity-0';
    
    cdaCard.innerHTML = `
        <div class="relative">
            <!-- Badge -->
            <div class="absolute top-4 left-4 z-20">
                <span class="${cda.badgeColor} text-white px-4 py-2 rounded-full text-xs font-bold shadow-lg flex items-center">
                    <i class="fas fa-award mr-1"></i>
                    ${cda.badge}
                </span>
            </div>
            
            <!-- Rating -->
            <div class="absolute top-4 right-4 z-20">
                <div class="bg-white/95 backdrop-blur-sm rounded-lg px-3 py-2 shadow-lg">
                    <div class="flex items-center space-x-1">
                        <i class="fas fa-star text-yellow-400"></i>
                        <span class="font-bold text-gray-900">${cda.rating}</span>
                        <span class="text-xs text-gray-600">(${cda.reviews})</span>
                    </div>
                </div>
            </div>
            
            <!-- Imagen con overlay -->
            <div class="relative h-48 overflow-hidden">
                <img src="${cda.image}" alt="${cda.name}" class="w-full h-full object-cover transform hover:scale-110 transition-transform duration-500">
                <div class="absolute inset-0 bg-gradient-to-t from-black/50 to-transparent"></div>
                
                <!-- Disponibilidad -->
                <div class="absolute bottom-4 left-4 flex items-center space-x-2 text-white">
                    <span class="relative flex h-3 w-3">
                        <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-green-400 opacity-75"></span>
                        <span class="relative inline-flex rounded-full h-3 w-3 bg-green-500"></span>
                    </span>
                    <span class="text-sm font-medium">${cda.availability}</span>
                </div>
            </div>
        </div>
        
        <div class="p-6">
            <!-- Título y dirección -->
            <h3 class="font-bold text-xl text-gray-900 mb-2">${cda.name}</h3>
            <p class="text-gray-600 mb-4 flex items-start">
                <i class="fas fa-map-marker-alt text-primary-500 mr-2 mt-1"></i>
                <span>${cda.address}</span>
            </p>
            
            <!-- Features -->
            <div class="flex flex-wrap gap-2 mb-4">
                ${cda.features.map((feature, i) => `
                    <span class="bg-gray-100 text-gray-700 px-3 py-1 rounded-full text-xs font-medium flex items-center" style="animation-delay: ${i * 100}ms">
                        <i class="fas fa-check-circle text-green-500 mr-1 text-xs"></i>
                        ${feature}
                    </span>
                `).join('')}
            </div>
            
            <!-- Tiempo y precio -->
            <div class="flex items-center justify-between mb-4 py-4 border-t border-gray-100">
                <div class="flex items-center space-x-4">
                    <div class="text-center">
                        <div class="text-xs text-gray-500">Tiempo est.</div>
                        <div class="font-semibold text-gray-900 flex items-center">
                            <i class="fas fa-clock text-primary-500 mr-1"></i>
                            ${cda.time}
                        </div>
                    </div>
                </div>
                <div class="text-right">
                    <div class="text-sm text-gray-500 line-through">$${cda.originalPrice.toLocaleString('es-CO')}</div>
                    <div class="text-2xl font-bold text-primary-600">$${cda.price.toLocaleString('es-CO')}</div>
                    <div class="text-xs text-green-600 font-medium">
                        Ahorra ${Math.round(((cda.originalPrice - cda.price) / cda.originalPrice) * 100)}%
                    </div>
                </div>
            </div>
            
            <!-- Botón de acción -->
            <button onclick="agendarCita('${cda.name}')" class="w-full group relative px-6 py-3 bg-gradient-to-r from-primary-600 to-secondary-600 text-white rounded-xl font-bold overflow-hidden transition-all hover:shadow-lg transform hover:scale-[1.02]">
                <span class="relative z-10 flex items-center justify-center">
                    <i class="fas fa-calendar-check mr-2"></i>
                    Agendar Cita
                    <i class="fas fa-arrow-right ml-2 transform group-hover:translate-x-1 transition-transform"></i>
                </span>
                <div class="absolute inset-0 bg-gradient-to-r from-secondary-600 to-accent-600 opacity-0 group-hover:opacity-100 transition-opacity"></div>
            </button>
        </div>
    `;
    
    // Animar entrada
    setTimeout(() => {
        cdaCard.classList.remove('opacity-0');
        cdaCard.classList.add('animate-scale-in');
    }, index * 150);
    
    return cdaCard;
}

// Función para agendar cita
function agendarCita(cdaName) {
    showNotification(`Redirigiendo al sistema de citas de ${cdaName}...`, 'info');
    
    // Aquí puedes agregar la lógica para abrir un modal o redirigir
    setTimeout(() => {
        showNotification('¡Cita agendada exitosamente! Te enviamos la confirmación por email.', 'success');
    }, 2000);
}

// Sistema de notificaciones mejorado
function showNotification(message, type = 'info') {
    // Remover notificaciones anteriores
    const existingNotifications = document.querySelectorAll('.notification');
    existingNotifications.forEach(notif => notif.remove());
    
    const notification = document.createElement('div');
    const bgColor = {
        'success': 'bg-gradient-to-r from-green-500 to-emerald-500',
        'error': 'bg-gradient-to-r from-red-500 to-pink-500',
        'info': 'bg-gradient-to-r from-blue-500 to-cyan-500',
        'warning': 'bg-gradient-to-r from-yellow-500 to-orange-500'
    }[type] || 'bg-gradient-to-r from-gray-500 to-gray-600';
    
    const icon = {
        'success': 'fas fa-check-circle',
        'error': 'fas fa-exclamation-circle',
        'info': 'fas fa-info-circle',
        'warning': 'fas fa-exclamation-triangle'
    }[type] || 'fas fa-bell';
    
    notification.className = `notification fixed top-24 right-6 ${bgColor} text-white px-6 py-4 rounded-xl shadow-2xl z-50 transform translate-x-full transition-all duration-300 flex items-center space-x-3 max-w-md`;
    
    notification.innerHTML = `
        <i class="${icon} text-2xl"></i>
        <div>
            <p class="font-semibold">${type.charAt(0).toUpperCase() + type.slice(1)}</p>
            <p class="text-sm opacity-90">${message}</p>
        </div>
        <button onclick="this.parentElement.remove()" class="ml-4 hover:opacity-70 transition-opacity">
            <i class="fas fa-times"></i>
        </button>
    `;
    
    document.body.appendChild(notification);
    
    // Animar entrada
    setTimeout(() => {
        notification.classList.remove('translate-x-full');
        notification.classList.add('translate-x-0');
    }, 100);
    
    // Auto remover después de 5 segundos
    setTimeout(() => {
        notification.classList.add('translate-x-full');
        setTimeout(() => {
            if (notification.parentElement) {
                notification.remove();
            }
        }, 300);
    }, 5000);
}

// Efectos de scroll
function setupScrollEffects() {
    const navbar = document.getElementById('navbar');
    let lastScroll = 0;
    
    window.addEventListener('scroll', function() {
        const currentScroll = window.pageYOffset;
        
        if (!navbar) return;
        
        // Cambiar apariencia del navbar
        if (currentScroll > 100) {
            navbar.classList.add('shadow-lg', 'bg-white/98');
            navbar.classList.remove('bg-white/95');
        } else {
            navbar.classList.remove('shadow-lg', 'bg-white/98');
            navbar.classList.add('bg-white/95');
        }
        
        // Hide/show navbar on scroll
        if (currentScroll > lastScroll && currentScroll > 500) {
            navbar.style.transform = 'translateY(-100%)';
        } else {
            navbar.style.transform = 'translateY(0)';
        }
        
        lastScroll = currentScroll;
    });
    
    // Intersection Observer para animaciones
    const observerOptions = {
        threshold: 0.1,
        rootMargin: '0px 0px -100px 0px'
    };
    
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('animate-fade-in');
                
                // Animar elementos hijos con retraso
                const children = entry.target.querySelectorAll('[data-animate]');
                children.forEach((child, index) => {
                    setTimeout(() => {
                        child.classList.add('animate-slide-up');
                    }, index * 100);
                });
            }
        });
    }, observerOptions);
    
    // Observar secciones
    document.querySelectorAll('section').forEach(section => {
        observer.observe(section);
    });
}

// Configurar animaciones adicionales
function setupAnimations() {
    // Parallax effect
    window.addEventListener('scroll', () => {
        const scrolled = window.pageYOffset;
        const parallaxElements = document.querySelectorAll('.parallax');
        
        parallaxElements.forEach(element => {
            const speed = element.dataset.speed || 0.5;
            element.style.transform = `translateY(${scrolled * speed}px)`;
        });
    });
    
    // Animación de números
    const animateNumbers = () => {
        const numbers = document.querySelectorAll('[data-number]');
        
        numbers.forEach(number => {
            const target = parseInt(number.dataset.number);
            const duration = 2000;
            const increment = target / (duration / 16);
            let current = 0;
            
            const updateNumber = () => {
                current += increment;
                if (current < target) {
                    number.textContent = Math.floor(current);
                    requestAnimationFrame(updateNumber);
                } else {
                    number.textContent = target;
                }
            };
            
            // Iniciar animación cuando sea visible
            const observer = new IntersectionObserver((entries) => {
                if (entries[0].isIntersecting) {
                    updateNumber();
                    observer.disconnect();
                }
            });
            
            observer.observe(number);
        });
    };
    
    animateNumbers();
}

// Sistema de tooltips
function setupTooltips() {
    const tooltips = document.querySelectorAll('[data-tooltip]');
    
    tooltips.forEach(element => {
        let tooltipEl = null;
        
        element.addEventListener('mouseenter', (e) => {
            const text = element.dataset.tooltip;
            tooltipEl = document.createElement('div');
            tooltipEl.className = 'absolute z-50 px-3 py-2 text-sm text-white bg-gray-900 rounded-lg shadow-lg transform -translate-x-1/2 -translate-y-full pointer-events-none opacity-0 transition-opacity';
            tooltipEl.textContent = text;
            
            document.body.appendChild(tooltipEl);
            
            const rect = element.getBoundingClientRect();
            tooltipEl.style.left = `${rect.left + rect.width / 2}px`;
            tooltipEl.style.top = `${rect.top - 10}px`;
            
            setTimeout(() => {
                tooltipEl.classList.add('opacity-100');
            }, 10);
        });
        
        element.addEventListener('mouseleave', () => {
            if (tooltipEl) {
                tooltipEl.classList.remove('opacity-100');
                setTimeout(() => {
                    tooltipEl.remove();
                }, 300);
            }
        });
    });
}

// Lazy loading para imágenes
function setupLazyLoading() {
    const images = document.querySelectorAll('img[data-src]');
    
    const imageObserver = new IntersectionObserver((entries, observer) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                const img = entry.target;
                img.src = img.dataset.src;
                img.classList.add('fade-in');
                imageObserver.unobserve(img);
            }
        });
    });
    
    images.forEach(img => imageObserver.observe(img));
}

// Utilidades
function formatNumber(num) {
    return num.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
}

function animatePlaceholder(input, text) {
    let index = 0;
    const interval = setInterval(() => {
        if (index <= text.length) {
            input.setAttribute('placeholder', text.substring(0, index));
            index++;
        } else {
            clearInterval(interval);
        }
    }, 100);
}

function showInputFeedback(input, isValid) {
    const parent = input.parentElement;
    let feedback = parent.querySelector('.input-feedback');
    
    if (!feedback) {
        feedback = document.createElement('div');
        feedback.className = 'input-feedback absolute right-12 top-1/2 transform -translate-y-1/2';
        parent.appendChild(feedback);
    }
    
    if (isValid) {
        feedback.innerHTML = '<i class="fas fa-check-circle text-green-500 animate-scale-in"></i>';
    } else {
        feedback.innerHTML = '<i class="fas fa-times-circle text-red-500 animate-shake"></i>';
    }
}

function shakeForm() {
    const form = document.getElementById('consultaForm');
    if (form) {
        form.classList.add('animate-shake');
        setTimeout(() => {
            form.classList.remove('animate-shake');
        }, 500);
    }
}

function showLoading(container) {
    container.innerHTML = `
        <div class="flex justify-center items-center py-20">
            <div class="relative">
                <div class="w-20 h-20 border-4 border-primary-200 rounded-full animate-spin"></div>
                <div class="w-20 h-20 border-4 border-primary-600 rounded-full animate-spin absolute top-0 left-0" style="animation-direction: reverse; animation-duration: 1.5s;"></div>
                <div class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2">
                    <i class="fas fa-car text-primary-600 text-2xl animate-pulse"></i>
                </div>
            </div>
        </div>
        <p class="text-center text-gray-600 mt-4 animate-pulse">Buscando los mejores CDAs para ti...</p>
    `;
}

// Agregar estilos CSS para animaciones personalizadas
const style = document.createElement('style');
style.textContent = `
    @keyframes shake {
        0%, 100% { transform: translateX(0); }
        25% { transform: translateX(-10px); }
        75% { transform: translateX(10px); }
    }
    
    .animate-shake {
        animation: shake 0.5s ease-in-out;
    }
    
    @keyframes fade-out {
        from { opacity: 1; transform: translateY(0); }
        to { opacity: 0; transform: translateY(-20px); }
    }
    
    .animate-fade-out {
        animation: fade-out 0.3s ease-out forwards;
    }
    
    .step-indicator.completed {
        background: linear-gradient(135deg, #10b981 0%, #059669 100%);
        border-color: transparent;
    }
    
    .progress-bar {
        height: 4px;
        background: linear-gradient(90deg, #06b6d4 0%, #3b82f6 50%, #8b5cf6 100%);
        transition: width 0.5s ease-out;
        border-radius: 2px;
    }
`;
document.head.appendChild(style);

// Log de inicialización
console.log('✨ PerSoft App v1.0 - Todos los sistemas funcionando correctamente');