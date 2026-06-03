<?php

namespace App\Controllers;
use CodeIgniter\API\ResponseTrait;
use CodeIgniter\RESTful\ResourceController;
use App\Models\Casos;
use App\Models\PropiedadIntelectual;
use App\Models\Oficinas;
use App\Models\Estatus;
use App\Models\RequerimientoUsuario;
use App\Models\Auditoria_sistema_Model;
use App\Models\Ubi_Admini_Model;
use App\Models\Seguimientos;
use App\Models\Casos_remitidos_Model;
use App\Models\Registro_cgr_Model;
use App\Models\Casos_denuncias_Model;
use App\Models\Documentos_casos_Model;
use App\Models\Roles_Model;
use App\Models\Tipo_Atencion_Usu_Model;
use App\Models\Coordenadas_Model;
use App\Models\SapiTerceroModel;
use App\Models\SapiExtensionModel; 
use App\Models\Mediacion;
use App\Models\SapiControversiaModel;

use App\Models\NizaClasses;
use App\Models\Notificaciones_Model;

class Casos_Controler extends BaseController
{


	public function pruebacasos()
	{
		
		$casoModel = new Documentos_casos_Model();
		if ($this->session->get('logged')) {
			
			echo view('template/header');
			echo view('template/nav_bar');
			echo view('casos/pruebacasos');
			echo view('template/footer');
			//echo view('administrador/usuarios/footer.php');
			echo view('/casos/footer_casos.php');
		} else {
			return redirect()->to('/');
		}
	}



	//Metodo que muestra la vista de los casos
	public function casos()
	{
		
	
		$casoModel = new Documentos_casos_Model();
		if ($this->session->get('logged')) {
			$direccionesModel = new Ubi_Admini_Model();
			//Obtenemos las direcciones  para mostrarlos en el modal
			unset($query);
			$query = $direccionesModel->listar_direcciones_administrativas();
			
			$direccionesopt = '';
			if (isset($query)) {
				foreach ($query->getResult() as $row) {
					$direccionesopt .= '<option value="' . $row->id . '">' . htmlentities($row->descripcion) . '</option>';
				}
			} else {
				$direccionesopt .= '<option value="NULL">Sin estatus</option>';
			}
			$data["mensaje"] = '';
			$data["direcciones"] = $direccionesopt;
			echo view('template/header');
			echo view('template/nav_bar');
			echo view('casos/content', $data);
			echo view('template/footer');
			//echo view('administrador/usuarios/footer.php');
			echo view('/casos/footer_casos.php');
		} else {
			return redirect()->to('/');
		}
	}
	//Metodo que muestra la vista de agregar casos
	public function vista_Agregar_caso()
	{
		if ($this->session->get('logged')) {
			echo view('template/header');
			echo view('template/nav_bar');
			echo view('casos/agregar_caso');
			echo view('template/footer');
			echo view('casos/footer_agregar_caso');
		} else {
			return redirect()->to('/');
		}
	}



//Metodo queo obtiene  la informacion de los usuarios para le web 
public function Informacion_Usuarios($casoced=null)
{
	$casoModel = new Casos();
	$query = $casoModel->Informacion_Usuarios($casoced);

	if (empty($query)) {
		$casos = [];
	} else {
		$casos = $query;
	}
	return $this->response->setJSON($casos);
}



/**
     * MÉTODO INTEGRAL: Registro de casos con soporte multi-registro,
     * cantidades dinámicas y lógicas específicas por departamento.
     */
public function nuevoCaso()
{
    // 1. CARGA DE TODOS LOS MODELOS (No falta ninguno)
    $casoModel = new Casos();
    $tipoPIModel = new PropiedadIntelectual();
    $model_Auditoria_sistema_Model = new Auditoria_sistema_Model();
    $segModel = new Seguimientos();
    $Casos_coordenadas = new Coordenadas_Model();
    $Registro_cgr_Model = new Registro_cgr_Model();
    $Casos_denuncias = new Casos_denuncias_Model();
    $terceroModel = new SapiTerceroModel();
    $apoderadoModel = new Mediacion();

    $db = \Config\Database::connect();
    
    // Autenticación por Token o Sesión
    $token = $this->request->getServer('HTTP_AUTHORIZATION');
    $buscar_token = $casoModel->buscar_token($token);
    
    if (($this->session->get('logged') && $this->request->isAJAX()) || !empty($buscar_token)) {
        
        $idusuopr = empty($buscar_token) ? $this->session->get('iduser') : $buscar_token[0]->id_usuario;
        $rawData = $this->request->getPost('data');

        // Decodificación: Soporta Array directo (SAPI) o Base64 (Web)
        $datos = is_array($rawData) ? $rawData : json_decode(base64_decode($rawData), true);

        if (!is_array($datos)) {
            return $this->response->setJSON(['mensaje' => 2, 'error' => 'Error en formato de datos']);
        }
        
        // 2. DETERMINAR LA LISTA DE TRABAJO (Consignación Masiva vs Caso Único)
        $lista_items = [];
        if (isset($datos["tipo-atencion-usu"]) && $datos["tipo-atencion-usu"] == '24' && !empty($datos['lista_consignacion'])) {
            $lista_items = json_decode($datos['lista_consignacion'], true);
        } else {
            $lista_items[] = [
                'id_pi' => $datos["pi-type"] ?? 1, 
                'cantidad' => 1
            ];
        }

        $detalles_generados = []; 
        $ids_generados = [];

        // 3. CICLO DE PROCESAMIENTO (con captura de errores SQL)
        try {
        foreach ($lista_items as $item) {
            $repeticiones = (isset($item['cantidad']) && (int)$item['cantidad'] > 0) ? (int)$item['cantidad'] : 1;

            for ($i = 0; $i < $repeticiones; $i++) {
                
                $newCase = [
                    "idusuopr"          => $idusuopr,
                    "casofec"           => $datos["date-entry"] ?? date('Y-m-d'),
                    "casoced"           => $datos["person-id"] ?? '',
                    "caso_nacionalidad" => $datos["nacionalidad"] ?? 'V',
                    "casonom"           => mb_strtoupper($datos["person-name"] ?? '', 'UTF-8'),
                    "casoape"           => mb_strtoupper($datos["person-lastname"] ?? '', 'UTF-8'),
                    "casotel"           => $datos["telephone"] ?? '',
                    "id_tipo_atencion"  => $datos["tipo-atencion-usu"] ?? 1,
                    "idest"             => ($datos["tipo-atencion-usu"] == '1') ? 2 : 1, // 1=Abierto, 2=Cerrado (Asesoría)
                    "idrrss"            => $datos["social_network"] ?? 1,
                    "estadoid"          => $datos["state"] ?? null,
                    "municipioid"       => $datos["county"] ?? null,
                    "parroquiaid"       => $datos["town"] ?? null,
                    "pais"              => $datos["country"] ?? 1,
                    "sexo"              => $datos["sexo"] ?? 1,
                    "ofiid"             => $datos["office"] ?? null,
                    "casodesc"          => mb_strtoupper($datos["user-requirement"] ?? '', 'UTF-8'),
                    "tipo_beneficiario" => $datos["tipo_beneficiario"] ?? 1,
                    "direccion"         => mb_strtoupper($datos["direccion"] ?? 'NO APLICA', 'UTF-8'),
                    "correo"            => mb_strtoupper($datos["correo"] ?? '', 'UTF-8'),
"caso_org_id"       => (!empty($datos["organismo-caso"]) ? (int)$datos["organismo-caso"] : 1),
                    "ente_adscrito_id"  => $datos["ente_adscrito"] ?? 0,
                    "edad"              => $datos["edad"] ?? null,
                    "fecha_nacimiento"  => $datos["fecha_nacimiento"] ?? null,
                    "tipo_atend_id"     => $datos["tipo_atend_id"] ?? null,
                    "profesion"         => mb_strtoupper($datos["profesion"] ?? '', 'UTF-8'),
                    "casonumsol"        => empty($datos["record-work"]) ? 'No Aplica' : $datos["record-work"]
                ];

                // INSERCIÓN PRINCIPAL (devuelve ID directamente desde la misma conexión)
                $idcaso = $casoModel->insertarNuevoCaso($newCase);
                if ($idcaso) {

                    // --- A. PROPIEDAD INTELECTUAL (Siempre se guarda) ---
                    $id_pi_final = $item['id_pi'] ?? ($datos["pi-type"] ?? 1);
                    $tipoPIModel->insertarTipoPICaso(['idcaso' => $idcaso, 'idtippropint' => $id_pi_final]);

                    // --- B. DENUNCIA (ID 5) ---
                    if ($newCase["id_tipo_atencion"] == '5') {
                        $Casos_denuncias->insertarCasos_Denuncias([
                            'denu_afecta_persona'   => filter_var($datos["denu_afecta_persona"] ?? false, FILTER_VALIDATE_BOOLEAN),
                            'denu_afecta_comunidad' => filter_var($datos["denu_afecta_comunidad"] ?? false, FILTER_VALIDATE_BOOLEAN),
                            'denu_afecta_terceros'  => filter_var($datos["denu_afecta_terceros"] ?? false, FILTER_VALIDATE_BOOLEAN),
                            'denu_fecha_hechos'     => $datos["denu_fecha_hechos"] ?? null,
                            'denu_involucrados'     => mb_strtoupper($datos["denu_involucrados"] ?? '', 'UTF-8'),
                            'denu_instancia_popular'=> mb_strtoupper($datos["denu_instancia_popular"] ?? '', 'UTF-8'),
                            'denu_rif_instancia'    => $datos["denu_rif_instancia"] ?? '',
                            'denu_ente_financiador' => mb_strtoupper($datos["denu_ente_financiador"] ?? '', 'UTF-8'),
                            'denu_nombre_proyecto'  => mb_strtoupper($datos["denu_nombre_proyecto"] ?? '', 'UTF-8'),
                            'denu_monto_aprovado'   => (float)($datos["denu_monto_aprovado"] ?? 0),
                            'denu_id_caso'          => $idcaso,
                            'denu_borrado'          => false
                        ]);
                    }

                    // --- C. MEDIACIÓN (ID 23) ---
                    if ($newCase["id_tipo_atencion"] == '23' && isset($datos['datos_medicion'])) {
                        $med = $datos['datos_medicion'];
                        $getTerceroId = function($p) use ($terceroModel) {
                            if (empty($p['ident_valor'])) return 0;
                            $ex = $terceroModel->where('ter_identificacion', $p['ident_valor'])->first();
                            if ($ex) return $ex['ter_id'];
                            $terceroModel->insert([
                                'ter_nombre' => mb_strtoupper($p['nombre_razon'] ?? '', 'UTF-8'),
                                'ter_tipo_per' => $p['ident_tipo'] ?? 1,
                                'ter_identificacion' => $p['ident_valor'],
                                'ter_correo' => mb_strtoupper($p['correo'] ?? '', 'UTF-8'),
                                'ter_telefono' => $p['telefono'] ?? '',
                                'ter_pais' => $p['pais'] ?? 1,
                                'ter_direccion' => mb_strtoupper($p['direccion'] ?? '', 'UTF-8')
                            ]);
                            return $terceroModel->insertID();
                        };

                        $apoderadoModel->insert([
                            'med_caso_id'       => $idcaso,
                            'med_contra_id'     => $getTerceroId($med['contraparte']),
                            'med_apo_sol_id'    => (isset($med['apoderado_solicitante'])) ? $getTerceroId($med['apoderado_solicitante']) : 0,
                            'med_apo_contra_id' => (isset($med['apoderado_contraparte'])) ? $getTerceroId($med['apoderado_contraparte']) : 0
                        ]);
                    }

                    // --- D. CGR (Contraloría) ---
                    if (filter_var($datos["bandera_cgr"] ?? false, FILTER_VALIDATE_BOOLEAN)) {
                        $Registro_cgr_Model->insertarRegistro_cgr([
                            'competencia_cgr' => $datos["competencia_crg"] ?? 2,
                            'asume_cgr'       => $datos["asume_crg"] ?? 2,
                            'id_caso'         => $idcaso
                        ]);
                    }

                    // --- E. COORDENADAS (Blindado) ---
                    $lat = $datos["latitud"] ?? '';
                    $lon = $datos["longitud"] ?? '';
                    if (!empty($lat) || !empty($lon)) {
                        $Casos_coordenadas->insertarCoordenadas([
                            "idcaso"   => $idcaso,
                            "latitud"  => $lat,
                            "longitud" => $lon,
                            "idusuopr" => $idusuopr
                        ]);
                    }

                    // --- F. SEGUIMIENTO Y AUDITORÍA ---
                    $segModel->insertarSeguimiento([
                        'idcaso' => $idcaso, 'idestllam' => 4, 'segcoment' => 'CREACIÓN DEL CASO', 
                        'idusuopr' => $idusuopr, 'segfec' => date('Y-m-d')
                    ]);

                    // Nombre para el reporte de éxito
                    $infoAten = $db->table('sgc_tipoatencion_usu')->select('tipo_aten_nombre')->where('tipo_aten_id', $newCase["id_tipo_atencion"])->get()->getRow();
                    $detalles_generados[] = [
                        'id' => $idcaso, 
                        'nombre' => $infoAten ? mb_strtoupper($infoAten->tipo_aten_nombre, 'UTF-8') : 'REGISTRO'
                    ];
                    $ids_generados[] = $idcaso;

                    $model_Auditoria_sistema_Model->agregar(['audi_user_id' => $idusuopr, 'audi_accion' => "REGISTRO CASO Nª{$idcaso}"]);
                }
            }
        }

    } catch (\Exception $e) {
            return $this->response->setJSON([
                'mensaje' => 2,
                'error'   => 'Error SQL: ' . $e->getMessage(),
                'trace'   => ENVIRONMENT === 'development' ? $e->getTraceAsString() : null
            ]);
        }

        // Respuesta Final
        return $this->response->setJSON([
            'mensaje' => (!empty($ids_generados)) ? 1 : 2,
            'total_items' => count($ids_generados),
            'detalles' => $detalles_generados,
            'idcaso' => $ids_generados[0] ?? null
        ]);
        
    } else {
        return redirect()->to('/');
    }
}
	//Metodo para ElIMINAR  UN CASO 
	public function eliminar_Caso()
	{
		$casoModel = new Casos();
		$tipoPIModel = new PropiedadIntelectual();
		$model_Auditoria_sistema_Model = new Auditoria_sistema_Model();
		$oficina = new Oficinas();
		$reqModel = new RequerimientoUsuario();
		$segModel = new Seguimientos();
		if ($this->session->get('logged') and $this->request->isAJAX()) {
			//Obtenemos los datos del formulario
			$datos = json_decode(base64_decode($this->request->getPost('data')), TRUE);
			//llenamos los datos iniciales del caso
			$newCase["idcaso"]    = $datos["idcaso"];
			$newCase["borrado"]    = $datos["borrado"];
			//Realizamos la actualizacion en la tabla
			$query_actualizar_caso = $casoModel->actualizarCaso($newCase);
			if (isset($query_actualizar_caso)) {
				$auditoria['audi_user_id']   = session('iduser');
				$auditoria['audi_accion']   = 'ElIMINO EL CASO 	Nª' . $datos["idcaso"];
				$Auditoria_sistema_Model = $model_Auditoria_sistema_Model->agregar($auditoria);
				$mensaje = 1;
				return json_encode($mensaje);
			} else {
				$mensaje = 2;
				return json_encode($mensaje);
			}
		} else {
			return redirect()->to('/');
		}
	}

// Metodo para ACTUALIZAR UN CASO 
public function actualizarCaso()
{
    // ===================================================================
    // 1. INSTANCIACIÓN DE MODELOS
    // ===================================================================
    $casoModel = new Casos();
    $tipoPIModel = new PropiedadIntelectual();
    $model_Auditoria_sistema_Model = new Auditoria_sistema_Model();
    $oficina = new Oficinas();
    $reqModel = new RequerimientoUsuario();
    $segModel = new Seguimientos();
    $Casos_coordenadas = new Coordenadas_Model();
    $Registro_cgr_Model = new Registro_cgr_Model();
    $Casos_denuncias = new Casos_denuncias_Model();

    // Modelos SAPI (Necesarios para el Tipo de Atención 23 - Mediación)
    $terceroModel = new SapiTerceroModel();
    $apoderadoModel = new Mediacion(); // Modelo que maneja sgc_mediacion
    $db = \Config\Database::connect(); // Conexión a DB para transacciones

    // ===================================================================
    // 2. INICIALIZACIÓN DE VARIABLES
    // ===================================================================
    $newCase = array();
    $denuncia = array();
    $coodenadas = array(); 
    $act_coordenadas = array();
    $dirCaso = array(); 
    $tipoPI = array();
    $reqUsuario = array(); 
    $mensaje = 2; // Mensaje de respuesta por defecto: Error

    if ($this->session->get('logged') and $this->request->isAJAX()) {
        
        // Obtener datos del formulario
        $datos = json_decode(base64_decode($this->request->getPost('data')), TRUE);
        
        // Asignación de variables clave
        $idusuopr = $this->session->get('iduser');
        $idcaso = $datos["idcaso"];

        $newCase["id_tipo_atencion"] = $datos["tipo-atencion-usu"];
        $tipoPI["idtippropint"] = $datos["pi-type"];
        $tipoPI["idcaso"] = $idcaso;

        // ===================================================================
        // 3. LÓGICA DE ACTUALIZACIÓN BASE DEL CASO (sgc_casos) Y COORDENADAS
        //    Esto aplica para el Tipo de Atención 23 (Mediación) y para los 
        //    casos que no son Denuncia (5) ni CGR (1).
        // ===================================================================
        
        // Si no es Denuncia (5) ni CGR (1), se actualizan los datos base
        if ($newCase["id_tipo_atencion"] !== '5' && $newCase["id_tipo_atencion"] !== '1')
        {
            $newCase["idcaso"] = $idcaso;
            $newCase["casofec"] = $datos["date-entry"];
            $newCase["casoced"] = $datos["person-id"];
            $newCase["caso_nacionalidad"] = $datos["nacionalidad"];
            $newCase["casonom"] = strtoupper($datos["person-name"]);
            $newCase["casoape"] = strtoupper($datos["person-lastname"]);
            $newCase["casotel"] = $datos["telephone"];
            $newCase["idest"] = 1;
            $newCase["idrrss"] = $datos["social_network"];
            $newCase["estadoid"] = $datos["state"];
            $newCase["municipioid"] = $datos["county"];
            $newCase["pais"] = $datos["country"];
            $newCase["sexo"] = $datos["sexo"];
            $newCase["parroquiaid"] = $datos["town"];
            $newCase["ofiid"] = $datos["office"];
            $newCase["caso_org_id"] = $datos["caso_org_id"];
            $newCase["casodesc"] = $datos["user-requirement"];
            // $newCase["id_tipo_atencion"] ya está asignado
            $newCase["tipo_beneficiario"] = $datos["tipo_beneficiario"];
            $newCase["direccion"] = $datos["direccion"];
            $newCase["correo"] = $datos["correo"];
            $newCase["ente_adscrito_id"] = $datos["ente_adscrito_id"];
            $newCase["edad"] = $datos["edad"];
            $newCase["fecha_nacimiento"] = $datos["fecha_nacimiento"];
            $newCase["tipo_atend_id"] = $datos["tipo_atend_id"];
            $newCase["profesion"] = $datos["profesion"];

            if (empty($datos["record-work"])) {
                $newCase["casonumsol"] = 'No Aplica';
            } else {
                $newCase["casonumsol"] = $datos["record-work"];
            }

            // LÓGICA DE COORDENADAS
            $act_coordenadas["act_coordenadas"] = $datos["act_coordenadas"];
            if ($act_coordenadas["act_coordenadas"] == 't') 
            {
                $coordenadas["idcaso"] = $idcaso;
                $coordenadas["nombre"] = $datos["nombre"];
$coordenadas["latitud"] = isset($datos["latitud"]) ? $datos["latitud"] : '';
$coordenadas["longitud"] = isset($datos["longitud"]) ? $datos["longitud"] : '';
                $coordenadas["borrado"] = false;
                $coordenadas['idusuopr'] = $idusuopr;
                
                $caso_existente = $Casos_coordenadas->buscar_caso_coordenadas($coordenadas);
                
                if ($caso_existente) 
                {
                    $Casos_coordenadas->Actualizar_coordenadas($coordenadas);
                } else {
                    $Casos_coordenadas->insertarCoordenadas($coordenadas);
                }
            } else {
                // Borrado lógico de coordenadas
                $coordenadas["idcaso"] = $idcaso;
                $coordenadas["borrado"] = true;
                $Casos_coordenadas->borrar_coordenadas($coordenadas);
            }

            // ACTUALIZACIÓN EN LA TABLA PRINCIPAL
            $casoModel->actualizarCaso($newCase);

            // REGISTRO DE AUDITORÍA BASE
            $auditoria['audi_user_id'] = $idusuopr;
            $auditoria['audi_accion'] = 'LOS SIGUIENTES CAMPOS DE EL CASO Nª' . $idcaso . ' FUERON MODIFICADOS: ' . ($datos["campos_modificados"] ?? 'Datos Base');
            $model_Auditoria_sistema_Model->agregar($auditoria);
            
            // ===================================================================
            // 4. LÓGICA DE MEDIACIÓN SAPI (TIPO ATENCIÓN 23)
            // ===================================================================
            if ($newCase["id_tipo_atencion"] == '23')
            {
                $medicionData = $datos['datos_medicion'];

                // Función auxiliar para buscar e insertar si no existe (Terceros)
                $checkAndInsertTercero = function($data) use ($terceroModel) {
                    $terceroExistente = $terceroModel
                                            ->where('ter_identificacion', $data['ter_identificacion'])
                                            ->first();

                    if ($terceroExistente) {
                        return $terceroExistente['ter_id'];
                    } else {
                        $terceroModel->insert($data);
                        return $terceroModel->insertID();
                    }
                };

                $db->transStart(); 
                
                try {
                    $contraparteId = null; 
                    $apoderadoSolId = null;
                    $apoderadoCptId = null;

                    // A. REGISTRO DE TERCEROS (sgc_sapi_terceros)
                    
                    // A.1. CONTRAPARTE (Obligatorio)
                    $contraparteData = $medicionData['contraparte'];
                    if (!empty($contraparteData['nombre_razon']) && !empty($contraparteData['correo'])) {
                        $dataToInsert = [
                            'ter_nombre' => $contraparteData['nombre_razon'],
                            'ter_tipo_per' => $contraparteData['ident_tipo'],
                            'ter_identificacion' =>  $contraparteData['ident_valor'],
                            'ter_correo' => $contraparteData['correo'],
                            'ter_telefono' => $contraparteData['telefono'] ?? null,
                            'ter_pais' => $contraparteData['pais'],
                            'ter_estado' => $contraparteData['estado'],
                            'ter_municipio' => $contraparteData['municipio'],
                            'ter_parroquia' => $contraparteData['parroquia'],
                            'ter_direccion' => $contraparteData['direccion'],
                        ];
                        $contraparteId = $checkAndInsertTercero($dataToInsert);
                    } else {
                        throw new \Exception("Datos de Contraparte incompletos para Mediación.");
                    }

                    // A.2. Apoderado Solicitante (Opcional)
                    $apoSolData = $medicionData['apoderado_solicitante'];
                    if (!empty($apoSolData['nombres'])) { 
                        $dataToInsert = [
                            'ter_tipo_per' => $apoSolData['ident_tipo'],
                            'ter_nombre' => $apoSolData['nombres'],
                            'ter_identificacion' => $apoSolData['ci'],
                            'ter_correo' => $apoSolData['correo'],
                            'ter_telefono' => $apoSolData['telefono'] ?? null,
                            'ter_pais' => $apoSolData['pais'],
                            'ter_estado' => $apoSolData['estado'],
                            'ter_municipio' => $apoSolData['municipio'],
                            'ter_parroquia' => $apoSolData['parroquia'],
                            'ter_direccion' => $apoSolData['direccion'],
                            'ter_impre_abogado' => $apoSolData['impre'] ?? null,
                        ];
                        $apoderadoSolId = $checkAndInsertTercero($dataToInsert);
                    }

                    // A.3. Apoderado Contraparte (Opcional)
                    $apoCptData = $medicionData['apoderado_contraparte'];
                    if (!empty($apoCptData['nombres'])) { 
                        $dataToInsert = [
                            'ter_tipo_per' => $apoCptData['ident_tipo'],
                            'ter_nombre' => $apoCptData['nombres'],
                            'ter_identificacion' => $apoCptData['ci'],
                            'ter_correo' => $apoCptData['correo'],
                            'ter_telefono' => $apoCptData['telefono'] ?? null,
                            'ter_pais' => $apoCptData['pais'],
                            'ter_estado' => $apoCptData['estado'],
                            'ter_municipio' => $apoCptData['municipio'],
                            'ter_parroquia' => $apoCptData['parroquia'],
                            'ter_direccion' => $apoCptData['direccion'],
                            'ter_impre_abogado' => $apoCptData['impre'] ?? null,
                        ];
                        $apoderadoCptId = $checkAndInsertTercero($dataToInsert);
                    }

                    // B. REGISTRO EN sgc_mediacion (Actualizar/Insertar)
                    if ($contraparteId) { 
                        $mediacionExistente = $apoderadoModel->where('med_caso_id', $idcaso)->first();

                        $dataMediacion = [
                            'med_apo_sol_id' => $apoderadoSolId, 
                            'med_contra_id' => $contraparteId, 
                            'med_apo_contra_id' => $apoderadoCptId, 
                        ];
                        
                        if ($mediacionExistente) {
                            $apoderadoModel->update($mediacionExistente['med_id'], $dataMediacion); 
                        } else {
                            $dataMediacion['med_caso_id'] = $idcaso;
                            $apoderadoModel->insert($dataMediacion);
                        }
                    }
                    
                    $db->transComplete(); // COMMIT
                    
                    // Auditoría específica de Mediación
                    $auditoria['audi_user_id'] = $idusuopr;
                    $auditoria['audi_accion'] = 'ACTUALIZACIÓN DE DATOS SAPI/MEDIACIÓN PARA EL CASO Nª' . $idcaso;
                    $model_Auditoria_sistema_Model->agregar($auditoria);
                    
                } catch (\Exception $e) {
                    $db->transRollback(); // ROLLBACK
                    $mensaje = 3; // Código de error para Mediación/Transacción
                    return json_encode($mensaje);
                }
            }

            // LUEGO DE LA LÓGICA DE MEDIACIÓN (Si aplica), CONTINÚA EL FLUJO NORMAL

        } else if ($newCase["id_tipo_atencion"] == '5') {
            // ===================================================================
            // 5. LÓGICA DE DENUNCIA (Tipo de Atención 5)
            // ===================================================================
            $denuncia["denu_afecta_persona"]    = $datos["denu_afecta_persona"];
            $denuncia["denu_afecta_comunidad"]    = $datos["denu_afecta_comunidad"];
            $denuncia["denu_afecta_terceros"]    = $datos["denu_afecta_terceros"];
            $denuncia["denu_fecha_hechos"]    = $datos["denu_fecha_hechos"];
            $denuncia["denu_involucrados"]    = $datos["denu_involucrados"];
            $denuncia['denu_instancia_popular']      = $datos["denu_instancia_popular"];
            $denuncia["denu_rif_instancia"]    = $datos["denu_rif_instancia"];
            $denuncia['denu_ente_financiador']      = $datos["denu_ente_financiador"];
            $denuncia["denu_nombre_proyecto"]    = $datos["denu_nombre_proyecto"];
            $denuncia["denu_monto_aprovado"]    = $datos["denu_monto_aprovado"];
            $denuncia['denu_id_caso']      = $idcaso;
            $denuncia["denu_borrado"]    = false;
            
            $query_buscarid_denuncia = $Casos_denuncias->verificar_id_caso_denuncia($idcaso);
            
            // Actualizar datos base del caso
            $newCase["idcaso"] = $datos["idcaso"];
            $newCase["casofec"] = $datos["date-entry"];
            $newCase["casoced"] = $datos["person-id"];
            $newCase["caso_nacionalidad"] = $datos["nacionalidad"];
            $newCase["casonom"] = strtoupper($datos["person-name"]);
            $newCase["casoape"] = strtoupper($datos["person-lastname"]);
            $newCase["casotel"] = $datos["telephone"];
            $newCase["idest"] = 1;
            $newCase["caso_org_id"] = $datos["caso_org_id"];
            $newCase["idrrss"] = $datos["social_network"];
            $newCase["estadoid"] = $datos["state"];
            $newCase["municipioid"] = $datos["county"];
            $newCase["sexo"] = $datos["sexo"];
            $newCase["tipo_atend_id"] = $datos["tipo_atend_id"];
            $newCase["parroquiaid"] = $datos["town"];
            $newCase["ofiid"] = $datos["office"];
            $newCase["casodesc"] = $datos["user-requirement"];
            $newCase["id_tipo_atencion"] = $datos["tipo-atencion-usu"];
            $newCase["tipo_beneficiario"] = $datos["tipo_beneficiario"];
            $newCase["direccion"] = $datos["direccion"];
            $newCase["correo"] = $datos["correo"];
            $newCase["ente_adscrito_id"] = $datos["ente_adscrito_id"];
            $newCase["edad"] = $datos["edad"];
            $newCase["fecha_nacimiento"] = $datos["fecha_nacimiento"];
            $newCase["profesion"] = $datos["profesion"];
            $newCase["casonumsol"] = empty($datos["record-work"]) ? 'No Aplica' : $datos["record-work"];

            $casoModel->actualizarCaso($newCase);

            if (empty($query_buscarid_denuncia)) {
                $Casos_denuncias->insertarCasos_Denuncias($denuncia);
                $auditoria['audi_user_id'] = $idusuopr;
                $auditoria['audi_accion'] = 'REGISTRO EN LA TABLA DE DENUNCIAS EL CASO Nª' . $idcaso;
                $model_Auditoria_sistema_Model->agregar($auditoria);
            } else {
                $Casos_denuncias->AtualizarCasos_Denuncias($denuncia);
                $auditoria['audi_user_id'] = $idusuopr;
                $auditoria['audi_accion'] = 'LOS SIGUIENTES CAMPOS DE EL CASO Nª' . $idcaso . ' FUERON MODIFICADOS: ' . ($datos["campos_modificados"] ?? 'Datos Denuncia');
                $model_Auditoria_sistema_Model->agregar($auditoria);
            }
            
            // BORRADO LÓGICO DE CGR
            $query_buscarid_CGR = $Registro_cgr_Model->verificar_id_caso_CGR($idcaso);
            if (!empty($query_buscarid_CGR)) {
                $cgr["borrado_cgr"] = true;
                $cgr['id_caso'] = $idcaso;
                $Registro_cgr_Model->AtualizarCasos_cgr($cgr);
            }

        } else if ($newCase["id_tipo_atencion"] == '1') {
            // ===================================================================
            // 6. LÓGICA DE ASESORÍA CGR (Tipo de Atención 1)
            // ===================================================================
            
            // Actualizar datos base del caso
            $newCase["idcaso"] = $datos["idcaso"];
            $newCase["casofec"] = $datos["date-entry"];
            $newCase["casoced"] = $datos["person-id"];
            $newCase["caso_nacionalidad"] = $datos["nacionalidad"];
            $newCase["casonom"] = strtoupper($datos["person-name"]);
            $newCase["casoape"] = strtoupper($datos["person-lastname"]);
            $newCase["casotel"] = $datos["telephone"];
            $newCase["idest"] = 1;
            $newCase["caso_org_id"] = $datos["caso_org_id"];
            $newCase["idrrss"] = $datos["social_network"];
            $newCase["estadoid"] = $datos["state"];
            $newCase["municipioid"] = $datos["county"];
            $newCase["sexo"] = $datos["sexo"];
            $newCase["tipo_atend_id"] = $datos["tipo_atend_id"];
            $newCase["parroquiaid"] = $datos["town"];
            $newCase["ofiid"] = $datos["office"];
            $newCase["casodesc"] = $datos["user-requirement"];
            $newCase["id_tipo_atencion"] = $datos["tipo-atencion-usu"];
            $newCase["tipo_beneficiario"] = $datos["tipo_beneficiario"];
            $newCase["direccion"] = $datos["direccion"];
            $newCase["correo"] = $datos["correo"];
            $newCase["ente_adscrito_id"] = $datos["ente_adscrito_id"];
            $newCase["edad"] = $datos["edad"];
            $newCase["fecha_nacimiento"] = $datos["fecha_nacimiento"];
            $newCase["profesion"] = $datos["profesion"];
            $newCase["casonumsol"] = empty($datos["record-work"]) ? 'No Aplica' : $datos["record-work"];

            $casoModel->actualizarCaso($newCase);
            
            // BUSCAMOS EL ID EN LA TABLA DE CGR , SI NO EXISTE PROCEDEMOS CON EL INSERT
            $query_buscarid_CGR = $Registro_cgr_Model->verificar_id_caso_CGR($idcaso);
            if (empty($query_buscarid_CGR)) {
                $cgr["competencia_cgr"] = $datos["competencia_cgr"];
                $cgr["asume_cgr"] = $datos["asume_cgr"];
                $cgr['id_caso'] = $idcaso;
                $Registro_cgr_Model->insertarRegistro_cgr($cgr);
                $auditoria['audi_user_id'] = $idusuopr;
                $auditoria['audi_accion'] = 'REGISTRO EN LA TABLA DE CGR EL CASO Nª' . $idcaso;
                $model_Auditoria_sistema_Model->agregar($auditoria);
            } else {
                // SI EXISTE EL REGISTRO HACEMOS UN UPDATE EN FUNCIÓN DEL ID 
                $cgr["competencia_cgr"] = $datos["competencia_cgr"];
                $cgr["asume_cgr"] = $datos["asume_cgr"];
                $cgr["borrado_cgr"] = false;
                $cgr['id_caso'] = $idcaso;
                $Registro_cgr_Model->AtualizarCasos_cgr($cgr);
                $auditoria['audi_user_id'] = $idusuopr;
                $auditoria['audi_accion'] = 'LOS SIGUIENTES CAMPOS DE EL CASO Nª' . $idcaso . ' FUERON MODIFICADOS: ' . ($datos["campos_modificados"] ?? 'Datos CGR');
                $model_Auditoria_sistema_Model->agregar($auditoria);
            }
            
            // BORRADO LÓGICO DE DENUNCIAS
            $query_buscarid_denuncia = $Casos_denuncias->verificar_id_caso_denuncia($idcaso);
            if (!empty($query_buscarid_denuncia)) {
                $denuncia["denu_borrado"] = true;
                $denuncia['denu_id_caso'] = $idcaso;
                $Casos_denuncias->AtualizarCasos_Denuncias($denuncia);
            }
        }
        
        // 7. ACTUALIZACIÓN DEL TIPO DE PROPIEDAD INTELECTUAL (sgc_casos_pi)
        $query_tipopimodel = $tipoPIModel->ActualizarTipoPICaso($tipoPI);
        
        // 8. RETORNO DE RESPUESTA FINAL
        if (isset($query_tipopimodel)) {
            $mensaje = 1;
            return json_encode($mensaje);
        } else {
            $mensaje = 2; 
            return json_encode($mensaje);
        }
        
    } else {
        // No autenticado
        return redirect()->to('/');
    }
}

	//Vista de carga de un caso
	public function vercaso($id)
	{
	
		$idrol = (session('userrol'));
		$casoModel = new Casos();
		$segModel = new Seguimientos();
		$estModel = new Estatus();
		$direccionesModel = new Ubi_Admini_Model();
		$atencion_model = new Tipo_Atencion_Usu_Model();
		//Arreglo para los detalles del caso
		$data = array();
		//TimeLine para los seguimientos
		$tlSeguimientos = '';
		//estatus del caso
		$idEstatusCaso = '';
		if ($this->session->get('logged')) {
			//Consultamos los detalles del caso
			$query = $casoModel->detalleCaso($id);
			if (isset($query)) 
			{
				foreach ($query as $row) {
					$data["idcaso"] = $id;
					$data["nombre"] = ucwords(strtolower($row->casonom) . ' ' . strtolower($row->casoape));
					$data["estado"] = ucfirst(strtolower($row->estadonom));
					$data["municipio"] = ucfirst(strtolower($row->municipionom));
					$data["parroquia"] = ucfirst(strtolower($row->parroquianom));
					//$data["casodesc"] = ucfirst(mb_strtolower(mb_convert_encoding($row->casodesc, 'UTF-8', 'auto')));
					$data["casodesc"] = mb_strtoupper(mb_convert_encoding($row->casodesc, 'UTF-8', 'auto'));
					$data["correo"] = ucfirst(strtolower($row->correo));
					$data["fecha_caso"] = $row->casofec;
					$data["usuario_operador"] = $row->user_name;
					$data["unidad_administrativa"] = $row->unidad_administrativa;
					$data["direccion"] = $row->direccion;
					$data["correo_beneficiario"] = $row->correo;
					$data["id_tipo_atencion"] = $row->id_tipo_atencion;	
					$data["env_correo"] = $row->env_correo;	
                    $data["tipo_aten_nombre"] = $row->tipo_aten_nombre;
                    $data["tipo_atend_nombre"] = $row->tipo_atend_nombre;
                    $data["tipo_prop_nombre"] = $row->tipo_prop_nombre;

                    
					//$data["casodesc"] = ucfirst(strtolower($row->casodesc));	
					
					//$idEstatusCaso = $row->idest;
				}
				//Obtenemos los estatus de las llamadas para el select del seguimiento
				unset($query);
				$query = $estModel->estatusLlamadas();
				$estopt = '';
				if (isset($query)) {
					foreach ($query->getResult() as $row) {
						$estopt .= '<option value="' . $row->idestllam . '">' . ucfirst(strtolower($row->estllamnom)) . '</option>';
					}
				} else {
					$estopt .= '<option value="NULL">Sin estatus</option>';
				}
				$data["estatus"] = $estopt;
				//Obtenemos los estatus de los casos para mostrarlos en el modal
				unset($query);
				$estopt = '';
				$query = $estModel->estatusCaso();
				if (isset($query)) {
					foreach ($query->getResult() as $row) {
						if ($row->idest == $idEstatusCaso) {
							$estopt .= '<option selected value="' . $row->idest . '">' . ucfirst(strtolower($row->estnom)) . '</option>';
						} else {
							$estopt .= '<option value="' . $row->idest . '">' . ucfirst(strtolower($row->estnom)) . '</option>';
						}
					}
				} else {
					$estopt .= '<option value="NULL">Sin estatus</option>';
				}

			

				$query_acc_participantes = $atencion_model->acc_participantes($data["id_tipo_atencion"]);
				
				foreach ($query_acc_participantes as $row) 
				{
					$data["acc_participantes"] = $row->acc_participantes;
					
				}
			
				$data["estatus_llamadas"] = $estopt;
				echo view('template/header');
				echo view('template/nav_bar');
				echo view('casos/ver_caso/content.php', $data);
				echo view('template/footer');
				echo view('casos/ver_caso/footer.php');
			} else {
				return redirect()->to('/404');
			}
		} else {
			return redirect()->to('/');
		}
	}


    // En app/Controllers/Casos_Controler.php

// En app/Controllers/Casos_Controler.php

public function DetalleCasoConsolidado($idcaso)
{
    // Carga de modelos necesarios
    $casoModel = new \App\Models\Casos();
    $segModel = new \App\Models\Seguimientos(); // Asumiendo que esta clase tiene obtenerSeguimientosPorCaso
    
    // 1. Verificar sesión
    if (!$this->session->get('logged')) {
        return $this->response->setJSON(['success' => false, 'message' => 'Sesión expirada o no iniciada.'])->setStatusCode(401);
    }
    
    // 2. Consultar los detalles del caso
    $queryCaso = $casoModel->detalleCaso($idcaso);
    
    // 3. Consultar los seguimientos del caso (Este método debe usar la consulta SQL que proporcionaste)
    $seguimientos = $segModel->obtenerSeguimientoDeCaso($idcaso); 
    
    if (empty($queryCaso)) {
        return $this->response->setJSON(['success' => false, 'message' => 'Caso no encontrado.'])->setStatusCode(404);
    }

    // 4. Procesar y preparar los datos del caso para el JSON
    $row = $queryCaso[0]; 
    
    $casoData = [
        "idcaso" => $idcaso,
        "nombre" => ucwords(strtolower($row->casonom) . ' ' . strtolower($row->casoape)),
        "estado" => ucfirst(strtolower($row->estadonom)),
        "municipio" => ucfirst(strtolower($row->municipionom)),
        "parroquia" => ucfirst(strtolower($row->parroquianom)),
        "casodesc" => mb_strtoupper(mb_convert_encoding($row->casodesc, 'UTF-8', 'auto')), 
        "correo" => strtolower($row->correo),
        "fecha_caso" => $row->casofec,
        "usuario_operador" => $row->user_name,
        "unidad_administrativa" => $row->unidad_administrativa,
        "direccion" => $row->direccion,
        "id_tipo_atencion" => $row->id_tipo_atencion,
        "env_correo" => $row->env_correo,
        "rol_usuario" => $this->session->get('userrol')
    ];
    
    // 5. Construir la respuesta final JSON
    $response = [
        'success' => true,
        'caso_data' => $casoData,
        'seguimientos' => $seguimientos // Array listo para pintar la tabla
    ];

    // Devolver JSON
    return $this->response->setJSON($response);
}



	//Metodo para ACTUALIZAR UN CASO 
	public function remitirCaso()
	{

		$documentos_casos = new Documentos_casos_Model();
		// Obtener la fecha actual
		$segfec = date('Y-m-d');
		$casoModel = new Casos();
		$caso_remitido = new Casos_remitidos_Model();
		$seguimientos=new Seguimientos();
		$direcciones=new Ubi_Admini_Model();
		$model_Auditoria_sistema_Model = new Auditoria_sistema_Model();
		//Arreglo para remitir un caso
		$remitirCase = array();
		if ($this->session->get('logged') and $this->request->isAJAX()) {
			//Obtenemos los datos del formulario
			$datos = json_decode(base64_decode($this->request->getPost('data')), TRUE);
			//llenamos los datos iniciales del caso
			$remitirCase["casos_id"]    = $datos["id_caso"];
			$remitirCase["direccion_id"]     = $datos["direccion"];
			$nombre_direccion["nombre_direccion"]     = $datos["nombre_direccion"];
			$remitirCase["idusuop"]    = $this->session->get('iduser');


       
			//verificamos si el caso habia sido remitido anteriormente  
			$buscar_caso_remitido = $caso_remitido->buscar_caso_remitido($datos["id_caso"]);
			//Si no a sido remitido hacemor un insert	
			if (empty($buscar_caso_remitido->getResult())) 
			{
				$repuesta[] = '0';
				$query_remitir_caso = $caso_remitido->remitirCaso($remitirCase);
				//Realizamos la Insercion en la tabla Auditoria 
				if (isset($query_remitir_caso)) 
				{
					$auditoria['audi_user_id']   = session('iduser');
					$auditoria['audi_accion']   = 'REMITIO EL CASO Nª' . $datos["id_caso"] . ' ' . 'A' . ' ' . '(' . ' ' . $nombre_direccion["nombre_direccion"] . ' ' . ')';
					$Auditoria_sistema_Model = $model_Auditoria_sistema_Model->agregar($auditoria);
					//Realizamos la insercion en la tabla de Seguimientos
					$datosSeguimiento['idcaso'] =$datos["id_caso"] ;
					$datosSeguimiento['idestllam'] ='4';
					$datosSeguimiento['segcoment']   = 'REMITIO EL CASO Nª' . $datos["id_caso"] . ' ' . 'A' . ' ' . '(' . ' ' . $nombre_direccion["nombre_direccion"] . ' ' . ')';
					$datosSeguimiento['segfec'] =$segfec ;
					$datosSeguimiento['idusuopr']   = session('iduser');
					$seguimientos_caso = $seguimientos->insertarSeguimiento($datosSeguimiento);
					
					// ===================================================================
					// CREAR NOTIFICACIÓN DE REMISIÓN DE CASO
					// ===================================================================
					$this->crearNotificacionRemision($datos["id_caso"], $datos["direccion"], $nombre_direccion["nombre_direccion"]);
					
					//BUSCAMOS LA DESCRIPCION DEL CASO 
					$buscar_descripcioncaso=$casoModel->buscar_correo($datos["id_caso"]);
					if(empty($buscar_descripcioncaso->getResult()))
					{
						echo('Esta vacio el correo');
						die();
					}
					else
					{
						foreach ($buscar_descripcioncaso->getResult() as $row) 
						{
						$desc_caso=$row->casodesc;	
						}
						//BUSCAMOS EL CORREO DE LA DIRECCION AL CUAL FUE REMITIDO EL CASO
						$buscar_correo=	$direcciones->buscar_correo($datos["direccion"]);
						//BUSCAMOS LOS ARCHIVOS ADJUNTOS AL CASO 
						$buscar_archivos=$documentos_casos->buscar_documentos($datos["id_caso"]);
						if (isset($buscar_correo)) 
						{
							foreach ($buscar_correo->getResult() as $row) 
							{
							$correo=$row->correo;	
							}
							if ($correo==NULL)
							{
								$repuesta['mensaje']      = 3;
								return json_encode($repuesta);
							}
							else 
							{
								//Enviamos un correo a la direccion Remitida 
								$dataEmail = array();

								$dataEmail["idcaso"]=$datos["id_caso"];
								$dataEmail["nombredireccion"]=$nombre_direccion["nombre_direccion"];
								$dataEmail["timestamp_generate"] = strtotime(date('Y-m-d H:i:s'));
								$dataEmail["timestamp_expire"] = strtotime("5 minutes", $dataEmail["timestamp_generate"]);
								$dataEmail["desc_caso"] = $desc_caso;
								//Codificamos el JSON y lo encriptamos
								$urlData = base64_encode(json_encode($dataEmail));
								$dataEmail["urldata"] = $urlData;
								try {
									$archivos = [];
									foreach ($buscar_archivos as $buscar_archivos) {
										$archivos[] = WRITEPATH . $buscar_archivos->docu_ruta;
									}
									$email = new \App\Libraries\EmailService();
									$subject = "CASO Nª".' '.$datos["id_caso"].' '.' HA SIDO REMITIDO A SU DIRECCIÓN';
									$body = view('mail/recover', $dataEmail);
									if (!$email->send($correo, $subject, $body, $archivos)) {
										$repuesta['mensaje'] = 2;
										return json_encode($repuesta);
									}
								} catch (\Exception $e) {
									log_message('error', 'Error SMTP: ' . $e->getMessage());
								}
								$repuesta['mensaje']      = 1;
								$repuesta['idcaso']  = $datos["id_caso"];
								return json_encode($repuesta);		
							}
						}  
					} 	
				}
			//Si  a sido remitido hacemos un update y luego un isnsert	
			}else
			{
						//BUSCAMOS LA DESCRIPCION DEL CASO 
						$buscar_descripcioncaso=$casoModel->buscar_correo($datos["id_caso"]);
						//BUSCAMOS LOS ARCHIVOS ADJUNTOS AL CASO 
						$buscar_archivos=$documentos_casos->buscar_documentos($datos["id_caso"]);
						if(empty($buscar_descripcioncaso->getResult()))
						{
							echo('Esta vacio el correo');
							die();

						}
						else
						{
							foreach ($buscar_descripcioncaso->getResult() as $row) 
							{
							$desc_caso=$row->casodesc;	
							}
							$actualizar_datos['casos_id']=$datos["id_caso"];
							$actualizar_datos['vigencia']=false;
							$actualizar_caso_remitido = $caso_remitido->actualizar_caso_remitido($actualizar_datos);
							if (isset($actualizar_caso_remitido))
							{
								$repuesta[] = '0';
								$query_remitir_caso = $caso_remitido->remitirCaso($remitirCase);
								//Realizamos la Insercion en la tabla Auditoria 
								if (isset($query_remitir_caso)) 
								{
									$auditoria['audi_user_id']   = session('iduser');
									$auditoria['audi_accion']   = 'REMITIO EL CASO 	Nª' . $datos["id_caso"] . ' ' . 'A' . ' ' . '(' . ' ' . $nombre_direccion["nombre_direccion"] . ' ' . ')';
									$Auditoria_sistema_Model = $model_Auditoria_sistema_Model->agregar($auditoria);
									//Realizamos la insercion en la tabla de Seguimientos
									$datosSeguimiento['idcaso'] =$datos["id_caso"] ;
									$datosSeguimiento['idestllam'] ='4';
									$datosSeguimiento['segcoment']   = 'REMITIO EL CASO 	Nª' . $datos["id_caso"] . ' ' . 'A' . ' ' . '(' . ' ' . $nombre_direccion["nombre_direccion"] . ' ' . ')';
									$datosSeguimiento['segfec'] =$segfec ;
									$datosSeguimiento['idusuopr']   = session('iduser');
									$seguimientos_caso = $seguimientos->insertarSeguimiento($datosSeguimiento);
									
									// ===================================================================
									// CREAR NOTIFICACIÓN DE REMISIÓN DE CASO (RE-REMISIÓN)
									// ===================================================================
									$this->crearNotificacionRemision($datos["id_caso"], $datos["direccion"], $nombre_direccion["nombre_direccion"]);
									
									//BUSCAMOS EL CORREO DE LA DIRECCION AL CUAL FUE REMITIDO EL CASO
									$buscar_correo=	$direcciones->buscar_correo($datos["direccion"]);
									if (isset($buscar_correo)) 
									{
										foreach ($buscar_correo->getResult() as $row) 
										{
										$correo=$row->correo;	
										}
										if ($correo==NULL)
										{
											$repuesta['mensaje']      = 3;
											return json_encode($repuesta);
										}
										else 
										{
											//Enviamos un correo a la direccion Remitida 
											$dataEmail = array();
											$dataEmail["idcaso"]=$datos["id_caso"];
											$dataEmail["nombredireccion"]=$nombre_direccion["nombre_direccion"];
											$targetDir = WRITEPATH; // Directorio donde se guardarán los archivos subidos
											$dataEmail["desc_caso"] = $desc_caso;
											$dataEmail["timestamp_generate"] = strtotime(date('Y-m-d H:i:s'));
											$dataEmail["timestamp_expire"] = strtotime("5 minutes", $dataEmail["timestamp_generate"]);
											//Codificamos el JSON y lo encriptamos
											$urlData = base64_encode(json_encode($dataEmail));
											$dataEmail["urldata"] = $urlData;
											try {
												$archivos = [];
												foreach ($buscar_archivos as $buscar_archivos) {
													$archivos[] = WRITEPATH . $buscar_archivos->docu_ruta;
												}
												$email = new \App\Libraries\EmailService();
												$subject = "CASO Nª".' '.$datos["id_caso"].' '.' HA SIDO REMITIDO A SU DIRECCIÓN';
												$body = view('mail/recover', $dataEmail);
												if (!$email->send($correo, $subject, $body, $archivos)) {
													$repuesta['mensaje'] = 2;
													return json_encode($repuesta);
												}
											} catch (\Exception $e) {
												log_message('error', 'Error SMTP: ' . $e->getMessage());
											}
											$repuesta['mensaje']      = 1;
											$repuesta['idcaso']  = $datos["id_caso"];
											return json_encode($repuesta);		
										}
									}   	
								}
							}
				}
			}
			
		} else {
			return redirect()->to('/');
		}
	}

	//Metodo queo obtiene  los todos los casos disponibles
	// public function listar_Casos_Usuarios()

	// {
	// 	$idrol = (session('userrol'));
	// 	$idusur = (session('iduser'));
	// 	$model = new Casos();
	// 	if($idrol==1 or  $idrol ==3 or  $idrol ==5)
	// 	{ 
		
	// 		$query = $model->obtenerCasos();
			
			
	// 	if (empty($query)) {
	// 			$casos = [];
	// 		} else {
	// 			$casos = $query;
	// 		}
	// 		echo json_encode($casos);
	// 	}
	// 	else
	// 	{
	// 		$query = $model->obtenerCasos_filtrados_por_usuario($idusur);
			
	// 		if (empty($query)) {
	// 			$casos = [];
	// 		} else {
	// 			$casos = $query;
	// 		}
	// 		echo json_encode($casos);
	// 	}
		
	// }

	
public function listar_Casos_Usuarios()
{
    // Obtener los parámetros enviados por DataTables
    $draw   = $this->request->getVar('draw');
    $start  = $this->request->getVar('start');
    $length = $this->request->getVar('length');
    $search = $this->request->getVar('search')['value'];
    $order  = $this->request->getVar('order');

    $model = new Casos();
    $idrol = (session('userrol'));
    $idusur = (session('iduser'));
    
    // Mapeo completo de todas las columnas que DataTables puede solicitar (índice => nombre de columna SQL)
    // NOTA: user_name es un ALIAS, no existe físicamente. Se ordena por la expresión completa.
    $columns = [
        0 => 'a.idcaso',                    // idcaso
        1 => 'a.casoced',                   // cedula
        2 => 'CONCAT(a.casonom, \' \', a.casoape)',  // nombre
        3 => 'a.casotel',                   // casotel
        4 => 'tpinte.tipo_prop_nombre',      // tipo_prop_nombre
        5 => 't_antusu.tipo_aten_nombre',   // tipo_aten_nombre
        6 => 'a.casofec',                   // casofec
        7 => 'b.estnom',                    // estnom
        8 => 'CONCAT(u_ope.usuopnom, \' \', u_ope.usuopape)',  // user_name (alias del operador)
        9 => 'a.idcaso'                      // columna de acciones (no ordenable realmente)
    ];
    
    // Validar que el índice de columna solicitado exista
    $orderColumnIndex = isset($order[0]['column']) ? $order[0]['column'] : 0;
    
    // Si el índice no existe en el mapeo, usar por defecto la columna 0 (idcaso)
    if (!isset($columns[$orderColumnIndex])) {
        $orderColumnIndex = 0;
    }
    
    $order_column = $columns[$orderColumnIndex];
    $order_direction = isset($order[0]['dir']) ? $order[0]['dir'] : 'desc';

    // Lógica para obtener los datos según el rol del usuario
    if ($idrol == 1 || $idrol == 3 || $idrol == 5) { 
        $data = $model->obtenerCasosServerSide($start, $length, $search, $order_column, $order_direction);
    } else {
        $data = $model->obtenerCasos_filtrados_por_usuario_serverSide($idusur, $start, $length, $search, $order_column, $order_direction);
    }
    
    // Preparar el array para la respuesta de DataTables
    $output = [
        "draw" => $draw,
        "recordsTotal" => $data['recordsTotal'],
        "recordsFiltered" => $data['recordsFiltered'],
        "data" => $data['data']
    ];

    return $this->response->setJSON($output);
}











	//Metodo queo obtiene  los Ultimos_Casos  disponibles
	public function listar_Ultimos_Casos()
	{
		$iduser = (session('iduser'));
		$model = new Casos();
		$query = $model->obtener_ultimos_casos($iduser);
		if (empty($query)) {
			$ultimos_casos = [];
		} else {
			$ultimos_casos = $query;
		}
		return $this->response->setJSON($ultimos_casos);
	}

// Método para subir archivos
public function upload()
{
    $model = new Casos();
    $id_caso_pdf = $this->request->getPost('id_caso_pdf') ?? '';
    $archivo = $this->request->getFile('archivo');

    // LISTA BLANCA
	$config['allowed_types'] = 'jpg|jpeg|png|pdf|doc|docx|ods|xls|xlsx|mp4|mp3|m4a|m4v|mov|wmv|avi|mkv|swf|odt';
    $tamañoMaximo = 10 * 1024 * 1024; // 10MB en bytes

    // Verificar si se ha subido un archivo
    if ($archivo && $archivo->isValid() && $archivo->getName() != '') 
    {
        // Limpiar el nombre del archivo
        $nombreArchivo = preg_replace('/[^a-zA-Z0-9_\-\.]/', '_', strtolower($id_caso_pdf . '_' . trim($archivo->getName())));
        $archivoTemporal = trim($archivo->getTempName());
        $rutaDestino = WRITEPATH . trim($nombreArchivo);
        $targetDir = WRITEPATH; // Directorio donde se guardarán los archivos subidos
        $targetFile = $targetDir . basename($nombreArchivo);

        // Comprobar si hay extensiones dobles
        $partesArchivo = explode('.', $nombreArchivo);
        if (count($partesArchivo) > 2) {
            return json_encode(8); // Nombre de archivo inválido. Las extensiones dobles no están permitidas.
        }

        // Obtener la extensión del archivo
        $fileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));

        // Verificar si el archivo tiene una extensión permitida
        if (!in_array($fileType, explode('|', $config['allowed_types']))) {
            return json_encode(5); // Tipo de archivo no permitido
        }

        // Verificar el tamaño del archivo
        if ($archivo->getSize() > $tamañoMaximo) {
            return json_encode(1); // Archivo demasiado grande
        }

        // Verificar el tipo MIME del archivo
        $finfo = finfo_open(FILEINFO_MIME_TYPE);
        $mimeType = finfo_file($finfo, $archivoTemporal);
        finfo_close($finfo);

        // Verificar si el MIME type coincide con la extensión
		$mimeTypes = [
			'jpg' => 'image/jpeg',
			'jpeg' => 'image/jpeg',
			'png' => 'image/png',
			'pdf' => 'application/pdf',
			'doc' => 'application/msword',
			'docx' => 'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
			'xls' => 'application/vnd.ms-excel',
			'xlsx' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
			'mp4' => 'video/mp4',
			'mp3' => 'audio/mpeg',
			'mov' => 'video/quicktime',
			'wmv' => 'video/x-ms-wmv',
			'avi' => 'video/x-msvideo',
			'mkv' => 'video/x-matroska',
			'swf' => 'application/x-shockwave-flash',
			'odt' => 'application/vnd.oasis.opendocument.text', 
		];

        if (!array_key_exists($fileType, $mimeTypes) || $mimeTypes[$fileType] !== $mimeType) {
            return json_encode(6); // Tipo de archivo no coincide con el contenido
        }

        // Verificar si el archivo ya existe
        if (file_exists($targetFile)) {
            return json_encode(0); // El archivo ya existe
        }

        // Verificar contenido para imágenes
        if ($fileType === 'jpg' || $fileType === 'jpeg' || $fileType === 'png') {
            $img = @imagecreatefromstring(file_get_contents($archivoTemporal));
            if (!$img) {
                return json_encode(9); // El archivo no es una imagen válida
            }
        }

        // Mover el archivo a la ubicación deseada
        if (move_uploaded_file($archivoTemporal, $rutaDestino)) {
            $documentos_casos['docu_id_caso'] = $id_caso_pdf;
            $documentos_casos['docu_ruta'] = $nombreArchivo;

            // Intentar agregar la información del documento a la base de datos
            $query_docu_casos = $model->agregar_docu_casos($documentos_casos);
            
                      // Verificar si la consulta fue exitosa
					  if ($query_docu_casos) {
						return json_encode(2); // Archivo subido y registrado en la base de datos
					} else {
						return json_encode(7); // Error al agregar a la base de datos
					}
				} else {
					return json_encode(3); // Error al subir el archivo
				}
			} else {
				return json_encode(4); // No se subió ningún archivo
			}
		}



public function buscar_datos_usuarios()
{
	$casoModel = new Casos();
	if ($this->session->get('logged') and $this->request->isAJAX()) {
		//Obtenemos los datos del formulario
		$data = json_decode(base64_decode($this->request->getPost('data')));
		$datos['usuario']   = $data->cedula_existente;
		$query_buscar_usuario = $casoModel->buscar_usuario($datos);
		if (empty($query_buscar_usuario->getResult())) {
			$data = 0;
			return json_encode($data);
		} else {
			$usuarios = $query_buscar_usuario->getResultArray();
		}
		return $this->response->setJSON($usuarios);
		
	} else {
		return redirect()->to('/');
	}
}


// 


	/**
	 * Crear notificación cuando se remite un caso a una dirección
	 * Notifica a todos los usuarios de la dirección destino, al autor original Y a supervisión global
	 * 
	 * Reglas implementadas:
	 * 1. Notificar a usuarios de la dirección DESTINO
	 * 2. Notificar al AUTOR ORIGINAL del caso (si tiene Rol 2)
	 * 3. Notificar a Roles 1, 3, 5 (SUPERVISIÓN GLOBAL) - SIEMPRE
	 * 4. Evitar auto-notificaciones
	 */
	private function crearNotificacionRemision($id_caso, $direccion_id, $nombre_direccion)
	{
		$notifModel = new Notificaciones_Model();
		$casoModel = new Casos();
		
		// Obtener información del caso
		$caso = $casoModel->obtenerCaso_id($id_caso);
		if (!$caso) {
			log_message('warning', "No se pudo obtener información del caso {$id_caso} para crear notificación de remisión");
			return;
		}
		
		// Datos del usuario actual (quien remite el caso)
		$idusuopr_actual = $this->session->get('iduser');
		$id_rol_actual = $this->session->get('userrol');
		$direccion_origen_id = $this->session->get('id_direccion_administrativa');
		$nombre_direccion_origen = $notifModel->obtenerNombreDireccion($direccion_origen_id);
		
		// Autor original del caso
		$id_caso_autor = $caso->idusuopr ?? 0;
		
		// Verificar si el autor es diferente de quien remite
		$autor_es_diferente = ($id_caso_autor != $idusuopr_actual);
		
		// Nombre del beneficiario
		$nombre_beneficiario = $caso->nombre ?? 'Caso #' . $id_caso;
		
		// Mensaje para destinatarios (dirección destino)
		$mensaje_destinatarios = "Se le ha remitido el caso #" . $id_caso . " - Beneficiario: " . $nombre_beneficiario . " a su dirección (" . $nombre_direccion . "). Remitido por: " . $nombre_direccion_origen;
		
		log_message('debug', "=== CREAR NOTIFICACIÓN REMISIÓN ===");
		log_message('debug', "Caso ID: {$id_caso}");
		log_message('debug', "Autor original: {$id_caso_autor}");
		log_message('debug', "Usuario actual: {$idusuopr_actual}");
		log_message('debug', "Autor diferente: " . ($autor_es_diferente ? 'SÍ' : 'NO'));
		
		$notificaciones_creadas = 0;
		
		// 1. NOTIFICAR A USUARIOS DE LA DIRECCIÓN DESTINO
		$usuarios_direccion = $notifModel->obtenerUsuariosPorDireccion($direccion_id);
		
		foreach ($usuarios_direccion as $usuario) {
			// Evitar auto-notificación
			if ($usuario->idusuopr == $idusuopr_actual) {
				log_message('debug', "Skipping self-notification for user: {$idusuopr_actual}");
				continue;
			}
			
			$insertado = $notifModel->insertarNotificacion([
				"id_caso" => $id_caso,
				"tipo_notificacion" => "REMISION",
				"mensaje" => $mensaje_destinatarios,
				"leida" => false,
				"fecha_creacion" => date('Y-m-d H:i:s'),
				"id_usuario_destino" => $usuario->idusuopr,
				"direccion_origen" => $direccion_origen_id,
				"id_usuario_accion" => $idusuopr_actual,
				"id_rol_accion" => $id_rol_actual,
				"id_caso_autor" => $id_caso_autor
			]);
			
			if ($insertado) {
				$notificaciones_creadas++;
			}
		}
		
		log_message('debug', "Notificaciones creadas para dirección destino: {$notificaciones_creadas}");
		
		// 2. NOTIFICAR AL AUTOR ORIGINAL DEL CASO (ROL 2)
		// Solo si el autor es diferente de quien remite Y el autor tiene Rol 2
		if ($autor_es_diferente && $id_caso_autor > 0) {
			$autor = $notifModel->obtenerUsuarioPorId($id_caso_autor);
			
			if ($autor && isset($autor->idrol) && $autor->idrol == 2 && !(isset($autor->usuopborrado) && $autor->usuopborrado === true)) {
				// El autor tiene Rol 2, necesita recibir notificación
				$mensaje_autor = "Su caso #" . $id_caso . " - Beneficiario: " . $nombre_beneficiario . " ha sido remitido a la dirección: " . $nombre_direccion . ". Remitido por: " . $nombre_direccion_origen;
				
				// No crear duplicado si ya fue notificado como destinatario
				$ya_notificado = false;
				foreach ($usuarios_direccion as $usuario) {
					if ($usuario->idusuopr == $id_caso_autor) {
						$ya_notificado = true;
						break;
					}
				}
				
				if (!$ya_notificado) {
					$insertado = $notifModel->insertarNotificacion([
						"id_caso" => $id_caso,
						"tipo_notificacion" => "REMISION",
						"mensaje" => $mensaje_autor,
						"leida" => false,
						"fecha_creacion" => date('Y-m-d H:i:s'),
						"id_usuario_destino" => $id_caso_autor,
						"direccion_origen" => $direccion_origen_id,
						"id_usuario_accion" => $idusuopr_actual,
						"id_rol_accion" => $id_rol_actual,
						"id_caso_autor" => $id_caso_autor
					]);
					
					if ($insertado) {
						$notificaciones_creadas++;
						log_message('debug', "Notificación de remisión enviada al autor (Rol 2): {$id_caso_autor}");
					}
				} else {
					log_message('debug', "Autor (Rol 2) ya notificado como destinatario de la dirección");
				}
			} else {
				log_message('debug', "El autor {$id_caso_autor} no tiene Rol 2 o está borrado, no se notifica");
			}
		}
		
		// 3. NOTIFICACIÓN A SUPERVISIÓN GLOBAL (ROLES 1, 3, 5)
		// Los supervisores SIEMPRE reciben notificación de remisión para auditar movimientos
		$usuarios_supervision = $notifModel->obtenerUsuariosPorRoles([1, 3, 5]);
		$mensaje_supervision = "El caso #" . $id_caso . " - Beneficiario: " . $nombre_beneficiario . " fue remitido de " . $nombre_direccion_origen . " a " . $nombre_direccion;
		
		foreach ($usuarios_supervision as $supervisor) {
			// Excluir auto-notificación (si el supervisor es quien remite)
			if ($supervisor->idusuopr == $idusuopr_actual) {
				continue;
			}
			
			$insertado = $notifModel->insertarNotificacion([
				"id_caso" => $id_caso,
				"tipo_notificacion" => "REMISION",
				"mensaje" => $mensaje_supervision,
				"leida" => false,
				"fecha_creacion" => date('Y-m-d H:i:s'),
				"id_usuario_destino" => $supervisor->idusuopr,
				"direccion_origen" => $direccion_origen_id,
				"id_usuario_accion" => $idusuopr_actual,
				"id_rol_accion" => $id_rol_actual,
				"id_caso_autor" => $id_caso_autor
			]);
			
			if ($insertado) {
				$notificaciones_creadas++;
			}
		}
		
		log_message('debug', "Notificaciones creadas para supervisión global: " . count($usuarios_supervision));
		log_message('debug', "Total notificaciones de remisión creadas: {$notificaciones_creadas}");
		log_message('debug', "=== FIN CREAR NOTIFICACIÓN REMISIÓN ===");
	}
}

