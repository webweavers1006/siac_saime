
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
 
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
                            <h3 class="text-secondary"><i class="fas fa-angle-double-right"></i> Consolidado de Atencion </h3>
                            <div>
                                <button type="button" class="btn btn-sm btn-primary consultar">Consultar</button>
                                <button type="button" class="btn btn-sm btn-secondary limpiar">Limpiar</button>
                            </div>
                        </div>
                    </div>

                    <!--Form-->
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-2">
                                <label for="desde">Desde:</label>
                                <input type="date" class="form-control" value="<?php echo date('YY-MM-DD'); ?>" name="desde" id="desde">
                            </div>
                            <div class="col-md-2">
                                <label for="hasta">Hasta:</label>
                                <input type="date" class="form-control" value="<?php echo date('YY-MM-DD'); ?>" name="hasta" id="hasta">
                            </div>
                            <div class="col-md-2">
                                <label for="sexo">Género:</label>
                                <select class="form-control" id="sexo" name="sexo">
                                    <option value="0" selected disabled>seleccione</option>
                                    <option value="1">MASCULINO</option>
                                    <option value="2">FEMENINO</option>
                                </select>
                            </div>
                            <div class="col-md-2">
                                <label for="t-beneficiario">Tipo de Beneficiario:</label>
                                <select class="form-control" id="t-beneficiario" name="t-beneficiario">
                                    <option value="0" selected disabled>seleccione</option>
                                    <option value="1">Usuario</option>
                                    <option value="2">Emprendedor</option>
                                </select>
                            </div>
                            <div class="col-md-2">
                                <label for="via-atencion">Via de Atención:</label>
                                <select class="form-control" id="via-atencion" name="via-atencion">
                                    <option value="0" selected disabled>seleccione</option>
                                </select>
                            </div>
                            <div class="col-md-2">
                                <label for="tipo-atencion-usu">Tipo de Atención:</label>
                                <select class="form-control" id="tipo-atencion-usu" name="tipo-atencion-usu">
                                    <option value="0" selected disabled>seleccione</option>
                                </select>
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col-md-3">
                                <label for="tipo-pi">Área:</label>
                                <select class="form-control" id="tipo-pi" name="tipo-pi">
                                    <option value="0" selected disabled>seleccione</option>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label for="direcciones_caso">Casos Remitidos por Dirección</label>
                                <select class="form-control " id="direcciones_caso" name="direcciones_caso" class="form-control">
                                    <option value="0" selected disabled>seleccione</option>
                                    <?php echo $direcciones; ?>
                                </select>
                            </div>
                            <div class="col-md-2">
                                <label for="estatus">Estatus:</label>
                                <select class="form-control" id="estatus" name="estatus">
                                    <option value="0" selected disabled>seleccione</option>
                                    <option value="1">Abierto</option>
                                    <option value="2">Cerrado</option>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label for="office">Dirección Administrativa:</label>
                                <select class="form-control" id="direcciones_caso" name="direcciones_caso">
                                    <option value="0" selected disabled>Seleccione</option>
                                    <?php echo $direcciones; ?>
                                </select>
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
                    <td class="text-center" style="width: 1%;">NºCaso</td>
                    <td class="text-center" style="width: 1%;">Cédula</td>
                    <td class="text-center" style="width: 1%;">Tipo Ben</td>
                    <td class="text-center" style="width: 8%;">Beneficiario</td>
                    <td class="text-center" style="width: 3%;">Teléfono</td>
                    <td class="text-center" style="width: 3%;">Descripcion-Caso</td>
                    <td class="text-center" style="width: 5%;">Seguimientos</td>
                    <td class="text-center" style="width: 1%;">Fecha</td>
                    <td class="text-center" style="width: 1%;">Estatus</td>
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