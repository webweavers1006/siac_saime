<?php
$session = session();
$userdata = $session->get();




?>





<style>
  /* CSS Variables - Sistema Colores */
  :root {
    --rojo-cierre: #ef4444;
    --rojo-badge: linear-gradient(135deg, #ef4444, #dc2626);
    --verde-seguimiento: #10b981;
    --verde-leida: #28a745;
    --azul-remision: #007bff;
    --azul-sistema: #1e3a5f;
    --azul-primario: #1d4ed8;
    --gris-leida: #6c757d;
  }

  .text-highlight {
    font-weight: bold;
    color: #003366;
    background-color: #e7f3ff;
    padding: 2px 5px;
    border-radius: 3px;
  }

  /* Badge Principal Navbar - ROJO Gradient */
  .notification-badge {
    background: var(--rojo-badge);
    color: white;
    border-radius: 50%;
    box-shadow: 0 2px 8px rgba(239, 68, 68, 0.4);
    min-width: 20px;
    height: 20px;
    font-size: 11px;
    font-weight: bold;
    display: flex;
    align-items: center;
    justify-content: center;
    position: absolute;
    top: -5px;
    right: -5px;
  }

  /* Círculo Tipo 48x48px */
  .type-circle {
    width: 48px;
    height: 48px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 20px;
    color: white;
    flex-shrink: 0;
    margin-right: 10px;
    box-shadow: 0 2px 8px rgba(0,0,0,0.15);
  }
  .type-circle.remision { background: var(--azul-remision); }
  .type-circle.seguimiento { background: var(--verde-seguimiento); }
  .type-circle.cierre { background: var(--rojo-cierre); }

  /* Badge NUEVA/LEÍDA */
  .status-badge {
    padding: 2px 8px;
    font-size: 10px;
    border-radius: 12px;
    font-weight: bold;
    margin-left: 8px;
  }
  .status-nueva {
    background: rgba(0, 123, 255, 0.12);
    color: var(--azul-remision);
  }
  .status-leida {
    background: rgba(255, 193, 7, 0.2);
    color: #f59e0b;
  }

  /* Items mejorados */
  .notification-item.unread {
    background: linear-gradient(135deg, #fafbfc 0%, white 100%);
    border-left: 4px solid var(--type-color, var(--azul-remision));
  }
  .notification-item.read {
    background: #f8f9fa;
    border-left: 4px solid var(--verde-leida);
    opacity: 0.85;
  }
  .notification-item p {
    line-height: 1.5;
    margin-bottom: 5px;
  }
  .notification-item {
    padding: 14px 16px;
    border-bottom: 1px solid #e9ecef;
    transition: all 0.2s ease;
    cursor: pointer;
  }
  .notification-item:hover {
    background-color: #f8f9fa;
  }
  .notification-item.unread {
    background-color: #e8f4fd;
    border-left: 4px solid #007bff;
  }
  .notification-item h6 {
    margin-bottom: 6px;
    font-size: 13px;
  }
  .notification-item .time {
    font-size: 11px;
    color: #6c757d;
    margin-top: 6px;
  }
  .notification-item .notif-message {
    font-size: 13px;
    color: #333;
    line-height: 1.4;
  }
  .notification-item .notif-message strong {
    color: #007bff;
    font-weight: 600;
  }
  .notification-badge {
    background-color: #dc3545;
    color: white;
    border-radius: 50%;
    padding: 3px 7px;
    font-size: 11px;
    position: absolute;
    top: -5px;
    right: -5px;
    font-weight: bold;
    box-shadow: 0 2px 4px rgba(0,0,0,0.2);
  }
  .notification-icon {
    position: relative;
    padding: 10px 14px;
  }
  .notification-icon i {
    font-size: 22px;
    color: #6c757d;
    transition: color 0.3s ease;
  }
  .notification-icon:hover i {
    color: #007bff;
  }
  .notification-icon.has-notifications i {
    color: #007bff;
  }
  .notification-menu {
    position: absolute;
    right: 0;
    top: 100%;
    width: 420px;
    max-height: 70vh;
    background: white;
    border-radius: 12px;
    box-shadow: 0 8px 30px rgba(0,0,0,0.2);
    z-index: 1000;
    overflow: hidden;
    display: flex;
    flex-direction: column;
  }
  .notification-menu .dropdown-header {
    background: linear-gradient(135deg, #007bff 0%, #0056b3 100%);
    color: white;
    padding: 16px 18px;
  }
  .notif-negrilla-azul {
    font-weight: bold !important;
    color: #003366 !important;
  }
  #notification-list .notif-negrilla-azul {
    font-weight: bold !important;
    color: #003366 !important;
  }
  .notification-item .notif-message .notif-negrilla-azul {
    font-weight: bold !important;
    color: #003366 !important;
  }
  /* Estilos para botones de filtro de notificaciones */
  .notification-filters {
    display: flex;
    gap: 8px;
    padding: 12px 15px;
    border-bottom: 1px solid #dee2e6;
    background: #f8f9fa;
  }
  .notification-filter-btn {
    flex: 1;
    padding: 8px 12px;
    font-size: 12px;
    border: 1px solid #007bff;
    border-radius: 20px;
    background: white;
    color: #007bff;
    cursor: pointer;
    transition: all 0.2s ease;
    text-align: center;
    font-weight: 500;
  }
  .notification-filter-btn:hover {
    background: #e8f4fd;
  }
  .notification-filter-btn.active {
    background: linear-gradient(135deg, #007bff 0%, #0056b3 100%);
    color: white;
    border-color: transparent;
  }
  /* Estilo para notificaciones leídas */
  .notification-item.read {
    background-color: #fafbfc;
    opacity: 0.8;
  }
  .notification-item.read:hover {
    background-color: #f1f3f4;
  }
  /* Indicador de leída */
  .leida-indicator {
    display: inline-block;
    width: 8px;
    height: 8px;
    border-radius: 50%;
    margin-right: 8px;
  }
  /* Legacy leida-indicator (fallback) */
  .notification-item.unread .leida-indicator {
    background-color: var(--azul-remision);
  }
  .notification-item.read .leida-indicator {
    background-color: var(--verde-leida);
  }
  /* Estilos de paginación */
  .notification-pagination {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 12px 15px;
    border-top: 1px solid #e9ecef;
    background: #fafbfc;
  }
  .pagination-info {
    font-size: 12px;
    color: #6c757d;
  }
  .pagination-controls {
    display: flex;
    gap: 6px;
  }
  .pagination-btn {
    padding: 5px 10px;
    border: 1px solid #dee2e6;
    background: white;
    border-radius: 6px;
    font-size: 12px;
    cursor: pointer;
    transition: all 0.2s ease;
    color: #007bff;
  }
  .pagination-btn:hover:not(:disabled) {
    background: #007bff;
    color: white;
    border-color: #007bff;
  }
  .pagination-btn:disabled {
    opacity: 0.5;
    cursor: not-allowed;
  }
  .pagination-btn.active {
    background: #007bff;
    color: white;
    border-color: #007bff;
  }
  /* Estilos empty state */
  .empty-notifications {
    text-align: center;
    padding: 40px 20px;
    color: #6c757d;
  }
  .empty-notifications i {
    font-size: 48px;
    margin-bottom: 15px;
    opacity: 0.5;
  }
  .empty-notifications p {
    margin: 0;
    font-size: 14px;
  }
  /* Scrollbar personalizado */
  #notification-list::-webkit-scrollbar {
    width: 6px;
  }
  #notification-list::-webkit-scrollbar-track {
    background: #f1f1f1;
  }
  #notification-list::-webkit-scrollbar-thumb {
    background: #c1c1c1;
    border-radius: 3px;
  }
  #notification-list::-webkit-scrollbar-thumb:hover {
    background: #a1a1a1;
  }
  #notification-list {
    flex: 1;
    overflow-y: auto;
  }
  
  /* Ocultar notificaciones para roles bloqueados */
  .notification-hidden {
    display: none !important;
  }
</style>
<meta charset="utf-8">
<link rel="stylesheet" href="<?php echo base_url(); ?>/css_paginas/navar.css">
<!-- SweetAlert2 para alertas emergentes (local) -->
<script src="<?php echo base_url(); ?>/theme/plugins/sweetalert2/sweetalert2.min.js"></script>
<!-- FontAwesome para iconos (local) -->
<link rel="stylesheet" href="<?php echo base_url(); ?>/theme/plugins/fontawesome-free/css/all.min.css">

<body class="hold-transition sidebar-mini layout-fixed">
  <div class="wrapper">
  <nav class="main-header navbar navbar-expand-lg navbar-white navbar-light" style="display: flex; align-items: center; justify-content: space-between; padding: 5px 15px;">
  
  <!-- Lado izquierdo: Menú hamburguesa -->
  <ul class="navbar-nav" style="margin-right: 10px;">
    <li class="nav-item">
      <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
    </li>
  </ul>
  
<!-- Cintillo más ancho (COMENTADO) -->
  <!-- <div class="cintillo-container" style="display: flex; justify-content: center; align-items: center; width: 100%; max-width: 100%; margin: 0 20px;">
    <img src="<?= base_url((new \Config\Assets())->cintillo) ?>" 
         alt="Cintillo Institucional" 
         style="width: 100%; max-width: 100%; height: auto; max-height: 100px; object-fit: contain;">
</div> -->
  
  <!-- Lado derecho: Notificaciones + Salir -->
  <div style="display: flex; align-items: center;">
    <?php 
    $rol_bloqueado = in_array($session->get('userrol'), [4, 6, 9]);
    $usuario_bloqueado = in_array($session->get('iduser'), [47]);
    ?>
    <?php if (!$rol_bloqueado && !$usuario_bloqueado): ?>
    <!-- Bandeja de Notificaciones -->
    <div class="notification-dropdown" style="margin-right: 25px;" id="notification-dropdown-container">
      <div class="notification-icon" onclick="toggleNotifications()" title="Notificaciones">
        <i class="fas fa-bell"></i>
        <span class="notification-badge" id="notification-count" style="display: none;">0</span>
      </div>
<div class="notification-menu dropdown-menu-end" id="notification-menu" style="display: none;">
        <div style="padding: 16px 18px; border-bottom: 1px solid #dee2e6; background: linear-gradient(135deg, #007bff 0%, #0056b3 100%); color: white; border-radius: 12px 12px 0 0;">
          <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 12px;">
            <strong style="font-size: 16px;"><i class="fas fa-bell mr-2"></i>Notificaciones</strong>
            <a href="#" onclick="marcarTodasLeidas(); return false;" style="font-size: 12px; color: #fff; background: rgba(255,255,255,0.2); padding: 6px 12px; border-radius: 20px; text-decoration: none;">Marcar todas como leídas</a>
          </div>
          <!-- Botones de filtro -->
          <div class="notification-filters">
            <button class="notification-filter-btn active" id="filter-unread" onclick="filtrarNotificaciones('unread')">
              <i class="fas fa-envelope"></i> No leídas
            </button>
            <button class="notification-filter-btn" id="filter-all" onclick="filtrarNotificaciones('all')">
              <i class="fas fa-inbox"></i> Todas
            </button>
          </div>
        </div>
        <!-- Contenedor scrollable para notificaciones -->
        <div id="notification-list" style="flex: 1; overflow-y: auto; max-height: 45vh;">
          <!-- Las notificaciones se cargarán aquí -->
          <div class="empty-notifications">
            <i class="fas fa-bell-slash"></i>
            <p>No hay notificaciones</p>
          </div>
        </div>
        <!-- Barra de paginación -->
        <div class="notification-pagination" id="notification-pagination" style="display: none;">
          <div class="pagination-info" id="pagination-info"></div>
          <div class="pagination-controls" id="pagination-controls"></div>
        </div>
      </div>
    </div>
    <?php endif; ?>
    
    <!-- Salir siempre visible, sin collapse -->
    <ul class="navbar-nav align-items-center">
      <li class="nav-item d-none d-sm-block">
        <h5><a href="#Foo" onclick="cerrarSesion();" style="color: black;" class="nav-primary">Salir</a></h5>
      </li>
    </ul>
  </div>
</nav>
  <script>
    // Variables globales
    let notificationsOpen = false;
    let currentFilter = 'unread'; // 'unread' o 'all'
    let currentPage = 1;
    let notificationsData = [];
    let paginationData = null;
    
    // Roles que NO deben ver notificaciones (pasados desde PHP)
    const rolesBloqueados = <?php echo json_encode([4, 6, 9]); ?>;
    const usuariosBloqueados = <?php echo json_encode([47]); ?>;
    const userRol = <?php echo json_encode($session->get('userrol') ?? 0); ?>;
    const userId = <?php echo json_encode($session->get('iduser') ?? 0); ?>;
    
    // Verificar si el rol O usuario está bloqueado
    const rolBloqueado = rolesBloqueados.includes(userRol);
    const usuarioBloqueado = usuariosBloqueados.includes(userId);
    
    // OCULTAR ícono de notificaciones para roles/usuarios bloqueados (doble seguridad)
    if (rolBloqueado || usuarioBloqueado) {
      const dropdownContainer = document.getElementById('notification-dropdown-container');
      if (dropdownContainer) {
        dropdownContainer.classList.add('notification-hidden');
      }
    }

    // Función para mostrar/ocultar notificaciones
    function toggleNotifications() {
      const menu = document.getElementById('notification-menu');
      if (menu.style.display === 'none' || menu.style.display === '') {
        menu.style.display = 'block';
        // Forzar scroll al inicio del menú en móviles para asegurar visibilidad
        if (window.innerWidth < 768) {
          window.scrollTo(0, 0); 
        }
        notificationsOpen = true;
        currentPage = 1; // Resetear a primera página
        cargarNotificaciones();
      } else {
        menu.style.display = 'none';
        notificationsOpen = false;
      }
    }

    // Cerrar dropdown al hacer click fuera
    document.addEventListener('click', function(event) {
      const dropdown = document.querySelector('.notification-dropdown');
      const menu = document.getElementById('notification-menu');
      if (dropdown && !dropdown.contains(event.target)) {
        menu.style.display = 'none';
        notificationsOpen = false;
      }
    });

    // Cargar notificaciones según el filtro actual
    function cargarNotificaciones() {
      const endpoint = currentFilter === 'all' 
        ? '<?php echo base_url(); ?>/notificaciones/obtenerTodasMisNotificaciones'
        : '<?php echo base_url(); ?>/notificaciones/obtenerMisNotificaciones';
      
      // Agregar parámetros de paginación
      const url = endpoint + '?pagina=' + currentPage + '&por_pagina=10';
      
      fetch(url, {
        method: 'GET',
        headers: {
          'X-Requested-With': 'XMLHttpRequest'
        }
      })
      .then(response => {
        if (!response.ok) {
          throw new Error('Network response was not ok');
        }
        return response.text();
      })
      .then(text => {
        try {
          const data = JSON.parse(text);
          if (data.message === 'success') {
            // Si hay datos de paginación, guardarlos
            if (data.pagination) {
              paginationData = data.pagination;
            } else {
              paginationData = null;
            }
            
            // Determinar qué datos usar
            const notificaciones = data.data || data || [];
            notificationsData = notificaciones;
            
            renderNotificaciones(notificaciones);
            actualizarContador();
            actualizarPaginacion();
          }
        } catch (e) {
          console.error('Error parsing JSON:', e);
          console.log('Raw response:', text);
        }
      })
      .catch(error => console.error('Error:', error));
    }

    // Filtrar notificaciones
    function filtrarNotificaciones(filtro) {
      currentFilter = filtro;
      currentPage = 1; // Resetear a primera página
      
      // Actualizar estilos de botones
      document.getElementById('filter-unread').classList.toggle('active', filtro === 'unread');
      document.getElementById('filter-all').classList.toggle('active', filtro === 'all');
      
      // Recargar notificaciones según el filtro
      cargarNotificaciones();
    }

    // Cambiar página
    function cambiarPagina(pagina) {
      if (pagina < 1 || (paginationData && pagina > paginationData.total_paginas)) return;
      
      currentPage = pagina;
      cargarNotificaciones();
      
      // Scroll al inicio de la lista
      const container = document.getElementById('notification-list');
      container.scrollTop = 0;
    }

    // Actualizar controles de paginación - CORREGIDO
    function actualizarPaginacion() {
      const paginationEl = document.getElementById('pagination-controls');
      const infoEl = document.getElementById('pagination-info');
      const container = document.getElementById('notification-pagination');
      
      // Ocultar si NO hay datos de paginación O si no hay notificaciones que mostrar
      if (!paginationData || !paginationData.total || notificationsData.length === 0) {
        container.style.display = 'none';
        paginationData = null; // Resetear para evitar persistencia
        return;
      }
      
      // Mostrar el contenedor si hay notificaciones
      container.style.display = 'flex';
      
      const { total, pagina, por_pagina, total_paginas } = paginationData;
      
      // Info de paginación
      const inicio = Math.min((pagina - 1) * por_pagina + 1, total);
      const fin = Math.min(pagina * por_pagina, total);
      infoEl.innerHTML = `<span>${inicio}-${fin} de ${total}</span>`;
      
      // Controles de paginación
      let controlsHTML = `
        <button class="pagination-btn" onclick="cambiarPagina(${pagina - 1})" ${pagina === 1 ? 'disabled' : ''}>
          <i class="fas fa-chevron-left"></i>
        </button>
      `;
      
      // Mostrar páginas cercanas
      const paginasAMostrar = [];
      for (let i = Math.max(1, pagina - 2); i <= Math.min(total_paginas, pagina + 2); i++) {
        paginasAMostrar.push(i);
      }
      
      // Primera página si no está en el rango
      if (paginasAMostrar[0] > 1) {
        controlsHTML += `<button class="pagination-btn" onclick="cambiarPagina(1)">1</button>`;
        if (paginasAMostrar[0] > 2) {
          controlsHTML += `<span style="padding: 5px; color: #6c757d;">...</span>`;
        }
      }
      
      // Páginas del rango
      paginasAMostrar.forEach(p => {
        controlsHTML += `
          <button class="pagination-btn ${p === pagina ? 'active' : ''}" onclick="cambiarPagina(${p})">
            ${p}
          </button>
        `;
      });
      
      // Última página si no está en el rango
      if (paginasAMostrar[ paginasAMostrar.length - 1 ] < total_paginas) {
        if (paginasAMostrar[ paginasAMostrar.length - 1 ] < total_paginas - 1) {
          controlsHTML += `<span style="padding: 5px; color: #6c757d;">...</span>`;
        }
        controlsHTML += `<button class="pagination-btn" onclick="cambiarPagina(${total_paginas})">${total_paginas}</button>`;
      }
      
      controlsHTML += `
        <button class="pagination-btn" onclick="cambiarPagina(${pagina + 1})" ${pagina >= total_paginas ? 'disabled' : ''}>
          <i class="fas fa-chevron-right"></i>
        </button>
      `;
      
      paginationEl.innerHTML = controlsHTML;
    }

    // Renderizar notificaciones en el dropdown
    function renderNotificaciones(notificaciones) {
      const container = document.getElementById('notification-list');
      const paginationContainer = document.getElementById('notification-pagination');
      
      // Debug: mostrar en consola lo que llega del servidor
      console.log('Notificaciones recibidas:', notificaciones);
      console.log('Filtro actual:', currentFilter);
      
      if (!notificaciones || notificaciones.length === 0) {
        container.innerHTML = `
          <div class="empty-notifications">
            <i class="fas fa-bell-slash"></i>
            <p>${currentFilter === 'all' ? 'No hay notificaciones registradas' : 'No hay notificaciones sin leer'}</p>
          </div>
        `;
        // Ocultar paginador si no hay notificaciones
        paginationContainer.style.display = 'none';
        paginationData = null;
        return;
      }

      let html = '';
      notificaciones.forEach(notif => {
        // Determinar si está leída
        const estaLeida = notif.leida === true || notif.leida === 't' || notif.leida === 'true';
        
        // Si el filtro es 'unread', solo mostrar no leídas
        if (currentFilter === 'unread' && estaLeida) {
          return;
        }
        
        // Tipo-specific: circle color/icon (overrides leida-indicator)
        const tipoConfig = {
          'REMISION': { icon: 'fa-file-import', color: 'var(--azul-remision)' },
          'SEGUIMIENTO': { icon: 'fa-tasks', color: 'var(--verde-seguimiento)' },
          'CIERRE': { icon: 'fa-check-circle', color: 'var(--rojo-cierre)' }
        };
        const config = tipoConfig[notif.tipo_notificacion] || { icon: 'fa-bell', color: '#6c757d' };
        
        const tipoClass = notif.tipo_notificacion === 'REMISION' ? 'text-primary' : 
                         (notif.tipo_notificacion === 'CIERRE' ? 'text-danger' : 'text-warning');
        
        // Construir mensaje completo con dirección origen si existe
        let mensajeCompleto = notif.mensaje;
        
        // Si la dirección origen viene en un campo separado, agregarla al mensaje
        if (notif.direccion_origen_nombre && !mensajeCompleto.includes('Remitido por:') && !mensajeCompleto.includes('Agregado por:') && !mensajeCompleto.includes('Actualizado por:')) {
          if (notif.tipo_notificacion === 'REMISION') {
            mensajeCompleto += '. Remitido por: <span class="notif-negrilla-azul">' + notif.direccion_origen_nombre + '</span>';
          } else if (notif.tipo_notificacion === 'SEGUIMIENTO') {
            mensajeCompleto += '. Agregado por: <span class="notif-negrilla-azul">' + notif.direccion_origen_nombre + '</span>';
          }
        }
        
        // Aplicar estilo a los nombres de dirección que ya vienen en el mensaje
        mensajeCompleto = mensajeCompleto.replace(/(Remitido por:\s*)([^<\.]+)/g, '$1<span class="notif-negrilla-azul">$2</span>');
        mensajeCompleto = mensajeCompleto.replace(/(Agregado por:\s*)([^<\.]+)/g, '$1<span class="notif-negrilla-azul">$2</span>');
        mensajeCompleto = mensajeCompleto.replace(/(Actualizado por:\s*)([^<\.]+)/g, '$1<span class="notif-negrilla-azul">$2</span>');
        
        // Determinar clase según estado de lectura
        const leidaClass = estaLeida ? 'read' : 'unread';
        const statusBadge = estaLeida ? 
          '<span class="status-badge status-leida">LEÍDA</span>' : 
          `<span class="status-badge status-nueva" style="--type-color: ${config.color}">NUEVA</span>`;
        
        // Legacy leidaIcon fallback
        const leidaIcon = estaLeida ? '<i class="fas fa-check" style="color: var(--verde-leida); margin-left: 5px;"></i>' : '';
        
        html += `
          <div class="notification-item ${leidaClass}" 
               onclick="verNotificacion(${notif.id}, '${notif.tipo_notificacion}', ${notif.id_caso})">
            <h6 style="display: flex; align-items: center;">
              <div class="type-circle ${notif.tipo_notificacion.toLowerCase()}" style="--type-color: ${config.color}">
                <i class="fas ${config.icon}"></i>
              </div>
              <span class="notif-negrilla-azul">${notif.tipo_notificacion}</span>
              ${statusBadge}${leidaIcon}
            </h6>
            <p class="notif-message">${mensajeCompleto}</p>
            <div class="time">${formatDate(notif.fecha_creacion)}</div>
          </div>
        `;
      });
      
      if (html === '') {
        container.innerHTML = `
          <div class="empty-notifications">
            <i class="fas fa-bell-slash"></i>
            <p>${currentFilter === 'all' ? 'No hay notificaciones registradas' : 'No hay notificaciones sin leer'}</p>
          </div>
        `;
        // Ocultar paginador si no hay notificaciones que mostrar
        paginationContainer.style.display = 'none';
        paginationData = null;
      } else {
        container.innerHTML = html;
      }
    }

    // Actualizar contador de notificaciones
    function actualizarContador() {
      // No ejecutar si el rol está bloqueado
      if (rolBloqueado) {
        return;
      }
      
      fetch('<?php echo base_url(); ?>/notificaciones/contarNotificaciones', {
        method: 'GET',
        headers: {
          'X-Requested-With': 'XMLHttpRequest'
        }
      })
      .then(response => response.json())
      .then(data => {
        const badge = document.getElementById('notification-count');
        const icon = document.querySelector('.notification-icon');
        
        if (data.total > 0) {
          badge.textContent = data.total;
          badge.style.display = 'block';
          // Agregar clase para resaltar la campanita
          icon.classList.add('has-notifications');
        } else {
          badge.style.display = 'none';
          // Quitar clase cuando no hay notificaciones
          icon.classList.remove('has-notifications');
        }
      })
      .catch(error => console.error('Error:', error));
    }

    // Ver notificación y redirigir - CORREGIDO
    function verNotificacion(id, tipo, idCaso) {
      // Cerrar dropdown inmediatamente para mejor UX
      document.getElementById('notification-menu').style.display = 'none';
      notificationsOpen = false;
      
      // Marcar como leída en segundo plano (sin esperar respuesta)
      fetch('<?php echo base_url(); ?>/notificaciones/marcarLeida', {
        method: 'POST',
        headers: {
          'Content-Type': 'application/x-www-form-urlencoded',
          'X-Requested-With': 'XMLHttpRequest'
        },
        body: 'data=' + btoa(JSON.stringify({ id_notificacion: id }))
      }).catch(error => {
        console.warn('Error al marcar como leída:', error);
      });
      
      // Actualizar contador
      actualizarContador();
      
      // Redirigir según el tipo de notificación
      if (tipo === 'REMISION' || tipo === 'SEGUIMIENTO') {
        window.location.href = '<?php echo base_url(); ?>/verCaso/' + idCaso;
      }
      // Para CIERRE u otros tipos, no redirigimos (o puedes agregar lógica específica)
    }

    // Marcar todas como leídas
    function marcarTodasLeidas() {
      // Obtener token CSRF
      const csrfToken = document.querySelector('input[name="<?php echo csrf_token(); ?>"]')?.value || '<?php echo csrf_hash(); ?>';
      
      const formData = new FormData();
      formData.append('<?php echo csrf_token(); ?>', csrfToken);
      
      fetch('<?php echo base_url(); ?>/notificaciones/marcarTodasLeidas', {
        method: 'POST',
        headers: {
          'X-Requested-With': 'XMLHttpRequest'
        },
        body: formData
      })
      .then(response => response.json())
      .then(data => {
        console.log('Respuesta:', data);
        if (data.message === 'success' || data.message.indexOf('marcadas como leídas') !== -1) {
          // Limpiar el dropdown inmediatamente
          document.getElementById('notification-list').innerHTML = `
            <div class="empty-notifications">
              <i class="fas fa-bell-slash"></i>
              <p>No hay notificaciones</p>
            </div>
          `;
          // Ocultar el badge
          document.getElementById('notification-count').style.display = 'none';
          // Ocultar el menú
          document.getElementById('notification-menu').style.display = 'none';
          notificationsOpen = false;
        }
      })
      .catch(error => console.error('Error:', error));
    }

    // Formatear fecha
    function formatDate(dateString) {
      const date = new Date(dateString);
      const now = new Date();
      const diff = now - date;
      
      // Menos de 1 minuto
      if (diff < 60000) {
        return 'Hace un momento';
      }
      // Menos de 1 hora
      if (diff < 3600000) {
        const minutes = Math.floor(diff / 60000);
        return 'Hace ' + minutes + ' minutos';
      }
      // Menos de 24 horas
      if (diff < 86400000) {
        const hours = Math.floor(diff / 3600000);
        return 'Hace ' + hours + ' horas';
      }
      // Más de 24 horas
      return date.toLocaleDateString('es-VE', { 
        day: '2-digit', 
        month: '2-digit', 
        year: 'numeric',
        hour: '2-digit',
        minute: '2-digit'
      });
    }

    // Mostrar notificaciones al inicio (directamente el dropdown)
    function mostrarAlertaNotificaciones() {
      // Verificar si estamos en las páginas de inicio permitidas
      const rutaActual = window.location.pathname;
      const esPaginaInicio = rutaActual.includes('/pantalla_bienvenida') || rutaActual.includes('/inicio') || rutaActual === '/' || rutaActual === '/siac_v2';
      
      // No mostrar automáticamente si el rol está bloqueado
      if (rolBloqueado) {
        return;
      }
      
      // Solo mostrar automáticamente en las páginas de inicio
      if (!esPaginaInicio) {
        return;
      }
      
      fetch('<?php echo base_url(); ?>/notificaciones/contarNotificaciones', {
        method: 'GET',
        headers: {
          'X-Requested-With': 'XMLHttpRequest'
        }
      })
      .then(response => response.json())
      .then(data => {
        if (data.total > 0) {
          // Hay notificaciones, mostrar directamente el dropdown
          document.getElementById('notification-menu').style.display = 'block';
          notificationsOpen = true;
          cargarNotificaciones();
        }
      })
      .catch(error => console.error('Error:', error));
    }

    // Ejecutar al cargar la página
    document.addEventListener('DOMContentLoaded', function() {
      // Solo ejecutar si el rol NO está bloqueado
      if (!rolBloqueado) {
        // Actualizar contador inmediatamente al cargar
        actualizarContador();
        
        // Actualizar contador cada 30 segundos
        setInterval(actualizarContador, 30000);
        
        // Verificar notificaciones para mostrar alerta automáticamente (solo una vez)
        setTimeout(mostrarAlertaNotificaciones, 1000);
      }
    });

    function cerrarSesion() {
      Swal.fire({
        title: '¿Deseas salir?',
        text: 'Estás a punto de abandonar la página.',
        icon: 'question',
        showCancelButton: true,
        confirmButtonText: 'Sí',
        cancelButtonText: 'No'
      }).then((result) => {
       
        if (result.value) {
          // Aquí puedes agregar la lógica para salir de la página
          window.location.href = '/';
        }
      });
    }
  </script>
</nav>
    <aside class="main-sidebar   sidebar-dark-light elevation-4" id="aside" data-toggle="collapse">
      <!-- Brand Logo -->
      <a href="#" class="brand-link">
        <span class="brand-text font-weight-light"> SIAC </span>
        <img src="<?= base_url((new \Config\Assets())->brandLogo) ?>"  class="brand-image" style="opacity: .8; float: left; box-shadow: none; width: 35px;" onclick="return false;">
      </a>
      <!-- Sidebar -->
      <div class="sidebar">
        <!-- Sidebar user panel (optional) -->
          <div class="info" style="text-align: center;">
            <a href="#" class="d-block">
              <h6><?= session('nombre'); ?></h6>
              <h7><?= session('usercargo'); ?></h7>    
            </a>
          </div>
<br>
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu1">
          


        
        <li class="nav-item ">
            <a href="<?php echo base_url(); ?>/pantalla_bienvenida" class="nav-link active"><i class="nav-icon fas fa-tachometer-alt"></i>
              <p>Inicio </p>
            </a>
          </li>

          
          <?php if ($session->get('userrol') == 1 or $session->get('userrol') == 5) { ?>
            <li class="nav-item">
              <a href="<?php echo base_url(); ?>/adminUsers" class="nav-link" id="casos"><i class="nav-icon fas fa-user-circle " id="menu_citas"></i>
                <p>Gestión </p>
                <i class="right fas fa-angle-left"></i>
              </a>
              <ul class="nav nav-treeview">
                <li class="nav-item">
                  <a href="<?php echo base_url(); ?>/adminUsers" class="nav-link">
                    <i class="nav-icon 	fas fa-address-card" style='font-size:20px'></i>
                    <p>Operadores</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="<?php echo base_url(); ?>/vista_roles" class="nav-link">
                    <i class="nav-icon 	fas fa-address-card" style='font-size:20px'></i>
                    <p>Roles</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="<?php echo base_url(); ?>/vista_direcciones_admin" class="nav-link">
                    <i class="nav-icon 	 fa fa-book" style='font-size:20px'></i>
                    <p>Direcciones </p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="<?php echo base_url(); ?>/auditoria_sistema" class="nav-link">
                    <i class="nav-icon 	fas  fa-users" style='font-size:20px'></i>
                    <p>Auditoría</p>
                  </a>
                </li>
              </ul>
            </li>
          <?php } ?>
          
          <?php if ($session->get('userrol') == 1 OR $session->get('userrol') == 2 OR $session->get('userrol') == 3 OR $session->get('userrol') == 4 OR $session->get('userrol') == 5 ) { ?>
          <li class="nav-item">
            <a href="<?php echo base_url(); ?>/casos" class="nav-link" id="casos"><i class="nav-icon fas fa-folder " id="menu_citas"></i>
              <p>Casos</p>
            </a>
          </li>
          <?php } ?>

          <?php if ($session->get('userrol') == 1 or $session->get('userrol') == 3 or $session->get('userrol') == 4  or $session->get('userrol') == 5 or $session->get('userrol') == 6) { ?>
          <li class="nav-item">
            <a href="#" class="nav-link" id=""><i class="nav-icon fas fa-folder-open "></i>
              <p> Reportes</p>
              <i class="right fas fa-angle-left"></i>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="<?php echo base_url(); ?>/consolidado" class="nav-link">
                  <i class="nav-icon 	 fa fa-book" style='font-size:20px'></i>
                  <p>Consolidado</p>
                </a>
              </li>
              


              <?php if ($session->get('userrol') == 1 or $session->get('userrol') == 3 or $session->get('userrol') == 5 or $session->get('userrol') == 6) { ?>
                <li class="nav-item">
                  <a href="<?php echo base_url(); ?>/operador" class="nav-link">
                    <i class="nav-icon 	fas  fa-users" style='font-size:20px'></i>
                    <p>Analista</p>
                  </a>
                </li>
                
                
                <li class="nav-item">
                  <a href="<?php echo base_url(); ?>/Talleres_Participantes" class="nav-link">
                    <i class="nav-icon 	fas  fa-users" style='font-size:20px'></i>
                    <p>Talleres Participantes</p>
                  </a>
                </li>
              <?php } ?>

              <!-- <php if ($session->get('userrol') == 1 or $session->get('userrol') == 3 or $session->get('userrol') == 5) { ?>
                <li class="nav-item">
                  <a href="<php echo base_url(); ?>/atencion" class="nav-link">
                    <i class="nav-icon 	fas  fa-users" style='font-size:20px'></i>
                    <p>Atencion</p>
                  </a>
                </li>
              <php } ?> -->
             
            </ul>
          </li>
          <?php } ?>
          
          <?php if (in_array($session->get('userrol'), [1, 3, 5, 6])): ?>
  <li class="nav-item">
    <a href="#" class="nav-link">
      <i class="nav-icon fas fa-chart-bar"></i>
      <p>Estadísticas</p>
      <i class="right fas fa-angle-left"></i>
    </a>
    <ul class="nav nav-treeview">
      <li class="nav-item">
        <a href="#" class="nav-link">
          <i class="nav-icon fa fa-book"></i>
          <p>Global</p>
          <i class="right fas fa-angle-left"></i>
        </a>

        <ul class="nav nav-treeview">


          <li class="nav-item">
            <a href="<?php echo base_url(); ?>/estadisticas" class="nav-link">
              <i class="nav-icon fas fa-users" style='font-size:20px'></i>
              <p>Reporte</p>
            </a>
          </li>
            <li class="nav-item">
            <a href="<?php echo base_url(); ?>/vista_Grafica_Encuestas/null/null" class="nav-link">
              <i class="nav-icon fas fa-users" style='font-size:20px'></i>
              <p>Graficas Encuestas</p>
            </a>
          </li>
        </ul>

      </li>

      




      <li class="nav-item">
        <a href="#" class="nav-link">
          <i class="nav-icon fa fa-book"></i>
          <p>Estadal</p>
          <i class="right fas fa-angle-left"></i>
        </a>
        <ul class="nav nav-treeview">
          
          <li class="nav-item">
            <a href="<?php echo base_url(); ?>/estadal/null/null" class="nav-link">
              <i class="nav-icon fa fa-bookmark" style='font-size:20px'></i>
              <p>Estatus</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="<?php echo base_url(); ?>/estadisticas_benificiario/null/null" class="nav-link">
              <i class="nav-icon fas fa-address-card" style='font-size:20px'></i>
              <p>Beneficiario</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="<?php echo base_url(); ?>/estadisticas_propiedad_intelectual/null/null" class="nav-link">
              <i class="nav-icon fas fa-clipboard" style='font-size:20px'></i>
              <p>Propiedad Intelectual</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="<?php echo base_url(); ?>/estadisticas_tipo_atencion/null/null/null" class="nav-link">
              <i class="nav-icon fas fa-chalkboard-teacher" style='font-size:20px'></i>
              <p>Tipo Atencion</p>
            </a>
          </li>


          <li class="nav-item">
            <a href="<?php echo base_url(); ?>/estadisticas_Detalle_tipo_atencion/null/null" class="nav-link">
              <i class="nav-icon fas fa-chalkboard-teacher" style='font-size:20px'></i>
              <p>Detalle Tipo Atencion</p>
            </a>
          </li>

          <li class="nav-item">
                  <a href="<?php echo base_url(); ?>/estadisticas_pp/null/null" class="nav-link">
                    <i class="nav-icon 	fas  fas fa-chalkboard-teacher " style='font-size:20px'></i>
                    <p>Organismo del PP</p>
                  </a>
          </li>  

          <li class="nav-item">
            <a href="<?php echo base_url(); ?>/estadisticas_mapa" class="nav-link">
              <img src="<?= base_url((new \Config\Assets())->bandera) ?>" style='width:40px;height:30px'>
              <p>Mapa de ayudas</p>
            </a>
          </li>
        </ul>
      </li>
      <?php if (in_array($session->get('userrol'), [1, 5, 6])): ?>
        <li class="nav-item">
          <a href="<?php echo base_url(); ?>/Control_Visitas" class="nav-link">
            <i class="nav-icon fas fa-users" style='font-size:20px'></i>
            <p>Contador de Visitas</p>
          </a>
        </li>
        <!-- <li class="nav-item">
          <a href="#" class="nav-link">
            <i class="nav-icon fas fa-chart-bar"></i>
            <p>Estad. Audiencias</p>
            <i class="right fas fa-angle-left"></i>
          </a>
          <ul class="nav nav-treeview">
            <li class="nav-item">
              <a href="<php echo base_url(); ?>/citas_otorgadas/null" class="nav-link">
                <i class="nav-icon fa fa-calendar-check" style="font-size:20px"></i>
                <p>Citas otorgadas</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="<php echo base_url(); ?>/casos_categorias" class="nav-link">
                <i class="nav-icon fas fa-file" style='font-size:20px'></i>
                <p>Casos por categoría</p>
              </a>
            </li>
          </ul>
        </li> -->
      <?php endif; ?>
    </ul>
  </li>
<?php endif; ?>
       

     
     

         
          <?php if ($session->get('userrol') == 5 ) { ?>

            <li class="nav-item">
            <a href="#" class="nav-link" id=""><i class="nav-icon fas far fa-sun"></i>
              <p> Mantenimiento </p>
              <i class="right fas fa-angle-left"></i>
            </a>
            <ul class="nav nav-treeview">

            <li class="nav-item">
                  <a href="<?php echo base_url(); ?>/vista_via_atencion" class="nav-link">
                    <i class="nav-icon 	fas  fa-users" style='font-size:20px'></i>
                    <p>Via De Atención</p>
                  </a>
              </li> 

              <li class="nav-item">
                  <a href="<?php echo base_url(); ?>/vista_tipo_atencion" class="nav-link">
                    <i class="nav-icon 	fas  fa-users" style='font-size:20px'></i>
                    <p>Tipo De Atención </p>
                  </a>
              </li> 
              <li class="nav-item">
                  <a href="<?php echo base_url(); ?>/vista_detalle_atencion" class="nav-link">
                    <i class="nav-icon 	fas  fas fa-chalkboard-teacher " style='font-size:20px'></i>
                    <p>Detalle Atencion</p>
                  </a>
                </li>

              <li class="nav-item">
                  <a href="<?php echo base_url(); ?>/vista_tipo_Beneficiarios/" class="nav-link">
                    <i class="nav-icon 	fas  fas fa-chalkboard-teacher " style='font-size:20px'></i>
                    <p>Tipo de Beneficiarios.</p>
                  </a>
                </li>  
                <li class="nav-item">
                  <a href="<?php echo base_url(); ?>/vista_tipo_Estatus/" class="nav-link">
                    <i class="nav-icon 	fas  fas fa-chalkboard-teacher " style='font-size:20px'></i>
                    <p>Tipo de Estatus</p>
                  </a>
                </li>

                <li class="nav-item">
                  <a href="<?php echo base_url(); ?>/vista_organismo_pp/" class="nav-link">
                    <i class="nav-icon 	fas  fas fa-chalkboard-teacher " style='font-size:20px'></i>
                    <p>Organismo del PP</p>
                  </a>
                </li>

                 <li class="nav-item">
                  <a href="<?php echo base_url(); ?>/Vista_Participantes_Mediacion/" class="nav-link">
                    <i class="nav-icon 	fas  fas fa-chalkboard-teacher " style='font-size:20px'></i>
                    <p>Parti-Mediacion </p>
                  </a>
                </li>
                 <li class="nav-item">
                  <a href="<?php echo base_url(); ?>/punto_cuenta" class="nav-link">
                    <i class="nav-icon 	fas  fa-users" style='font-size:20px'></i>
                    <p>Punto de Cuenta</p>
                  </a>
              </li> 
            </ul>
          </li>
          <?php } ?>
          
          <!-- ************************************************************************** -->

          <?php if ($session->get('userrol') == 10 ) { ?>
                    <li class="nav-item">
                  
                      <li class="nav-item">
                          <a href="<?php echo base_url(); ?>/vista_casos_remitidos" class="nav-link">
                            <i class="nav-icon fas fa-folder" style='font-size:20px'></i>
                            <p>Casos</p>
                          </a>
                      </li>   
                      
                  
                    </li>
                    <?php } ?>




<?php 
// 1. Definimos los permisos que habilitan las opciones del listado
$permisos_audiencia = ['requerimientos.read', 'solicitudes.read', 'requerimientos.create', 'citas.read'];

// 2. Verificamos si existe al menos uno de los permisos en su lista
$tiene_permisos_lista = false;
if (isset($userdata['permisos']['permisos'])) {
    if (count(array_intersect($permisos_audiencia, $userdata['permisos']['permisos'])) > 0) {
        $tiene_permisos_lista = true;
    }
}

// Solo entramos si tiene el acceso general habilitado
if ($session->get('acceso_audi') == 't'): 

    // SUB-MENU: LISTADOS Y REGISTROS (Solo si tiene permisos específicos)
    if ($tiene_permisos_lista): ?>
        <li class="nav-item">
            <a href="#" class="nav-link">
                <i class="nav-icon fas far fa-sun"></i>
                <p> Audiencias <i class="right fas fa-angle-left"></i></p>
            </a>
            <ul class="nav nav-treeview">
                <?php if (in_array('requerimientos.read', $userdata['permisos']['permisos'])): ?>
                    <li class="nav-item">
                        <a href="<?= base_url('/vista_audiencias') ?>" class="nav-link">
                            <i class="nav-icon fas fa-users" style="font-size:20px"></i>
                            <p>Listado</p>
                        </a>
                    </li>
                <?php endif; ?>

                <?php if (in_array('solicitudes.read', $userdata['permisos']['permisos'])): ?>
                    <li class="nav-item">
                        <a href="<?= base_url('/vista_solicitudes') ?>" class="nav-link">
                            <i class="nav-icon fas fa-users" style="font-size:20px"></i>
                            <p>Listado de solicitudes</p>
                        </a>
                    </li>
                <?php endif; ?>

                <?php if (in_array('requerimientos.create', $userdata['permisos']['permisos'])): ?>
                    <li class="nav-item">
                        <a href="<?= base_url('/vista_agregar_requerimientos') ?>" class="nav-link">
                            <i class="nav-icon fas fa-users" style="font-size:20px"></i>
                            <p>Registrar Audiencias</p>
                        </a>
                    </li>
                <?php endif; ?>

                <?php if (in_array('citas.read', $userdata['permisos']['permisos'])): ?>
                    <li class="nav-item">
                        <a href="<?= base_url('/citas') ?>" class="nav-link">
                            <i class="nav-icon fas fa-users" style="font-size:20px"></i>
                            <p>Citas</p>
                        </a>
                    </li>
                <?php endif; ?>
            </ul>
        </li>
    <?php endif; ?>

    <li class="nav-item">
        <a href="#" class="nav-link">
            <i class="nav-icon fas fa-chart-bar"></i>
            <p>Estadísticas Audi <i class="right fas fa-angle-left"></i></p>
        </a>
        <ul class="nav nav-treeview">
            <li class="nav-item">
                <a href="<?= base_url('/estadisticas_audiencias') ?>" class="nav-link">
                    <i class="nav-icon fa fa-user-friends" style="font-size:20px"></i>
                    <p>Audiencias</p>
                </a>
            </li>   
            <li class="nav-item">
                <a href="<?= base_url('/citas_otorgadas/null') ?>" class="nav-link">
                    <i class="nav-icon fa fa-calendar-check" style="font-size:20px"></i>
                    <p>Citas otorgadas</p>
                </a>
            </li>   
            <li class="nav-item">
                <a href="<?= base_url('/casos_categorias') ?>" class="nav-link">
                    <i class="nav-icon fas fa-tags" style="font-size:20px"></i>
                    <p>Casos por categoría</p>
                </a>
            </li>   
        </ul>
    </li>

    <?php if ($session->get('userrol') == 9 && $userdata["nivel_rol"] == "1"): ?>
        <li class="nav-item">
            <a href="#" class="nav-link">
                <i class="nav-icon fas far fa-sun"></i>
                <p>Mantenimiento Audi <i class="right fas fa-angle-left"></i></p>
            </a>
            <ul class="nav nav-treeview">
                <li class="nav-item">
                    <a href="<?= base_url('/vista_Roles_audiencias') ?>" class="nav-link">
                        <i class="nav-icon fas fa-list-alt" style="font-size:20px"></i>
                        <p>Roles</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="<?= base_url('/vista_Permisos_audiencias') ?>" class="nav-link">
                        <i class="nav-icon fas fa-user-lock" style="font-size:20px"></i>
                        <p>Permisos</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="<?= base_url('/vista_Categorias_audiencias') ?>" class="nav-link">
                        <i class="nav-icon fas fa-tags" style="font-size:20px"></i>
                        <p>Categorias</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="<?= base_url('/vista_Usuario_Areas_audiencias') ?>" class="nav-link">
                        <i class="nav-icon fas fa-user" style="font-size:20px"></i>
                        <p>Asignar Trabajador</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="<?= base_url('/vista_Bufetes_audiencias') ?>" class="nav-link">
                        <i class="nav-icon fas fa-briefcase" style="font-size:20px;"></i>
                        <p>Bufetes</p>
                    </a>
                </li>
            </ul>
        </li>
    <?php endif; ?>

<?php endif; ?>


          <li class="nav-item">
            <a href="#Foo" onclick="cerrarSesion();" class="nav-link" id="casos"><i class="fa fa-external-link" aria-hidden="true"></i>
              <p>Salir</p>
            </a>
          </li>
       

      </div>
    </aside>
</body>

