<?php

namespace App\Controllers;

use App\Models\Seguimientos;
use App\Models\Auditoria_sistema_Model;
use CodeIgniter\API\ResponseTrait;

class Seguimiento_Controler extends BaseController
{

    use ResponseTrait;


    //Metodo queo obtiene  los todos los seguimientos disponibles
    public function listar_Seguimientos($id_caso)
    {
        $model_seguimientos = new Seguimientos();
        $query = $model_seguimientos->obtenerSeguimientoDeCaso($id_caso);
        if (empty($query)) {
            $seguimientos = [];
        } else {
            $seguimientos = $query;
        }
        echo json_encode($seguimientos);
    }

    
    //Metodo para añadir seguimientos 
    public function addSeguimiento()
    {
        $segModel = new Seguimientos();
        $model_Auditoria_sistema_Model = new Auditoria_sistema_Model();
        if ($this->request->isAJAX() and $this->session->get('logged')) {
              //$datos = json_decode(base64_decode($this->request->getPost('data')));
             
           $datos = json_decode(base64_decode($this->request->getPost('data')), TRUE);
            if (strlen($datos["segcomment"]) < 1) {
                return $this->respond(["message" => "El comentario no debe estar en blanco"], 500);
            } else {
                $query = $segModel->insertarSeguimiento(array(
                    "idcaso" => $datos["caseid"],
                    "idestllam" => $datos["callid"],
                    "segcoment" =>  strtoupper($datos["segcomment"]),
                    "segfec" => date('Y-m-d'),
                    "idusuopr" => $this->session->get('iduser')
                ));
                if (isset($query)) {
                    $auditoria['audi_user_id']   = session('iduser');
                    $auditoria['audi_accion']   = 'INGRESO UN NUEVO SEGUIMIENTO';
                    $Auditoria_sistema_Model = $model_Auditoria_sistema_Model->agregar($auditoria);
                    return $this->respond(["message" => "Seguimiento cargado exitosamente"], 200);
                } else {
                    return $this->respond(["message" => "Hubo un error al cargar el seguimiento"], 500);
                }
            }
        } else {
            return redirect()->to('/');
        }
    }

    //Metodo para  actualizar Seguimientos
    public function  actualizar_Seguimiento()
    {
        $segModel = new Seguimientos();
        $model_Auditoria_sistema_Model = new Auditoria_sistema_Model();
        if ($this->request->isAJAX() and $this->session->get('logged')) {
            $datos = json_decode(base64_decode($this->request->getPost('data')), TRUE);
            if (strlen($datos["segcomment"]) < 1) {
                return $this->respond(["message" => "El comentario no debe estar en blanco"], 500);
            } else {
                $query = $segModel->actualizarSeguimiento(array(
                    "idcaso" => $datos["caseid"],
                    "idestllam" => $datos["callid"],
                    "segcoment" => $datos["segcomment"],
                    "idsegcas" => $datos["idsegcas"],
                    "segfec" => date('Y-m-d'),
                    "idusuopr" => $this->session->get('iduser')

                ));
                if (isset($query)) {
                    $auditoria['audi_user_id']   = session('iduser');
                    $auditoria['audi_accion']   = 'HA ACTUALIZADO EL SEGUIMIENTO Nª' . $datos["idsegcas"];
                    $Auditoria_sistema_Model = $model_Auditoria_sistema_Model->agregar($auditoria);
                    return $this->respond(["message" => "Seguimiento cargado exitosamente"], 200);
                } else {
                    return $this->respond(["message" => "Hubo un error al cargar el seguimiento"], 500);
                }
            }
        } else {
            return redirect()->to('/');
        }
    }

    //Metodo para  eliminar seguimiento
    public function  eliminar_seguimiento()
    {
        $segModel = new Seguimientos();
        $model_Auditoria_sistema_Model = new Auditoria_sistema_Model();
        if ($this->request->isAJAX() and $this->session->get('logged')) {
            $datos = json_decode(utf8_decode(base64_decode($this->request->getPost('data'))), TRUE);
            $query = $segModel->eliminarSeguimiento(array(
                "idsegcas" => $datos["idsegcas"],
                "borrado" => $datos["borrado"],
                "segcoment" => 'HA ELIMINADO EL SEGUIMIENTO Nª' . $datos["idsegcas"],
                "segfec" => date('Y-m-d'),
                "idusuopr" => $this->session->get('iduser')
            ));
            if (isset($query)) {
                $auditoria['audi_user_id']   = session('iduser');
                $auditoria['audi_accion']   = 'Ha eliminado el seguimiento Nª' . $datos["idsegcas"];
                $Auditoria_sistema_Model = $model_Auditoria_sistema_Model->agregar($auditoria);
                return $this->respond(["message" => "Seguimiento cargado exitosamente"], 200);
            } else {
                return $this->respond(["message" => "Hubo un error al cargar el seguimiento"], 500);
            }
        } else {
            return redirect()->to('/');
        }
    }


    public function obtenerTL()
    {
        $segModel = new Seguimientos();
        if ($this->request->isAJAX() and $this->session->get('logged')) {
            $datos = json_decode(utf8_encode(base64_decode($this->request->getPost('data'))), TRUE);
            $query = $segModel->obtenerSeguimientoDeCaso($datos["data"]);
            if (isset($query)) {

                return $this->respond(["message" => "success", "data" => $this->getSeguimientos($query)], 200);
            } else {
                return $this->respond(["message" => "No se encontraron seguimientos"], 404);
            }
        } else {
            return redirect()->to('/');
        }
    }
}
