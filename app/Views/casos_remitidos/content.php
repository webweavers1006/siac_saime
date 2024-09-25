<!-- Content Wrapper. Contains page content -->
<?php
$session = session();
?>



<!-- <link rel="stylesheet" href="<php echo base_url(); ?>/datatable_responsive/css/responsive.bootstrap4.css"> -->
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
    <div class="container-fluid">
      <!-- /.row -->
      <div class="row">
        <div class="col-lg-12 col-sm-12 col-md-12 p-2">
          <div class="card">
          
            <div class="card-header border-0">
              <div class="d-flex justify-content-between">
              <h3 class="text-secondary"><i class="fas fa-angle-double-right"></i>Casos Remitidos </h3>
              <h5 class="text-primary"> <?php echo $direccion;?></h5>
                
                <input type="hidden" name="" id="rol_usuario" value="<?php echo($session->get('userrol'));?>">
                </h3>
                <input type="hidden" name="" id="mensaje_documento" value="<?php echo $mensaje ?>">

                
              </div>
              <div class="row">
                  <div class="col-lg-12 col-sm-12 col-md-12 ">
                    
                        <table class="display table-responsive" id="table_casos" style="width:100%" style="margin-top: 20px">
                        <thead>
                          <tr>
                            <td class="col" style="width: 1%;">Nº</td>
                            <td class="text-center" style="width: 1%;">Cédula</td>
                            <td class="text-center" style="width: 12%;">Beneficiario</td>
                            <td class="text-center" style="width: 3%;">Teléfono</td>
                            <td class="text-center" style="width: 8%;">Propiedad Intelectual</td>
                            <td class="text-center" style="width: 4%;">Tipo de Atención</td>
                            <td class="text-center" style="width: 3%;">Fecha</td>
                            <td class="text-center" style="width: 3%;">Estatus</td>
                            <td class="text-center" style="width: 6%;">Operador</td>
                            <td class="text-center" style="width: 1%;">Acciones</td>
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
      <!-- /.row -->
    </div><!-- /.container-fluid -->
    <style>
      #editCase {
      overflow-y: auto;
      max-height: auto; /* adjust the max-height value as needed */
    }
    </style>
 


    
  </div>
  <!-- /.content -->
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