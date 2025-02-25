<?php
$session = session();
$userdata = $session->get();


?>





<meta charset="utf-8">
<link rel="stylesheet" href="<?php echo base_url(); ?>/css_paginas/navar.css">
<body class="hold-transition sidebar-mini layout-fixed">
  <div class="wrapper">
  <nav class="main-header navbar navbar-expand-lg navbar-white navbar-light">
  <ul class="navbar-nav">
    <li class="nav-item">
      <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
    </li>
  </ul>
  <input type="text" name="" disabled="disabled" style="width: 100px; background-color: transparent; border: none;" value="">
  <img src="<?php echo base_url(); ?>/img/cintillo_tradicional.png" height="60" class="d-none d-lg-block">
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  <div class="collapse navbar-collapse" id="navbarSupportedContent">
    <ul class="navbar-nav ml-auto">
      <li class="nav-item">
        <h5><a href="#Foo" onclick="cerrarSesion();" style="color: black;" class="nav-primary">Salir</a></h5>
      </li>
    </ul>
  </div>
  <script>
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
          
          <?php if ($session->get('userrol') == 1 or $session->get('userrol') == 3 or $session->get('userrol') == 5 or $session->get('userrol') == 6) { ?>
          <li class="nav-item">
            <a href="#" class="nav-link" id=""><i class="nav-icon  nav-icon fas fa-chart-bar"></i>
              <p> Estadísticas</p>
              <i class="right fas fa-angle-left"></i>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                  <a href="<?php echo base_url(); ?>/estadisticas" class="nav-link">
                    <i class="nav-icon 	 fas fa-globe" style='font-size:20px'></i>
                    <p>Global</p>
                  </a>
              </li>
              <li class="nav-item">
              <a href="#" class="nav-link" id=""><i class="nav-icon fa  fa-book"></i>
                <p> Estadal</p>
                <i class="right fas fa-angle-left"></i>
              </a>
             
              <ul class="nav nav-treeview">
              <li class="nav-item">
                  <a href="<?php echo base_url(); ?>/estadal/null/null" class="nav-link">
                    <i class="nav-icon 	 fa fa-bookmark  " style='font-size:20px'></i>
                    <p>Estatus</p>
                  </a>
              </li>
                <li class="nav-item">
                  <a href="<?php echo base_url(); ?>/estadisticas_benificiario/null/null" class="nav-link">
                    <i class="nav-icon 	fas  fa-address-card " style='font-size:20px'></i>
                    <p>Beneficiario</p>
                  </a>
                </li>
               
                <li class="nav-item">
                  <a href="<?php echo base_url(); ?>/estadisticas_propiedad_intelectual/null/null" class="nav-link">
                    <i class="nav-icon 	fas  fas fa-clipboard " style='font-size:20px'></i>
                    <p>Propiedad Intelectual</p>
                    </a>
                </li>
                <li class="nav-item">
                  <a href="<?php echo base_url(); ?>/estadisticas_tipo_atencion/null/null" class="nav-link">
                    <i class="nav-icon 	fas  fas fa-chalkboard-teacher " style='font-size:20px'></i>
                    <p>Tipo Atencion</p>
                  </a>
                </li>

                <li class="nav-item">
              <a href="<?php echo base_url(); ?>/estadisticas_mapa" class="nav-link">
                  <img src="<?php echo base_url(); ?>/img/venezuela2.png" style='width:40px;height:30px'>
                  <p>Mapa de Venezuela</p>
              </a>
            </li>

              </ul>
              <?php if ($session->get('userrol') == 5 or $session->get('userrol') == 1 or $session->get('userrol') == 6) { ?>
              <li class="nav-item">
                  <a href="<?php echo base_url(); ?>/Control_Visitas" class="nav-link">
                  <i class="nav-icon 	fas  fa-users" style='font-size:20px'></i>
                    <p>Contador de Visitas</p>
                  </a>
              </li>
                      <!-- ESTADISTICAS AUDIENCIAS -->
                      <li class="nav-item">
                      <a href="#" class="nav-link" id="">
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



            </ul>
               

          </li>


          <?php } ?>
          <?php } ?>
         
       

     
     

         
          <?php if ($session->get('userrol') == 5 || $session->get('userrol') == 3 ) { ?>

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