<?php

namespace Config;

// Create a new instance of our RouteCollection class.
$routes = Services::routes();

// Load the system's routing file first, so that the app and ENVIRONMENT
// can override as needed.
if (file_exists(SYSTEMPATH . 'Config/Routes.php')) {
     require SYSTEMPATH . 'Config/Routes.php';
}

/**
 * --------------------------------------------------------------------
 * Router Setup
 * --------------------------------------------------------------------
 */
$routes->setDefaultNamespace('App\Controllers');
$routes->setDefaultController('Home');
$routes->setDefaultMethod('index');
$routes->setTranslateURIDashes(false);
$routes->set404Override();
$routes->setAutoRoute(false);
/**
 * --------------------------------------------------------------------
 * Route Definitions
 * --------------------------------------------------------------------
 */
// We get a performance increase by specifying the default
// route since we don't have to scan directories.



     $routes->get('/', 'Home::login');
     $routes->get('/inicio', "Home::dashboard");
     $routes->post('/inicio', "Home::dashboard");
     $routes->get('/pantalla_bienvenida', "Home::pantalla_bienvenida");
     $routes->get('/pantalla1', "Home::pantalla1");
     $routes->get('/pantalla2', "Home::pantalla2");
     $routes->get('/perfil/(:num)', 'Perfil::perfil/$1');
     $routes->get('/signin', "Login::autenticar");
     $routes->get('/logout', "Login::logout");
     $routes->get('/buscar_rol_correo/(:any)', "Login::buscar_rol_correo/$1");
/*
     * --------------------------------------------------------------------
     * MODULO AUDITORIA SISTEMA
     * --------------------------------------------------------------------
     */
     $routes->get('/auditoria_sistema', 'Auditoria_sistema_Controllers::auditoria_sistema');
     $routes->get('/listar_auditoria_sistema/(:any)/(:any)', 'Auditoria_sistema_Controllers::listar_auditoria_sistema/$1/$2');
/*
     * --------------------------------------------------------------------
     * MODULO USUARIOS VISITAS
     * --------------------------------------------------------------------
     */
    $routes->get('/usuarios_visitas', 'Usuarios_Visitas::usuarios_visitas');
    $routes->get('/Control_Visitas', 'Usuarios_Visitas::Control_Visitas');
    $routes->get('/ContarUsuariosVisitas/(:any)/(:any)', "Usuarios_Visitas::ContarUsuariosVisitas/$1/$2");
     //Rutas para los reportes de los usuarios
     $routes->get('/reporteusuario/(:num)/(:num)', "Reporte::c/$1/$2");
     $routes->get('/consolidadoUsuario/(:num)', "Reporte::consolidadoUsuario/$1");
     $routes->get('/reporte/(:num)', "Repofrte::tipoReporte/$1");
     $routes->get('/obtener_reportes', "Reporte::obtener_reportes");
     //Rutas para la vista de casos del sistema
     $routes->get('/casos', "Casos_Controler::casos");
     $routes->get('/pruebacasos', "Casos_Controler::pruebacasos");
     $routes->get('/vista_agregar_caso', "Casos_Controler::vista_Agregar_caso");
     $routes->get('/editar_caso', "Casos_Controler::vista_Editar_caso");
     $routes->get('/listar_Casos_Usuarios', "Casos_Controler::listar_Casos_Usuarios");
     //RUTA PRA OBTENER INFORMACION DE LOS USUARIOS DESDE LA WEB
     $routes->get('/Informacion_Usu/(:any)', "Casos_Controler::Informacion_Usuarios/$1");
     $routes->get('/buscar_Caso_id(arios:any)', "Casos_Controler::buscar_Caso_id/$1");
     $routes->get('/listar_Ultimos_Casos', "Casos_Controler::listar_Ultimos_Casos");
     $routes->post('/buscar_datos_usuarios', "Casos_Controler::buscar_datos_usuarios");
     //Rutas para la generacion de casos por los Usuarios
     $routes->post('/registrarCaso', 'Casos_Controler::nuevoCaso');
     $routes->post('/actualizarCaso', 'Casos_Controler::actualizarCaso');
     $routes->post('/remitirCaso', 'Casos_Controler::remitirCaso');
     $routes->post('/eliminar_Caso', 'Casos_Controler::eliminar_Caso');
     $routes->post('/upload', 'Casos_Controler::upload');
     $routes->post('/buscar_documentos_casos', "Documentos_casos_Controler::buscar_documentos_casos");
     $routes->post('/ver_documentos/(:any)', "Documentos_casos_Controler::ver_documentos/$1");
     //Rutas para la consulta de los casos en el pool de casos
     $routes->get('/verCaso/(:num)', "Casos_Controler::vercaso/$1");
     $routes->get('/casosActivos', "Casos_Controler::listadoCasosActivos");
     $routes->get('/historicoCasos', "Casos_Controler::historicoCasos");
     //Rutas para la busqueda de la Division Politico territorial de Venezuela
     $routes->get('/llenar_Estados', "Estados_Controler::listar_Estados");
     $routes->post('/municipios', "Municipios_Controler::listar_Municipios");
     $routes->post('/parroquias', "Municipios_Controler::listar_Parroquias");
     //Rutas del controlador Tipo de Atencion Usuario
     $routes->get('/Listar_Tipo_Atencion', "Tipo_Atencion_Usu_Controler::Listar_Tipo_Atencion");
     //Rutas del controlador Entes asdcritos
     $routes->get('/Listar_Entes_asdcritos', "Entes_asdcritos_Controler::Listar_Entes_asdcritos");
     //Rutas del controlador Tipo de Propiedad Intelectual
     $routes->get('/Listar_Propiedad_Intelectual', "Tipo_Propiedad_Intelectual_Controler::Listar_Propiedad_Intelectual");
     $routes->get('/Listar_Propiedad_Intelectual_MOD', "Tipo_Propiedad_Intelectual_Controler::Listar_Propiedad_Intelectual_MOD");
     //Rutas para la vista de los Reportes
     $routes->get('/reportes', "Reporte_Controler::Vista_reportes");
     $routes->get('/listar_Red_Social', "Red_Social_Controler::listar_Red_Social");
     $routes->get('/listar_Red_Social_filtro', "Red_Social_Controler::listar_Red_Social_filtro");
     //Rutas para el administrador del sistema
     $routes->get('/adminUsers', "Administrador::adminUsers");
     $routes->get('/Get_All_Usuarios', "Administrador::Get_All_Usuarios");
     $routes->get('/adminRoles', "Administrador::adminRoles");
     $routes->post('/addNewUser', "Administrador::addUsuarios");
     $routes->post('/getUser', "Administrador::obtenerUsuario");
     $routes->post('/editUser', "Administrador::editarUsuario");
     $routes->post('/Bloquear_User', "Administrador::Bloquear_User");
     $routes->post('/actualizarTablaUsuarios', "Administrador::actualizaTabla");
     $routes->get('/listar_Combo_Roles', "Administrador::listar_Combo_Roles");
     //RUTAS PARA LAS DIRECCIONES ADMINISTRATIVAS
     $routes->get('/vista_direcciones_admin', 'Ubi_Admini_Controler::vista_direcciones_admin');
     $routes->get('/listar_Ubicacion_Administrativa', "Ubi_Admini_Controler::listar_Ubicacion_Administrativa");
     $routes->get('/listar_direcciones_administrativas', "Ubi_Admini_Controler::listar_direcciones_administrativas");
     $routes->get('/listar_direcciones_user_create/(:any)', "Ubi_Admini_Controler::listar_direcciones_user_create/$1");
     $routes->post('/add_Direccion', "Ubi_Admini_Controler::add_Direccion");
     $routes->post('/editDirecciones', "Ubi_Admini_Controler::editDirecciones");
     //RUTAS PARA LOS ROLES
     $routes->get('/vista_roles', 'Roles_Controler::vista_roles');
     $routes->get('/listar_roles', "Roles_Controler::listar_roles");
     $routes->post('/add_Rol', "Roles_Controler::add_Rol");
     $routes->post('/editRol', "Roles_Controler::editRol");
     //RUTAS PARA LOS TIPOS DE ATENCION
     $routes->get('/vista_tipo_atencion', 'Tipo_Atencion_Usu_Controler::vista_tipo_atencion');
     $routes->get('/Listar_Tipo_Atencion', "Tipo_Atencion_Usu_Controler::Listar_Tipo_Atencion");
     $routes->get('/Listar_Tipo_Atencion_filtro', "Tipo_Atencion_Usu_Controler::Listar_Tipo_Atencion_filtro");
     $routes->post('/add_Tipo_Atencion', "Tipo_Atencion_Usu_Controler::add_Tipo_Atencion");
     $routes->post('/editTipoAtencion', "Tipo_Atencion_Usu_Controler::editTipoAtencion");
     //Rutas para los seguimientos
     $routes->get('/listar_Seguimientos/(:any)', 'Seguimiento_Controler::listar_Seguimientos/$1');
     $routes->post('/addSeguimiento', "Seguimiento_Controler::addSeguimiento");
     $routes->post('/actualizar_Seguimiento', "Seguimiento_Controler::actualizar_Seguimiento");
     $routes->post('/eliminar_seguimiento', "Seguimiento_Controler::eliminar_seguimiento");
     $routes->post('/gettl', "Seguimiento_Controler::obtenerTL");
     //Rutas para realizar el cambio de estatus en los casos
     $routes->post('/cambiarEstatus', "Estatus::cambioEstatus");
     //Rutas para enviar correo al beneficiario desde el protal web 
     $routes->get('/enviar_correo_portal/(:any)',"Estatus::enviar_correo_portal/$1");
     //RUTAS PARA EL SUPERVISOR
     $routes->get('/consolidado', "Reporte_Controler::vista_consolidado");
     $routes->get('/reporte_consolidado/(:any)/(:any)/(:any)/(:any)/(:any)/(:any)/(:any)/(:any)/(:any)/(:any)/(:any)/(:any)/(:any)/(:any)', "Reporte_Controler::reporte_consolidado/$1/$2/$3/$4/$5/$6/$7/$8/$9/$10/$11/$12/$13/$14");
     //RUTAS PARA EL OPERADOR
     $routes->get('/operador', "Reporte_Controler::vista_operador");
     $routes->get('/reporte_operador/(:any)/(:any)/(:any)/(:any)/(:any)/(:any)/(:any)/(:any)/(:any)/(:any)/(:any)/(:any)', "Reporte_Controler::reporte_operador/$1/$2/$3/$4/$5/$6/$7/$8/$9/$10/$11/$12");
     //RUTAS PARA LAS ESTADISTICAS
     $routes->get('/estadisticas', "Reporte_Controler::vista_estadisticas");
     $routes->get('/estadal/(:any)/(:any)', "Reporte_Controler::vista_estadisticas_estadal/$1/$2");
     $routes->get('/estadisticas_benificiario/(:any)/(:any)', "Reporte_Controler::vista_estadisticas_beneficiario/$1/$2");
     $routes->get('/estadisticas_propiedad_intelectual/(:any)/(:any)', "Reporte_Controler::vista_estadisticas_prop_intelectual/$1/$2");
     $routes->get('/estadisticas_tipo_atencion/(:any)/(:any)', "Reporte_Controler::vista_estadisticas_tipo_atencion/$1/$2");
     $routes->get('/estadisticas_con_filtro/(:any)/(:any)/(:any)', "Reporte_Controler::vista_estadisticas_filtros/$1/$2/$3");
     $routes->get('/estadisticas2', "Reporte_Controler::vista_estadisticas2");
     
     $routes->get('/estadisticas_mapa', "Reporte_Controler::estadisticas_mapa");
     

     $routes->post('/consultar_estados', "Reporte_Controler::consultar_estados");
     $routes->get('/generar_pdf/(:any)', "PdfController::generar_pdf/$1");
     //Rutas generales de la aplicacion
     $routes->get('/403', "Home::forbidden");
     $routes->get('/404', "Home::notFound");
     //RUTAS PARA lAS ATENCIONES 
     $routes->get('/atencion', 'Reporte_Atencion_Controler::vista_atencion');
     $routes->get('/Listar_Atencion/(:any)/(:any)/(:any)/(:any)/(:any)/(:any)/(:any)/(:any)/(:any)/(:any)', "Reporte_Atencion_Controler::Listar_Atencion/$1/$2/$3/$4/$5/$6/$7/$8/$9/$10");
     
     $routes->get('/Listar_Atencion_filtro', "Reporte_Atencion_Controler::Listar_Atencion_filtro");


      //RUTAS PARA EL MAPA , EN EL SIAC MUNICIPIOS
      $routes->get('/Listar_Casos_Municipios', "Reporte_Atencion_Controler::Listar_Casos_Municipios");

       //RUTAS PARA EL MAPA , EN EL SIAC ESTADOS
       $routes->get('/Listar_Casos_Estados', "Reporte_Atencion_Controler::Listar_Casos_Estados");


/**
 * --------------------------------------------------------------------
* APARTADO DE AUDIENCIAS
* --------------------------------------------------------------------
*/


 //RUTAS PARA LOS ROLES DE AUDIENCIAS 
 $routes->get('/vista_Roles_audiencias', 'Roles_Audiencias_Controler::vista_Roles_audiencias');


  //RUTAS PARA LOS PERMISOS DE AUDIENCIAS 
  $routes->get('/vista_Permisos_audiencias', 'Permisos_Audiencias_Controler::vista_Permisos_audiencias');

 //RUTAS PARA LAS CATEGORIAS DE AUDIENCIAS 
 $routes->get('/vista_Categorias_audiencias', 'Categorias_Audiencias_Controler::vista_Categorias_audiencias');

 

 //RUTAS PARA USUARIOS AREAS DE AUDIENCIAS 
 $routes->get('/vista_Usuario_Areas_audiencias', 'UsuariosAreas_Audiencias_Controler::vista_Usuario_Areas_audiencias');

 //RUTAS PARA USUARIOS BUFETES DE AUDIENCIAS 
 $routes->get('/vista_Bufetes_audiencias', 'Bufetes_Audiencias_Controler::vista_Bufetes_audiencias');

 

 



//RUTAS PARA AUDIENCIAS
$routes->get('/vista_audiencias', 'Audiencias_Controler::vista_audiencias');
$routes->get('/detalles_requerimientos/(:any)', 'Audiencias_Controler::detalles_requerimientos/$1');
$routes->get('/vista_agregar_requerimientos', 'Audiencias_Controler::vista_agregar_requerimientos');
$routes->get('/detalles_solicitudes/(:any)', 'Audiencias_Controler::detalles_solicitudes/$1');
$routes->get('/actualizar_audiencia/(:any)', 'Audiencias_Controler::actualizar_audiencia/$1');
$routes->get('/agregar_solicitudes/(:any)', 'Audiencias_Controler::agregar_solicitudes/$1');
$routes->get('/citas', 'Audiencias_Controler::citas');
$routes->get('/actualizar_citas/(:any)', 'Audiencias_Controler::actualizar_citas/$1');
$routes->get('/actualizar_solicitud/(:any)', 'Audiencias_Controler::actualizar_solicitud/$1');






//RUTAS PARA SOLICITUDES
$routes->get('/vista_solicitudes', 'Audiencias_Controler::vista_solicitudes');

//RUTAS PARA AUDIENCIAS /ESTADISTICAS
$routes->get('/citas_otorgadas', 'Audiencias_Controler::citas_otorgadas');
$routes->get('/casos_categorias', 'Audiencias_Controler::casos_categorias');







//RUTAS PARA LOS CASOS REMITIDOS
$routes->get('/vista_casos_remitidos', 'Casos_Remitidos::vista_casos_remitidos');
$routes->get('/listar_Casos_Remitidos', 'Casos_Remitidos::listar_Casos_Remitidos');








     if (file_exists(APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php')) {
          require APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php';
     }
