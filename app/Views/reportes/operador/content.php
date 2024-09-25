<!-- Content Wrapper. Contains page content -->
<?php
$session = session();
?>

<div class="content-wrapper">
<link rel="stylesheet" href="<?php echo base_url(); ?>/datatable_responsive/css/responsive.bootstrap4.css">

  <style>
    table.dataTable thead,
    table.dataTable tfoot {
      background: linear-gradient(to right, #a9b6c2, #a9b6c2, #a9b6c2);
    }
  </style>
  <!-- Main content -->
  <div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12 col-sm-12 col-md-12 p-2">
                <div class="card">
                    <div class="card-header border-0">
                        <div class="d-flex justify-content-between">
                            <div>
                                <h3 class="text-secondary"><i class="fas fa-angle-double-right"></i> Reporte por Analistas
                                <select class="custom-select" id="usuarios" style="width:200px;" name="usuarios">
                                    <option value="0" selected disabled>Seleccione</option>
                                    <?php echo $usuarios; ?>
                                </select>
                              </h3>    
                            </div>
                            
                        </div>
                    </div>
                    <!--Form-->
                    <div class="card-body">
                        <div class="row">
                            <div class="form-group col-md-2">
                                <label for="desde">Desde</label>
                                <input type="date" class="form-control" value="<?php echo date('YY-MM-DD'); ?>" name="desde" id="desde">
                            </div>
                            <div class="form-group col-md-2">
                                <label for="hasta">Hasta</label>
                                <input type="date" class="form-control" value="<?php echo date('YY-MM-DD'); ?>" name="hasta" id="hasta">
                            </div>
                            <div class="form-group col-md-2">
                                <label for="sexo">Género</label>
                                <select class="form-control" id="sexo" name="sexo">
                                    <option value="0" selected disabled>Seleccione</option>
                                    <option value="1">MASCULINO</option>
                                    <option value="2">FEMENINO</option>
                                </select>
                            </div>
                            <div class="form-group col-md-3">
                                <label for="tipo-pi">Tipo de Propiedad Intelectual</label>
                                <select class="form-control" id="tipo-pi" name="tipo-pi">
                                    <option value="0" selected disabled>Seleccione</option>
                                </select>
                            </div>
                            <div class="form-group col-md-3">
                                <label for="t-beneficiario">Tipo de Beneficiario</label>
                                <select class="form-control" id="t-beneficiario" name="t-beneficiario">
                                    <option value="0" selected disabled>Seleccione</option>
                                    <option value="1">Usuario</option>
                                    <option value="2">Emprendedor</option>
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-2">
                                <label for="via-atencion">Vía de Atención</label>
                                <select class="form-control" id="via-atencion" name="via-atencion">
                                    <option value="0" selected disabled>Seleccione</option>
                                </select>
                            </div>
                            <div class="form-group col-md-2">
                                <label for="tipo-atencion-usu">Tipo de Atención</label>
                                <select class="form-control" id="tipo-atencion-usu" name="tipo-atencion-usu">
                                    <option value="0" selected disabled>Seleccione</option>
                                </select>
                            </div>
                            <div class="col-lg-3 col-sm-3 col-md-3">
                            <label for="estado-caso">Estado</label>
                            <select id="estado-caso" name="estado-caso" class="form-control">
                                <option value="0" disabled>Seleccione Estado</option>
                            </select>
                        </div>
                            <div class="form-group col-md-3">
                                <label for="direcciones_caso">Direcciones Administrativa</label>
                                <select class="form-control" id="direcciones_caso" name="direcciones_caso">
                                    <option value="0" selected disabled>Seleccione</option>
                                    <?php echo $direcciones; ?>
                                </select>
                            </div>

                            <div class="col-md-5">
                        <br>
                         <label for="estado-caso">Edad-> </label>
                           <label for="edad_min"  >Desde:</label>
                           <input type="number"  style="width: 50px;" id="edad_min" min="0" name="edad_min">&nbsp;&nbsp;
                           <label for="edad_max">Hasta:</label>                                
                           <input type="number"  style="width: 50px;"id="edad_max" min="0" name="edad_max">
                         </div>

                         <div class="col-md-3">
                            <br>
                             <button type="button" class="btn btn-sm btn-primary consultar">Consultar</button>&nbsp;&nbsp;
                             <button type="button" class="btn btn-sm btn-secondary limpiar">Limpiar</button>
                         </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
  

             
       
      <!--Form-->
      <div class="row">
        <div class="col-lg-12 col-sm-12 col-md-12 ">
          <div class="card">
            <div class="card-body">
              <table class="display table-responsive" id="table_casos" style="width:100%" style="margin-top: 20px">
                <thead>
                  <tr>
                    <!-- <td class="text-center" style="width: 1%;">Nº</td> -->
                    <td class="text-center" style="width: 1%;">Cédula</td>
                    <td class="text-center" style="width: 1%;">Tipo de Beneficiario</td>
                    <td class="text-center" style="width: 12%;">Beneficiario</td>
                    <td class="text-center" style="width: 3%;">Teléfono</td>
                    <td class="text-center" style="width: 6%;">Propiedad Intelectual</td>
                    <td class="text-center" style="width: 4%;">Tipo de Atención</td>
                    <td class="text-center" style="width: 1%;">Fecha</td>
                    <td class="text-center" style="width: 1%;">Estatus</td>
                    <td class="text-center" style="width: 12%;">Dirección Remitida</td>
                    <td class="text-center" style="width: 5%;">Operador</td>
                  </tr>
                </thead>
                <tbody id="listar_casos">
                </tbody>
              </table>
            </div>

          </div>
        </div>
      </div>
    </div>
  </div>
  </div>