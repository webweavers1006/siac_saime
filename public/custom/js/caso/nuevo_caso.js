$(function() {

    // let tipo_atencion_usu = $("#tipo-atencion-usu").val();
 
   
     llenar_Propiedad_Intelectual(Event);
     llenar_Estados(Event);
     llenar_pais(Event);
     llenar_Red_social(Event);
     llenar_Entes_asdcritos(Event);
     llenar_Tipo_Beneficiarios(Event);
     llenar_Organismos_PP(Event);
 });
 

//FUNCION PARA LLENAR EL COMBO ORGANISMOS DEL PODER POPULAR 
function llenar_Organismos_PP(e, id) {
    e.preventDefault;
    url = "/Listar_Organismo_PP_filtro";
    $.ajax({
        url: url,
        method: "GET",
        dataType: "JSON",
        beforeSend: function(data) {},
        success: function(data) {
            if (data.length >= 1) {
             $("#organismo-caso").empty();
                $("#organismo-caso").append(
                    "<option value=0  selected disabled>Seleccione</option>"
                );
                if (id === undefined) {
                    $.each(data, function(i, item) {
                        //
                        $("#organismo-caso").append(
                            "<option value=" +
                            item.org_id+
                            ">" +
                            item.org_nombre +
                            "</option>"
                        );
                    });
                } else {
                    $.each(data, function(i, item) {
                        if (item.id=== org_id) {
                            $("#organismo-caso").append(
                                "<option value=" +
                                item.org_id+
                                " selected>" +
                                item.org_nombre +
                                "</option>"
                            );
                        } else {
                            $("#organismo-caso").append(
                                "<option value=" +
                                item.org_id+
                                ">" +
                                item.org_nombre +
                                "</option>"
                            );
                        }
                    });
                }
            }
        },
        error: function(xhr, status, errorThrown) {
            
        },
    });
}








 
 //FUNCION PARA LLENAR EL COMBO TIPO DE BENEFICIARIOS
 function llenar_Tipo_Beneficiarios(e, id) {
    e.preventDefault;
    url = "/Listar_Tipo_Beneficiarios_filtro";
    $.ajax({
        url: url,
        method: "GET",
        dataType: "JSON",
        beforeSend: function(data) {},
        success: function(data) {
            if (data.length >= 1) {
             $("#t-beneficiario").empty();
                $("#t-beneficiario").append(
                    "<option value=0  selected disabled>Seleccione</option>"
                );
                if (id === undefined) {
                    $.each(data, function(i, item) {
                        //
                        $("#t-beneficiario").append(
                            "<option value=" +
                            item.tipo_beneficiario_id+
                            ">" +
                            item.tipo_beneficiario_nombre +
                            "</option>"
                        );
                    });
                } else {
                    $.each(data, function(i, item) {
                        if (item.id=== ente_adscrito_id) {
                            $("#t-beneficiario").append(
                                "<option value=" +
                                item.tipo_beneficiario_id+
                                " selected>" +
                                item.tipo_beneficiario_nombre +
                                "</option>"
                            );
                        } else {
                            $("#t-beneficiario").append(
                                "<option value=" +
                                item.tipo_beneficiario_id+
                                ">" +
                                item.tipo_beneficiario_nombre +
                                "</option>"
                            );
                        }
                    });
                }
            }
        },
        error: function(xhr, status, errorThrown) {
            
        },
    });
}
 
 //FUNCION PARA LLENAR EL COMBO ENTES ADSCRITOS
 function llenar_Entes_asdcritos(e, ente_adscrito_id) {
     e.preventDefault;
     url = "/Listar_Entes_asdcritos";
     $.ajax({
         url: url,
         method: "GET",
         dataType: "JSON",
         beforeSend: function(data) {},
         success: function(data) {
             if (data.length >= 1) {
              $("#ente-adscrito").empty();
                 $("#ente-adscrito").append(
                     "<option value=0  selected disabled>Seleccione</option>"
                 );
                 if (ente_adscrito_id === undefined) {
                     $.each(data, function(i, item) {
                         //
                         $("#ente-adscrito").append(
                             "<option value=" +
                             item.ente_id +
                             ">" +
                             item.ente_nombre +
                             "</option>"
                         );
                     });
                 } else {
                     $.each(data, function(i, item) {
                         if (item.ente_id === ente_adscrito_id) {
                             $("#ente-adscrito").append(
                                 "<option value=" +
                                 item.ente_id +
                                 " selected>" +
                                 item.ente_nombre +
                                 "</option>"
                             );
                         } else {
                             $("#ente-adscrito").append(
                                 "<option value=" +
                                 item.ente_id +
                                 ">" +
                                 item.ente_nombre +
                                 "</option>"
                             );
                         }
                     });
                 }
             }
         },
         error: function(xhr, status, errorThrown) {
             alert(xhr.status);
             alert(errorThrown);
         },
     });
 }
 
 //FUNCION PARA LLENAR EL COMBO DE LAS REDES SOCIALES
 function llenar_Red_social(e, id) {
     e.preventDefault;
     url = "/listar_Red_Social_filtro";
     $.ajax({
         url: url,
         method: "GET",
         dataType: "JSON",
         beforeSend: function(data) {},
         success: function(data) {
             if (data.length >= 1) {
                 $("#red-social").empty();
                 $("#red-social").append(
                     "<option value=0  selected disabled>Seleccione</option>"
                 );
                 if (id === undefined) {
                     $.each(data, function(i, item) {
                         //
                         $("#red-social").append(
                             "<option value=" +
                             item.red_s_id +
                             ">" +
                             item.red_s_nom +
                             "</option>"
                         );
                     });
                 } else {
                     $.each(data, function(i, item) {
                         if (item.id === id) {
                             $("#red-social").append(
                                 "<option value=" +
                                 item.red_s_id +
                                 " selected>" +
                                 item.red_s_nom +
                                 "</option>"
                             );
                         } else {
                             $("#red-social").append(
                                 "<option value=" +
                                 item.red_s_id +
                                 ">" +
                                 item.red_s_nom +
                                 "</option>"
                             );
                         }
                     });
                 }
             }
         },
         error: function(xhr, status, errorThrown) {
             alert(xhr.status);
             alert(errorThrown);
         },
     });
 }
 
 // FUNCION PARA LLENAR EL COMBO ESTADOS
function llenar_Estados(e, id) {
    const url = "/llenar_Estados"; // Usar const para variables que no cambian
    $.ajax({
        url: url,
        method: "GET",
        dataType: "JSON",
        beforeSend: function(data) {
            // Puedes agregar un loader o alguna indicación de que se está cargando
        },
        success: function(data) {
            //;
          
            if (data.length >= 1) {
                $("#estado-caso").empty(); // Limpiar el combo
                $("#estado-caso").append(
                    "<option value='0' selected disabled>Seleccione</option>"
                );
                $.each(data, function(i, item) {
                    // Agregar las opciones al combo
                    if (id === undefined) {
                        $("#estado-caso").append(
                            "<option value='" + item.estadoid + "'>" + item.estadonom + "</option>"
                        );
                    } else {
                       
                        if (item.estadoid === id) {
                            $("#estado-caso").append(
                                "<option value='" + item.estadoid + "' selected>" + item.estadonom + "</option>"
                            );
                        } else {
                            $("#estado-caso").append(
                                "<option value='" + item.estadoid + "'>" + item.estadonom + "</option>"
                            );
                        }
                    }
                });
            }
        },
        error: function(xhr, status, errorThrown) {
            alert("Error: " + xhr.status + " - " + errorThrown);
        },
    });
}

//FUNCION PARA LLENAR EL COMBO PAIS
function llenar_pais(e, id) {
    e.preventDefault;
    url = "/llenar_pais";
    $.ajax({
        url: url,
        method: "GET",
        dataType: "JSON",
        beforeSend: function(data) {},
        success: function(data) {
            if (data.length >= 1) {
                $("#pais-caso").empty();
               
                if (id === undefined) {
                    $.each(data, function(i, item) {
                        //
                        $("#pais-caso").append(
                            "<option value=" +
                            item.paisid +
                            ">" +
                            item.paisnom +
                            "</option>"
                        );
                    });
                } else {
                    $.each(data, function(i, item) {
                        if (item.id === id) {
                            $("#pais-caso").append(
                                "<option value=" +
                                item.paisid +
                                " selected>" +
                                item.paisnom +
                                "</option>"
                            );
                        } else {
                            $("#pais-caso").append(
                                "<option value=" +
                                item.paisid +
                                ">" +
                                item.paisnom +
                                "</option>"
                            );
                        }
                    });
                }
            }
        },
        error: function(xhr, status, errorThrown) {
            alert(xhr.status);
            alert(errorThrown);
        },
    });
}


 
 //FUNCION PARA LLENAR EL COMBO TIPO DE PROPIEDAD INTELECTUAL
 function llenar_Propiedad_Intelectual(e, id) {
     e.preventDefault;
     url = "/Listar_Propiedad_Intelectual_MOD";
     $.ajax({
         url: url,
         method: "GET",
         dataType: "JSON",
         beforeSend: function(data) {},
         success: function(data) {
             if (data.length >= 1) {
                 $("#tipo-pi").empty();
                 $("#tipo-pi").append(
                     "<option value=0  selected disabled>Seleccione</option>"
                 );
                 if (id === undefined) {
                     $.each(data, function(i, item) {
                         //
                         $("#tipo-pi").append(
                             "<option value=" +
                             item.tipo_prop_id +
                             ">" +
                             item.tipo_prop_nombre +
                             "</option>"
                         );
                     });
                 } else {
                     $.each(data, function(i, item) {
                         if (item.id === id) {
                             $("#tipo-pi").append(
                                 "<option value=" +
                                 item.tipo_prop_id +
                                 " selected>" +
                                 item.tipo_prop_nombre +
                                 "</option>"
                             );
                         } else {
                             $("#tipo-pi").append(
                                 "<option value=" +
                                 item.tipo_prop_id +
                                 ">" +
                                 item.tipo_prop_nombre +
                                 "</option>"
                             );
                         }
                     });
                 }
             }
         },
         error: function(xhr, status, errorThrown) {
             alert(xhr.status);
             alert(errorThrown);
         },
     });
 }
 
// Función para llenar el combo tipo de atención usuario con formación








 //Evento que busca los municipios por estados
 $(document).on("click", "#estado-caso", (e) => {
     e.preventDefault();
 
     let datos = {
         id_estado: $("#estado-caso").val(),
     };
     $.ajax({
             url: "/municipios",
             method: "POST",
             dataType: "JSON",
             data: {
                 data: btoa(JSON.stringify(datos)),
             },
         })
         .then((response) => {
             $("#municipio-caso").html(response.data);
 
             let mun = $("#municipio-caso").val();
 
             if (mun != 0) {
                 let datos = {
                     id_municipio: $("#municipio-caso").val(),
                 };
                 $.ajax({
                         url: "/parroquias",
                         method: "POST",
                         dataType: "JSON",
                         data: {
                             data: btoa(JSON.stringify(datos)),
                         },
                     })
                     .then((response) => {
                         $("#parroquia-caso").html(response.data);
                     })
                     .catch((request) => {
                         Swal.fire("Error", response.JSONmessage, "Error");
                     });
             }
         })
         .catch((request) => {
             Swal.fire("Error", response.JSONmessage, "Error");
         });
 });
 //Evento que busca las parroquias por municipio
 $(document).on("click", "#municipio-caso", (e) => {
     e.preventDefault();
     let datos = {
         id_municipio: $("#municipio-caso").val(),
     };
     $.ajax({
             url: "/parroquias",
             method: "POST",
             dataType: "JSON",
             data: {
                 data: btoa(JSON.stringify(datos)),
             },
         })
         .then((response) => {
             $("#parroquia-caso").html(response.data);
         })
         .catch((request) => {
             Swal.fire("Error", response.JSONmessage, "Error");
         });
 });
 
 $("#red-social").on('change', function() {
     $("#red-social").removeClass('is-invalid');
     id_red_social=$('#red-social').val();  
     
    llenar_Tipo_Atencion(Event,id_red_social);   
  
 });
 
 $("#estado-caso").on('change', function() {
     $("#estado-caso").removeClass('is-invalid');
 });
 $("#tipo-pi").on('change', function() {
     $("#tipo-pi").removeClass('is-invalid');
 
 });



 function llenar_Tipo_Atencion(e, idRedSocial) {
    let url = "/buscar_via_tipo_atencion/" + idRedSocial;
    $.ajax({
        url: url,
        method: "GET",
        dataType: "JSON",
        beforeSend: function() {
            // Puedes agregar un loader o alguna acción antes de la solicitud
        },
        success: function(data) {
            let $select = $("#tipo-atencion-usu");
            $select.empty();
            $select.append("<option value='0' selected disabled>Seleccione</option>");
            $.each(data, function(index, item) {
                $select.append($('<option></option>')
                    .val(item.tipo_atencion_id)
                    .text(item.tipo_aten_nombre)
                    .attr('data-act-pro-int', item.act_pro_int)
                    .attr('data-organismo_pp', item.organismo_pp)
                );
            });
        },
        error: function(xhr) {
            alert("Error: " + xhr.status + " - " + xhr.statusText);
        },
    });
}




 
 // Evento change para el select de tipo de atención
 $("#tipo-atencion-usu").on('change', function(e) {
    document.getElementById("detalles_atencion").disabled = false;
    $("#hijos_tipoatencion").val('NO');
    let idTipoAtencion = $(this).val(); 
    let selectedOption = $(this).find('option:selected');

    let actProInt = selectedOption.data('act-pro-int');
    let organismoPp = selectedOption.data('organismo_pp');
    // Muestra u oculta elementos según el tipo de atención
    if (idTipoAtencion == 5 || idTipoAtencion == 1) {
        $("#denuncias").toggle(idTipoAtencion == 5);
        $(".tipoproint").toggle(actProInt === 't');
        document.getElementById("tipo-pi").disabled = (actProInt !== 't');
        $(".org_pp").toggle(organismoPp === 't');
        document.getElementById("organismo-caso").disabled = (organismoPp !== 't');
    } else {
        $("#cgr").hide();
        $("#denuncias").hide();
        $(".tipoproint").toggle(actProInt === 't');
        document.getElementById("tipo-pi").disabled = (actProInt !== 't');
        $(".org_pp").toggle(organismoPp === 't');
        document.getElementById("organismo-caso").disabled = (organismoPp !== 't');
    }
    // Llama a la función para llenar detalles de atención
    llenar_detalle_atencion(e, idTipoAtencion);
});



$("#pais-caso").on('change', function() {

    $("#pais-caso").removeClass('is-invalid');
    var pais = $('#pais-caso').val();  
    if (pais != 1) 
    {
        llenar_Estados(Event, '26'); 
        $("#municipio-caso").val('336');
        $("#parroquia-caso").val('1135');
       
        $("#estado-caso").prop('disabled', true);
        $("#municipio-caso").prop('disabled', true);
        $("#parroquia-caso").prop('disabled', true);

        let datos_m = {
            id_estado: 26,
        };

        $.ajax({
            url: "/municipios",
            method: "POST",
            dataType: "JSON",
            data: {
                data: btoa(JSON.stringify(datos_m)),
            },
        })
        .then((response) => {
            $("#municipio-caso").html(response.data);

            // Cargar parroquias solo si hay municipios
            let mun = $("#municipio-caso").val();
            if (mun != 0) {
                let datos_p = {
                    id_municipio: mun,
                };
                return $.ajax({
                    url: "/parroquias",
                    method: "POST",
                    dataType: "JSON",
                    data: {
                        data: btoa(JSON.stringify(datos_p)),
                    },
                });
            }
        })
        .then((response) => {
            $("#parroquia-caso").html(response.data);
        })
        .catch((request) => {
            Swal.fire("Error", request.responseJSON.message || "Error al cargar datos", "error");
        });
        
    } 
    else
    {
        // Si el país es 1, restablecer y deshabilitar selectores

        $("#estado-caso").val('0').prop('disabled', false); // Restablecer y deshabilitar
        $("#municipio-caso").val('0').prop('disabled', false); // Restablecer y deshabilitar
        $("#parroquia-caso").val('0').prop('disabled', false); // Restablecer y deshabilitar
        llenar_Estados(Event, '1'); 
        $("#municipio-caso").val('1');
        $("#parroquia-caso").val('1');

        let datos_m = {
            id_estado: 1,
        };

        $.ajax({
            url: "/municipios",
            method: "POST",
            dataType: "JSON",
            data: {
                data: btoa(JSON.stringify(datos_m)),
            },
        })
        .then((response) => {
            $("#municipio-caso").html(response.data);

            // Cargar parroquias solo si hay municipios
            let mun = $("#municipio-caso").val();
            if (mun != 0) {
                let datos_p = {
                    id_municipio: mun,
                };
                return $.ajax({
                    url: "/parroquias",
                    method: "POST",
                    dataType: "JSON",
                    data: {
                        data: btoa(JSON.stringify(datos_p)),
                    },
                });
            }
        })
        .then((response) => {
            $("#parroquia-caso").html(response.data);
        })
        .catch((request) => {
            Swal.fire("Error", request.responseJSON.message || "Error al cargar datos", "error");
        });

    }
});







function  llenar_detalle_atencion(e,idTipoAtencion)
{

    e.preventDefault;
    
      url='/Listar_Detalle_Atencion_filtro';
       $.ajax
      ({
           url:url,
           method:'GET',
          dataType:'JSON',
          beforeSend:function(data)
          {
          },
          success:function(data)
          {
          
if(data.length>=1)
{
     $('#detalles_atencion').empty();
     $('#detalles_atencion').append('<option value=0  selected disabled>Seleccione</option>');   
     if(idTipoAtencion===undefined)
    {
      
      
         $.each(data, function(i, item)
         {
           $(".detelle_atencion").hide();
              //
              $('#detalles_atencion').append('<option value='+item.tipo_atend_id+'>'+item.tipo_atend_nombre+'</option>');

         });
    }
    else
    {
       $(".detelle_atencion").hide();
       data=data.filter(dato=>dato.tipo_aten_id==idTipoAtencion);
       //console.log(buscar);
          $.each(data, function(i, item)
          {
          
   
           $(".detelle_atencion").show();
           $("#hijos_tipoatencion").val('SI');
           $('#detalles_atencion').append('<option value='+item.tipo_atend_id+'>'+item.tipo_atend_nombre+'</option>');    
         });
    }
}      
},
error:function(xhr, status, errorThrown)
{
    alert(xhr.status);
    alert(errorThrown);
}
});
}


 $("#requerimiento-usuario").on('change', function() {
     $("#requerimiento-usuario").removeClass('is-invalid');
 });




 //METODO PARA GUARDAR EL CASO 
 $(document).on("click", "#guardar", function(e) {
     e.preventDefault();
     let tipo_prop_intelec = $("#tipo-pi").val();
     let tipo_atencion = $("#tipo-atencion-usu").val();
     let tipo_atend_id = $("#detalles_atencion").val();
     let requerimiento_user = $("#requerimiento-usuario").val();
     let red_social = $("#red-social").val();
     let estado = $("#estado-caso").val();
     let org_id = $("#organismo-caso").val();
        if (org_id == null || org_id == '') {
            org_id = 1; 
        }

     let sexo = $("#sexo").val();
     requerimiento_user = requerimiento_user.trim();
     if (red_social == null) {
         $("#red-social").addClass('is-invalid');
 
         Swal.fire({
             icon: "success",
             type: 'error',
             html: '<strong>DEBE SELECCIONAR LA VIA DE ATENCION.</strong>',
 
             toast: true,
             position: "center",
             showConfirmButton: false,
             timer: 3500,
         });
     } else if (estado == null) {
         $("#red-social").removeClass('is-invalid');
         $("#estado-caso").addClass('is-invalid');
         Swal.fire({
             icon: "success",
             type: 'error',
             html: '<strong>EL CAMPO ESTADO ES OBLIGATORIO.</strong>',
             toast: true,
             position: "center",
             showConfirmButton: false,
             timer: 3500,
         });
     } 
     else if (tipo_atencion == null) {
         $("#tipo-pi").removeClass('is-invalid');
         $("#tipo-atencion-usu").addClass('is-invalid');
         Swal.fire({
             icon: "success",
             type: 'error',
             html: '<strong>EL USUARIO DEBE TENER ALGUN TIPO DE ATENCION</strong>',
             toast: true,
             position: "center",
             showConfirmButton: false,
             timer: 3500,
         })
     } else if (requerimiento_user == '') {
         $("#tipo-atencion-usu").removeClass('is-invalid');
         $("#requerimiento-usuario").addClass('is-invalid');
         $
         Swal.fire({
             icon: "success",
             type: 'error',
             html: '<strong>DEBE INDICAR LA DESCRIPCION DEL CASO .</strong>',
             toast: true,
             position: "center",
             showConfirmButton: false,
             timer: 3500,
         });
     } else {
         $("button[type=button]").attr('disabled', 'false');
         $("#red-social").removeClass('is-invalid');
         $("#estado-caso").removeClass('is-invalid');
         $("#tipo-pi").removeClass('is-invalid');
         $("#tipo-atencion-usu").removeClass('is-invalid');
         $("#requerimiento-usuario").removeClass('is-invalid');

         //VERIFICO SI LA ATENCION ES ASESORIA PARA TOMAR EL VALOR DE LOS CAMPOS CORREPONDIENTES

         let tipo_atencion_usu = $("#tipo-atencion-usu").val();
         //VARIABLES PARA CGR
         let competencia_crg =2;
         let asume_crg= 2;
         let ente_adscrito
         let bandera_cgr = false;
         //VARIABLES PARA LA DEDUNCIA
         let option_personal
         let option_comunidad
         let option_terceros
         let bandera_denuncia = false;
         let fecha_hechos = $('#fecha-hechos').val();
         let denu_involucrados = $('#denu-involucrados').val();
         denu_involucrados = denu_involucrados.trim();
         let nombre_instancia = $('#nombre-instancia').val();
         let rif_instancia = $('#rif-instancia').val();
         let ente_financiador = $('#ente-financiador').val();
         let nombre_proyecto = $('#nombre-proyecto').val();
         let monto_aprovado = $('#monto-aprovado').val();
    
         if (tipo_atencion === '1') 
        {
             if (tipo_prop_intelec == null) {
                     $("#estado-caso").removeClass('is-invalid');
                     $("#tipo-pi").addClass('is-invalid');
                     Swal.fire({
                         icon: "success",
                         type: 'error',
                         html: '<strong>DEBE SELECCIONAR UN TIPO DE PROPIEDAD INTELECTUAL.</strong>',
                         toast: true,
                         position: "center",
                         showConfirmButton: false,
                         timer: 3500,
                     });
                 }else
                 {

                   



                     // competencia_crg = $("#competencia-cgr").val()
                     // asume_crg = $("#asume-cgr").val()
                     // if (competencia_crg == null) {
                     //   alert('DEBE INDICAR SI APLICA O NO  LA COMPETENCIA DEL CGR')
                     //} //else if (asume_crg == null) {
                     // alert('DEBE INDICAR SI ASUME CGR')
                     // } else {
                 bandera_cgr = true;
                     // valor_competencia = $("#competencia-cgr").val();
                     // valor_asume = $("#asume-cgr").val();
                     let cedula= $("#cedula-persona").val()
                     if (cedula.charAt(0).match(/[a-zA-Z]/))
                     {
                         cedula = cedula.slice(1);
                     }
                  let datos = {
                      "social_network": $("#red-social").val(),
                      "date-entry": $("#fecha-recibido").val(),
                      "person-name": $("#nombre-persona").val(),
                      "person-lastname": $("#apellido-persona").val(),
                      "person-id": cedula,
                      "nacionalidad": $("#tipo-persona").val(),
                      "telephone": $("#telefono").val(),
                      "country": $("#pais-caso").val(),
                      "state": $("#estado-caso").val(),
                      "county": $("#municipio-caso").val(),
                      "town": $("#parroquia-caso").val(),
                      "bandera_denuncia": bandera_denuncia,
                      "record-work": $("#num-tramite").val(),
                      "pi-type": $("#tipo-pi").val(),
                      "user-requirement": $("#requerimiento-usuario").val(),
                      "office": $("#office").val(),
                      "tipo-atencion-usu": $("#tipo-atencion-usu").val(),
                      "sexo": $("#sexo").val(),
                      "bandera_cgr": bandera_cgr,
                      "tipo_atend_id": tipo_atend_id,
                      "edad": $("#edad").val(),
                      "fecha_nacimiento": $("#fecha-nacimiento").val(),
                      "profesion": $("#profesion").val(),
                      "competencia_crg": competencia_crg,
                      "asume_crg": asume_crg,
                      "tipo_beneficiario": $("#t-beneficiario").val(),
                      "direccion": $("#office").val(),
                      "correo": $("#correo").val(),
                      "profesion": $("#profesion").val(),
                      "ente_adscrito": 0,
                      "organismo-caso": org_id,
                      //"ente_adscrito": $("#ente-adscrito").val(0),
                  }
                  
                  $.ajax({
                      url: "/registrarCaso",
                      method: "POST",
                      dataType: "JSON",
                      data: {
                          "data": btoa(JSON.stringify(datos))
                      },
                      beforeSend: function() {
                          
                      },
                      success: function(respuesta) {
                         $("button[type=button]").attr('disabled', 'false');
                          if (respuesta.mensaje === 1) {
                              Swal.fire({
                                  icon: "success",
                                  type: 'success',
                                  html: '<strong>Caso registrado exitosamente con el Nª' + ' ' + ' ' + respuesta.idcaso + '</strong>',
                                  toast: true,
                                  position: "center",
                                  showConfirmButton: false,
                                  //timer: 3500,
                              });
                              setTimeout(function() {
                                  window.location = "/casos";
                              }, 1500);
                          } else if (respuesta.mensaje === 2) {
                              Swal.fire({
                                  icon: "error",
                                  type: 'error',
                                  html: '<strong>Hubo un error en el registro del requerimiento del usuario .</strong>',
                                  toast: true,
                                  position: "center",
                                  showConfirmButton: false,
                                  //timer: 3000,
                              });
                              setTimeout(function() {
                                  window.location = "/casos";
                              }, 1500);
                          }
                          else if (respuesta.mensaje === 7) {
                            Swal.fire({
                                icon: "error",
                                type: 'error',
                                html: '<strong>Hubo un error en el registro del requerimiento del usuario .</strong>',
                                toast: true,
                                position: "center",
                                showConfirmButton: false,
                                //timer: 3000,
                            });
                            setTimeout(function() {
                                window.location = "/casos";
                            }, 1500);
                        }
                        //NO SE ENCONTRO EL ID DEL USUARIO
                        else if (respuesta.mensaje === 8) {
                            Swal.fire({
                                icon: "error",
                                type: 'error',
                                html: '<strong>Hubo un error en el proceso del registro .</strong>',
                                toast: true,
                                position: "center",
                                showConfirmButton: false,
                                //timer: 3000,
                            });
                            setTimeout(function() {
                                window.location = "/casos";
                            }, 1500);
                        }
                      }
                  });
 
                 }
 
            
             } 
             else if (tipo_atencion === '5') 
            {
                    if (document.getElementById('option-personal').checked) {
                        option_personal = true
                    } else {
                        option_personal = false
                    }
                    if (document.getElementById('option-comunidad').checked) {
                        option_comunidad = true
                    } else {
                        option_comunidad = false
                    }
                    if (document.getElementById('option-terceros').checked) {
                        option_terceros = true
                    } else {
                        option_terceros = false
                    }
        
                    if (option_personal == false && option_comunidad == false && option_terceros == false) {
                        alert('Debe indicar a quien afecta el hecho');
                    } else {
                        ente_adscrito = 0
                        if (fecha_hechos == '') {
                            alert('Debe selecciar la fecha en que ocurrieron los hechos');
        
                        } else if (denu_involucrados === '') {
                            $("#denu-involucrados").addClass('is-invalid');
                            alert('Este campo es requerido , por favor introduzca la informacion solicitada');
                        } else {
                            bandera_denuncia = true;
        
                            let tipo_prop_intelec = $("#tipo-pi").val();

             
                            if (tipo_prop_intelec !=null && tipo_prop_intelec !='null') 
                           {
                               prop_intelectual= $("#tipo-pi").val();
                           }
                           else
                           {
                               prop_intelectual = 1
               
                           }

                           
                            let cedula= $("#cedula-persona").val()
                            if (cedula.charAt(0).match(/[a-zA-Z]/))
                            {
                                cedula = cedula.slice(1);
                            }
                            $("#denu-involucrados").removeClass('is-invalid');
                            let datos = {
                                "social_network": $("#red-social").val(),
                                "date-entry": $("#fecha-recibido").val(),
                                "person-name": $("#nombre-persona").val(),
                                "person-lastname": $("#apellido-persona").val(),
                                "person-id": cedula,
                                "nacionalidad": $("#tipo-persona").val(),
                                "telephone": $("#telefono").val(),
                                "country": $("#pais-caso").val(),
                                "state": $("#estado-caso").val(),
                                "county": $("#municipio-caso").val(),
                                "town": $("#parroquia-caso").val(),
                                "record-work": $("#num-tramite").val(),
                                "pi-type": prop_intelectual = 1,
                                "user-requirement": $("#requerimiento-usuario").val(),
                                "office": $("#office").val(),
                                "tipo-atencion-usu": $("#tipo-atencion-usu").val(),
                                "sexo": $("#sexo").val(),
                                "tipo_atend_id": tipo_atend_id,
                                "bandera_denuncia": bandera_denuncia,
                                "option_personal": option_personal,
                                "option_comunidad": option_comunidad,
                                "option_terceros": option_terceros,
                                "fecha_hechos": fecha_hechos,
                                "denu_involucrados": denu_involucrados,
                                "nombre_instancia": nombre_instancia,
                                "rif_instancia": rif_instancia,
                                "ente_financiador": ente_financiador,
                                "nombre_proyecto": nombre_proyecto,
                                "monto_aprovado": monto_aprovado,
                                "bandera_cgr": bandera_cgr,
                                "tipo_beneficiario": $("#t-beneficiario").val(),
                                "direccion": $("#office").val(),
                                "correo": $("#correo").val(),
                                "ente_adscrito": ente_adscrito,
                                "edad": $("#edad").val(),
                                "fecha_nacimiento": $("#fecha-nacimiento").val(),
                                "profesion": $("#profesion").val(),
                                "organismo-caso": org_id,
                                
                            }
                            $.ajax({
                                url: "/registrarCaso",
                                method: "POST",
                                dataType: "JSON",
                                data: {
                                    "data": btoa(JSON.stringify(datos))
                                },
                                beforeSend: function() {
                                    
                                },
                                success: function(respuesta) {
                                    $("button[type=button]").attr('disabled', 'false');
                                    if (respuesta.mensaje === 1) {
                                        Swal.fire({
                                            icon: "success",
                                            type: 'success',
                                            html: '<strong>Caso registrado exitosamente con el Nª' + ' ' + ' ' + respuesta.idcaso + '</strong>',
                                            toast: true,
                                            position: "center",
                                            showConfirmButton: false,
                                            //timer: 3500,
                                        });
                                        setTimeout(function() {
                                            window.location = "/casos";
                                        }, 1500);
                                    } else if (respuesta.mensaje === 2) {
                                        Swal.fire({
                                            icon: "error",
                                            type: 'error',
                                            html: '<strong>Hubo un error en el registro del requerimiento del usuario .</strong>',
                                            toast: true,
                                            position: "center",
                                            showConfirmButton: false,
                                            //timer: 3000,
                                        });
                                        setTimeout(function() {
                                            window.location = "/casos";
                                        }, 1500);
                                    }
                                    else if (respuesta.mensaje === 7) {
                                        Swal.fire({
                                            icon: "error",
                                            type: 'error',
                                            html: '<strong>Hubo un error en el registro del requerimiento del usuario .</strong>',
                                            toast: true,
                                            position: "center",
                                            showConfirmButton: false,
                                            //timer: 3000,
                                        });
                                        setTimeout(function() {
                                            window.location = "/casos";
                                        }, 1500);
                                    }
                                }
                                
                            });
                        }
        
                    }
 
         }
         
         else 
         {
             bandera_cgr = false;
             bandera_denuncia = false;
             valor_competencia = '';
             ente_adscrito = 0
             valor_asume = '';

             let tipo_prop_intelec = $("#tipo-pi").val();

             
             if (tipo_prop_intelec !=null && tipo_prop_intelec !='null') 
            {
                prop_intelectual= $("#tipo-pi").val();
            }
            else
            {
                prop_intelectual = 1

            }


       
       
             let cedula= $("#cedula-persona").val()
             if (cedula.charAt(0).match(/[a-zA-Z]/))
             {
                 cedula = cedula.slice(1);
             }
             let datos = {
                 "social_network": $("#red-social").val(),
                 "date-entry": $("#fecha-recibido").val(),
                 "person-name": $("#nombre-persona").val(),
                 "person-lastname": $("#apellido-persona").val(),
                 "person-id": cedula,
                 "tipo_atend_id": tipo_atend_id,
                 "nacionalidad": $("#tipo-persona").val(),
                 "telephone": $("#telefono").val(),
                 "country": $("#pais-caso").val(),
                 "state": $("#estado-caso").val(),
                 "county": $("#municipio-caso").val(),
                 "town": $("#parroquia-caso").val(),
                 "record-work": $("#num-tramite").val(),
                 "pi-type":prop_intelectual,
                 "user-requirement": $("#requerimiento-usuario").val(),
                 "office": $("#office").val(),
                 "tipo-atencion-usu": $("#tipo-atencion-usu").val(),
                 "sexo": $("#sexo").val(),
                 "bandera_cgr": bandera_cgr,
                 "bandera_denuncia": bandera_denuncia,
                 "competencia_crg": competencia_crg,
                 "ente_adscrito": ente_adscrito,
                 "asume_crg": asume_crg,
                 "tipo_beneficiario": $("#t-beneficiario").val(),
                 "direccion": $("#office").val(),
                 "correo": $("#correo").val(),
                 "edad": $("#edad").val(),
                 "fecha_nacimiento": $("#fecha-nacimiento").val(),
                 "profesion": $("#profesion").val(),
                 "organismo-caso": org_id,
             }
             $.ajax({
                 url: "/registrarCaso",
                 method: "POST",
                 dataType: "JSON",
                 data: {
                     "data": btoa(JSON.stringify(datos))
                 },
                 beforeSend: function() {
                     
                 },
                 success: function(respuesta) {
                     $("button[type=button]").attr('disabled', 'false');
                     if (respuesta.mensaje === 1) {
                         Swal.fire({
                             icon: "success",
                             type: 'success',
                             html: '<strong>Caso registrado exitosamente con el Nª' + ' ' + ' ' + respuesta.idcaso + '</strong>',
                             toast: true,
                             position: "center",
                             showConfirmButton: false,
                             //timer: 3500,
 
                         });
                         setTimeout(function() {
                             window.location = "/casos";
                         }, 1500);
                     } else if (respuesta.mensaje === 2) {
                         Swal.fire({
                             icon: "error",
                             type: 'error',
                             html: '<strong>Hubo un error en el registro del requerimiento del usuario .</strong>',
                             toast: true,
                             position: "center",
                             showConfirmButton: false,
                             //timer: 1500,
                         });
                         setTimeout(function() {
                             window.location = "/casos";
                         }, 1500);
                     }
                     else if (respuesta.mensaje === 7) {
                        Swal.fire({
                            icon: "error",
                            type: 'error',
                            html: '<strong>Hubo un error en el registro del requerimiento del usuario .</strong>',
                            toast: true,
                            position: "center",
                            showConfirmButton: false,
                            //timer: 3000,
                        });
                        setTimeout(function() {
                            window.location = "/casos";
                        }, 1500);
                    }
                 }
             });
         }
 
     }
 
 
 });

 $('#btn_buscar').on('click',function(e)
 {  
     e.preventDefault
     let cedula_normal = $("#cedula-existente").val().trim();
    let cedula_existente = $("#cedula-existente").val().trim();
    if (cedula_existente.charAt(0).match(/[a-zA-Z]/))
    {
        cedula_existente = cedula_existente.slice(1);
    }
      
    if (cedula_existente==''||cedula_existente==null) 
    {
        alert('Debe ingresar la cédula para los datos del Usuario');   
    }else
    {
        var url='/buscar_datos_usuarios';
        var data=
        {
            cedula_existente: cedula_existente,
        }
         $.ajax
         ({
             url:url,
             method:'POST',
             data:{data:btoa(unescape(encodeURIComponent(JSON.stringify(data))))},
             dataType:'JSON',
             beforeSend:function(data)
             {
             },
             success:function(data)
             {    

              
                if (data==0) 
                {
                   alert('La cedula no se encuentra registrada');
                   $("#cedula-persona").val(cedula_existente);
                }else
                {
                   
                     // Accede al objeto data
                const caso = data[0];
                const nombre = caso.casonom ;
                const apellido = caso.casoape ;
                const cedula = cedula_normal;
                let nacionalidad = caso.caso_nacionalidad;
                if (nacionalidad == 'null' || nacionalidad == null) {
                    nacionalidad = 'V'; 
                }
                
               
                const beneficiario = caso.tipo_beneficiario;
                const genero = caso.sexo;
                const telefono = caso.casotel;
                const correo = caso.correo;
                const estado = caso.estadoid;
                const municipio = caso.municipioid;
                const parroquia = caso.parroquiaid;
                const tipo_atencion = caso.idTipoAtencion;
                const fecha_nacimiento = caso.fecha_nacimiento;
                const edad = caso.edad;
                const profesion = caso.profesion;

           
             
                
    
                // Asigna el nombre al valor del atributo value del input
                const nombreInput = document.getElementById("nombre-persona");
                nombreInput.value = nombre;
                const apellidoInput = document.getElementById("apellido-persona");
                apellidoInput.value = apellido;
                const cedulaInput = document.getElementById("cedula-persona");
                cedulaInput.value = cedula;
                const telefonoInput = document.getElementById("telefono");
                telefonoInput.value = telefono;
                const correoInput = document.getElementById("correo");
                correoInput.value = correo;


                // Obtener la fecha de nacimiento seleccionada
                var fechaNacimiento = new Date(fecha_nacimiento); // Asegúrate de que fecha_nacimiento sea una cadena válida
                var hoy = new Date();

                // Calcular la edad
                var edad_actual = hoy.getFullYear() - fechaNacimiento.getFullYear();
                var mes = hoy.getMonth() - fechaNacimiento.getMonth();

                // Ajustar la edad si no ha cumplido años este año
                if (mes < 0 || (mes === 0 && hoy.getDate() < fechaNacimiento.getDate())) {
                    edad_actual--;
                }

                // Asignar la edad al elemento con id='edad'
                $("#edad").val(edad_actual);


              




                const fecha_nacimientoInput = document.getElementById("fecha-nacimiento");
                fecha_nacimientoInput.value = fecha_nacimiento;

                const profesionInput = document.getElementById("profesion");
                profesionInput.value = profesion;

                //NACIONALIDAD
                const nacionalidadselect = document.getElementById("tipo-persona");
                const indicenacionalidad = Array.from(nacionalidadselect.options).findIndex(option => option.value === nacionalidad);
                nacionalidadselect.selectedIndex = indicenacionalidad;
                //BENEFICIARIO
                const beneficiarioselect = document.getElementById("t-beneficiario");
                const indicebeneficiario = Array.from(beneficiarioselect.options).findIndex(option => option.value === beneficiario);
                beneficiarioselect.selectedIndex = indicebeneficiario;
                 //SEXO
                 const sexoselect = document.getElementById("sexo");
                 const indicesexo = Array.from(sexoselect.options).findIndex(option => option.value === genero);
                 sexoselect.selectedIndex = indicesexo;
                 //ESTADO
                 const estadoselect = document.getElementById("estado-caso");
                 const indiceestado = Array.from(estadoselect.options).findIndex(option => option.value === estado);
                 estadoselect.selectedIndex = indiceestado;
                 //MUNICIPIO
                 let datos = {
                    id_estado: $("#estado-caso").val(),
                };
                $.ajax({
                        url: "/municipios",
                        method: "POST",
                        dataType: "JSON",
                        data: {
                            data: btoa(JSON.stringify(datos)),
                        },
                    })
                    .then((response) => {
                        $("#municipio-caso").html(response.data);
            
                        let mun = $("#municipio-caso").val();
            
                        if (mun != 0) {
                            let datos = {
                                id_municipio: $("#municipio-caso").val(),
                            };
                            $.ajax({
                                    url: "/parroquias",
                                    method: "POST",
                                    dataType: "JSON",
                                    data: {
                                        data: btoa(JSON.stringify(datos)),
                                    },
                                })
                                .then((response) => {
                                    $("#parroquia-caso").html(response.data);
                                })
                                .catch((request) => {
                                    Swal.fire("Error", response.JSONmessage, "Error");
                                });
                        }
                    })
                    .catch((request) => {
                        Swal.fire("Error", response.JSONmessage, "Error");
                    });
                // //PARROQUIA
                let datos2 = {
                    id_municipio: $("#municipio-caso").val(),
                };
                $.ajax({
                        url: "/parroquias",
                        method: "POST",
                        dataType: "JSON",
                        data: {
                            data: btoa(JSON.stringify(datos2)),
                        },
                    })
                    .then((response) => {
                        $("#parroquia-caso").html(response.data);
                    })
                    .catch((request) => {
                        Swal.fire("Error", response.JSONmessage, "Error");
                    });



                }
               
             },

            error:function(xhr, status, errorThrown)
            {
                 alert(xhr.status);
                 alert(errorThrown);
            }
        });
    }
         
}); 


$("#fecha-nacimiento").on('change', function() {
    // Obtener la fecha de nacimiento seleccionada
    var fechaNacimiento = new Date($(this).val());
    var hoy = new Date();
    
    // Calcular la edad
    var edad = hoy.getFullYear() - fechaNacimiento.getFullYear();
    var mes = hoy.getMonth() - fechaNacimiento.getMonth();
    
    // Ajustar la edad si no ha cumplido años este año
    if (mes < 0 || (mes === 0 && hoy.getDate() < fechaNacimiento.getDate())) {
        edad--;
    }
    // Asignar la edad al elemento con id='edad'
    $("#edad").val(edad);
});

