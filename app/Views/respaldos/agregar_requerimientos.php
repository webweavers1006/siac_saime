<!-- Enlace a la hoja de estilos -->
<link rel="stylesheet" href="<?php echo base_url(); ?>/css_paginas/vista_agregar_requerimientos.css">

<!-- Estilos personalizados -->
<style>
  table.dataTable thead,
  table.dataTable tfoot {
    background: linear-gradient(to right, #a9b6c2, #a9b6c2, #a9b6c2);
  }
</style>

<!-- Contenido principal -->
<div class="content-wrapper">
  <main class="content">
    <br>
    <div class="container">
      <!-- Tarjeta principal -->
      <div class="card card_table">
        <div class="card-header border-0">
          <div class="d-flex align-items-center">
            <img src="<?php echo base_url(); ?>/img/favicon.jpg" style="width: 30px; height: 30px;">
            <div class="ml-2">
              <p class="mb-0" style="font-size: 18px; font-weight: bold;">Audiencia</p>
              <span style="font-size: 14px;">Ingresar</span>
            </div>
          </div>
        </div>

        <div class="card-body text-center">
          <!-- Formulario -->
          <div class="row mx-auto">
            <div class="col-lg-12">
              <div class="columns is-centered is-multiline">
                <!-- Fila 1 -->
                <div class="row">
                  <div class="col-lg-5 col-sm-5 col-md-5 mx-auto">
                    <div class="field">
                      <label class="label float-left">Tipo de audiencia</label>
                      <div class="control w-100">
                        <div class="select w-100">
                          <select name="id_area" id="id_area" class="w-100">
                            <option value="0">---Seleccione un tipo de audiencia---</option>
                            <option value="1">Marcas</option>
                            <option value="2">Patentes</option>
                          </select>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="col-1"></div>
                  <div class="col-lg-5 col-sm-5 col-md-5 mx-auto">
                    <div class="field">
                      <label class="label float-left">Formato Cita</label>
                      <div class="control w-100">
                        <div class="select w-100">
                          <select name="id_formato_cita" class="w-100">
                            <option value="0">---Seleccione un Formato---</option>
                            <option value="1">Presencial</option>
                            <option value="2">Virtual</option>
                          </select>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>

                <!-- Fila 2 -->
                <div class="row">
                  <div class="col-lg-5 col-sm-5 col-md-5 mx-auto">
                    <div class="field">
                      <label class="label float-left">Pais</label>
                      <div class="control w-100">
                        <div class="select w-100">
                        <select name="id_pais" class="w-100" id="pais-select">
                        <option value="0">---Seleccione un pais---</option>
                        <?php
                        foreach ($datos2['paisess'] as $estado) {
                            echo "<option value='{$estado['id']}'>{$estado['pais']}</option>";
                        }
                        ?>
                        </select>

                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="col-1"></div>
                  <div class="col-lg-5 col-sm-5 col-md-5 mx-auto">
                    <div class="field">
                      <label class="label float-left">Estado</label>
                      <div class="control w-100">
                        <div class="select w-100"> 
                        <select name="id_estado_pais" class="w-100">
                        <option value="0">---Seleccione un pais---</option>
                        <?php
                        foreach ($datos['estados_paisess'] as $estado) {
                            echo "<option value='{$estado['id']}'>{$estado['estado_pais']}</option>";
                        }
                        ?>
                        </select>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>

        <div class="card-body">
          <div class="columns">
            <div class="column is-12">
              <div class="dividir"><span>Solicitudes</span></div>
            </div>
          </div>

          <div class="row">
  <!-- Número de Solicitud -->
  <div class="column is-5">
    <div class="field col-lg-12 col-sm-12 col-md-12 ">
      <label class="label">Numero Solicitud</label>
      <div class="field-body">
        <div class="field">
          <div class="control" style="display: inline-block">
            <input class="input is-expanded" type="text" maxlength="4" name="ano" value="">
          </div>
          <div class="control" style="display: inline-block">
            <p>&nbsp;-&nbsp;</p>
          </div>
          <div class="control" style="display: inline-block">
            <input class="input is-expanded" type="text" name="sol" maxlength="6" value="">
          </div>
          <div class="control" style="display: inline-block">
            <button class="button is-info">Buscar</button>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="col-1">
  </div>
  <!-- Numero Registro -->
  <div class="column is-5">
    <div class="field col-lg-12 col-sm-12 col-md-12 ">
      <label class="label">Numero Registro</label>
      <div class="field-body">
        <div class="field">
          <div class="control" style="display: inline-block">
            <div class="select">
              <select name="letra">
                <option value="0">---</option>
                <option value="S">S</option>
                <option value="P">P</option>
                <option value="F">F</option>
                <option value="D">D</option>
                <option value="N">N</option>
                <option value="L">L</option>
              </select>
            </div>
          </div>
          <div class="control" style="display: inline-block">
            <p>&nbsp;-&nbsp;</p>
          </div>
          <div class="control" style="display: inline-block">
            <input class="input is-expanded" type="text" name="num" maxlength="6" value="">
          </div>
          <div class="control" style="display: inline-block">
            <button class="button is-info">Buscar</button>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<br>

<div class="row">
  <!-- Columna 3 -->
  <div class="col-12">
    <!-- Información de la marca -->
    <div class="ant-descriptions css-2i2tap">
      <div class="ant-descriptions-header">
        <div class="ant-descriptions-title"> 
          <label class="label">Información de la marca</label>
        </div>
      </div>
      <div class="ant-descriptions-view">
        <table style="width:100%; border: none">
          <thead>
            <tr>
              <th style="font-weight: normal">Nombre de la Marca</th>
              <th style="font-weight: normal">Nombre Titular</th>
              <th style="font-weight: normal">Numero Poder</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td>N/A</td>
              <td></td>
              <td></td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>
<div class="row">
  <div class="col-12">
    <!-- Categoria -->
    <div class="field">
      <label class="label">Categoria</label>
      <div class="control">
        <div class="select">
          <select name="id_categoria" style="width: 100%">
            <option value="0">---Seleccione una categoria---</option>
          </select>
        </div>
      </div>
    </div>
  </div>
</div>
<br>
<div class="row">
  <!-- Columna 3 -->
  <div class="col-12">
    <!-- Descripcion -->
    <div class="field">
      <label class="label">Descripción</label>
      <textarea class="textarea" style="margin-top: 0;" name="descripcion">
      </textarea>
    </div>
  </div>
</div>
<br>
<div class="row">
  <!-- Columna 3 -->
  <div class="col-12">
    <!-- Botón Agregar Caso -->
    <button class="button is-primary is-fullwidth">Agregar Caso</button>
  </div>
</div>


<br>
<div class="columns is-centered is-multiline">
  <!-- Columna 1 -->
  <div class="column is-9">
    <!-- Tabla de audiencia -->
    <div class="box">
      <div class="ant-table-wrapper css-2i2tap">
        <div class="ant-spin-nested-loading css-2i2tap">
          <div class="ant-spin-container">
            <div class="ant-table ant-table-empty">
              <div class="ant-table-container">
                <div class="ant-table-content">
                  <table class="table table-striped table-bordered" id="table_audiencia" style="table-layout: auto;">
                    <thead>
                      <tr>
                        <th class="ant-table-cell" scope="col">Nombre</th>
                        <th class="ant-table-cell" scope="col">Numero de registro</th>
                        <th class="ant-table-cell" scope="col">Numero de solicitud</th>
                        <th class="ant-table-cell" scope="col">Categoria</th>
                        <th class="ant-table-cell" scope="col">Descripcion categoria</th>
                        <td class="ant-table-cell">
                      </tr>
                    </thead>
                    <tbody class="tbody_0">
                      <!-- Contenido de la tabla -->
                      <td class="ant-table-cell" colspan="7" style="text-align: center;">
                        <div class="css-2i2tap ant-empty ant-empty-normal">
                          <div class="ant-empty-image" style="display: block; margin: 0 auto;">
                            <svg width="64" height="41" viewBox="0 0 64 41" xmlns="http://www.w3.org/2000/svg">
                              <g transform="translate(0 1)" fill="none" fill-rule="evenodd">
                                <ellipse fill="#f5f5f5" cx="32" cy="33" rx="32" ry="7"></ellipse>
                                <g fill-rule="nonzero" stroke="#d9d9d9">
                                  <path d="M55 12.76L44.854 1.258C44.367.474 43.656 0 42.907 0H21.093c-.749 0-1.46.474-1.947 1.257L9 12.761V22h46v-9.24z"></path>
                                  <path d="M41.613 15.931c0-1.605.994-2.93 2.227-2.931H55v18.137C55 33.26 53.68 35 52.05 35h-40.1C10.32 35 9 33.259 9 31.137V13h11.16c1.233 0 2.227 1.323 2.227 2.928v.022c0 1.605 1.005 2.901 2.237 2.901h14.752c1.232 0 2.237-1.308 2.237-2.913v-.007z" fill="#fafafa"></path>
                                </g>
                              </g>
                            </svg>
                          </div>
                          <div class="ant-empty-description">No data</div>
                        </div>
                      </td>
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

  <!-- Columna 2 -->
  <div class="column is-9">
    <!-- Botón Ingresar Requerimiento -->
    <div class="box">
      <button class="button is-primary is-fullwidth">Ingresar Audiencia</button>
    </div>
  </div>
</div>
  </main>
  <br>
</div>
