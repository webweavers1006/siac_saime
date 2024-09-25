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
    $casos = [];
    
    $total_requests = 0; 
    foreach ($query as $row) {
        $timestamp = strtotime($row->fecha);
        $day_name = strftime('%A', $timestamp);
        $initial = ucfirst($day_name);
        $casos[] = [
            "dia_semana_completo" => $initial,
            "fecha" => date("d-m-Y", $timestamp),
            "num_requests" => intval($row->num_requests)
        ];
        $total_requests += intval($row->num_requests);
    }
     //  // Agregar la fila de total al final de los registros
 if ($row === end($query)) { // Verificar si es el último registro
  $casos[] = [
      "dia_semana_completo" => "Total",
      "fecha" => "",
      "num_requests" => $total_requests,
      "class" => "bg-primary text-blue" // Añadir una clase CSS para cambiar el color de fondo y el texto
  ];
} 
  
    $json_casos = json_encode($casos, JSON_PRETTY_PRINT);
    echo $json_casos;
    
  }




 
}