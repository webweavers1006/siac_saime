<?php

namespace App\Controllers;
use App\Models\Usuarios_Visitas_Model;
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
 
    setlocale(LC_TIME, 'es_ES.UTF-8');
    $model = new Usuarios_Visitas_Model();
    $query = $model->ContarUsuariosVisitas($desde, $hasta);
    setlocale(LC_TIME, 'es_ES.UTF-8');

    // Obtener la fecha actual
    $fecha_actual = $hasta;
    
    // Fecha indicada
    $fecha_indicada = $desde;
    
    // Obtener el modelo de usuarios
    $model = new Usuarios_Visitas_Model();
    
    // Contar las visitas de usuarios
    $query = $model->ContarUsuariosVisitas($fecha_indicada, $fecha_actual);
    
    // Encontrar el primer y último registro con valor
    $primer_registro = null;
    $ultimo_registro = null;
    foreach ($query as $row) {
        if ($row->num_requests > 0) {
            if (!$primer_registro) {
                $primer_registro = $row;
            }
            $ultimo_registro = $row;
        }
    }
    
    // Si no se encontró un primer o último registro con valor, mostrar un mensaje de error
    if (!$primer_registro || !$ultimo_registro) {
        echo "No se encontró un primer o último registro con valor";
        exit;
    }
    
    // Recorrer todos los días del rango
    $fecha_iteracion = $fecha_indicada;
    while ($fecha_iteracion <= $fecha_actual) {
        $encontrado = false;
        $visitas = 0;
        foreach ($query as $row) {
            if ($row->fecha === $fecha_iteracion) {
                $encontrado = true;
                $visitas = $row->num_requests;
                break;
            }
        }
    
        // Mostrar el día, las visitas y la fecha en el arreglo
        $casos[] = array(
            "dia" => strftime('%A', strtotime($fecha_iteracion)),
            "visitas" => $visitas,
            "fecha" => $fecha_iteracion,
        );
    
        // Sumar un día a la fecha de iteración
        $fecha_iteracion = date('Y-m-d', strtotime($fecha_iteracion . " + 1 days"));
    }
    
  
    
       
// Cargar la biblioteca FPDF
$pdf = new \FPDF('P', 'mm', 'letter');
$pdf->AddPage();
  $pdf->Header_Usuarios_Visitas();
    $pdf->Content_Usuarios_Visitas($casos,$desde,$hasta);
    $pdf->SetMargins(10, 10);
    $pdf->SetAutoPageBreak(true, 10);
    $pdf->Footer_Planilla();
    $this->response->setHeader('Content-Type', 'application/pdf');
    $pdf->Output("salidas_pdf.pdf", "I");
  }

  
  

}