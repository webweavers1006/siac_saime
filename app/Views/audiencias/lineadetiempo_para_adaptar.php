<?php
// Conectar a la base de datos
$conn = mysqli_connect("localhost", "usuario", "contraseña", "base_de_datos");

// Verificar la conexión
if (!$conn) {
  die("Conexión fallida: " . mysqli_connect_error());
}

// Ejecutar la consulta SQL
$result = mysqli_query($conn, "SELECT * FROM timeline ORDER BY año DESC");

// Mostrar la información en la línea del tiempo
while ($row = mysqli_fetch_assoc($result)) {
  // Crear un elemento de la línea del tiempo para cada registro
  echo '<div class="row timeline-movement">';
  echo '  <div class="timeline-badge center-' . ($row['tipo'] == 'credito' ? 'left' : 'right') . '"></div>';
  echo '  <div class="col-sm-4 timeline-item">';
  echo '    <div class="row">';
  echo '      <div class="col-sm-11">';
  echo '        <div class="timeline-panel ' . ($row['tipo'] == 'credito' ? 'credits' : 'debits') . ' anim animate fadeIn' . ($row['tipo'] == 'credito' ? 'Left' : 'Right') . '">';
  echo '          <ul class="timeline-panel-ul">';
  echo '            <li><a href="#" class="importo">' . $row['titulo'] . '</a></li>';
  echo '            <li><span class="causale" style="color:#000; font-weight: 600;">' . $row['descripcion'] . '</span></li>';
  echo '            <li><span class="causale">' . $row['fecha'] . '</span></li>';
  echo '          </ul>';
  echo '        </div>';
  echo '      </div>';
  echo '    </div>';
  echo '  </div>';
  echo '</div>';
}

// Cerrar la conexión
mysqli_close($conn);
?>