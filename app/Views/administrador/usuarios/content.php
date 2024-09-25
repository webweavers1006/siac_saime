
<link rel="stylesheet" href="<?php echo base_url(); ?>/css_paginas/agregar_usuario.css">
<link rel="stylesheet" href="<?php echo base_url(); ?>/css_paginas/botones_datatable.css">
<style>
  table.dataTable thead,
  table.dataTable tfoot {
    background: linear-gradient(to right, #a9b6c2, #a9b6c2, #a9b6c2);
  }
</style>
<!-- Content Wrapper. Contains page content -->
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

  <!-- Main content -->
  <div class="content">
    <div class="container">
      <div class="row">
        <div class="col-lg-12 col-sm-12 col-md-12 col-xs-12">
          <div class="card">
            <div class="card-header">
              <h3 class="text-secondary"><i class="fas fa-angle-double-right"></i>Operadores </h3>
              <div class="card-tools">
                <button type="button" class="btn btn-sm  btn-primary" data-toggle="modal" data-target="#addUser">
                  <i class="fa fa-plus"></i> Añadir Usuario
                </button>
              </div>
            </div>
            <div class="card-body">
              <div class="row">
                <div class="col-lg-12 col-sm-12 col-md-12 p-2">
                  <div class="card">
                    <div class="card-body">
                      <!--table class="table table-hover table-bordered" id="table_roles" style="margin-top: 20px"-->
                      <table class="display table-responsive" id="table_usuarios" style="width:102%" style="margin-top: 20px">
                        <thead>
                          <tr>
                            <td class="text-center" style="width: 1%;">ID</td>
                            <td class="text-center" style="width: 10%;">Nombre</td>
                            <td class="text-center" style="width: 10%;">Apellido</td>
                            <td class="text-center" style="width: 10%;">Rol de Usuario</td>
                            <td class="text-center" style="width: 20%;">Correo Electrónico </td>
                            <td class="text-center" style="width: 10%;">Cargo </td>
                            <td class="text-center" style="width: 3%;">Estatus</td>
                            <td class="text-center" style="width: 3%;">Acciones</td>
                          </tr>
                        </thead>
                        <tbody id="listar_usuarios">
                        </tbody>
                      </table>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <!-- /.col-md-6 -->
      </div>
      <!-- /.row -->
    </div><!-- /.container-fluid -->
  </div>
  <!-- /.content -->
</div>

<input type="hidden" class="sinborder" id="nivel_usuario" disabled="disabled" value='<?= session('userrol'); ?> ' />

	<!-- <php if (session('userrol') != '5' ): ?>
		<style>
			.btn-primary {
			
			}
		</style>
	<php endif; ?> -->

  

<!-- /.content-wrapper -->
<!-- Modal para añadir usuarios-->
<div class="modal fade" id="addUser">
  <div class="modal-dialog modal-dialog-centered  modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Registrar Usuario</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form id="new-user" method="POST" role="form">
  <div class="modal-body">
    <div class="row">
      <div class="col-md-6">
        <div class="form-group">
          <label for="user-name">Nombre</label>
          <input type="text" name="user-name" id="user-name" class="form-control" placeholder="Ej: Juan" autocomplete="off" required>
        </div>
        <div class="form-group">
          <label for="user-email">Correo Electrónico</label>
          <input type="email" name="user-email" id="user-email" class="form-control" placeholder="Ej: Juan.perez@sapi.gob.ve" autocomplete="off" required>
        </div>
        <div class="form-group">
          <label for="id_direccion_administrativa">Direccion Administrativa</label>
          <select class="form-control" name="id_direccion_administrativa" id="id_direccion_administrativa" style="font-size: 13px;">
          <option value="0" disabled>Seleccione</option>
        </select>
        </div>


       
        <div class="form-group user_cedula"  style="display: none;" >
          <label for="user-name">Cédula</label>
          <input type="text" name="ceula" id="cedula"autocomplete="off" class="form-control">
        </div>

        <div class="form-group">
          <label for="user-pass">Contraseña</label>
          <input type="password" name="user-pass" id="user-pass" autocomplete="off"class="form-control" required>
        </div>

      </div>
      <div class="col-md-6">
      <div class="form-group">
          <label for="user-lastname">Apellido</label>
          <input type="text" name="user-lastname" id="user-lastname" autocomplete="off"class="form-control" placeholder="Ej: Perez" required>
        </div>


        <div class="form-group">
          <label for="user-rol">Rol de Usuario</label>
          <select class="form-control" id="user-rol" name="user-rol">
            <?php echo $roles; ?>
          </select>
        </div>

        

        <div class="form-group id_rol_nivel" style="display: none;" >
            <label for="user-rol">Nivel de Rol</label>
            <select class="form-control" id="id_rol" name="id_rol">
                <?php foreach($nivel_rol["roless"] as $rol) { ?>
                    <option value="<?php echo $rol["id"]; ?>"><?php echo $rol["rol"]; ?></option>
                <?php } ?>
            </select>
        </div>

       
        
        <div class="form-group">
          <label for="usercargo">Cargo</label>
          <input type="text" name="usercargo" id="usercargo" class="form-control" placeholder="Ej: Director" required>
        </div>
        <div class="form-group">
          <label for="user-confirm-pass">Confirmar Contraseña</label>
          <input type="password" name="user-confirm-pass" id="user-confirm-pass"autocomplete="off" class="form-control" required>
        </div>
      </div>
    </div>
  </div>
  <div class="modal-footer">
    <button class="btn btn-sm btn-light" type="reset">Limpiar</button>
    <button class="btn btn-sm  btn-primary" type="submit">Guardar</button>
    <button type="button" class="btn  btn-sm  btn-danger" data-dismiss="modal">Cerrar</button>
  </div>
</form>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>
<!-- /.modal -->
<!-- Modal para editar usuarios-->
<div class="modal fade" id="editUser">
  <div class="modal-dialog modal-dialog-centered  modal-md">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Editar Usuario</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form id="edit-user" method="POST" role="form">
        <input type="hidden" name="userid" id="userid">
        <div class="modal-body">
          <div class="form-group">
            <label for="user-name">Nombre</label>
            <input type="text" name="edit-user-name" id="edit-user-name" class="form-control" placeholder="Ej: Juan">
            <label for="user-lastname">Apellido</label>
            <input type="text" name="edit-user-lastname" id="edit-user-lastname" class="form-control" placeholder="Ej: Perez">
            <label for="user-email">Correo electronico</label>
            <input type="email" name="edit-user-email" id="edit-user-email" class="form-control" placeholder="Ej: juan.perez@sapi.gob.ve">
            <label for="user-lastname">Cargo</label>
            <input type="text" name="cargo" id="cargo" class="form-control" placeholder="Ej: Perez">
           
          </div>

         
        
           <label for="user-pass">Cambiar Contraseña</label>&nbsp;&nbsp;
            <input type="checkbox" class="cambiar-clave" id="cambiar-clave" name="cambiar-clave" value='false'>
          <div class="form-group" id="modulo-claves" style="display: none;">
            <label for="user-pass">Contraseña</label>
            <input type="password" name="edit-user-pass" id="edit-user-pass" class="form-control">
            <label for="user-pass" style="display: none;">Confirmar Contraseña</label>
            <input type="password" style="display: none;" name="edit-user-confirm-pass" id="edit-user-confirm-pass" class="form-control">
          </div>
         
          <div class="form-group">
            <label for="user-rol">Rol de usuario</label>
            <select class="form-control" id="edit-user-rol" name="edit-user-rol">
              <option value="0" disabled>Seleccione</option>
            </select>

            
            <div class="form-group edit_id_rol_nivel" style="display: none;" >
            <label for="user-rol">Nivel de Rol</label>
            <select class="form-control" id="edit_id_rol" name="id_rol">
                <?php foreach($nivel_rol["roless"] as $rol) { ?>
                    <option value="<?php echo $rol["id"]; ?>"><?php echo $rol["rol"]; ?></option>
                <?php } ?>
            </select>
        </div>


     


            <div class="direcciones"  >
              <label for="user-rol">Direccione Administrativa</label>
              <select class="form-control" name="edit_direccion_administrativa" id="edit_direccion_administrativa" style="font-size: 13px;">
                <option value="0" disabled>Seleccione</option>
              </select>
            </div>


        <div class="form-group edit_user_cedula"  style="display: none;" >
          <label for="user-name">cedula</label>
          <input type="text" name="ceula" id="edit_cedula" class="form-control">
        </div>
           
          </div>
          &nbsp; <label for="user-pass">Activo</label>&nbsp;&nbsp;
            <input type="checkbox" class="usuopborrado" id="usuopborrado" name="usuopborrado" value='false'>

        </div>
        <div class="modal-footer ">
          <button class="btn  btn-sm btn-light" type="reset">Limpiar</button>
          <button class="btn  btn-sm  btn-primary" type="submit">Guardar</button>
          <button type="button" class="btn btn-sm  btn-danger" data-dismiss="modal">Cerrar</button>
        </div>
      </form>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>