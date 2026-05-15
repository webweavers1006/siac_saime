<?php

namespace App\Controllers;

use App\Models\Auditoria_sistema_Model;
use App\Models\Categoria_Model;
use CodeIgniter\API\ResponseTrait;
use App\Models\Participantes_Model;
use CodeIgniter\RESTful\ResourceController;
use App\Models\Talleres_Participantes_Model;

class Participantes_Controler extends BaseController
{
	use ResponseTrait;

	//Metodo para añadir tipo de atencion
public function agregar_participantes()
{
    $model = new Participantes_Model();
    $model_Auditoria_sistema_Model = new Auditoria_sistema_Model();

    if ($this->session->get('logged') && $this->request->isAJAX()) 
    {
        // Obtenemos los datos del formulario
        $datos = json_decode(utf8_encode(base64_decode($this->request->getPost('data'))), TRUE);
        $id_caso = ["id_caso" => $datos["id_caso"]];
        $participantes = $datos["solicitudes"]; 
        $ids_insertados = [];

        // Iteramos sobre cada solicitud de participante
        foreach ($participantes as $solicitud) 
        {
            $cedula = $solicitud["cedula"];
            $org_id = $solicitud["organismo_pp"]; // Capturamos el org_id aquí
            $query_participante = $model->buscar_participante($cedula);
            
            if (empty($query_participante)) 
            {
                // Eliminar el campo 'organismo_pp' del array $solicitud
                unset($solicitud["organismo_pp"]);
                
                // Si no existe el participante general, lo agregamos
                $id_insertado = $model->agregar_participante($solicitud);
                if ($id_insertado) {
                    $ids_insertados[] = [
                        'id' => $id_insertado, // Guardamos el ID del participante insertado
                        'org_id' => $org_id // Guardamos el org_id correspondiente
                    ];  
                }
            } 
            else 
            {
                // Si el participante ya existe, guardamos su ID y el org_id
                $ids_insertados[] = [
                    'id' => $query_participante[0]->id,
                    'org_id' => $org_id
                ]; 
            }
        }
        
        if (!empty($ids_insertados)) 
        {
            $info_talleres = array();

            foreach ($ids_insertados as $data) {
                $info_talleres[] = array(
                    "id_caso" => $id_caso["id_caso"], 
                    "participante_id" => $data['id'],
                    "org_id" => $data['org_id'] 
                );
            }

            // Enviamos el lote completo al modelo.
            // Gracias al ON CONFLICT DO NOTHING del modelo, PostgreSQL insertará los nuevos
            // e ignorará silenciosamente los que ya existan para este caso.
            $query_agregar_participantes_talleres = $model->agregar_participantes_talleres($info_talleres);

            if ($query_agregar_participantes_talleres) {
                return json_encode(['status' => 1, 'message' => 'Registro Exitoso.']);
            } else {
                return json_encode(['status' => 404, 'message' => 'Error al insertar participantes en talleres.']);
            }
        } 
        else 
        {
            return json_encode(['status' => 2, 'message' => 'No se insertaron participantes.']);
        }       
    } 
    else 
    {
        return redirect()->to('/');
    }
}


//Metodo para ACTUALIZAR ATENCIONES
public function actualizar_participantes($id_participante)
{
	$model = new Participantes_Model();
    $taller = new Talleres_Participantes_Model();
	$model_Auditoria_sistema_Model = new Auditoria_sistema_Model();
	if ($this->session->get('logged') and $this->request->isAJAX()) {
		//Obtenemos los datos del formulario
		$datos = json_decode(utf8_encode(base64_decode($this->request->getPost('data'))), TRUE);
		$participante["nombre"]     = $datos["nombre"];
		$participante["apellido"]     = $datos["apellido"];
		$participante["cedula"]     = $datos["cedula"];
		$participante["nacionalidad"]     = $datos["nacionalidad"];
		$participante["tipo_beneficiario"]     = $datos["tipo_beneficiario"];
		$participante["edad"]     = $datos["edad"];
		$participante["pais"]     = $datos["pais"];
		$participante["estado"]     = $datos["estado"];
		$participante["municipio"]     = $datos["municipio"];
		$participante["parroquia"]     = $datos["parroquia"];
		$participante["telefono"]     = $datos["telefono"];
		$participante["sexo"]     = $datos["sexo"];

        $info_talleres["participante_id"]     = $id_participante;
		$info_talleres["id"]     = $datos["id_taller"];
        $info_talleres["org_id"]     = $datos["org_id"];
        
        $query_editar_org_taller = $taller->editar_org_taller($info_talleres);


		$query_editar_participante = $model->editar_participante($participante,$id_participante);
		
		if (isset($query_editar_participante)) {
			$auditoria['audi_user_id']   = session('iduser');
			$auditoria['audi_accion']   = ' Los Datos de  :' . ' ' . '(' . ' ' . $participante["nombre"] .' '.$participante["apellido"]. ')' . ' ' . ' FUE ACTUALIZADO';
			$Auditoria_sistema_Model = $model_Auditoria_sistema_Model->agregar($auditoria);
			return json_encode(['message' => 'Los datos han sido actualizados correctamente.']);
		} else {
			
			return json_encode(['message' => 'Error al actualizar los datos.']);
		}
	} else {
		return redirect()->to('/');
	}
}




	/*
       FUNCION PARA OBTENER LOS PARTICIPANTES EN FUNCION DEL CASO 
    */
	public function listar_participantes($id_caso)
	{
		$model = new Participantes_Model();
		$query = $model->listar_participantes($id_caso);
		
		
		if (empty($query)) {
			$participantes = [];
		} else {
			$participantes = $query;
		}
		echo json_encode($participantes);
	}

	/*
       FUNCION PARA OBTENER LOS PARTICIPANTES EN FUNCION DE LA CEDULA
    */
	public function buscar_participante($cedula)
	{
		
		$model = new Participantes_Model();
		$query = $model->buscar_participante($cedula);
		
		if (empty($query)) {
			$participantes = [];
		} else {
			$participantes = $query;
		}
		echo json_encode($participantes);
	}



}
