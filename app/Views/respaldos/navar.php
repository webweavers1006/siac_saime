<meta charset="utf-8">
<link rel="stylesheet" href="<?php echo base_url(); ?>/css_paginas/navar.css">
<!-- Google Font: Source Sans Pro -->
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">

<body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper">
        <nav class="main-header navbar navbar-expand navbar-white navbar-light">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" data-widget="pushmenu" onclick="cerrarMenu();" href="#" role="button"><i class="fas fa-bars"></i></a>
                </li>

            </ul>
            <ul class="navbar-nav ml-auto">
                <!-- <a href="javascript:history.back()"><img src="<php echo base_url();?>/img/i2.jpg" class="img-size-50 img-circle mr-3"></a> -->
                <li class="nav-item">
                <li class="nav-item d-none d-sm-inline-block">
                    <a href="#Foo" onclick="cerrarSesion();" class="nav-link">Salir</a>
                </li>
                <script>
                    function cerrarSesion() {
                        Swal.fire({
                            title: '¿Deseas salir?',
                            text: 'Estás a punto de abandonar la página.',
                            icon: 'question',
                            showCancelButton: true,
                            confirmButtonText: 'Sí',
                            cancelButtonText: 'No'
                        }).then((result) => {
                            if (result.value) {
                                // Aquí puedes agregar la lógica para salir de la página
                                window.location.href = '/';
                            }
                        });
                    }
                </script>
                </li>
            </ul>
        </nav>
        <style>
            .asiside {
                display: block;
            }
        </style>
        <script>
            function cerrarMenu() {

                var menu = document.getElementById("asisde");
                if (menu.classList.contains("asiside")) {
                    menu.classList.remove("asiside");
                    menu.style.display = "none";
                } else {
                    menu.classList.add("asiside");
                    menu.style.display = "block";
                }
            }
        </script>

        <aside class="main-sidebar  sidebar-dark-light elevation-4" id="aside">
            <!-- Brand Logo -->
            <a href="index3.html" class="brand-link">
                <!-- <img src="<php echo base_url(); ?>/img/logosapi-01.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-4" style="opacity: .8"> -->
                <span class="brand-text font-weight-light">Gestion de Casos </span>
            </a>
            <!-- Sidebar -->
            <div class="sidebar">
                <!-- Sidebar user panel (optional) -->
                <div class="user-panel mt-3 pb-3 mb-3 d-flex">

                    <div class="info">
                        <a href="#" class="d-block">
                            <h6><?= session('nombre'); ?></h6>
                        </a>
                    </div>
                </div>

                <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu1">
                    <li class="nav-item ">
                        <a href="<?php echo base_url(); ?>/inicio" class="nav-link active"><i class="nav-icon fas fa-tachometer-alt"></i>
                            <p>Inicio </p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="<?php echo base_url(); ?>/casos" class="nav-link" id="casos"><i class="nav-icon fas fa-copy" id="menu_citas"></i>
                            <p>Casos</p>

                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="<?php echo base_url(); ?>/reportes" class="nav-link" id="reportes"><i class="nav-icon fas fa-copy"></i>
                            <p>Reportes</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="<?php echo base_url(); ?>/reposos" class="nav-link" id="menu_reposos"><i class="nav-icon fas fa-copy"></i>
                            <p> Reposos</p>
                        </a>
                    </li>
                </ul>
            </div>
        </aside>
</body>

<script>
    $('#btnAgregar').on('push', function(e) {
        alert('clicl ');


    });
</script>