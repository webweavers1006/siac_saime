$('#btn_agregar').on('click', function(e) {
    window.location = '/vista_agregar_caso'
});
$(function() {
    let estatus =null
    Listar_Casos(estatus);
});




/*
 * Función para definir datatable de usuarios:
 */
function Listar_Casos(estatus=null) {
    let info;
    let rol_usuario=$('#rol_usuario').val();
    let ruta_imagen = rootpath;
    var encabezado = '';
    var table = $('#table_casos').DataTable({
        responsive: true,
      
        dom: "Bfrtip",
        buttons: {
            dom: {
                button: {
                    className: 'btn-xs-xs'
                },
            },
            buttons: [{
                    //definimos estilos del boton de pd
                    extend: "pdf",
                    text: 'PDF',
                    className: 'btn-xs btn-dark',
                    orientation: 'landscape',
                    pageSize: 'LETTER',
                    header: true,
                    footer: true,
                    download: 'open',
                    exportOptions: {
                        columns: [0, 1, 2, 3, 4, 5, 6, 7, 8],
                    },
                    alignment: 'center',

                    customize: function(doc) {
                        //Remove the title created by datatTables
                        doc.content.splice(0, 1);
                        doc.styles.title = {
                            color: '#4c8aa0',
                            fontSize: '18',
                            alignment: 'center'
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
                            // Create a header
                            doc.pageMargins = [40, 95, 0, 70];
                        doc['header'] = (function(page, pages) {
                            doc.styles.title = {
                                color: '#4c8aa0',
                                fontSize: '18',
                                alignment: 'center',
                            }
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
                                        text: 'Control de Casos',
                                        fontSize: 18,
                                    },
                                    {
                                        margin: [-600, 80, -25, 0],
                                        text: encabezado,
                                    },
                                ],
                            }
                        });
                        // Create a footer
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
                    //definimos estilos del boton de excel
                    extend: "excel",
                    text: 'Excel',
                    className: 'btn-xs btn-dark',
                    title: 'Control de Casos',

                    download: 'open',
                    exportOptions: {
                        columns: [0, 1, 2, 3, 4, 5, 6, 7, 8],
                    },
                    excelStyles: {
                        "template": [
                            "blue_medium",
                            "header_blue",
                            "title_medium"
                        ]
                    },

                }
            ]
        },
        
        order: [[7, (estatus === '1' || estatus === null) ? "asc" : "desc"]],
        "paging": true,
        "lengthChange": true,

        dom: 'Blfrtip',
        "searching": true,
        "lengthMenu": [
            [10, 25, 50, -1],
            ['10', '25', '50', 'Todos']
        ],
        "ordering": true,
        "info": true,
        autoWidth: false, // Cambiar a false para controlar el ancho manualmente

        ajax: {

            url: "/listar_Casos_Remitidos",

            type: "GET",

            dataSrc: ''

        },

       columns: [
    { data: 'casos_id', width: "5%" },
    { data: 'cedula', width: "10%" },
    { data: 'nombre', width: "20%" },
    { data: 'casotel', width: "10%" },
    { data: 'tipo_prop_nombre', width: "15%" },
    { data: 'tipo_aten_nombre', width: "12%" },
    { data: 'casofec', width: "5%" },
    { data: 'estnom', width: "3%" },
    { data: 'user_name', width: "10%" },
    {
        data: null,
        orderable: false, // Recomendado para columnas de acción
        render: function(data, type, row) {
            // Usamos template literals (`) para evitar el caos de las comillas y concatenaciones
            return `
                <a href="javascript:;" class="btn btn-xs btn-primary Seguimientos" style="font-size:1px" 
                    data-toggle="tooltip" title="Seguimientos" 
                    data-casoape="${row.casoape}" data-casonom="${row.casonom}" data-cedula="${row.casoced}" 
                    data-caso_nacionalidad="${row.caso_nacionalidad}" data-sexo="${row.sexo}" data-casotel="${row.casotel}" 
                    data-casofec_normal="${row.casofec_normal}" data-idrrss="${row.idrrss}" data-ofiid="${row.ofiid}" 
                    data-estadoid="${row.estadoid}" data-tipo_prop_id="${row.tipo_prop_id}" data-id_tipo_atencion="${row.id_tipo_atencion}" 
                    data-casodesc="${row.casodesc}" data-municipioid="${row.municipioid}" data-parroquiaid="${row.parroquiaid}" 
                    data-idcaso="${row.casos_id}">
                    <i class="material-icons">search</i>
                </a>

               

                <a href="javascript:;" class="btn btn-xs btn-success Remitir" style="font-size:1px" 
                    data-toggle="tooltip" title="Remitir" 
                    data-idcaso="${row.casos_id}" data-tipo_atend_id="${row.tipo_atend_id}">
                    <i class="material-icons">redo</i>
                </a>`;
        }
    }
],

        
        "language": {
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
            },
            "columnDefs": [{
                "targets": [0],
                "visible": false,
                "searchable": false
            }, ]

        },
        initComplete: function(settings, json) {
            // Recuperar el estado de la paginación
            let savedPage = localStorage.getItem('datatable_page');
            if (savedPage !== null) {
                table.page(parseInt(savedPage)).draw(false);
                localStorage.removeItem('datatable_page');
            }
        }
    });
     // Guardar el estado de la paginación antes de recargar la página
     table.on('page.dt', function () {
        let info = table.page.info();
        localStorage.setItem('datatable_page', info.page);
    });
}

//METODO PARA ABRIR EL MODAL PARA LA   EDICION DEL CASO
$('#listar_casos').on('click', '.Imprimir', function(e) {
    e.preventDefault();
    let idcaso = $(this).data('idcaso');
    window.open('generar_pdf/' + idcaso, '_blank');
    // window.location = '/generar_pdf/' + idcaso, '_blank'
});

//METODO PARA VER EL DETALLE DE LOS SEGUIMIENTOS
$('#listar_casos').on('click', '.Seguimientos', function(e) {
    e.preventDefault();
    let idcaso = $(this).data('idcaso');
    window.location = '/verCaso/' + idcaso;

});

//METODO PARA ELIMINAR UN SEGUIMIENTO
$('#listar_casos').on('click', '.Bloquear', function(e) {
    let idcaso = $(this).data('idcaso');
    let borrado = 'true'
    let datos = {
        idcaso: idcaso,
        borrado: borrado
    }
    Swal.fire({
        title: '¿Deseas Eliminar el Registro?',
        text: 'El registro será eliminado del Sitema.',
        icon: 'question',
        showCancelButton: true,
        confirmButtonText: 'Sí',
        cancelButtonText: 'No'
    }).then((result) => {
        if (result.value) {
            // Aquí puedes agregar la lógica para salir de la página
            $.ajax({
                url: "/eliminar_Caso",
                method: "POST",
                dataType: "JSON",
                data: {
                    "data": btoa(JSON.stringify(datos))
                },
                beforeSend: function() {

                }
            }).then((response) => {
                Swal.fire('Exito!', "Caso eliminado exitosamente", "success");
                $("#editUser").modal('hide');

                setTimeout(function() {
                    location.reload();
                }, 1500);
            }).catch((request) => {
                Swal.fire("Error!", "Ha ocurrido un error", "error");
                setTimeout(function() {
                    location.reload();
                }, 1500);
            });

        }
    });
});




$("#estatus").on('change', function(e) {

    let estatus = $('#estatus').val();
    $("#table_casos").dataTable().fnDestroy();
  
        Listar_Casos(estatus); // Fetch data first
    
});



//METODO PARA ABRIR EL MODAL PARA REMITIR EL CASO
$('#listar_casos').on('click', '.Remitir', function(e) {
    e.preventDefault();

    let idcaso = $(this).attr('data-idcaso');
   
    $("#remitir_caso").modal("show");
    $("#remitir_caso").find('#idcaso').val(idcaso);
});

$(document).on("submit", "#caso-remitido", function(e) {
    e.preventDefault();

    const $btnSubmit = $(this).find("button[type='submit']");
    const $contenedorMensaje = $("#mensaje");

    let datos = {
        "id_caso": $("#idcaso").val(),
        "direccion": $("#direcciones_caso").val(),
        "nombre_direccion": $('#direcciones_caso option:selected').text()
    };

    $.ajax({
        url: "/remitirCaso",
        method: "POST",
        dataType: "JSON",
        data: { data: btoa(unescape(encodeURIComponent(JSON.stringify(datos)))) },
        beforeSend: function() {
            // Deshabilitar botón para evitar doble clic
            $btnSubmit.attr('disabled', 'true').html('<i class="fas fa-spinner fa-spin mr-1"></i> Remitiendo...');
            
            // Mostrar mensaje de carga dentro del modal
            $contenedorMensaje
                .hide() // Lo ocultamos primero por si había uno previo
                .removeClass('alert-success alert-danger')
                .addClass('alert-info')
                .html('<i class="fas fa-sync fa-spin mr-2"></i> Procesando remisión, por favor espere...')
                .fadeIn();
        },
        success: function(respuesta) {
            if (respuesta.mensaje === 1) {
                $contenedorMensaje
                    .removeClass('alert-info alert-danger')
                    .addClass('alert-success')
                    .html('<strong><i class="fas fa-check-circle mr-1"></i> ¡EXITO!</strong> El caso Nº ' + respuesta.idcaso + ' ha sido remitido con éxito.');

                setTimeout(function() {
                    window.location = "/vista_casos_remitidos";
                }, 1600);

            } else {
                // Si es error tipo 2 o 3
                let textoError = (respuesta.mensaje === 3) 
                    ? 'La dirección seleccionada no tiene un correo asociado.' 
                    : 'No se pudo completar la remisión. Intente de nuevo.';
                
                let iconoError = (respuesta.mensaje === 3) ? 'fa-envelope-slash' : 'fa-times-circle';

                $contenedorMensaje
                    .removeClass('alert-info alert-success')
                    .addClass('alert-danger')
                    .html('<strong><i class="fas ' + iconoError + ' mr-1"></i> ERROR:</strong> ' + textoError);
                
                // Reactivamos el botón para que el usuario pueda intentar corregir
                $btnSubmit.removeAttr('disabled').html('<i class="fas fa-check-circle mr-2"></i> Confirmar Remisión');
            }
        },
        error: function() {
            $contenedorMensaje
                .removeClass('alert-info')
                .addClass('alert-danger')
                .html('<strong><i class="fas fa-exclamation-triangle mr-1"></i> Error Crítico:</strong> El servidor no responde.');
            
            $btnSubmit.removeAttr('disabled').html('<i class="fas fa-check-circle mr-2"></i> Confirmar Remisión');
        }
    });
});