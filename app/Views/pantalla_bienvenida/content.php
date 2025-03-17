<!-- Content Wrapper. Contains page content -->
<?php
$session = session();
?>


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
      <div class="row">
        <div class="col-lg-12 col-sm-12 col-md-12 ">
          <div class="card">


            <div class="card-body imagen">
              <input type="hidden" id="rol" value="<?= session('userrol');?> "> 
              <section class="form-login_imagen">
                <div class="imagencentral">
                  <img class="img-fluid mx-auto d-block" src="<?= base_url() ?>/img/LogoSIAC_sapi.png" id="imagencentral">
                </div>
                <br><br><br><br><br>
              </div>
             
            </section>
           
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