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
    .btn-xs {
      color: white;
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
      /*
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
                <h3 class="text-secondary"><i class="fas fa-angle-double-right"></i>Direcciones administrativas
                  <button type="submit" id="btn_agregar" class="btn btn-sm btn-primary btn_agregar" data-toggle="modal" data-target="#add-direcciones">Agregar</button>
                </h3>
              </div>
              <div class="card-body">
                <div class="row">
                  <div class="col-lg-11 col-sm-11 col-md-11 ">
                    <div class="card">
                      <div class="card-body">
                        <table class="display table-responsive" id="table_direcciones" style="width:100%" style="margin-top: 20px">
                          <thead>
                            <tr>
                              <td class="text-center" style="width: 1%;">id</td>
                              <td class="text-center" style="width: 20%;">Descripcion</td>
                              <td class="text-center" style="width: 20%;">Correo</td>
                              <td class="text-center" style="width: 1%;">Estatus</td>
                              <td class="text-center" style="width: 1%;">Acciones</td>
                            </tr>
                          </thead>
                          <tbody id="listar_direcciones">
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
      <!-- Modal para añadir direciones-->
      <div class="modal fade" id="add-direcciones">
        <div class="modal-dialog  modal-dialog-centered  modal-md">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title">Direcciones Administrativa</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <form id="new-direccion" method="POST" role="form">
              <div class="modal-body">
                <div class="form-group">
                  <label for="user-name">Nombre</label>
                  <input type="text" name="name-direccion" onkeyup="mayus(this);" id="name-direccion" class="form-control" placeholder="Ej: Direccion de tecnología" autocomplete="off" required>
                </div>
                <div class="form-group">
                  <label for="user-name">Correo</label>
                  <input type="text" name="name-correo" id="name-correo" class="form-control" placeholder="Ej: Direccion.tecnología@sapi.gob.ve" autocomplete="off" required>
                </div>
              </div>
              <div class="modal-footer ">
                <button class="btn btn-sm  btn-light" type="reset">Limpiar</button>
                <button class="btn btn-sm  btn-primary" type="submit">Guardar</button>
                <button type="button" class="btn btn-sm btn-danger" data-dismiss="modal">Cerrar</button>
              </div>
            </form>
          </div>
          <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
      </div>
      <!-- /.modal -->
      <!-- Modal para editar direcciones-->

      <div class="modal fade" id="editar">
        <div class="modal-dialog  modal-dialog-centered modal-md">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title">Editar Direcciones Administrativas</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <form id="edit-direccion" method="POST" role="form">
              <div class="modal-body">
                <div class="form-group">
                  <label for="user-name">Nombre</label>
                  <input type="hidden" name="id-direccion" id="id-direccion" class="form-control">
                  <input type="text" name="name-direccion" onkeyup="mayus(this);" id="editar-direccion" class="form-control" placeholder="Ej: Direccion de tecnología" autocomplete="off" required>
                </div>
                <div class="form-group">
                  <label for="user-name">Correo</label>
                  
                  <input type="text" name="name-correo"  id="editar-correo" class="form-control" placeholder="Ej: Direccion de tecnología" autocomplete="off" required>
                </div>

                &nbsp; <label for="user-pass">Activo</label>&nbsp;&nbsp;
                <input type="checkbox" class="borrado" id="borrado" name="borrado" value='false'>
              </div>
              <div class="modal-footer ">
                <button class="btn btn-sm  btn-light" type="reset">Limpiar</button>
                <button class="btn btn-sm  btn-primary" type="submit">Guardar</button>
                <button type="button" class="btn btn-sm btn-danger" data-dismiss="modal">Cerrar</button>
              </div>
            </form>
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