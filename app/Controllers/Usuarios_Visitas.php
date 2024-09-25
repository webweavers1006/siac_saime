<?php

namespace App\Controllers;
use App\Models\Usuarios_Visitas_Model;
use App\Models\Casos;
use CodeIgniter\I18n\Time;
use CodeIgniter\API\ResponseTrait;
use CodeIgniter\Exceptions\AlertError;
use CodeIgniter\RESTful\ResourceController;


class DateTime extends BaseController
{
    public function index()
    {
        $data = json_decode('[{"count": "1","fecha": "2024-03-20"}]');

        foreach ($data as $value) {
          $date = \DateTime::createFromFormat('Y-m-d', $value->fecha);
            $day = $date->format('l');
            $formattedDate = $date->format('d/m/Y');
            $count = $value->count;

            echo sprintf("%s, %s, %s<br>", $day, $formattedDate, $count);
        }
    }
}

class Usuarios_Visitas extends BaseController
{

  public function Control_Visitas()
  {
    if ($this->session->get('logged')) { 
      echo view('template/header');
      echo view('template/nav_bar');
      echo view('usuarios_visitas/content');
      echo view('template/footer');
      echo view('usuarios_visitas/footer_usuarios_visitas.php');
      
    } else {
      return redirect()->to('/');
    }
  }


  public function ContarUsuariosVisitas($desde = null, $hasta = null)
  {
    $model = new Usuarios_Visitas_Model();
    $model_casos = new Casos();
    //$query = $model->ContarUsuariosVisitas($desde, $hasta);
    // Obtener la fecha actual
    $fecha_actual = date($hasta);
    // Fecha indicada
    $fecha_indicada = $desde;
    // Obtener el modelo de usuarios
    $model = new Usuarios_Visitas_Model();
    // Contar las visitas de usuarios
    $query = $model->ContarUsuariosVisitas($fecha_indicada, $fecha_actual); 
   
    $casos = [];
    for ($date = $desde; $date <= $hasta; $date = date('Y-m-d', strtotime($date . ' +1 day'))) {
    $num_requests = 0;
    $date_formatted = date('Y/m/d', strtotime($date));
  // Loop through each result in the query
  foreach ($query as $row) {
    // If the result's date matches the current day, add its number of requests to the total
    if ($row->fecha === $date_formatted) {
      $num_requests = $row->num_requests;
      break;
    }
  }
  // Add the current day and its number of requests to the casos array
  $fecha_formateada = date("d-m-Y", strtotime($date));
  $casos[] = [
    'dia' => ucfirst(strftime('%A', strtotime($date))), // get the day name in Spanish and capitalize the first letter
    'fecha' => $fecha_formateada,
    'visitas' => $num_requests,
  ];
}


    // Recorrer todos los días del rango
    $fecha_iteracion = $fecha_indicada;
    //FECHA CONVERTIDA DESDE 
    function convertirFecha($fecha) {
      // Convertir la fecha a un timestamp de Unix
      $fecha_timestamp = strtotime($fecha);
      // Dividir el timestamp en partes
      $anio = date('Y', $fecha_timestamp);
      $mes = date('m', $fecha_timestamp);
      $dia = date('d', $fecha_timestamp);
      // Formatear la fecha en el formato deseado
      $fecha_formateada = $dia . '-' . $mes . '-' . $anio;
      return $fecha_formateada;
    }
    $fecha_formateada_desde = convertirFecha($desde);
    $fecha_formateada_hasta = convertirFecha($hasta);
   
    // Obtener el valor de "casos_creador" portal web
    $casos_creados = $model_casos->ContarCasos_Portal_Web($desde, $hasta);

    $creados = array();
    foreach ($casos_creados as $fila) {
      // Definir las variables
      $dia_semana_completo = $fila->dia_semana_completo;
      $casos_creados = $fila->casos_creados;
      $fecha = $fila->fecha;
      $fecha_formateada = date("d-m-Y", strtotime($fecha));
      // Mostrar el día, las visitas y la fecha en el arreglo
      $dias_semana = array("Domingo", "Lunes", "Martes", "Miércoles", "Jueves", "Viernes", "Sábado");
      $creados[] = array(
          "dia" => $dias_semana[date("w", strtotime($fecha))],
          "creados" => $casos_creados,
          "fecha" => $fecha_formateada,
      
      );
    }  
   
  
  
    foreach ($casos as $key => $value) {
      foreach ($creados as $key2 => $value2) {
        if ($value["fecha"] == $value2["fecha"]) {
          $casos[$key]["creados"] = $value2["creados"];
        }
      }
    }  
   

//esto es para obtener los casos creados en el reporte
// Obtener el valor de "casos_creador"
$casos_sistema = $model_casos->ContarCasos($desde, $hasta);

$sgc_casos = array();
foreach ($casos_sistema as $fila) {
  $dias_semana = array("Domingo", "Lunes", "Martes", "Miércoles", "Jueves", "Viernes", "Sábado");
  $casos_DAC = $fila->total_idcaso;
  $fecha_DAC = $fila->casofec;
  $fecha_DAC = date("d-m-Y", strtotime($fecha_DAC));
    $sgc_casos[] = array(
      "dia" => $dias_semana[date("w", strtotime($fecha_DAC))],
      "sgc_casos_DAC" => $casos_DAC,
      "fecha" => $fecha_DAC,
  );
 
} 


foreach ($casos as $key => $caso) {
  foreach ($sgc_casos as $sgc_caso) {
      if ($caso['fecha'] == $sgc_caso['fecha']) {
          $casos[$key]['sgc_casos_DAC'] = $sgc_caso['sgc_casos_DAC'];
          break;
      } else if (empty($caso)) {
          $casos[$key]['sgc_casos_DAC'] = 0; // Asignar 0 si $caso está vacío
      }
  }
}

// // Cargar la biblioteca FPDF
$pdf = new \FPDF('P', 'mm', 'letter');
$pdf->AddPage();
  $pdf->Header_Usuarios_Visitas();
    $pdf->Content_Usuarios_Visitas($casos,$desde,$hasta, $fecha_formateada_desde, $fecha_formateada_hasta,$creados);
    $pdf->SetMargins(10, 10);
    $pdf->SetAutoPageBreak(true, 10);
    $pdf->Footer_Planilla();
    $this->response->setHeader('Content-Type', 'application/pdf');
    $pdf->Output("salidas_pdf.pdf", "I");
  }
}