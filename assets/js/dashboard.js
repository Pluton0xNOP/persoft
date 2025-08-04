document.addEventListener('DOMContentLoaded', function() {
    // Agregar botones de actualización a cada vehículo
    const vehicleCards = document.querySelectorAll('.vehicle-card');
    
    vehicleCards.forEach(card => {
        const gestionarBtn = card.querySelector('.btn-gestionar');
        if (gestionarBtn) {
            const vehiculoId = gestionarBtn.getAttribute('data-id');
            
            const semafSection = card.querySelector('.space-y-4');
            if (semafSection) {
                const semafItem = semafSection.querySelector('div:nth-child(3)');
                if (semafItem) {
                    const refreshBtn = document.createElement('button');
                    refreshBtn.className = 'text-xs text-primary hover:text-primary-700 mt-2 flex items-center';
                    refreshBtn.innerHTML = '<i class="fas fa-sync-alt mr-1"></i> Actualizar semaforización';
                    refreshBtn.onclick = function(e) {
                        e.preventDefault();
                        window.location.href = BASE_URL + 'dashboard/vehiculos?actualizar_vehiculo=' + vehiculoId;
                    };
                    
                    semafItem.appendChild(refreshBtn);
                }
            }
        }
    });
    
    // Inicializar filtrado de vehículos
    initVehicleFilters();
});
document.addEventListener('DOMContentLoaded', function() {
    // Inicializar filtrado de vehículos
    initVehicleFilters();
});

function initVehicleFilters() {
    const searchInput = document.getElementById('searchVehicles');
    const filterType = document.getElementById('filterType');
    const filterStatus = document.getElementById('filterStatus');
    const clearFiltersBtn = document.getElementById('clearFilters');
    const vehicleCards = document.querySelectorAll('.vehicle-card');
    const noResultsMessage = document.getElementById('noResultsMessage');
    
    function applyFilters() {
        const searchText = searchInput ? searchInput.value.toLowerCase() : '';
        const typeFilter = filterType ? filterType.value : '';
        const statusFilter = filterStatus ? filterStatus.value : '';
        
        let visibleCount = 0;
        
        vehicleCards.forEach(card => {
            const type = card.getAttribute('data-type') || '';
            const status = card.getAttribute('data-status') || '';
            const placa = card.querySelector('h3') ? card.querySelector('h3').textContent.toLowerCase() : '';
            const info = card.querySelector('p.text-sm') ? card.querySelector('p.text-sm').textContent.toLowerCase() : '';
            
            // También buscar en el estado de semaforización
            const semafStatus = card.querySelector('.space-y-4 div:nth-child(3) .status-badge') ? 
                card.querySelector('.space-y-4 div:nth-child(3) .status-badge').textContent : '';
            
            const matchesSearch = !searchText || placa.includes(searchText) || info.includes(searchText);
            const matchesType = !typeFilter || type === typeFilter;
            const matchesStatus = !statusFilter || status === statusFilter || semafStatus === statusFilter;
            
            if (matchesSearch && matchesType && matchesStatus) {
                card.style.display = 'block';
                visibleCount++;
            } else {
                card.style.display = 'none';
            }
        });
        
        if (noResultsMessage) {
            if (visibleCount === 0 && vehicleCards.length > 0) {
                noResultsMessage.classList.remove('hidden');
            } else {
                noResultsMessage.classList.add('hidden');
            }
        }
    }
    
    if (searchInput) searchInput.addEventListener('input', applyFilters);
    if (filterType) filterType.addEventListener('change', applyFilters);
    if (filterStatus) filterStatus.addEventListener('change', applyFilters);
    
    if (clearFiltersBtn) {
        clearFiltersBtn.addEventListener('click', function() {
            if (searchInput) searchInput.value = '';
            if (filterType) filterType.value = '';
            if (filterStatus) filterStatus.value = '';
            applyFilters();
        });
    }
}

function actualizarSemaforizacion(vehiculoId, btnElement, containerElement) {
    const originalBtnHtml = btnElement.innerHTML;
    btnElement.innerHTML = '<i class="fas fa-circle-notch fa-spin mr-1"></i> Actualizando...';
    btnElement.disabled = true;
    
    fetch(BASE_URL + 'semaforizacion/actualizarSemaforizacion', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: 'vehiculo_id=' + vehiculoId
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            showNotification('Semaforización actualizada correctamente', 'success');
            
            const statusBadge = containerElement.querySelector('.status-badge');
            const progressBar = containerElement.querySelector('.bg-neutral-200 .h-1\\.5');
            
            const estado = data.semaforizacion.estado;
            
            let bgClass, textClass, progressClass;
            if (estado === 'Pago Pendiente') {
                bgClass = 'bg-yellow-100';
                textClass = 'text-yellow-700';
                progressClass = 'bg-yellow-500';
            } else {
                bgClass = 'bg-green-100';
                textClass = 'text-green-700';
                progressClass = 'bg-green-500';
            }
            
            if (statusBadge) {
                statusBadge.className = `status-badge px-2 py-0.5 rounded-full text-xs font-semibold ${bgClass} ${textClass}`;
                statusBadge.textContent = estado;
            }
            
            if (progressBar) {
                progressBar.className = `${progressClass} h-1.5 rounded-full transition-all duration-1000`;
                progressBar.style.width = estado === 'Pago Pendiente' ? '100%' : '0%';
            }
            
            const infoText = containerElement.querySelector('p.text-xs.text-neutral-500:not(:first-child)');
            
            if (estado === 'Pago Pendiente' && data.semaforizacion.total_deuda) {
                if (infoText) {
                    infoText.innerHTML = `Deuda total: $${new Intl.NumberFormat('es-CO').format(data.semaforizacion.total_deuda)}`;
                }
                
                const municipiosText = containerElement.querySelector('p.text-xs.text-neutral-500:last-child');
                if (municipiosText && data.semaforizacion.municipios) {
                    municipiosText.textContent = `Municipios: ${data.semaforizacion.municipios.join(', ')}`;
                }
            } else {
                if (infoText) {
                    infoText.textContent = 'No se encontraron deudas pendientes.';
                }
                
                const municipiosText = containerElement.querySelector('p.text-xs.text-neutral-500:last-child');
                if (municipiosText && municipiosText !== infoText) {
                    municipiosText.remove();
                }
            }
            
            setTimeout(() => {
                window.location.reload();
            }, 1000);
            
        } else {
            showNotification('Error: ' + data.message, 'error');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showNotification('Error al actualizar la semaforización', 'error');
    })
    .finally(() => {
        btnElement.innerHTML = originalBtnHtml;
        btnElement.disabled = false;
    });
}

function showNotification(message, type = 'info') {
    const existingNotifications = document.querySelectorAll('.notification');
    existingNotifications.forEach(notif => notif.remove());
    
    const notification = document.createElement('div');
    const bgColor = {
        'success': 'bg-green-500',
        'error': 'bg-red-500',
        'info': 'bg-blue-500',
        'warning': 'bg-yellow-500'
    }[type] || 'bg-gray-500';
    
    const icon = {
        'success': 'fas fa-check-circle',
        'error': 'fas fa-exclamation-circle',
        'info': 'fas fa-info-circle',
        'warning': 'fas fa-exclamation-triangle'
    }[type] || 'fas fa-bell';
    
    notification.className = `notification fixed top-24 right-6 ${bgColor} text-white px-4 py-3 rounded-lg shadow-lg z-50 transform translate-x-full transition-all duration-300`;
    
    notification.innerHTML = `
        <div class="flex items-center">
            <div class="mr-3">
                <i class="${icon}"></i>
            </div>
            <div>
                <p class="font-medium">${message}</p>
            </div>
            <div class="ml-4">
                <button class="text-white opacity-75 hover:opacity-100" onclick="this.parentElement.parentElement.parentElement.remove()">
                    <i class="fas fa-times"></i>
                </button>
            </div>
        </div>
    `;
    
    document.body.appendChild(notification);
    
    setTimeout(() => {
        notification.classList.remove('translate-x-full');
    }, 10);
    
    setTimeout(() => {
        notification.classList.add('translate-x-full');
        setTimeout(() => {
            if (notification.parentElement) {
                notification.remove();
            }
        }, 300);
    }, 4000);
}