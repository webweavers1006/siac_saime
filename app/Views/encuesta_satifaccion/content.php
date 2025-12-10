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
                <h3 class="text-secondary"><i class="fas fa-angle-double-right"></i>Encuestas de Satisfacción
               
                </h3>
              </div>
              <div class="card-body">
              <div class="row">
                            <div class="col-md-3">
                                <label for="desde">Desde:</label>
                                <input type="date" class="form-control" value="<?php echo date('YY-MM-DD'); ?>" name="desde" id="fecha_inicio">
                            </div>
                            <div class="col-md-3">
                                <label for="hasta">Hasta:</label>
                                <input type="date" class="form-control" value="<?php echo date('YY-MM-DD'); ?>" name="hasta" id="fecha_fin">
                            </div>
                            <div class="col-md-3">
                                <label for="tramite">Nº Solicitud:</label>
                                <input type="text" class="form-control"  onkeypress="return valideKey(event);" value="" name="tramite" id="tramite">
                            </div>
        
                </div>
                <br>
                <div class="col-md-4">
                             <button type="button" class="btn btn-sm btn-primary consultar">Consultar</button>&nbsp;&nbsp;
                             <button type="button" class="btn btn-sm btn-secondary limpiar">Limpiar</button>
                </div>
                <br>
                <div class="row">
                  <div class="col-lg-12 col-sm-12 col-md-12 ">
                    <div class="card">
                      <div class="card-body">
                        <table class="display table-responsive" id="table_participantes_encuestas" style="width:100%" style="margin-top: 20px">
                          <thead>
                            <tr>
                              <td class="text-center" style="width: 1%;">id</td>
                              <td class="text-center" style="width: 10%;">Solicitud</td>
                              <td class="text-center" style="width: 20%;">Nombre y Apellido</td>
                               <td class="text-center" style="width: 10%;">Tipo de Prop</td>
                              <td class="text-center" style="width: 20%;">Fecha</td>
                              <td class="text-center" style="width: 1%;">Acciones</td>
                            </tr>
                          </thead>
                          <tbody id="listar_participante_encuesta">
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