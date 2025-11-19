<?php

namespace App\Controllers;

use App\Models\Estatus as Status;
use App\Models\Mapa_Ayuda_Model;
use App\Models\Casos;
use CodeIgniter\API\ResponseTrait;
use App\Models\Auditoria_sistema_Model;


require_once APPPATH . '/ThirdParty/PHPMailer/PHPMailer.php';
require_once APPPATH . '/ThirdParty/PHPMailer/Exception.php';
require_once APPPATH . '/ThirdParty/PHPMailer/SMTP.php';
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use VARIANT;
class Mapa_Ayuda_Controler extends BaseController
{
    use ResponseTrait;




/*
   FUNCION PARA OBTENER LOS TIPOS DE ATENCION DE USUARIOS
*/
 
public function Listar_Casos_Ayuda()
    {
        $model = new Mapa_Ayuda_Model();
        
        // 1. Obtener los datos raw (con filas duplicadas)
        $casos_raw = $model->Listar_Casos_Ayuda(); 
        
        // Array para almacenar los casos consolidados (una fila por id_caso)
        $casos_consolidados = [];

        foreach ($casos_raw as $fila) {
            $id_caso = $fila['id_caso'];
            $id_pc = $fila['id_punto_de_cuenta']; // Clave para el Punto de Cuenta
            $ruta_docu_pc = $fila['pc_ruta_documento']; // Clave para el Documento del PC

            // 2. INICIALIZACIÓN DEL CASO BASE (Solo se ejecuta una vez por id_caso)
            if (!isset($casos_consolidados[$id_caso])) {
                
                // Copiamos la información base del caso (relación 1:1)
                $caso_base = $fila;

                // Inicializamos los arrays para las estructuras 1:N
                $caso_base['rutas_documentos_caso'] = [];
                $caso_base['puntos_cuenta'] = [];

                // Quitamos los campos que se van a agrupar o son 1:N
                unset($caso_base['ruta_documento']);
                unset($caso_base['id_punto_de_cuenta']);
                unset($caso_base['pc_nombre_beneficiario']);
                unset($caso_base['pc_apellido_beneficiario']);
                unset($caso_base['pc_monto_aprobado']);
                unset($caso_base['pc_causa_beneficio']);
                unset($caso_base['pc_ruta_documento']);
                unset($caso_base['pc_descripcion_documento']);

                $casos_consolidados[$id_caso] = $caso_base;
            }

            // 3. Agregación de Documentos del Caso
            $ruta_caso = $fila['ruta_documento'];
            if ($ruta_caso !== null && !in_array($ruta_caso, $casos_consolidados[$id_caso]['rutas_documentos_caso'])) {
                $casos_consolidados[$id_caso]['rutas_documentos_caso'][] = $ruta_caso;
            }

            // 4. Agregación de Puntos de Cuenta y sus Documentos
            if ($id_pc !== null) {
                $pc_key = 'pc_' . $id_pc;
                
                // 4.1. Inicializar el Punto de Cuenta (solo una vez por pc_key)
                if (!isset($casos_consolidados[$id_caso]['puntos_cuenta'][$pc_key])) {
                    $casos_consolidados[$id_caso]['puntos_cuenta'][$pc_key] = [
                        'id_punto_de_cuenta' => $id_pc,
                        'nombre' => $fila['pc_nombre_beneficiario'],
                        'apellido' => $fila['pc_apellido_beneficiario'],
                        'monto_aprobado' => $fila['pc_monto_aprobado'],
                        'causa_beneficio' => $fila['pc_causa_beneficio'],
                        'documentos_pc' => [] // 🆕 Array para documentos del PC
                    ];
                }

                // 4.2. Agregación de Documentos del Punto de Cuenta (Anidado)
                if ($ruta_docu_pc !== null) {
                    $documento_pc = [
                        'ruta' => $fila['pc_ruta_documento'],
                        'descripcion' => $fila['pc_descripcion_documento'],
                    ];
                    
                    // Usamos una clave basada en la ruta para evitar duplicados en el array anidado
                    $ruta_key = md5($ruta_docu_pc); 
                    
                    if (!isset($casos_consolidados[$id_caso]['puntos_cuenta'][$pc_key]['documentos_pc'][$ruta_key])) {
                         $casos_consolidados[$id_caso]['puntos_cuenta'][$pc_key]['documentos_pc'][$ruta_key] = $documento_pc;
                    }
                }
            }
        }
        
        // 5. Devolver el array indexado (sin las claves id_caso) para el JSON final
        $response = array_values($casos_consolidados);

        return $this->response->setJSON($response);
    }

/*
   ///busco si el caso tiene corrdenadas
*/
 public function buscar_caso_cordenada($idcaso=null)
    {
      $model = new Mapa_Ayuda_Model();
        $casos = $model->buscar_caso_cordenada($idcaso);
       

        if (empty($casos)) {
            $response = [];
        } else {
            $response = $casos;
        }

        return $this->response->setJSON($response);
    }



}