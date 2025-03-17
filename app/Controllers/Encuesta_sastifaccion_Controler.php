<?php

namespace App\Controllers;

use App\Models\Auditoria_sistema_Model;
use App\Models\Categoria_Model;
use CodeIgniter\API\ResponseTrait;
use App\Models\Participantes_Model;
use CodeIgniter\RESTful\ResourceController;

class Encuesta_sastifaccion_Controler extends BaseController
{
    use ResponseTrait;

    // Método que muestra la vista de los tipos de direcciones
    public function vista_Encuesta()
    {
       
        $url_encuestas = URL_ENCUESTAS; 
        if ($this->session->get('logged')) {
            echo view('template/header');
            echo view('template/nav_bar');
            echo view('encuesta_satifaccion/content.php');
            echo view('template/footer');
            echo view('encuesta_satifaccion/footer_encuesta', ['url_encuestas' => $url_encuestas]);
        } else {
            return redirect()->to('/');
        }
    }

    public function Vista_Detalle_Encuesta($id_participante = null)
    {
        if ($this->session->get('logged')) {
            $url_encuestas = URL_ENCUESTAS; 
    
            // Obtener los datos de la encuesta
            $comentario = json_decode(file_get_contents("{$url_encuestas}/api/encuesta"), true);
            $detalle_encuesta = json_decode(file_get_contents("{$url_encuestas}/api/respuesta/byPresFunc/1/{$id_participante}/1/10000"), true);
            
            // Agrupar todos los datos en un solo array
            $data = [
                'id_participante' => $id_participante,
                'comentario' => $comentario,
                'detalle_encuesta' => $detalle_encuesta,
                'url_encuestas' => $url_encuestas

            ];

            // Cargar las vistas
            echo view('template/header');
            echo view('template/nav_bar');
            echo view('encuesta_satifaccion/vista_detalle_encuesta', $data);
            echo view('template/footer');
            echo view('encuesta_satifaccion/footer_encuesta', $data);
        } else {
            return redirect()->to('/');
        }
    }

    public function vista_Grafica_Encuestas($fecha_inicio = null, $fecha_fin = null)
    {

    
        if ($this->session->get('logged')) {
            $url_encuestas = URL_ENCUESTAS; 
            
          
            // Establecer la fecha actual si las fechas son null o vacías
            if ($fecha_inicio=='null') {
                $fecha_inicio='2025-01-01';
            }
            if ($fecha_fin=='null') {
                $fecha_fin = date('Y-m-d'); // Fecha actual en formato YYYY-MM-DD
            }
    

        
            
            // Construir la URL con los parámetros
            $url = "{$url_encuestas}/api/estadisticas/respuestas?" . http_build_query([
                'fecha_inicio' => $fecha_inicio,
                'fecha_fin' => $fecha_fin
            ]);
    
            // Obtener los datos de la encuesta
            $response = @file_get_contents($url);
    
            if ($response === FALSE) {
                log_message('error', 'Error al obtener datos de la API: ' . $url);
                return redirect()->to('/error'); // Cambia esto según tu lógica
            }
    
            $grafica = json_decode($response, true);
    
          
    
            $data = [
                'graficos' => $grafica,
                'fecha_inicio' => $fecha_inicio,
                'fecha_fin' => $fecha_fin,

            ];
    
            // Cargar las vistas
            echo view('template/header');
            echo view('template/nav_bar');
            echo view('estadisticas_encuestas/content.php', $data);
            echo view('template/footer');
            echo view('estadisticas_encuestas/footer_encuesta', $data);
        } else {
            return redirect()->to('/');
        }
    }

    
}