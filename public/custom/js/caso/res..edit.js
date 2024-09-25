 // valore anteriores para luego comparar
 let nombre = $(this).attr('casonom');
 let nombre_anterior = nombre
 let apellido = $(this).attr('casoape');
 let apellido_anterior = apellido
 let cedula = $(this).attr('cedula');
 let cedula_anterior = cedula
 let nacionalidad = $(this).attr('caso_nacionalidad');
 let nacionalidad_anterior = nacionalidad
 let sexo = $(this).attr('sexo');
 let sexo_anterior = sexo
 let casotel = $(this).attr('casotel');
 let casotel_anterior = casotel
 let casofec_normal = $(this).attr('casofec_normal');
 let casofec_normal_anterior = casofec_normal
 let idrrss = $(this).attr('idrrss');
 let idrrss_anterior = idrrss
 let ofiid = $(this).attr('ofiid');
 let ofiid_anterior = ofiid
 let estadoid = $(this).attr('estadoid');
 let estadoid_anterior = estadoid
 let tipo_prop_id = $(this).attr('tipo_prop_id');
 let tipo_prop_id_anterior = tipo_prop_id
 let id_tipo_atencion = $(this).attr('id_tipo_atencion');
 let id_tipo_atencion_anterior = id_tipo_atencion
 let casodesc = $(this).attr('casodesc');
 let casodesc_anterior = casodesc
 casodesc = casodesc.trim();
 casodesc_anterior = casodesc_anterior.trim();
 let municipioid = $(this).attr('municipioid');
 let municipioid_anterior = municipioid
 let parroquiaid = $(this).attr('parroquiaid');
 let parroquiaid_anterior = parroquiaid
 let idcaso = $(this).attr('idcaso');
 let tipo_beneficiario = $(this).attr('tipo_beneficiario');
 let tipo_beneficiario_anterior = tipo_beneficiario
 let direccion = $(this).attr('direccion');
 let direccion_anterior = direccion
 let correo = $(this).attr('correo');
 let correo_anterior = correo
 let ente_adscrito_id = $(this).attr('ente_adscrito_id');
 let ente_adscrito_id_anterior = ente_adscrito_id
 let competencia_cgr = $(this).attr('competencia_cgr');
 let competencia_cgr_anterior = competencia_cgr
 let asume_cgr = $(this).attr('asume_cgr');
 let asume_cgr_anterior = asume_cgr
 let denu_afecta_persona = $(this).attr('denu_afecta_persona');
 let denu_afecta_persona_anterior = denu_afecta_persona
 let denu_afecta_comunidad = $(this).attr('denu_afecta_comunidad');
 let denu_afecta_comunidad_anterior = denu_afecta_comunidad
 let denu_afecta_terceros = $(this).attr('denu_afecta_terceros');
 let denu_afecta_terceros_anterior = denu_afecta_terceros
 let denu_involucrados = $(this).attr('denu_involucrados');
 let denu_involucrados_anterior = denu_involucrados
 let denu_fecha_hechos = $(this).attr('denu_fecha_hechos');
 let denu_fecha_hechos_anterior = denu_fecha_hechos
 let denu_instancia_popular = $(this).attr('denu_instancia_popular');
 let denu_instancia_popular_anterior = denu_instancia_popular
 let denu_rif_instancia = $(this).attr('denu_rif_instancia');
 let denu_rif_instancia_anterior = denu_rif_instancia
 let denu_ente_financiador = $(this).attr('denu_ente_financiador');
 let denu_ente_financiador_anterior = denu_ente_financiador
 let denu_nombre_proyecto = $(this).attr('denu_nombre_proyecto');
 let denu_nombre_proyecto_anterior = denu_nombre_proyecto
 let denu_monto_aprovado = $(this).attr('denu_monto_aprovado');
 let denu_monto_aprovado_anterior = denu_monto_aprovado
 if (direccion == 'null') {
     direccion = ''
 }
 if (correo == 'null') {
     correo = ''
 }
 if (denu_ente_financiador == 'null') {
     denu_ente_financiador = ''
 }
 if (denu_involucrados == 'null') {
     denu_involucrados = ''
 }
 if (denu_fecha_hechos == 'null') {
     denu_fecha_hechos = ''
 }
 if (denu_instancia_popular == 'null') {
     denu_instancia_popular = ''
 }
 if (denu_rif_instancia == 'null') {
     denu_rif_instancia = ''
 }
 if (denu_nombre_proyecto == 'null') {
     denu_nombre_proyecto = ''
 }
 if (denu_monto_aprovado == 'null') {
     denu_monto_aprovado = ''
 }
 ////////
 if (direccion_anterior == 'null') {
     direccion_anterior = ''
 }
 if (correo_anterior == 'null') {
     correo_anterior = ''
 }
 if (denu_ente_financiador_anterior == 'null') {
     denu_ente_financiador_anterior = ''
 }
 if (denu_involucrados_anterior == 'null') {
     denu_involucrados_anterior = ''
 }
 if (denu_fecha_hechos_anterior == 'null') {
     denu_fecha_hechos_anterior = ''
 }
 if (denu_instancia_popular_anterior == 'null') {
     denu_instancia_popular_anterior = ''
 }
 if (denu_rif_instancia_anterior == 'null') {
     denu_rif_instancia_anterior = ''
 }
 if (denu_nombre_proyecto_anterior == 'null') {
     denu_nombre_proyecto_anterior = ''
 }
 if (denu_monto_aprovado_anterior == 'null') {
     denu_monto_aprovado_anterior = ''
 }



 $('#editCase').find('#nombre_anterior').val(nombre_anterior);
 $('#editCase').find('#apellido_anterior').val(apellido_anterior);
 $('#editCase').find('#direccion_anterior').val(direccion_anterior);
 $('#editCase').find('#correo_anterior').val(correo_anterior);
 $('#editCase').find('#ofiid_anterior').val(ofiid_anterior);
 $('#editCase').find('#via_atencion_anterior').val(idrrss_anterior);
 $('#editCase').find('#fecha_anterior').val(casofec_normal_anterior);
 $('#editCase').find('#genero_anterior').val(sexo_anterior);
 $('#editCase').find('#t_beneficiario_anterior').val(tipo_beneficiario_anterior);
 $('#editCase').find('#cedula_anterior').val(cedula_anterior);
 $('#editCase').find('#tipo_persona_anterior').val(nacionalidad_anterior);
 $('#editCase').find('#telefono_anterior').val(casotel_anterior);
 $('#editCase').find('#descripcion_anterior').val(casodesc_anterior);
 $('#editCase').find('#parroquia_anterior').val(parroquiaid_anterior);
 $('#editCase').find('#municipio_anterior').val(municipioid_anterior);
 $('#editCase').find('#estado_anterior').val(estadoid);
 $('#editCase').find('#competencia_anterior').val(competencia_cgr_anterior);