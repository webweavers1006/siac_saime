<!-- Content Wrapper. Contains page content -->
<link rel="stylesheet" href="<?php echo base_url(); ?>/css_paginas/audiencias.css">

<style>
  table.dataTable thead,
  table.dataTable tfoot {
    background: linear-gradient(to right, #a9b6c2, #a9b6c2, #a9b6c2);
  }
</style>

<div class="content-wrapper">
  <main class="content">
    <div class="container-fluid ml-0 rounded-pill">
      <div class="row">
        <div class="col-lg-10"> <!-- Tarjeta principal -->
          <div class="card card_table">
            <div class="card-header border-0">
              <div class="d-flex justify-content-between">
                <h3 class="text-secondary text-center">
                  <i class="fas fa-angle-double-right"></i>
                  Listado de Audiencias
                </h3>
                <button type="submit" id="btn_agregar" class="btn btn-sm btn-primary btn_agregar" data-toggle="modal" data-target="#add-direcciones">
                  Agregar (+)
                </button>
              </div>
            </div>
            <div class="card-body">
            <div class="col-lg-12 col-sm-12 col-md-12 ">
                    
                    <table class="display table-responsive" id="table_audiencia" style="width:100%" style="margin-top: 20px">
                    <thead>
                      <tr>
                        <td class="text-center ant-table-cell" style="width: 1%;" >Estatus</td>
                        <td class="text-center" style="width: 4%;">Numero de audiencia</td>
                        <td class="text-center" style="width: 5%;">Pais</td>
                        <td class="text-center" style="width: 4%;">Estatus del caso</td>
                        <td class="text-center" style="width: 3%;">Area</td>
                        <td class="text-center" style="width: 8%;">Usuario</td>
                        <td class="text-center" style="width: 1%;">Acciones</td>
                      </tr>
                    </thead>
                    <tbody id="listar_audencias">
                    </tbody>
                  </table>
                </div>
            </div>
          </div>
        </div>
        <div class="col-lg-2"> 
          <!-- Tarjeta pequeña con interruptores y botón de exportar -->
          <div class="card interructores">
            <div class="card-body">
              <label class="form-check-label text-left" for="pdf"><b>Exportación</b></label>
              <div class="form-check">
                <input class="form-check-input" type="checkbox" id="pdf" />
                <label class="form-check-label" for="pdf">PDF</label>
              </div>
              <div class="form-check">
                <input class="form-check-input" type="checkbox" id="excel" />
                <label class="form-check-label" for="excel">Excel</label>
              </div>
              <button class="btn btn-primary btn-block exportar " id="exportar">Exportar</button>
            </div>
          </div>
        </div>
      </div>


      <div class="row">
  <div class="col-4">
    <div class="box_estatus">
      <div class="card estatus">
        <div class="card-body">
          <div><span class="legend-items">
            <span class="ant-badge ant-badge-status ant-badge-not-a-wrapper css-2i2tap">
            <span class="legend-item leyend1">Nuevo</span>
          <div><span class="legend-items">
          <span class="legend-item leyend2">En proceso</span>
          <div><span class="legend-items">
          <span class="legend-item leyend3">Resuelto</span>
        </div>
      </div>
    </div>
  </div>
</div>




    </div>
    


    
  </main>



<script>
 const exportarButton = document.getElementById('exportar');
exportarButton.addEventListener('click', exportData);

function exportData() {
  const pdfCheckbox = document.getElementById('pdf');
  const excelCheckbox = document.getElementById('excel');

  const exportToPdf = pdfCheckbox.checked;
  const exportToExcel = excelCheckbox.checked;

  const table = document.getElementById('table_audiencia');
  const rows = table.getElementsByTagName('tr');

  let filteredData = [];

  for (let i = 1; i < rows.length; i++) {
    let row = rows[i];
    let cols = row.getElementsByTagName('td');
    let dataRow = [];

    for (let j = 0; j < cols.length; j++) {
      dataRow.push(cols[j].textContent);
    }

    filteredData.push(dataRow);
  }

  if (exportToPdf) {
    exportToPdfFile(filteredData);
  }

  if (exportToExcel) {
    exportToExcelFile(filteredData);
  }
}

function exportToPdfFile(data) {
  let tableHtml = '<table>'; // Declare as let instead of const
  for (let i = 0; i < data.length; i++) {
    const row = data[i];
    tableHtml += '<tr>';
    for (let j = 0; j < row.length; j++) {
      tableHtml += `<td>${row[j]}</td>`;
    }
    tableHtml += '</tr>';
  }
  tableHtml += '</table>';

  const printWindow = window.open('', '_blank');
  printWindow.document.write(tableHtml);
  printWindow.document.close();
  printWindow.print();
  printWindow.close();
}

function exportToExcelFile(data) {
  let csvContent = 'sep=,\r\n'; // Declarar como let en lugar de const
  for (let i = 0; i < data.length; i++) {
    const row = data[i];
    csvContent += row.join(',') + '\r\n';
  }

  const blob = new Blob([csvContent], { type: 'text/csv' });
  const url = URL.createObjectURL(blob);
  const a = document.createElement('a');
  a.href = url;
  a.download = 'export.csv';
  a.click();
  URL.revokeObjectURL(url);
}
</script>



  
</div>