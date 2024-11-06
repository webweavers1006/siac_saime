<!-- Content Wrapper. Contains page content -->
<?php
$session = session();
?>
<link rel="stylesheet" href="<?php echo base_url(); ?>/css_paginas/modal_permisos.css">

<link rel="stylesheet" href="<?php echo base_url(); ?>/css_paginas/botones_datatable.css">
<style>
  table.dataTable thead,
  table.dataTable tfoot {
    background: linear-gradient(to right, #a9b6c2, #a9b6c2, #a9b6c2);
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
                <h3 class="text-secondary"><i class="fas fa-angle-double-right"></i>Bufetes
                  <button type="submit" id="btn_agregar" class="btn btn-sm btn-primary btn_agregar" data-toggle="modal" data-target="#add-bufetes">Agregar</button>
                </h3>
              </div>
              <div class="card-body">
                <div class="row">
                  <div class="col-lg-11 col-sm-11 col-md-11 ">
                    <div class="card">
                      <div class="card-body">
                        <table class="display table-responsive" id="table_bufetes" style="width:100%" style="margin-top: 20px">
                          <thead>
                            <tr>
                              <td class="text-center" style="width: 1%;">id</td>
                              <td class="text-center" style="width: 20%;">Nombre</td>
                              <td class="text-center" style="width: 20%;">Rif</td>
                              <td class="text-center" style="width: 20%;">Correo</td>
                              <td class="text-center" style="width: 20%;">Telefono</td>
                              <td class="text-center" style="width: 1%;">Acciones</td>
                            </tr>
                          </thead>
                          <tbody id="listar_bufetes">
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
      <!-- Modal para añadir un usuario areas-->
      <div class="modal fade" id="add-bufetes">
        <div class="modal-dialog  modal-dialog-centered  modal-md">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title">Bufetes</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            

            </div>
            <form id="new-bufete" method="POST" role="form">
              <div class="modal-body">
              <div class="form-group">
                  <label for="user-name">Nombre</label>
                  <input type="text"  name="name-descripcion"  id="nombre_bufete" class="form-control" autocomplete="off" required>
              </div>

              <div class="form-group">
                  <label for="user-name">Correo</label>
                  <input type="text"  name="name-descripcion"  id="correo" class="form-control" autocomplete="off" required>
              </div>
              
              <div class="form-group">
                  <label for="user-name">Rif</label>
                  <input type="text"  name="name-descripcion"  id="rif" class="form-control" autocomplete="off" >
              </div>

              <div class="form-group">
                  <label for="user-name">Telefono</label>
                  <input type="text"  name="name-descripcion"  id="telefono" class="form-control" autocomplete="off" >
              </div>

              </div>
              <div class="modal-footer ">
                <button class="btn btn-sm  btn-light" type="reset">Limpiar</button>
                <button class="btn btn-sm  btn-primary guardar" type="submit">Guardar</button>
                <button type="button" class="btn btn-sm btn-danger " data-dismiss="modal">Cerrar</button>
              </div>
            </form>
          </div>
          <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
      </div>
      <!-- /.modal -->
      <!-- Modal para editar categorias-->
      <div class="modal fade" id="editar">
        <div class="modal-dialog  modal-dialog-centered modal-md">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title">Editar Bufete </h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <form id="edit-bufete" method="POST" role="form">
            <div class="modal-body">
            <input type="hidden"  name="name-descripcion"  id="id_bufete" class="form-control" autocomplete="off" >
              <div class="form-group">
                  <label for="user-name">Nombre</label>
                  <input type="text"  name="name-descripcion"  id="edit_nombre_bufete" class="form-control" autocomplete="off" required>
              </div>

              <div class="form-group">
                  <label for="user-name">Correo</label>
                  <input type="text"  name="name-descripcion"  id="edit_correo" class="form-control" autocomplete="off" required>
              </div>
              
              <div class="form-group">
                  <label for="user-name">Rif</label>
                  <input type="text"  name="name-descripcion"  id="edit_rif" class="form-control" autocomplete="off" >
              </div>

              <div class="form-group">
                  <label for="user-name">Telefono</label>
                  <input type="text"   name="name-descripcion"  id="edit_telefono_bufete" class="form-control" autocomplete="off" >
              </div>
              <label for="user-email">Activo</label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
              <input type="checkbox" name="terminos" id="id_condicion" class="form-check-input">

              <div class="modal-footer ">
                <button class="btn btn-sm  btn-light" type="reset">Limpiar</button>
                <button class="btn btn-sm  btn-primary actualizar" type="submit">Actualizar</button>
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