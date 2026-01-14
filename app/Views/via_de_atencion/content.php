<!-- Content Wrapper. Contains page content -->
<?php
$session = session();
?>

<link rel="stylesheet" href="<?php echo base_url(); ?>/css_paginas/botones_datatable.css">
<style>
  table.dataTable thead,
  table.dataTable tfoot {
    background: linear-gradient(to right, #a9b6c2, #a9b6c2, #a9b6c2);
  }
   /* Paleta y superficies tipo Tailwind */
    :root {
        --slate-50: #f8fafc;
        --slate-100: #eef2f7; /* más contraste */
        --slate-200: #d9e0ea;
        --slate-300: #b8c2cf;
        --slate-500: #4b5563;
        --slate-700: #1f2937;
        --primary-500: #083B7A; /* Azul primario */
        --primary-600: #062F60;
        --primary-700: #05264D;
        --success-500: #10b981;
        --danger-500: #ef4444;
        --warning-500: #f59e0b;
        --info-500: #06b6d4;
        --accent-500: #1363DF; /* azul acento */
        --radius-md: 14px;
        --radius-sm: 10px;
        --shadow-sm: 0 2px 4px rgba(2,6,23,0.08), 0 1px 3px rgba(2,6,23,0.06);
        --shadow-md: 0 20px 25px -5px rgba(2,6,23,0.1), 0 10px 10px -5px rgba(2,6,23,0.04);
    }
      /* Botones mejorados */
    .btn-primary {
        background: linear-gradient(135deg, var(--primary-500), var(--accent-500));
        border-color: transparent;
        font-weight: 700;
         padding: 4px 6px; 
        font-size: 13px;
        border-radius: 9999px;
        transition: transform 0.08s ease, box-shadow 0.08s ease, filter 0.08s ease;
    }

       /* Botones mejorados */
   .btn_agregar{
     background: linear-gradient(135deg, var(--primary-500), var(--accent-500));
        border-color: transparent;
        font-weight: 700;
         padding: 8px 13px; 
        font-size: 13px;
        border-radius: 9999px;
        transition: transform 0.08s ease, box-shadow 0.08s ease, filter 0.08s ease;
    }
    .btn-primary:hover {
        filter: brightness(1.05);
        transform: translateY(-1px);
       
    }
</style>

<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <div class="content-header">
    <div class="container">
      <div class="row mb-2">
        <div class="col-sm-6">
        </div><!-- /.col -->
        <div class="col-sm-6">
        </div><!-- /.col -->
      </div><!-- /.row -->
    </div><!-- /.container-fluid -->
  </div>
  <!-- /.content-header -->

  <!-- Main content  fluid-->
  <div class="content">
    <div class="container">
      <div class="row">
        <div class="col-lg-12 col-sm-12 col-md-12 p-2">
          <div class="card">
            <div class="card-header border-0">
              <div class="d-flex justify-content-between">
                <h3 class="text-secondary"><i class="fas fa-angle-double-right"></i>Via de Atención
                  <button type="submit" id="btn_agregar" class="btn btn-sm btn-primary btn_agregar" data-toggle="modal" data-target="#add-via-atencion">Agregar</button>
                </h3>
              </div>
              <div class="card-body">
                <div class="row">
                  <div class="col-lg-11 col-sm-11 col-md-11 ">
                    <div class="card">
                      <div class="card-body">
                        <table class="display table-responsive" id="table_via_atencion" style="width:100%" style="margin-top: 20px">
                          <thead>
                            <tr>
                              <td class="text-center" style="width: 1%;">id</td>
                              <td class="text-center" style="width: 20%;">Descripción</td>
                              <td class="text-center" style="width: 1%;">Estatus</td>
                              <td class="text-center" style="width: 1%;">Acciones</td>
                            </tr>
                          </thead>
                          <tbody id="listar_via_atencion">
                          </tbody>
                        </table>
                      </div>
                    </div>
                  </div>
                </div>
              </div>

            </div>
          </div>
        </div>
      </div>
      <!-- /.content-wrapper -->
      <!-- Modal -->
      <div class="modal fade" id="add-via-atencion">
        <div class="modal-dialog modal-dialog-centered  modal-md">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title">Via de Atencion</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <form id="new-via-atencion" method="POST" role="form">
              <div class="modal-body">
                <div class="form-group">
                  <label for="user-name">Nombre</label>
                  <input type="text" name="name-atencion"  id="name-via-atencion" class="form-control"  autocomplete="off" required>
                </div>
              </div>
          
              <div class="modal-footer ">
                <button class="btn btn-sm btn-light" type="reset">Limpiar</button>
                <button class="btn  btn-sm btn-primary" type="submit">Guardar</button>
                <button type="button" class="btn btn-sm btn-danger" data-dismiss="modal">Cerrar</button>
              </div>
            </form>
          </div>
          <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
      </div>
      <!-- /.modal -->
      <!-- Modal para editar usuarios-->
      
      <div class="modal fade" id="editar">

      <style>
				.historial_info {

          border-radius: 5px 5px 5px 5px;
          border: 2px solid rgb(209, 205, 207);
          font-size: 13px;
          border-radius: 10px 10px 10px 10px;
          box-shadow: 10px 10px 3px 3px rgb(88, 88, 88);
          color: #104b72;
          outline: none; 

          }
				</style>



        <div class="modal-dialog modal-dialog-centered  modal-md">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title">Editar Via de Atencion</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
           
              <div class="modal-body">
                <div class="form-group">
                  <label for="user-name">Nombre</label>
                  <input type="hidden" name="id-atencion" id="id-viaatencion" class="form-control">
                  <input type="text" name="name-atencion"  id="editar-viaatencion" class="form-control"  autocomplete="off" required>
                </div>
                &nbsp; <label for="user-pass">Activo</label>&nbsp;&nbsp;
                <input type="checkbox" class="borrado" id="borrado" name="borrado" value='false'>
              
                <div class="historial_info" >
                  <div class="row">
                    <div class="col-md-1">
                    </div>
                    <div>
                    <fieldset class="bodersueve_fieldset">
                        <legend class="legend" style="font-size: 17px;"><b><u>Tipo de Atencion</u></b> </legend>	
                        <form action="#" class="form">
                          <div class="check_tipo_atencion" id="check_tipo_atencion">	
                          </div>	
                        </form>
                    </fieldset>  
                    </div>
                  </div>	
                </div>
              </div>
              <div class="modal-footer ">
                <button class="btn btn-sm btn-light" type="reset">Limpiar</button>
                <button class="btn  btn-sm btn-primary btnActualizar" type="button" >Actualizar</button>
                <button type="button" class="btn  btn-sm btn-danger" data-dismiss="modal">Cerrar</button>
              </div>
           
          </div>
          <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
      </div>

      <!-- ***** FUNCION PARA SOLO NUMEROS***-** -->
      <script type="text/javascript">
        function valideKey(evt) {
          var code = (evt.which) ? evt.which : evt.keyCode;
          if (code == 8) { // backspace.
            return true;
          } else if (code >= 48 && code <= 57) { // is a number.
            return true;
          } else { // other keys.
            return false;
          }
        }
      </script>
      <!-- ***** FUNCION PARA SOLO LETRAS***-** -->
      <script>
        function noNumeros(event) {
          const tecla = event.keyCode || event.which;
          if (tecla >= 48 && tecla <= 57) {
            event.preventDefault();
          }
        }
      </script>
      <!-- ***** FUNCION PARA CONVERTIR EN MAYUSCULA***-** -->
      <script>
        function mayus(e) {
          e.value = e.value.toUpperCase();
        }
      </script>