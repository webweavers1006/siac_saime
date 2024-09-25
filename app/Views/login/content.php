<body class="hold-transition login-page">

<style>
  .login-box {
  margin-top: -180px;
}
</style>
  <div class="login-box">
    <div class="login-logo">
      <img src="<?php echo base_url(); ?>/theme/img/Logosapi-2020.png" style="max-width: 10rem; max-height: 10rem;">
    </div>
    <!-- /.login-logo -->
    <div class="card">
      <div class="card-body login-card-body">
        <p class="login-box-msg">Inicie sesion para usar la aplicacion</p>

        <form method="post" id="login-user">
          <div class="input-group mb-3">
            <input type="email" class="form-control" placeholder="Correo electronico institucional" name="usuario-email" id="usuario-email">
            <div class="input-group-append">
              <div class="input-group-text">
                <span class="fas fa-envelope"></span>
              </div>
            </div>
          </div>
          <div class="input-group mb-3">
            <input type="password" class="form-control" placeholder="Contraseña" name="usuario-clave" id="usuario-clave">
            <div class="input-group-append">
              <div class="input-group-text">
                <span class="fas fa-lock"></span>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-8">
            </div>
            <!-- /.col -->
            <div class="col-4">
              <button type="submit" class="btn btn-primary btn-block">Entrar</button>
            </div>
            <!-- /.col -->
          </div>
        </form>


      </div>
      <!-- /.login-card-body -->
    </div>
  </div>
  <!-- /.login-box -->