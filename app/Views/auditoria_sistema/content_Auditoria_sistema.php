<!-- Content Wrapper. Contains page content -->
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
            <!-- /.row -->
            <div class="row">
                <div class="col-lg-12 col-sm-12 col-md-12 p-2">
                    <div class="card">
                        <div class="card-header border-0">

                            <div class="d-flex justify-content-between">

                                <h3 class="text-secondary"><i class="fas fa-angle-double-right"></i> Auditoría Sistema</h3>

                            </div>
                        </div>
                        <div class="card-body">
                            <!--Form-->
                            <div class="row">
                                <div class="col-lg-12 col-sm-12 col-md-12 ">
                                    <div class="card">
                                        <div class="card-body">
                                            <table class="display table-responsive" id="table_auditoria_sistema" style="width:100%" style="margin-top: 20px">
                                                <thead>
                                                    <tr>
                                                        <td class="text-center" style="width: 10%;">Ip</td>
                                                        <td class="text-center" style="width: 20%;">Usuario</td>
                                                        <td class="text-center" style="width: 80px;">Acción</td>
                                                        <td class="text-center" style="width: 10%;">Fecha</td>
                                                        <td class="text-center" style="width: 10%;">Hora</td>
                                                        <td class="text-center" style="width: 10%;">Dispositivo</td>
                                                    </tr>
                                                </thead>
                                                <tbody id="listar_auditoria">
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
            <!-- /.row -->
        </div><!-- /.container-fluid -->

    </div>
    <!-- /.content -->
</div>