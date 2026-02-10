<?php $session = session(); ?>

<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700;800&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

<style>
    /* ==============================================================
       SISTEMA DE DISEÑO PREMIUM CORPORATIVO (PHP 8.4 / CI4)
       ============================================================== */
    :root {
        --corporate-blue: #003366;
        --gradient-header: linear-gradient(135deg, #002244 0%, #003366 50%, #004488 100%);
        --accent-blue: #3498db;
        --bg-light: #f4f7fa;
        --card-radius: 15px;
        --primary-dark: #2c3e50;
    }

    .content-wrapper { 
        background-color: var(--bg-light) !important; 
        min-height: 100vh;
        font-family: 'Inter', 'Segoe UI', sans-serif;
        padding: 20px;
    }

    .table-container-slim {
        max-width: 98%; 
        margin: 0 auto;
    }

    /* --- HEADER PREMIUM --- */
    .premium-top-header {
        background: var(--gradient-header);
        color: white;
        padding: 1.2rem 2rem;
        border-radius: var(--card-radius);
        box-shadow: 0 10px 25px rgba(0, 34, 68, 0.15);
        margin-bottom: 20px;
    }

    .header-grid {
        display: grid;
        grid-template-columns: 1fr 2fr 1fr;
        align-items: center;
    }

    .title-area h2 { font-size: 1.3rem !important; font-weight: 800; letter-spacing: -0.5px; }
    .direction-center { text-align: center; }
    .direction-badge-large {
        display: inline-block;
        background: rgba(255, 255, 255, 0.1);
        backdrop-filter: blur(10px);
        padding: 8px 25px;
        border-radius: 12px;
        border: 1px solid rgba(255, 255, 255, 0.2);
    }
    .direction-badge-large strong { font-size: 1.4rem; font-weight: 800; line-height: 1.1; display: block; }

    /* ==============================================================
       ESTILOS DE LA TABLA COMPACTA
       ============================================================== */
    .card-premium-table {
        border: none;
        border-radius: var(--card-radius);
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.05);
        background: #fff;
        padding: 20px;
        width: 100%;
    }

    /* ALINEACIÓN DE CONTROLES (MOSTRAR Y BUSCAR) */
    .dataTables_wrapper .row:first-child {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 15px;
    }

    .dataTables_length { float: left; }
    .dataTables_filter { float: right; text-align: right; }

    .dataTables_filter input {
        border: 1px solid #e2e8f0 !important;
        border-radius: 8px !important;
        padding: 6px 12px !important;
        width: 220px !important;
        outline: none;
        font-size: 0.85rem;
    }

    .dataTables_length select {
        border: 1px solid #e2e8f0 !important;
        border-radius: 6px !important;
        padding: 4px 8px !important;
        outline: none;
        font-size: 0.85rem;
    }

    /* DISEÑO DEL ENCABEZADO DE TABLA */
    .table-professional thead th {
        background-color: #f1f5f9 !important;
        color: var(--corporate-blue) !important;
        font-weight: 800 !important;
        text-transform: uppercase;
        font-size: 0.70rem !important;
        letter-spacing: 0.5px;
        padding: 0.75rem 0.5rem !important; /* Compacto */
        border-bottom: 2px solid #cbd5e1 !important;
        white-space: nowrap;
    }

    /* DISEÑO DE CELDAS */
    .table-professional td {
        padding: 0.6rem 0.5rem !important;
        vertical-align: middle !important;
        font-size: 0.85rem;
        border-bottom: 1px solid #f1f5f9 !important;
    }

    .table-professional tbody tr:hover {
        background-color: #f8fafc !important;
    }

    /* Ajuste para Responsive de DataTables */
    #table_casos tbody td:first-child {
        padding-left: 35px !important;
        position: relative;
    }

    /* --- MODALES --- */
    .modal-content { border: none; border-radius: 1rem; overflow: hidden; }
    .modal-header { background: var(--primary-dark); color: white; }
    .section-title {
        font-size: 0.75rem; font-weight: 800; color: var(--accent-blue);
        text-transform: uppercase; border-bottom: 2px solid #f0f0f0;
        padding-bottom: 5px; margin-bottom: 15px;
    }

    /* Animación de escritura */
    .typing-cursor {
        display: inline-block; width: 3px; height: 1.1em; background-color: var(--accent-blue);
        margin-left: 5px; animation: blink-cursor 0.8s infinite; vertical-align: middle;
    }
    @keyframes blink-cursor { 0%, 100% { opacity: 1; } 50% { opacity: 0; } }
</style>

<div class="content-wrapper">
    <div class="table-container-slim">
        
        <header class="premium-top-header">
            <div class="header-grid">
                <div class="title-area">
                    <h2 class="m-0"><i class="fas fa-folder-open mr-2 text-info"></i> Casos Remitidos</h2>
                    <small class="text-white-50">SISTEMA DE GESTIÓN ADMINISTRATIVA</small>
                </div>

                <div class="direction-center">
                    <div class="direction-badge-large">
                        <span class="d-block small text-uppercase" style="letter-spacing:3px; opacity:0.8; font-size: 0.6rem;">Unidad Administrativa</span>
                        <strong id="typing-direccion" data-text="<?= $direccion ?? 'DIRECCIÓN GENERAL'; ?>"></strong>
                    </div>
                </div>

                <div class="text-right">
                    <div class="d-inline-block bg-white px-3 py-1 rounded-pill shadow-sm border">
                        <label for="estatus" class="mr-1 mb-0 font-weight-bold text-muted" style="font-size: 0.65rem;">FILTRAR:</label>
                        <select class="border-0 font-weight-bold" id="estatus" style="outline:none; color: var(--corporate-blue); cursor: pointer; font-size: 0.75rem;">
                            <option value="0">TODOS</option>
                            <option value="1">ABIERTOS</option>
                            <option value="2">CERRADOS</option>
                        </select>
                    </div>
                </div>
            </div>
        </header>

        <div class="card-premium-table">
            <div class="table-responsive">
                <table class="table table-professional" id="table_casos">
                    <thead>
                        <tr>
                            <th class="text-center">ID</th>
                            <th>Identificación</th>
                            <th style="min-width: 200px;">Beneficiario</th> 
                            <th>Teléfono</th>
                            <th>Propiedad</th>
                            <th>Atención</th>
                            <th>Fecha</th>
                            <th class="text-center">Estatus</th>
                            <th>Operador</th>
                            <th class="text-center">Acciones</th>
                        </tr>
                    </thead>
                    <tbody id="listar_casos">
                        </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="editCase" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-scrollable">
        <div class="modal-content shadow-lg">
            <div class="modal-header bg-dark text-white">
                <h5 class="modal-title font-weight-bold"><i class="fas fa-edit mr-2"></i> Gestión de Caso</h5>
                <button type="button" class="close text-white" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body p-4 bg-light">
                <form id="form_editar_completo">
                    <input type="hidden" id="id_caso">
                    <div class="bg-white p-4 rounded shadow-sm">
                        <div class="section-title"><i class="fas fa-user mr-2"></i> Información del Solicitante</div>
                        <div class="row">
                            <div class="col-md-3 form-group">
                                <label class="small font-weight-bold">Nombre</label>
                                <input type="text" class="form-control form-control-sm" id="nombre-persona" onkeyup="mayus(this)" required>
                            </div>
                            <div class="col-md-3 form-group">
                                <label class="small font-weight-bold">Apellido</label>
                                <input type="text" class="form-control form-control-sm" id="apellido-persona" onkeyup="mayus(this)" required>
                            </div>
                            <div class="col-md-2 form-group">
                                <label class="small font-weight-bold">Tipo</label>
                                <select class="form-control form-control-sm" id="tipo-persona">
                                    <option value="V">V</option><option value="E">E</option><option value="J">J</option>
                                </select>
                            </div>
                            <div class="col-md-4 form-group">
                                <label class="small font-weight-bold">Cédula o RIF</label>
                                <input type="text" class="form-control form-control-sm" id="cedula-persona" required>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer bg-white border-0">
                <button type="button" class="btn btn-light btn-sm px-4" data-dismiss="modal">Cancelar</button>
                <button type="submit" form="form_editar_completo" class="btn btn-primary btn-sm px-5 shadow-sm" id="editar_caso">
                    <i class="fas fa-save mr-2"></i> Guardar Cambios
                </button>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // 1. Efecto de Escritura
        const target = document.getElementById('typing-direccion');
        const textToWrite = target.getAttribute('data-text') || '';
        if(textToWrite) {
            const cursor = document.createElement('span');
            cursor.className = 'typing-cursor';
            target.after(cursor);
            let index = 0;
            function typeWriter() {
                if (index < textToWrite.length) {
                    target.textContent += textToWrite.charAt(index);
                    index++;
                    setTimeout(typeWriter, 40);
                } else {
                    setTimeout(() => cursor.style.display = 'none', 1000);
                }
            }
            setTimeout(typeWriter, 300);
        }

        // 2. Inicialización de DataTable (Asegúrate de tener jQuery y DataTables cargados)
        // $('#table_casos').DataTable({
        //     "dom": '<"d-flex justify-content-between align-items-center mb-3"lf>rtip',
        //     "language": {
        //         "url": "//cdn.datatables.net/plug-ins/1.10.24/i18n/Spanish.json"
        //     },
        //     "pageLength": 10
        // });
    });

    function mayus(e) { e.value = e.value.toUpperCase(); }
</script>