<?php
// views/dashboard/centros_servicio.php
?>

<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

<div class="space-y-6">
   <div class="flex justify-between items-center">
       <div>
           <h1 class="text-2xl font-bold text-gray-900">Centros de Servicio</h1>
           <p class="text-gray-600">Encuentra los Centros de Diagnóstico Automotor más cercanos</p>
       </div>
   </div>

   <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
       <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-4">
           <div>
               <label class="block text-sm font-medium text-gray-700 mb-2">Tipo de Servicio</label>
               <select id="tipoServicio" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500">
                   <option value="automotive+service">Centros de Diagnóstico Automotor (CDA)</option>
                   <option value="vehicle_inspection">Revisión Técnico Mecánica</option>
                   <option value="insurance+agency">Venta de SOAT</option>
                   <option value="government">Oficinas de Tránsito</option>
               </select>
           </div>
           <div>
               <label class="block text-sm font-medium text-gray-700 mb-2">Radio de búsqueda</label>
               <select id="radioBusqueda" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500">
                   <option value="5000">5 km</option>
                   <option value="10000" selected>10 km</option>
                   <option value="15000">15 km</option>
                   <option value="25000">25 km</option>
               </select>
           </div>
           <div>
               <label class="block text-sm font-medium text-gray-700 mb-2">Mi ubicación</label>
               <button id="obtenerUbicacion" class="w-full px-4 py-2 bg-primary-600 text-white rounded-lg hover:bg-primary-700 transition-colors">
                   <i class="fas fa-location-arrow mr-2"></i>Usar mi ubicación
               </button>
           </div>
       </div>

       <div class="mb-4">
           <label class="block text-sm font-medium text-gray-700 mb-2">O buscar por dirección</label>
           <div class="flex gap-2">
               <input type="text" id="direccionBusqueda" placeholder="Ej: Carrera 7 #32-16, Bogotá" 
                      class="flex-1 px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500">
               <button id="buscarDireccion" class="px-4 py-2 bg-gray-600 text-white rounded-lg hover:bg-gray-700 transition-colors">
                   <i class="fas fa-search"></i>
               </button>
           </div>
       </div>
   </div>

   <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
       <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-4">
           <h3 class="text-lg font-semibold text-gray-900 mb-4">Mapa de Centros</h3>
           <div id="mapa" class="w-full h-96 rounded-lg border border-gray-300"></div>
           <div id="ubicacionStatus" class="mt-3 text-sm text-gray-600"></div>
       </div>

       <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-4">
           <h3 class="text-lg font-semibold text-gray-900 mb-4">Centros Encontrados</h3>
           <div id="resultadosCentros" class="space-y-4 max-h-96 overflow-y-auto">
               <div class="text-center text-gray-500 py-8">
                   <i class="fas fa-map-marker-alt text-3xl mb-2"></i>
                   <p>Haz clic en "Usar mi ubicación" para encontrar centros cercanos</p>
               </div>
           </div>
       </div>
   </div>

   <div class="bg-blue-50 border border-blue-200 rounded-xl p-6">
       <h3 class="text-lg font-semibold text-blue-900 mb-3">
           <i class="fas fa-info-circle mr-2"></i>Información Importante
       </h3>
       <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm text-blue-800">
           <div>
               <h4 class="font-medium mb-2">Revisión Técnico Mecánica:</h4>
               <ul class="space-y-1">
                   <li>• Obligatoria cada año para vehículos particulares</li>
                   <li>• Cada 6 meses para vehículos de servicio público</li>
                   <li>• Llevar: Licencia de tránsito, SOAT vigente, cédula</li>
               </ul>
           </div>
           <div>
               <h4 class="font-medium mb-2">Consejos:</h4>
               <ul class="space-y-1">
                   <li>• Verifica horarios de atención antes de ir</li>
                   <li>• Algunos centros requieren cita previa</li>
                   <li>• Lleva dinero en efectivo para el pago</li>
               </ul>
           </div>
       </div>
   </div>
</div>

<script>
   let mapa;
   let marcadorUsuario;
   let marcadoresCentros = [];
   let ubicacionUsuario = null;
   let busquedaActual = null;

   function inicializarMapa() {
       mapa = L.map('mapa').setView([4.1420, -73.6266], 12);
       
       L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
           attribution: '© OpenStreetMap contributors'
       }).addTo(mapa);

       document.getElementById('ubicacionStatus').textContent = 'Mapa centrado en Villavicencio, Meta';
   }

   function obtenerUbicacion() {
       const boton = document.getElementById('obtenerUbicacion');
       const status = document.getElementById('ubicacionStatus');
       
       boton.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Obteniendo ubicación...';
       boton.disabled = true;
       
       if (navigator.geolocation) {
           navigator.geolocation.getCurrentPosition(
               function(position) {
                   ubicacionUsuario = {
                       lat: position.coords.latitude,
                       lng: position.coords.longitude
                   };
                   
                   mapa.setView([ubicacionUsuario.lat, ubicacionUsuario.lng], 13);
                   
                   if (marcadorUsuario) {
                       mapa.removeLayer(marcadorUsuario);
                   }
                   
                   marcadorUsuario = L.marker([ubicacionUsuario.lat, ubicacionUsuario.lng])
                       .addTo(mapa)
                       .bindPopup('<b>Tu ubicación</b>')
                       .openPopup();
                   
                   status.textContent = 'Ubicación obtenida correctamente';
                   boton.innerHTML = '<i class="fas fa-check mr-2"></i>Ubicación obtenida';
                   
                   buscarCentrosCercanos();
                   
                   setTimeout(() => {
                       boton.innerHTML = '<i class="fas fa-location-arrow mr-2"></i>Actualizar ubicación';
                       boton.disabled = false;
                   }, 2000);
               },
               function(error) {
                   status.textContent = 'Error al obtener ubicación: ' + error.message;
                   boton.innerHTML = '<i class="fas fa-location-arrow mr-2"></i>Usar mi ubicación';
                   boton.disabled = false;
               }
           );
       } else {
           status.textContent = 'Geolocalización no soportada en este navegador';
           boton.innerHTML = '<i class="fas fa-location-arrow mr-2"></i>Usar mi ubicación';
           boton.disabled = false;
       }
   }

   function buscarPorDireccion() {
       const direccion = document.getElementById('direccionBusqueda').value.trim();
       if (!direccion) {
           alert('Por favor ingresa una dirección');
           return;
       }

       const url = `https://nominatim.openstreetmap.org/search?q=${encodeURIComponent(direccion + ', Colombia')}&format=json&limit=1&countrycodes=co`;
       
       fetch(url)
           .then(response => response.json())
           .then(data => {
               if (data.length > 0) {
                   const resultado = data[0];
                   ubicacionUsuario = {
                       lat: parseFloat(resultado.lat),
                       lng: parseFloat(resultado.lon)
                   };
                   
                   mapa.setView([ubicacionUsuario.lat, ubicacionUsuario.lng], 13);
                   
                   if (marcadorUsuario) {
                       mapa.removeLayer(marcadorUsuario);
                   }
                   
                   marcadorUsuario = L.marker([ubicacionUsuario.lat, ubicacionUsuario.lng])
                       .addTo(mapa)
                       .bindPopup(`<b>Ubicación buscada:</b><br>${resultado.display_name}`)
                       .openPopup();
                   
                   buscarCentrosCercanos();
                   document.getElementById('ubicacionStatus').textContent = 'Dirección encontrada correctamente';
               } else {
                   alert('No se pudo encontrar la dirección especificada');
               }
           })
           .catch(error => {
               console.error('Error:', error);
               alert('Error al buscar la dirección');
           });
   }

   function buscarCentrosCercanos() {
       if (!ubicacionUsuario) return;

       const radioMetros = document.getElementById('radioBusqueda').value;
       const tipoServicio = document.getElementById('tipoServicio').value;
       
       limpiarMarcadores();
       mostrarMensajeCarga();
       
       const bbox = calcularBoundingBox(ubicacionUsuario.lat, ubicacionUsuario.lng, radioMetros);
       
       let query = `[out:json][timeout:25];
       (
           node["amenity"="${tipoServicio}"](${bbox});
           way["amenity"="${tipoServicio}"](${bbox});
           relation["amenity"="${tipoServicio}"](${bbox});
       );
       out center meta;`;

       if (tipoServicio === 'automotive+service') {
           query = `[out:json][timeout:25];
           (
               node["shop"="car_repair"](${bbox});
               node["amenity"="car_wash"](${bbox});
               node["shop"="car"](${bbox});
               way["shop"="car_repair"](${bbox});
               way["amenity"="car_wash"](${bbox});
               way["shop"="car"](${bbox});
               relation["shop"="car_repair"](${bbox});
               relation["amenity"="car_wash"](${bbox});
               relation["shop"="car"](${bbox});
           );
           out center meta;`;
       } else if (tipoServicio === 'government') {
           query = `[out:json][timeout:25];
           (
               node["amenity"="townhall"](${bbox});
               node["office"="government"](${bbox});
               node["government"="administrative"](${bbox});
               way["amenity"="townhall"](${bbox});
               way["office"="government"](${bbox});
               way["government"="administrative"](${bbox});
               relation["amenity"="townhall"](${bbox});
               relation["office"="government"](${bbox});
               relation["government"="administrative"](${bbox});
           );
           out center meta;`;
       } else if (tipoServicio === 'insurance+agency') {
           query = `[out:json][timeout:25];
           (
               node["office"="insurance"](${bbox});
               node["shop"="insurance"](${bbox});
               way["office"="insurance"](${bbox});
               way["shop"="insurance"](${bbox});
               relation["office"="insurance"](${bbox});
               relation["shop"="insurance"](${bbox});
           );
           out center meta;`;
       }

       fetch('https://overpass-api.de/api/interpreter', {
           method: 'POST',
           body: query,
           headers: {
               'Content-Type': 'text/plain'
           }
       })
       .then(response => response.json())
       .then(data => {
           procesarResultados(data.elements);
       })
       .catch(error => {
           console.error('Error en búsqueda:', error);
           mostrarError('Error al buscar centros. Intente nuevamente.');
       });
   }

   function calcularBoundingBox(lat, lng, radioMetros) {
       const R = 6371000;
       const dLat = radioMetros / R;
       const dLng = radioMetros / (R * Math.cos(lat * Math.PI / 180));
       
       const latMin = lat - dLat * 180 / Math.PI;
       const latMax = lat + dLat * 180 / Math.PI;
       const lngMin = lng - dLng * 180 / Math.PI;
       const lngMax = lng + dLng * 180 / Math.PI;
       
       return `${latMin},${lngMin},${latMax},${lngMax}`;
   }

   function procesarResultados(elementos) {
       const centros = elementos.map(elemento => {
           const lat = elemento.lat || elemento.center.lat;
           const lng = elemento.lon || elemento.center.lon;
           const tags = elemento.tags || {};
           
           const distancia = calcularDistancia(ubicacionUsuario.lat, ubicacionUsuario.lng, lat, lng);
           
           return {
               id: elemento.id,
               nombre: tags.name || tags['name:es'] || 'Centro sin nombre',
               direccion: formatearDireccion(tags),
               telefono: tags.phone || tags['contact:phone'] || 'No disponible',
               lat: lat,
               lng: lng,
               distancia: distancia,
               tipo: determinarTipo(tags),
               horario: tags.opening_hours || 'Consultar horarios',
               sitio_web: tags.website || tags['contact:website'] || null
           };
       }).filter(centro => centro.distancia <= parseInt(document.getElementById('radioBusqueda').value) / 1000);

       centros.sort((a, b) => a.distancia - b.distancia);
       
       mostrarCentrosEnMapa(centros);
       mostrarListaCentros(centros);
   }

   function formatearDireccion(tags) {
       const partes = [];
       if (tags['addr:street']) partes.push(tags['addr:street']);
       if (tags['addr:housenumber']) partes.push(tags['addr:housenumber']);
       if (tags['addr:city']) partes.push(tags['addr:city']);
       
       return partes.length > 0 ? partes.join(' ') : 'Dirección no disponible';
   }

   function determinarTipo(tags) {
       if (tags.shop === 'car_repair' || tags.amenity === 'car_wash') return 'Taller/CDA';
       if (tags.office === 'insurance' || tags.shop === 'insurance') return 'SOAT/Seguros';
       if (tags.amenity === 'townhall' || tags.office === 'government') return 'Oficina Gubernamental';
       return 'Centro de Servicio';
   }

   function calcularDistancia(lat1, lng1, lat2, lng2) {
       const R = 6371;
       const dLat = (lat2 - lat1) * Math.PI / 180;
       const dLng = (lng2 - lng1) * Math.PI / 180;
       const a = Math.sin(dLat/2) * Math.sin(dLat/2) +
               Math.cos(lat1 * Math.PI / 180) * Math.cos(lat2 * Math.PI / 180) *
               Math.sin(dLng/2) * Math.sin(dLng/2);
       const c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1-a));
       return R * c;
   }

   function limpiarMarcadores() {
       marcadoresCentros.forEach(marcador => mapa.removeLayer(marcador));
       marcadoresCentros = [];
   }

   function mostrarMensajeCarga() {
       document.getElementById('resultadosCentros').innerHTML = `
           <div class="text-center text-gray-500 py-8">
               <i class="fas fa-spinner fa-spin text-3xl mb-2"></i>
               <p>Buscando centros cercanos...</p>
           </div>
       `;
   }

   function mostrarError(mensaje) {
       document.getElementById('resultadosCentros').innerHTML = `
           <div class="text-center text-red-500 py-8">
               <i class="fas fa-exclamation-triangle text-3xl mb-2"></i>
               <p>${mensaje}</p>
           </div>
       `;
   }

   function mostrarCentrosEnMapa(centros) {
       limpiarMarcadores();

       centros.forEach(centro => {
           const icono = obtenerIcono(centro.tipo);
           const marcador = L.marker([centro.lat, centro.lng], { icon: icono })
               .addTo(mapa)
               .bindPopup(`
                   <div class="p-2">
                       <h4 class="font-bold text-sm">${centro.nombre}</h4>
                       <p class="text-xs text-gray-600 mt-1">${centro.direccion}</p>
                       <p class="text-xs text-gray-600">${centro.telefono}</p>
                       <p class="text-xs text-blue-600 mt-1">${centro.horario}</p>
                       <p class="text-xs text-green-600 font-medium">📍 ${centro.distancia.toFixed(1)} km</p>
                       ${centro.sitio_web ? `<a href="${centro.sitio_web}" target="_blank" class="text-xs text-blue-500">🌐 Sitio web</a>` : ''}
                   </div>
               `);
           
           marcadoresCentros.push(marcador);
       });
   }

   function obtenerIcono(tipo) {
       const iconos = {
           'Taller/CDA': '🔧',
           'SOAT/Seguros': '🛡️',
           'Oficina Gubernamental': '🏛️',
           'Centro de Servicio': '📍'
       };
       
       return L.divIcon({
           html: `<div style="background: white; border: 2px solid #0891b2; border-radius: 50%; width: 30px; height: 30px; display: flex; align-items: center; justify-content: center; font-size: 14px;">${iconos[tipo] || '📍'}</div>`,
           iconSize: [30, 30],
           iconAnchor: [15, 15]
       });
   }

   function mostrarListaCentros(centros) {
       const contenedor = document.getElementById('resultadosCentros');
       
       if (centros.length === 0) {
           contenedor.innerHTML = `
               <div class="text-center text-gray-500 py-8">
                   <i class="fas fa-search text-3xl mb-2"></i>
                   <p>No se encontraron centros en el radio especificado</p>
                   <p class="text-sm">Prueba aumentando el radio de búsqueda</p>
               </div>
           `;
           return;
       }

       contenedor.innerHTML = centros.map(centro => `
           <div class="border border-gray-200 rounded-lg p-4 hover:border-primary-300 transition-colors cursor-pointer"
                onclick="centrarEnCentro(${centro.lat}, ${centro.lng})">
               <div class="flex justify-between items-start mb-2">
                   <h4 class="font-semibold text-gray-900 text-sm">${centro.nombre}</h4>
                   <span class="bg-green-100 text-green-800 text-xs px-2 py-1 rounded-full">${centro.distancia.toFixed(1)} km</span>
               </div>
               <p class="text-xs text-gray-600 mb-1">📍 ${centro.direccion}</p>
               <p class="text-xs text-gray-600 mb-1">📞 ${centro.telefono}</p>
               <p class="text-xs text-blue-600 mb-2">🕒 ${centro.horario}</p>
               <div class="flex flex-wrap gap-1">
                   <span class="bg-blue-100 text-blue-800 text-xs px-2 py-1 rounded">${centro.tipo}</span>
                   ${centro.sitio_web ? '<span class="bg-green-100 text-green-800 text-xs px-2 py-1 rounded">Sitio web</span>' : ''}
               </div>
           </div>
       `).join('');
   }

   function centrarEnCentro(lat, lng) {
       mapa.setView([lat, lng], 16);
   }

   document.getElementById('obtenerUbicacion').addEventListener('click', obtenerUbicacion);
   document.getElementById('buscarDireccion').addEventListener('click', buscarPorDireccion);
   document.getElementById('radioBusqueda').addEventListener('change', () => {
       if (ubicacionUsuario) buscarCentrosCercanos();
   });
   document.getElementById('tipoServicio').addEventListener('change', () => {
       if (ubicacionUsuario) buscarCentrosCercanos();
   });

   document.getElementById('direccionBusqueda').addEventListener('keypress', function(e) {
       if (e.key === 'Enter') {
           buscarPorDireccion();
       }
   });

   document.addEventListener('DOMContentLoaded', function() {
       inicializarMapa();
   });
</script>