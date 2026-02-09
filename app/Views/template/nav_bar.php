<?php
$session = session();
$userdata = $session->get();
?>





<style>
  .text-highlight {
    font-weight: bold;
    color: #003366;
    background-color: #e7f3ff;
    padding: 2px 5px;
    border-radius: 3px;
  }
  .notification-item p {
    line-height: 1.5;
    margin-bottom: 5px;
  }
  .notification-item {
    padding: 12px 15px;
    border-bottom: 1px solid #e9ecef;
    transition: all 0.2s ease;
    cursor: pointer;
  }
  .notification-item:hover {
    background-color: #f8f9fa;
  }
  .notification-item.unread {
    background-color: #e8f4fd;
    border-left: 3px solid #007bff;
  }
  .notification-item h6 {
    margin-bottom: 5px;
    font-size: 13px;
  }
  .notification-item .time {
    font-size: 11px;
    color: #6c757d;
    margin-top: 5px;
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
    padding: 2px 6px;
    font-size: 11px;
    position: absolute;
    top: -5px;
    right: -5px;
  }
  .notification-icon {
    position: relative;
    padding: 8px 12px;
  }
  .notification-icon i {
    font-size: 20px;
    color: #6c757d;
  }
  .notification-icon.has-notifications i {
    color: #007bff;
  }
  .notification-menu {
    position: absolute;
    right: 0;
    top: 100%;
    width: 380px;
    background: white;
    border-radius: 8px;
    box-shadow: 0 4px 20px rgba(0,0,0,0.15);
    z-index: 1000;
    overflow: hidden;
  }
  .notification-menu .dropdown-header {
    background: linear-gradient(135deg, #007bff, #0056b3);
    color: white;
    padding: 12px 15px;
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
    padding: 10px 15px;
    border-bottom: 1px solid #dee2e6;
    background: #f8f9fa;
  }
  .notification-filter-btn {
    flex: 1;
    padding: 6px 12px;
    font-size: 12px;
    border: 1px solid #007bff;
    border-radius: 15px;
    background: white;
    color: #007bff;
    cursor: pointer;
    transition: all 0.2s ease;
    text-align: center;
  }
  .notification-filter-btn:hover {
    background: #e8f4fd;
  }
  .notification-filter-btn.active {
    background: #007bff;
    color: white;
  }
  /* Estilo para notificaciones leídas */
  .notification-item.read {
    background-color: #f8f9fa;
    opacity: 0.7;
  }
  .notification-item.read:hover {
    background-color: #e9ecef;
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
  
<!-- Cintillo más ancho -->
  <div class="cintillo-container" style="display: flex; justify-content: center; align-items: center; width: 100%; max-width: 100%; margin: 0 20px;">
    <img src="<?= base_url('img/cintillo_tradicional.png') ?>" 
         alt="Cintillo Institucional" 
         style="width: 100%; max-width: 100%; height: auto; max-height: 100px; object-fit: contain;">
</div>
  
  <!-- Lado derecho: Notificaciones + Salir -->
  <div style="display: flex; align-items: center;">
    <!-- Bandeja de Notificaciones -->
    <div class="notification-dropdown" style="margin-right: 25px;">
      <div class="notification-icon" onclick="toggleNotifications()" title="Notificaciones">
        <i class="fas fa-bell"></i>
        <span class="notification-badge" id="notification-count" style="display: none;">0</span>
      </div>
      <div class="notification-menu" id="notification-menu" style="display: none;">
        <div style="padding: 12px 15px; border-bottom: 1px solid #dee2e6; background: linear-gradient(135deg, #007bff, #0056b3); color: white; border-radius: 8px 8px 0 0;">
          <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 8px;">
            <strong style="font-size: 15px;"><i class="fas fa-bell mr-2"></i>Notificaciones</strong>
            <a href="#" onclick="marcarTodasLeidas(); return false;" style="font-size: 12px; color: #fff; background: rgba(255,255,255,0.2); padding: 5px 10px; border-radius: 15px; text-decoration: none;">Marcar todas como leídas</a>
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
        <div id="notification-list">
          <!-- Las notificaciones se cargarán aquí -->
          <div class="empty-notifications">
            <i class="fas fa-bell-slash"></i>
            <p>No hay notificaciones</p>
          </div>
        </div>
      </div>
    </div>
    
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation" style="margin-right: 10px;">
      <span class="navbar-toggler-icon"></span>
    </button>
    
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav align-items-center">
        <li class="nav-item">
          <h5><a href="#Foo" onclick="cerrarSesion();" style="color: black;" class="nav-primary">Salir</a></h5>
        </li>
      </ul>
    </div>
  </div>
</nav>
  <script>
    // Variables globales
    let notificationsOpen = false;
    let currentFilter = 'unread'; // 'unread' o 'all'
    let todasLasNotificaciones = []; // Almacena todas las notificaciones para filtrado

    // Función para mostrar/ocultar notificaciones
    function toggleNotifications() {
      const menu = document.getElementById('notification-menu');
      if (menu.style.display === 'none') {
        menu.style.display = 'block';
        notificationsOpen = true;
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
      
      fetch(endpoint, {
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
            // Guardar todas las notificaciones si es el filtro "Todas"
            if (currentFilter === 'all') {
              todasLasNotificaciones = data.data;
            }
            renderNotificaciones(data.data);
            actualizarContador();
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
      
      // Actualizar estilos de botones
      document.getElementById('filter-unread').classList.toggle('active', filtro === 'unread');
      document.getElementById('filter-all').classList.toggle('active', filtro === 'all');
      
      // Recargar notificaciones según el filtro
      cargarNotificaciones();
    }

    // Renderizar notificaciones en el dropdown
    function renderNotificaciones(notificaciones) {
      const container = document.getElementById('notification-list');
      
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
        
        const tipoClass = notif.tipo_notificacion === 'REMISION' ? 'text-primary' : 
                         (notif.tipo_notificacion === 'CIERRE' ? 'text-danger' : 'text-warning');
        const tipoIcon = notif.tipo_notificacion === 'REMISION' ? 'fa-file-import' : 
                         (notif.tipo_notificacion === 'CIERRE' ? 'fa-check-circle' : 'fa-tasks');
        
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
        const leidaIcon = estaLeida ? '<i class="fas fa-check" style="color: #28a745; margin-right: 5px;"></i>' : '';
        
        html += `
          <div class="notification-item ${leidaClass}" 
               onclick="verNotificacion(${notif.id}, '${notif.tipo_notificacion}', ${notif.id_caso})">
            <h6><span class="notif-negrilla-azul"><i class="fas ${tipoIcon} ${tipoClass}"></i> ${notif.tipo_notificacion}</span> ${leidaIcon}</h6>
            <p class="notif-message">${mensajeCompleto}</p>
            <div class="time">${formatDate(notif.fecha_creacion)}${estaLeida ? ' · Leída' : ''}</div>
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
      } else {
        container.innerHTML = html;
      }
    }

    // Actualizar contador de notificaciones
    function actualizarContador() {
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

    // Ver notificación y redirigir
    function verNotificacion(id, tipo, idCaso) {
      // Marcar como leída (si falla, continuamos con la redirección)
      fetch('<?php echo base_url(); ?>/notificaciones/marcarLeida', {
        method: 'POST',
        headers: {
          'Content-Type': 'application/x-www-form-urlencoded',
          'X-Requested-With': 'XMLHttpRequest'
        },
        body: 'data=' + btoa(JSON.stringify({ id_notificacion: id }))
      })
      .then(response => {
        if (!response.ok) {
          console.warn('Error al marcar como leída, continuando...');
        }
        return response.json().catch(() => ({}));
      })
      .then(data => {
        console.log('Notificación marcada como leída');
      })
      .catch(error => {
        console.warn('Error en fetch de marcarLeida:', error);
      })
      .finally(() => {
        // Cerrar dropdown
        document.getElementById('notification-menu').style.display = 'none';
        notificationsOpen = false;
        actualizarContador();
        
        // Redirigir según el tipo (SIEMPRE)
        if (tipo === 'REMISION' || tipo === 'SEGUIMIENTO') {
          window.location.href = '<?php echo base_url(); ?>/verCaso/' + idCaso;
        }
      });
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
      // Actualizar contador inmediatamente al cargar
      actualizarContador();
      
      // Actualizar contador cada 30 segundos
      setInterval(actualizarContador, 30000);
      
      // Verificar notificaciones para mostrar alerta automáticamente (solo una vez)
      setTimeout(mostrarAlertaNotificaciones, 1000);
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
        <img src="<?php echo base_url(); ?>/img/favicon.jpg"  class="brand-image" style="opacity: .8; float: left; box-shadow: none; width: 35px;" onclick="return false;">
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
              <img src="<?php echo base_url(); ?>/img/venezuela2.png" style='width:40px;height:30px'>
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
        <li class="nav-item">
          <a href="#" class="nav-link">
            <i class="nav-icon fas fa-chart-bar"></i>
            <p>Estad. Audiencias</p>
            <i class="right fas fa-angle-left"></i>
          </a>
          <ul class="nav nav-treeview">
            <li class="nav-item">
              <a href="<?php echo base_url(); ?>/citas_otorgadas/null" class="nav-link">
                <i class="nav-icon fa fa-calendar-check" style="font-size:20px"></i>
                <p>Citas otorgadas</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="<?php echo base_url(); ?>/casos_categorias" class="nav-link">
                <i class="nav-icon fas fa-file" style='font-size:20px'></i>
                <p>Casos por categoría</p>
              </a>
            </li>
          </ul>
        </li>
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





         
           <!-- *********************MENU ADUDIENCIAS*************** -->
          <?php if ($session->get('acceso_audi') == 't' ) { ?>
       
          <li class="nav-item">
          <a href="#" class="nav-link" id=""><i class="nav-icon fas far fa-sun"></i>
            <p> Audiencias</p>
            <i class="right fas fa-angle-left"></i>
          </a>
          <ul class="nav nav-treeview">
               <!-- Comprobamos el nivel de rol y mostramos el HTML correspondiente -->
            


 
               <?php
               
                  if (isset($userdata['permisos']['permisos'])) {
                      // Verificar permisos para "requerimientos.read"
                      if (in_array('requerimientos.read', $userdata['permisos']['permisos'])) {
                          echo '<li class="nav-item">
                                  <a href="' . base_url() . '/vista_audiencias" class="nav-link">
                                      <i class="nav-icon fas fa-users" style="font-size:20px"></i>
                                      <p>Listado</p>
                                  </a>
                                </li>';
                      }

                      // Verificar permisos para "solicitudes.read"
                      if (in_array('solicitudes.read', $userdata['permisos']['permisos'])) {
                          echo '<li class="nav-item">
                                  <a href="' . base_url() . '/vista_solicitudes" class="nav-link">
                                      <i class="nav-icon fas fa-users" style="font-size:20px"></i>
                                      <p>Listado de solicitudes</p>
                                  </a>
                                </li>';
                      }

                      // Verificar permisos para "requerimientos.create"
                      if (in_array('requerimientos.create', $userdata['permisos']['permisos'])) {
                          echo '<li class="nav-item">
                                  <a href="' . base_url() . '/vista_agregar_requerimientos" class="nav-link">
                                      <i class="nav-icon fas fa-users" style="font-size:20px"></i>
                                      <p>Registrar Audiencias</p>
                                  </a>
                                </li>';
                      }

                      // Verificar permisos para "citas.read"
                      if (in_array('citas.read', $userdata['permisos']['permisos'])) {
                          echo '<li class="nav-item">
                                  <a href="' . base_url() . '/citas" class="nav-link">
                                      <i class="nav-icon fas fa-users" style="font-size:20px"></i>
                                      <p>Citas</p>
                                  </a>
                                </li>';
                      }
                  }
                  ?>
 
          </ul>
          </li>
          <?php 

              if ($userdata["nivel_rol"] == "1" || $userdata["nivel_rol"] == "2") {
              ?>
                  <li class="nav-item">
                      <a href="#" class="nav-link" id="">
                          <i class="nav-icon fas fa-chart-bar"></i>
                          <p>Estadísticas</p> 
                          <i class="right fas fa-angle-left"></i> 
                      </a>
                      <ul class="nav nav-treeview">

                      <li class="nav-item">
                              <a href="<?php echo base_url(); ?>/estadisticas_audiencias" class="nav-link">
                              <i class="nav-icon fa fa-user-friends" style="font-size:20px"></i>
                                  <p>Audiencias</p>
                              </a>
                          </li>   

                          <li class="nav-item">
                              <a href="<?php echo base_url(); ?>/citas_otorgadas/null" class="nav-link">
                              <i class="nav-icon fa fa-calendar-check" style="font-size:20px"></i>
                                  <p>Citas otorgadas</p>
                              </a>
                          </li>   
                          <li class="nav-item">
                              <a href="<?php echo base_url(); ?>/casos_categorias" class="nav-link">
                              <i class="nav-icon fas fa-tags" style="font-size:20px"></i>
                                  <p>Casos por categoría</p>
                              </a>
                          </li>   
                      </ul>
                  </li>
              <?php 
              }
              ?>
          <?php } ?>

          <!-- *********************MANTENIMIENTO ROLES ADUDIENCIAS*************** -->
          <?php if (($session->get('userrol') == 9) && ($session->get('acceso_audi') == 't')) { ?>
            <?php 
                  if ($userdata["nivel_rol"] == "1") { ?>
          <li class="nav-item">
              <a href="#" class="nav-link" id="">
                  <i class="nav-icon fas far fa-sun"></i>
                  <p>Mantenimiento Audi</p>
                  <i class="right fas fa-angle-left"></i>
              </a>
              <ul class="nav nav-treeview">
                 
                      <li class="nav-item">
                          <a href="<?php echo base_url(); ?>/vista_Roles_audiencias" class="nav-link">
                              <i class="nav-icon fas fa-list-alt" style="font-size:20px"></i>
                              <p>Roles</p>
                          </a>
                      </li>
                      <li class="nav-item">
                          <a href="<?php echo base_url(); ?>/vista_Permisos_audiencias" class="nav-link">
                              <i class="nav-icon fas fa-user-lock" style="font-size:20px"></i>
                              <p>Permisos</p>
                          </a>
                      </li>

                      <li class="nav-item">
                          <a href="<?php echo base_url(); ?>/vista_Categorias_audiencias" class="nav-link">
                              <i class="nav-icon fas fa-tags" style="font-size:20px"></i>
                              <p>Categorias</p>
                          </a>
                      </li>

                      <li class="nav-item">
                          <a href="<?php echo base_url(); ?>/vista_Usuario_Areas_audiencias" class="nav-link">
                              <i class="nav-icon fas fa-user" style="font-size:20px"></i>
                              <p>Asignar Trabajador</p>
                          </a>
                      </li>

                      <li class="nav-item">
                          <a href="<?php echo base_url(); ?>/vista_Bufetes_audiencias" class="nav-link">
                              <i class="nav-icon fas fa-briefcase" style="font-size:24px;"></i>
                              <p>Bufetes</p>
                          </a>
                      </li>
                                        
              </ul>
          </li>
          <?php } ?>
          <?php } ?>
          


          <li class="nav-item">
            <a href="#Foo" onclick="cerrarSesion();" class="nav-link" id="casos"><i class="fa fa-external-link" aria-hidden="true"></i>
              <p>Salir</p>
            </a>
          </li>
       

      </div>
    </aside>
</body>

