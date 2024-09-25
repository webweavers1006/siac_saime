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
              <p class="mb-0" style="font-size: 18px; font-weight: bold;">Agregar solicitudes</p>
              <span style="font-size: 14px;">Audiencia N°<?php echo $datos2['id']; ?> </span> 
            </div>
          </div>
        </div>

        

<div class="card-body">
  <div class="row">
  <!-- Número de Solicitud -->
  <div class="column is-5">
    <div class="field col-lg-12 col-sm-12 col-md-12 ">
    <form id="buscar" method="POST" role="form">
      <label class="label">Numero Solicitud</label>
      <div class="field-body">
        <div class="field">
          <div class="control" style="display: inline-block">
            <input class="input is-expanded" onkeypress="return valideKey(event);" type="text" maxlength="4" name="ano" id="ano" value="">
          </div>
          <div class="control" style="display: inline-block">
            <p>&nbsp;-&nbsp;</p>
          </div>
          <div class="control" style="display: inline-block">
            <input class="input is-expanded" onkeypress="return valideKey(event);"  type="text" name="sol" id="sol" maxlength="6" value="">
          </div>
          <div class="control" style="display: inline-block">
            <button class="button is-info" >Buscar</button>
          </div>
        </div>
      </div>
    </form>
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
      

      <div class="row">
  <div class="col-lg-4 col-sm-4 col-md-4">          
    <label for="nombre_marca">Nombre de la Marca:</label>
  </div>
  <div class="col-lg-4 col-sm-4 col-md-4">
    <label for="nombre_titular">Nombre Titular:</label>
  </div>
  <div class="col-lg-4 col-sm-4 col-md-4">
    <label for="numero_poder">Numero Poder:</label>
  </div>
</div>

<div class="row">
  <div class="col-lg-4 col-sm-4 col-md-4">          
    <textarea class="text_area_marca" id="nombre_marca" name="nombre_marca" ></textarea>
  </div>
  <div class="col-lg-4 col-sm-4 col-md-4">
    <textarea class="text_area_marca" id="nombre_titular" name="nombre_titular" ></textarea>
  </div>
  <div class="col-lg-4 col-sm-4 col-md-4">
    <textarea class="text_area_marca" id="numero_poder" name="numero_poder" ></textarea>
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
        <select id="id_categoria" style="width: 100%">
          <option value="0">---Seleccione una categoria---</option>
         
        </select>

        <script>
        var categorias = <?php echo json_encode($categorias['categorias']); ?>;
    
        var areaId = <?php echo json_encode($datos2['id_area']); ?>;
        var categoriaSelect = document.getElementById('id_categoria');
        
        // Clear the options
        categoriaSelect.innerHTML = '<option value="0">---Seleccione una categoria---</option>';
        
        // Filter the categories based on the selected department
        var filteredCategorias = categorias.filter(function(cate) {
          return cate.id_departamento === parseInt(areaId);
        });
        
        // Add the filtered options to the select box
        filteredCategorias.forEach(function(cate) {
          var option = document.createElement('option');
          option.value = cate.id;
          option.text = cate.categoria;
          categoriaSelect.add(option);
        });
     
      </script>
  




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
      <textarea class="textarea" style="margin-top: 0;" name="descripcion" id="descripcion">
      </textarea>
    </div>
  </div>
</div>
<br>
<div class="row">
  <!-- Columna 3 -->
  <div class="col-12">
    <!-- Botón Agregar Caso -->
    <button class="button is-primary is-fullwidth" id="agregar_caso" >Agregar Caso</button>
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
                   
                      </tr>
                    </thead>
                    <tbody class="tbody_0">
                      <!-- Contenido de la tabla -->
                      <td class="image_email" colspan="7" style="text-align: center;">
                        <div class="css-2i2tap ant-empty ant-empty-normal">
                          <div  style="display: block; margin: 0 auto;">
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

<script>
  function valideKey(event) {
  var charCode = (event.which) ? event.which : event.keyCode;
  if (charCode > 31 && (charCode < 48 || charCode > 57)) {
    return false;
  }
  return true;
}
</script>

<script>
  // Selecciona el elemento textarea
const textArea = document.querySelector('.text_area_marca');

// Función para ajustar el tamaño del textarea según su contenido
function ajustarTamañoTextArea() {
  textArea.style.height = 'auto'; // Restablece el alto a auto
  textArea.style.height = textArea.scrollHeight + 'px'; // Ajusta el alto según el contenido
}

// Llama a la función cuando se escriba algo en el textarea
textArea.addEventListener('input', ajustarTamañoTextArea);

// Llama a la función inicialmente para ajustar el tamaño según el contenido inicial
ajustarTamañoTextArea();
</script>