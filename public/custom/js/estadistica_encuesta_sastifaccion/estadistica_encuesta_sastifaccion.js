$(document).on('click', '.consultar', function(e) {
    e.preventDefault();
    let fecha_inicio = $('#fecha_inicio').val();
    let fecha_fin = $('#fecha_fin').val();
    $('#fecha_inicio').val(fecha_inicio);
    $('#fecha_fin').val(fecha_fin );

    if (fecha_inicio == '') {
        fecha_inicio = 'null'
    }
   

    if (fecha_fin == '') {
        fecha_fin = 'null'
    }
    if (fecha_inicio == 'null' && fecha_fin != 'null') {
        alert('DEDE INDICAR EL CAMPO DESDE');

    } else if (fecha_fin == 'null' && fecha_inicio != 'null') {
        alert('DEDE INDICAR EL CAMPO fecha_fin');
    } else if (fecha_fin < fecha_inicio) {
        alert('EL CAMPO DESDE ES MAYOR AL CAMPO fecha_fin')
    }

   else
    {
   
        window.location='/vista_Grafica_Encuestas/'+fecha_inicio+'/'+fecha_fin;
    }
})
$(document).on('click', '.limpiar', function(e) {
  
    if (fecha_inicio == '') {
        fecha_inicio = 'null'
    }
   

    if (fecha_fin == '') {
        fecha_fin = 'null'
    }
    window.location='/vista_Grafica_Encuestas/'+null+'/'+null;

})

// Variable global para mantener la referencia a la instancia de DataTable,
// aunque la nueva lógica la hace menos dependiente de esta variable.
let detalleDataTable = null; 

/**
 * Inicializa y configura todas las gráficas en la página.
 */
function inicializarGraficas() {
    const backgroundColors = [
        '#ec8800',
        '#ff9800',
        '#77dd77',
        '#9ca3af',
        '#a9e9a4',
    ];

    if (typeof chartConfigs !== 'undefined' && Array.isArray(chartConfigs)) {
        chartConfigs.forEach(config => {
            const ctx = document.getElementById(config.id).getContext('2d');
            
            new Chart(ctx, {
                type: config.type,
                data: {
                    labels: config.labels,
                    datasets: [{
                        data: config.data,
                        backgroundColor: backgroundColors,
                        total_respuestas: config.total_respuestas,
                    }],
                },
                options: {
                    maintainAspectRatio: false,
                    animation: false,
                    layout: { padding: { left: 0, right: 0, top: 0, bottom: 40 } },
                    plugins: {
                        legend: { display: true, position: 'top' },
                        tooltip: {
                            callbacks: {
                                label: function(tooltipItem) {
                                    const index = tooltipItem.dataIndex;
                                    const total = config.total_respuestas[index];
                                    const percentage = config.porcentajes[index]; 
                                    return ['Porcentaje: ' + percentage + '%', 'Respuestas: ' + total];
                                },
                                footer: function() { return ''; }
                            }
                        },
                        datalabels: { 
                            color: 'black',
                            anchor: 'center',
                            align: 'center',
                            formatter: (value, context) => {
                                const index = context.dataIndex; 
                                const total = context.chart.data.datasets[0].total_respuestas[index]; 
                                const sum = context.chart.data.datasets[0].data.reduce((acc, val) => acc + val, 0);
                                const percentage = ((total / sum) * 100).toFixed(2);
                                return total > 0 ? [' ' + percentage + '%', ' ' + ' ' + ' ' + ' ' + ' ' + total] : ''; 
                            }
                        }
                    },
                    onClick: (event, activeElements) => handleChartClick(event, activeElements, config),
                },
                plugins: [ChartDataLabels]
            });
        });
    }
}
/**
 * Manejador del evento de clic en un segmento de la gráfica.
 * Configura el título del modal (bonito) y el título de exportación (con \n).
 */

/**
 * Manejador del evento de clic en un segmento de la gráfica.
 * 1. Configura el título del modal con estilos.
 * 2. Prepara el título de exportación para PDF/Excel con saltos de línea (\n).
 * 3. Realiza la llamada a la API y abre el modal.
 */
function handleChartClick(event, activeElements, config) {
    if (activeElements.length > 0) {
        const clickedElementIndex = activeElements[0].index;
        const textoPregunta = config.questionText;
        const nombreTipoRespuesta = config.labels[clickedElementIndex];

        // Títulos de exportación y modal 
        const nuevoTituloTexto = `Pregunta: ${textoPregunta}\n Respuesta: ${nombreTipoRespuesta}`; 
        const nuevoContenidoHTML = `
            <span style="color: black; font-weight: bold;">Pregunta: </span>
            <span class="text-primary" style="font-size: 0.9em;">
                <strong>${textoPregunta}</strong>
            </span>
            <br>
            <span style="color: black; font-weight: bold;">Respuesta: </span>
            <span class="text-primary" style="font-size: 0.9em;">
                <strong>${nombreTipoRespuesta}</strong>
            </span>
        `; 

        const modalTitleElement = document.querySelector('#miModal .modal-title');
        if (modalTitleElement) {
            modalTitleElement.innerHTML = nuevoContenidoHTML;
        }

        // --- Lógica de la API (Existente) ---
        const questionId = config.questionId;
        const responseData = config.responseData;
        const responseTypeId = responseData[clickedElementIndex].id_tipo;
        const url = `https://encuesta.sapi.gob.ve/api/estadisticas/detalle/${questionId}/${responseTypeId}`;

        fetch(url)
            .then(response => response.ok ? response.json() : Promise.reject(new Error('Error en la API')))
            .then(data => {
                actualizarTablaModal(data, nuevoTituloTexto); 
                
                // 💡 SOLUCIÓN: Desplazar la ventana a la parte superior (ScrollTop(0))
                // Esto asegura que el modal (que usa position: fixed) siempre se muestre.
                if (typeof jQuery !== 'undefined' && $.fn.modal) {
                     // Solo desplazamos si hay scroll actual para evitar parpadeos innecesarios
                    if ($(document).scrollTop() > 0) {
                        $('body, html').scrollTop(0);
                    }
                    
                    // Mostrar el modal
                    $('#miModal').modal('show');
                } else {
                    console.error("jQuery o la función modal de Bootstrap no están disponibles.");
                    // Si no está jQuery, simplemente muestra un error y sal.
                }

            })
            .catch(error => {
                console.error('Hubo un problema con la petición fetch:', error);
                alert('No se pudieron obtener los datos. Revisa la consola para más detalles.');
            });
    }
}


// Este código debe estar en tu archivo principal de JavaScript
$(document).ready(function() {
    // 1. SOLUCIÓN AL SCROLL BAJO: Forzar el scroll a la parte superior antes de mostrar.
    $('#miModal').on('show.bs.modal', function (e) {
        if ($(document).scrollTop() > 0) {
            $('body, html').scrollTop(0);
        }
    });

    // 2. SOLUCIÓN AL ANCHO DE DATATABLES: Recalcular el diseño después de que el modal sea visible.
    $('#miModal').on('shown.bs.modal', function () {
        // Llama a handleUpdate si estás en Bootstrap 4/3 con jQuery
        $(this).find('.modal-dialog').trigger('focus');
        
        // Si usas DataTables, fuerza el redibujado de la tabla para que se ajuste al ancho
        if ($.fn.DataTable.isDataTable('#tablaDatos')) {
            $('#tablaDatos').DataTable().columns.adjust().draw();
        }
    });
});

/**
 * Actualiza la tabla dentro del modal con nuevos datos y reinicializa DataTables,
 * incluyendo el título dinámico para la exportación a PDF y Excel.
 * * @param {Array} data - Los datos a cargar en DataTables.
 * @param {string} exportTitle - El título completo a usar en la exportación (e.g., "Pregunta: X\nRespuesta: Y").
 */
function actualizarTablaModal(data, exportTitle) {
    const tableElement = $('#tablaDatos'); 
    let ruta_imagen = rootpath;
    
    // Destruye la instancia existente si la hay, de forma segura.
    if ($.fn.DataTable.isDataTable('#tablaDatos')) {
        tableElement.DataTable().destroy();
    }
    
    // 📌 Definición de 8 columnas
    const columnsDefinition = [
        { data: 'apellidos_nombres', title: 'Nombres'}, 
        { data: 'tramite', title: 'Solicitud'}, 
        { data: 'observacion', title: 'Observación'}, 
        { data: 'respuesta_text', title: 'Respuesta'}, 
        { data: 'telefono', title: 'Teléfono'}, 
        { data: 'tipo_propiedad', title: 'Área' },
        
        // 7. Columna para el botón de acción (corresponde a <th>Ver</th>)
        { 
            data: null, // Dato no mapeado, lo creamos
            title: 'Ver', 
            orderable: false, 
            searchable: false,
            // Usamos 'row' para acceder al id_encuesta de la fila
            render: function (data, type, row) {
                const id_encuesta = row.id_encuesta;
                return `<button class="btn btn-xs btn-info ver-detalle-btn" data-id="${id_encuesta}">
                            <i class="fa fa-search"></i> 
                        </button>`;
            }
        },
        // 8. Columna para el id_encuesta (corresponde al <th> vacío, lo ocultamos)
        // Nota: Asegúrate de que tus datos 'data' contengan el campo 'id_encuesta'.
        { data: 'id_encuesta', title: 'ID Encuesta', visible: false } 
    ];
    
    // Inicializar DataTables con los nuevos datos y la configuración mejorada.
    tableElement.DataTable({
        data: data,                 
        columns: columnsDefinition, 
        
        // El resto de tu configuración...
        dom: "Bfrtip",
        buttons: {
            dom: {
                button: {
                    className: 'btn-xs-xs'
                },
            },
            buttons: [{
                extend: "pdf",
                text: 'PDF',
                className: 'btn-xs btn-dark',
                orientation: 'landscape',
                pageSize: 'LETTER',
                header: true,
                footer: true,
                download: 'open',
                exportOptions: {
                    // Exportamos solo las 6 columnas visibles originales
                    columns: [0, 1, 2, 3, 4, 5], 
                },
                alignment: 'center',
                customize: function(doc) {
                    // ... (código customize para PDF) ...
                    doc.content.splice(0, 1);
                    doc.content.unshift({
                        text: exportTitle, 
                        style: 'title'
                    });
                    
                    doc.styles.title = {
                        color: '#4c8aa0',
                        fontSize: '14', 
                        alignment: 'center',
                        margin: [0, 0, 0, 10] 
                    }
                    doc.styles['td:nth-child(2)'] = {
                        width: '130px',
                        'max-width': '130px'
                    },
                    doc.styles.tableHeader = {
                        fillColor: '#4c8aa0',
                        color: 'white',
                        alignment: 'center'
                    },
                    doc.pageMargins = [40, 95, 0, 70];
                    
                    doc['header'] = (function(page, pages) {
                        return {
                            columns: [{
                                margin: [10, 3, 40, 40],
                                image: ruta_imagen,
                                width: 780,
                                height: 50,
                            },
                            {
                                margin: [-800, 50, -25, 0],
                                color: '#4c8aa0',
                                fontSize: '18',
                                alignment: 'center',
                                text: 'Detalle de Encuesta',
                                fontSize: 18,
                            },
                           ],
                        }
                    });
                    
                    doc['footer'] = (function(page, pages) {
                        return {
                            columns: [{
                                alignment: 'center',
                                text: ['pagina ', { text: page.toString() }, ' of ', { text: pages.toString() }]
                            }],
                        }
                    });
                },
            },
            {
                extend: "excel",
                text: 'Excel',
                className: 'btn-xs btn-dark',
                title: exportTitle, 
                download: 'open',
                exportOptions: {
                    // Exportamos solo las 6 columnas visibles originales
                    columns: [0, 1, 2, 3, 4, 5], 
                },
                excelStyles: {
                    "template": [
                        "blue_medium",
                        "header_blue",
                        "title_medium"
                    ]
                },
            }]
        },
        // Opciones generales de DataTables
        "paging": true,
        "info": true,
        "searching": true,
        "ordering": true,
        "responsive": false, 
        "autoWidth": true,
        "scrollX": true,
        "destroy": true,          
        "processing": true,
        "lengthMenu": [ [10, 25, 50, -1], [10, 25, 50, "Todos"] ],
        "pageLength": 10,
        "scrollX": true,
        "scrollY": '50vh', 
        "scrollCollapse": true,
        "responsive": false, 

        "language": {
            // ... (código de idioma) ...
            "sProcessing": "Procesando...",
            "sLengthMenu": "Mostrar _MENU_ registros",
            "sZeroRecords": "No se encontraron resultados",
            "sEmptyTable": "Ningún dato disponible en esta tabla",
            "sInfo": "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
            "sInfoEmpty": "Mostrando registros del 0 al 0 de un total de 0 registros",
            "sInfoFiltered": "(filtrado de un total de _MAX_ registros)",
            "sInfoPostFix": "",
            "sSearch": "Buscar:",
            "sUrl": "",
            "sInfoThousands": ",",
            "sLoadingRecords": "Cargando...",
            "oPaginate": {
                "sFirst": "Primero",
                "sLast": "Último",
                "sNext": "Siguiente",
                "sPrevious": "Anterior"
            },
            "oAria": {
                "sSortAscending": ": Activar para ordenar la columna de manera ascendente",
                "sSortDescending": ": Activar para ordenar la columna de manera descendente"
            }
        }
    });

    // 📌 Manejo del Evento Click del Botón (Delegación de eventos)
    // Limpiamos el manejador anterior y lo volvemos a añadir
    $('#tablaDatos tbody').off('click', '.ver-detalle-btn'); 
    $('#tablaDatos tbody').on('click', '.ver-detalle-btn', function() {
        const id_encuesta_seleccionado = $(this).data('id'); 
        
        window.location="/Vista_Detalle_Encuesta/"+id_encuesta_seleccionado
       
        
        // Aquí puedes agregar la lógica para abrir otro modal o cargar datos
    });
}
/**
 * Configuración del modal.
 */
function configurarModal() {
    const modal = document.getElementById('miModal');
    const spanCerrar = document.getElementsByClassName('cerrar')[0];

    // Cerrar con el clic en la "x"
    spanCerrar.onclick = function() {
        modal.style.display = 'none';
    }

    // Cerrar al hacer clic fuera del modal
    window.onclick = function(event) {
        if (event.target === modal) {
            modal.style.display = 'none';
        }
    }
}


// Ejecutar la inicialización de las funciones cuando el DOM esté completamente cargado
document.addEventListener('DOMContentLoaded', () => {
    // Retraso para dar tiempo a la carga de librerías externas
    setTimeout(() => {
        configurarModal();
        inicializarGraficas();
    }, 100); 
});