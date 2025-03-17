<?php

namespace App\Controllers;

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
use App\Models\NizaClasses;
use App\Models\Usuarios;



class Reporte_Controler extends BaseController
{
	public function vista_consolidado()
	{
		if ($this->session->get('logged')) {
			$direccionesModel = new Ubi_Admini_Model();
			//Obtenemos las direcciones  para mostrarlos en el modal
			unset($query);
			$query = $direccionesModel->listar_Ubicacion_Administrativa();
		
			$direccionesopt = '';
			if (isset($query)) {
				foreach ($query->getResult() as $row) {
					$direccionesopt .= '<option value="' . $row->id . '">' . htmlentities($row->descripcion) . '</option>';
				}
			} else {
				$direccionesopt .= '<option value="NULL">Sin estatus</option>';
			}
			$data["direcciones"] = $direccionesopt;
			//Pasamos la tabla como parametro para la vista
			echo view('template/header');
			echo view('template/nav_bar');
			echo view('reportes/general/content', $data);
			echo view('template/footer');
			echo view('reportes/general/footer.php');
		} else {
			return redirect()->to('/');
		}
	}
	//Metodo queo obtiene  los todos los casos disponibles
	public function reporte_consolidado($desde = null, $hasta = null, $tipo_pi = null, $tipo_atencion_usu = null, $sexo = null, $via_atencion = null, $direcciones_caso = null, $tipo_beneficiario = 0, $atencion_cuidadano = 0, $estatus = 0,$id_pais=0,$id_estado=0,$id_municipio=0,$id_parroquia=0,$edad_min=null,$edad_max=null,$detalle_atencion=0)
	{
		
		
		$model = new Casos();
		$query = $model->reporte_consolidado($desde, $hasta, $tipo_pi, $tipo_atencion_usu, $sexo, $via_atencion, $direcciones_caso, $tipo_beneficiario, $atencion_cuidadano, $estatus,$id_pais,$id_estado,$id_municipio,$id_parroquia,$edad_min,$edad_max,$detalle_atencion);
		
		
		if (empty($query)) {
			$casos = [];
		} else {
			$casos = $query;
		}
		echo json_encode($casos);
	}

	public function vista_operador()
	{
		if ($this->session->get('logged')) {


			$usuariosModel = new Usuarios();
			$direccionesModel = new Ubi_Admini_Model();
			//Obtenemos las direcciones  para mostrarlos en el modal
			unset($query);
			$query = $direccionesModel->listar_Ubicacion_Administrativa();

			$direccionesopt = '';
			if (isset($query)) {
				foreach ($query->getResult() as $row) {
					$direccionesopt .= '<option value="' . $row->id . '">' . htmlentities($row->descripcion) . '</option>';
				}
			} else {
				$direccionesopt .= '<option value="NULL">Sin estatus</option>';
			}




			
			$query_usuarios = $usuariosModel->getAllUsers();
			;
			$usuarios = [];
			if (isset($query_usuarios) && $query_usuarios->getResult()) {
				foreach ($query_usuarios->getResult() as $row) {
					$nombreCompleto = strtoupper($row->usuopnom . ' ' . $row->usuopape);
				
		
					$usuarios[] = '<option value="' . htmlspecialchars($row->idusuopr) . '">' . $nombreCompleto . '</option>';
				}
			} else {
				$usuarios[] = '<option value="NULL">Sin estatus</option>';
			}

			$data["usuarios"] = implode('', $usuarios);

			$data["direcciones"] = $direccionesopt;
			
			
			
			//Pasamos la tabla como parametro para la vista
			echo view('template/header');
			echo view('template/nav_bar');
			echo view('reportes/operador/content.php', $data);
			echo view('template/footer');
			echo view('reportes/operador/footer.php');
		} else {
			return redirect()->to('/');
		}
	}
	//Metodo queo obtiene  los todos los casos disponibles POR USUARIO
	public function reporte_operador($desde = null, $hasta = null, $tipo_pi = null, $tipo_atencion_usu = null, $sexo = null, $via_atencion = null, $direcciones_caso = null, $tipo_beneficiario = 0, $usuarios = null,$estatus=0,$id_pais=0,$id_estado=0,$id_municipio=0,$id_parroquia=0,$edad_min=null,$edad_max=null)
	{
		$model = new Casos();
		$idusuopr   = $this->session->get('iduser');
		$query = $model->reporte_operador($desde, $hasta, $tipo_pi, $tipo_atencion_usu, $sexo, $idusuopr, $via_atencion, $direcciones_caso, $tipo_beneficiario, $usuarios,$estatus,$id_pais,$id_estado,$id_municipio,$id_parroquia,$edad_min,$edad_max);
		if (empty($query)) {
			$casos = [];
		} else {
			$casos = $query;
		}
		echo json_encode($casos);
	}

	public function vista_estadisticas()
	{

		$id_estado=null;
		if ($this->session->get('logged')) {
			$model = new Casos();
			$desde = 'null';
			$hasta = 'null';
			//BUSCAMOS LOS CASOS ATENDIDOS POR TIPO BENEFICIARIO USUARIO
			$estadisticas["usuario"] = 0;
			$beneficiarios = $model->contarCasos_Tipo_Beneficiario($desde, $hasta,$id_estado);
					
			$data = [
				'beneficiarios' => $beneficiarios
			];
			if (empty($beneficiarios)) 
			{
				echo view('template/header');
				echo view('template/nav_bar');
				echo view('reportes/estadisticas/error_estadisticas.php');
				echo view('template/footer');
			} else 
			{
				//	BUSCAMOS LOS CASOS ATENDIDOS POR RED SOCIAL
				$query_casos_atendidos = $model->contarCasosAtendidos();
				
				$data = [
					'beneficiarios' => $beneficiarios,
					'via_atencion' => $query_casos_atendidos
				];
				
				
			  //BUSCAMOS EL COUNT Y EL NOMBRE DEL TIPO ATENCION PARA LA GRAFICA
				$count_atencion = [];
				// Verificamos si el resultado de la consulta no está vacío
				if (!empty($query_casos_atendidos)) {
					// Iteramos sobre cada atención y obtenemos el nombre
					foreach ($query_casos_atendidos as $atencion) {
						// Suponiendo que 'nombre' es la propiedad que contiene el nombre de la atención
						$nombres_atencion[]= $atencion->red_s_nom;
						$count_atencion[] = $atencion->count;
					}
				}

				//BUSCAMOS LOS CASOS ATENDIDOS  POR RED SOCIAL POR GENERO MASCULINO
				$query_casos_atendidos_Masculino = $model->contarCasosAtendidos_MASCULINO($desde, $hasta,$id_estado);
				$count_atencion_Masculino = [];
				// Verificamos si el resultado de la consulta no está vacío
				if (!empty($query_casos_atendidos_Masculino)) {
					// Iteramos sobre cada atención y obtenemos el nombre
					foreach ($query_casos_atendidos_Masculino as $atencion) {
						// Suponiendo que 'nombre' es la propiedad que contiene el nombre de la atención
						$count_atencion_Masculino[] = $atencion->count;
					}
				}


				//BUSCAMOS LOS CASOS ATENDIDOS  POR RED SOCIAL POR GENERO FEMENINO
				$query_casos_atendidos_Femenino = $model->contarCasosAtendidos_FEMENINO($desde, $hasta,$id_estado);
				$count_atencion_Femenino = [];
				// Verificamos si el resultado de la consulta no está vacío
				if (!empty($query_casos_atendidos_Femenino)) {
					// Iteramos sobre cada atención y obtenemos el nombre
					foreach ($query_casos_atendidos_Femenino as $atencion) {
						// Suponiendo que 'nombre' es la propiedad que contiene el nombre de la atención
						$count_atencion_Femenino[] = $atencion->count;
					}
				}

				$data = [
					'beneficiarios' => $beneficiarios,
					'via_atencion' => $query_casos_atendidos,
					'nombre_atencion' => $nombres_atencion,
					'count_atencion' => $count_atencion,
					'count_atencion_masculino' => $count_atencion_Masculino,
					'count_atencion_Femenino' => $count_atencion_Femenino,
				];

				//	BUSCAMOS LOS CASOS ATENDIDOS POR TIPO DE ATENCION
				$query_casos_solicitud = $model->contarCasosAtencionCiudadano();

						
				//BUSCAMOS EL COUNT Y EL NOMBRE DEL TIPO DE SOLICITUD PARA LA GRAFICA
				$count_solicitud = [];
				$nombres_solicitud = [];
				// Verificamos si el resultado de la consulta no está vacío
				if (!empty($query_casos_solicitud)) {
					// Iteramos sobre cada atención y obtenemos el nombre
					foreach ($query_casos_solicitud as $count_solic) {
						// Suponiendo que 'nombre' es la propiedad que contiene el nombre de la atención
						$nombres_solicitud[]= $count_solic->tipo_aten_nombre;
						$count_solicitud[] = $count_solic->count;
					}
				}

				//BUSCAMOS LOS CASOS ATENDIDOS POR TIPO DE ATENCION MASCULINO
				$query_casos_solicitud_Masculino = $model->contarCasosTipoSolicitudMasculino($desde, $hasta);
				
				$count_solicitud_Masculino = [];
				// Verificamos si el resultado de la consulta no está vacío
				if (!empty($query_casos_solicitud_Masculino)) {
					// Iteramos sobre cada atención y obtenemos el nombre
					foreach ($query_casos_solicitud_Masculino as $solicitud) {
						// Suponiendo que 'nombre' es la propiedad que contiene el nombre de la atención
						$count_solicitud_Masculino[] = $solicitud->count;
					}
				}




				//BUSCAMOS LOS CASOS ATENDIDOS POR TIPO DE ATENCION Femenino
				$query_casos_solicitud_Femenino = $model->contarCasosTipoSolicitudFemenino($desde, $hasta);
				$count_solicitud_Femenino = [];
				// Verificamos si el resultado de la consulta no está vacío
				if (!empty($query_casos_solicitud_Femenino)) {
					// Iteramos sobre cada atención y obtenemos el nombre
					foreach ($query_casos_solicitud_Femenino as $solicitud) {
						// Suponiendo que 'nombre' es la propiedad que contiene el nombre de la atención
						$count_solicitud_Femenino[] = $solicitud->count;
					}
				}

				$data = [
					'beneficiarios' => $beneficiarios,
					'via_atencion' => $query_casos_atendidos,
					'nombre_atencion' => $nombres_atencion,
					'count_atencion' => $count_atencion,
					'count_atencion_masculino' => $count_atencion_Masculino,
					'count_atencion_Femenino' => $count_atencion_Femenino,
					'tipo_solicitud' => $query_casos_solicitud,
					'nombre_solicitud' => $nombres_solicitud,
					'count_solicitud' =>$count_solicitud,
					'count_solicitud_Masculino' => $count_solicitud_Masculino,
					'count_solicitud_Femenino' => $count_solicitud_Femenino
				];
				


				//	BUSCAMOS LOS CASOS POR ESTATUS
				$query_casos_EstatusCasos = $model->contarCasosEstatus();
				
				
				$data = [
					'beneficiarios' => $beneficiarios,
					'via_atencion' => $query_casos_atendidos,
					'nombre_atencion' => $nombres_atencion,
					'count_atencion' => $count_atencion,
					'count_atencion_masculino' => $count_atencion_Masculino,
					'count_atencion_Femenino' => $count_atencion_Femenino,
					'tipo_solicitud' => $query_casos_solicitud,
					'nombre_solicitud' => $nombres_solicitud,
					'count_solicitud' =>$count_solicitud,
					'count_solicitud_Masculino' => $count_solicitud_Masculino,
					'count_solicitud_Femenino' => $count_solicitud_Femenino,
					'estatus_casos' => $query_casos_EstatusCasos
				];


				echo view('template/header');
				echo view('template/nav_bar');				
				echo  view('reportes/estadisticas/content.php',$data);
				echo view('template/footer');
				echo view('reportes/estadisticas/footer.php');

				
			

			}


		} else {
			return redirect()->to('/');
		}

		
	}
	public function vista_estadisticas_filtros($desde = null, $hasta = null, $id_estado = null)
	{
		if ($this->session->get('logged')) {
			$model = new Casos();
			//VERIFICAMOS SI HAY CASOS PARA LA FECHA INGRESADA
			$querybuscarcasos = $model->contarCasosPorFecha($desde, $hasta);
			
			
			if (empty($querybuscarcasos->getResult())) {
				echo view('template/header');
				echo view('template/nav_bar');
				echo view('reportes/estadisticas/error_estadisticas.php');
				echo view('template/footer');
			} else {
				
			//BUSCAMOS LOS CASOS ATENDIDOS POR TIPO DE  BENEFICIARIO
			$beneficiarios = $model->contarCasos_Tipo_Beneficiario_fecha($desde, $hasta,$id_estado=null);
			
			
			
			$data = [
   				 	'beneficiarios' => $beneficiarios
					];


			//	BUSCAMOS LOS CASOS ATENDIDOS POR RED SOCIAL
				$query_casos_atendidos = $model->contarCasosAtendidos_Fecha($desde, $hasta,$id_estado=null);
				
				$data = [
					'beneficiarios' => $beneficiarios,
					'via_atencion' => $query_casos_atendidos
				];


				//BUSCAMOS EL COUNT Y EL NOMBRE DEL TIPO ATENCION PARA LA GRAFICA
				$count_atencion = [];
				// Verificamos si el resultado de la consulta no está vacío
				if (!empty($query_casos_atendidos)) {
					// Iteramos sobre cada atención y obtenemos el nombre
					foreach ($query_casos_atendidos as $atencion) {
						// Suponiendo que 'nombre' es la propiedad que contiene el nombre de la atención
						$nombres_atencion[]= $atencion->red_s_nom;
						$count_atencion[] = $atencion->count;
					}
				}


				//BUSCAMOS LOS CASOS ATENDIDOS  POR RED SOCIAL POR GENERO MASCULINO
				$query_casos_atendidos_Masculino = $model->contarCasosAtendidos_MASCULINO($desde, $hasta,$id_estado=null);
				$count_atencion_Masculino = [];
				// Verificamos si el resultado de la consulta no está vacío
				if (!empty($query_casos_atendidos_Masculino)) {
					// Iteramos sobre cada atención y obtenemos el nombre
					foreach ($query_casos_atendidos_Masculino as $atencion) {
						// Suponiendo que 'nombre' es la propiedad que contiene el nombre de la atención
						$count_atencion_Masculino[] = $atencion->count;
					}
				}

				//BUSCAMOS LOS CASOS ATENDIDOS  POR RED SOCIAL POR GENERO FEMENINO
				$query_casos_atendidos_Femenino = $model->contarCasosAtendidos_FEMENINO($desde, $hasta,$id_estado=null);
				$count_atencion_Femenino = [];
				// Verificamos si el resultado de la consulta no está vacío
				if (!empty($query_casos_atendidos_Femenino)) {
					// Iteramos sobre cada atención y obtenemos el nombre
					foreach ($query_casos_atendidos_Femenino as $atencion) {
						// Suponiendo que 'nombre' es la propiedad que contiene el nombre de la atención
						$count_atencion_Femenino[] = $atencion->count;
					}
				}


				$data = [
					'beneficiarios' => $beneficiarios,
					'via_atencion' => $query_casos_atendidos,
					'nombre_atencion' => $nombres_atencion,
					'count_atencion' => $count_atencion,
					'count_atencion_masculino' => $count_atencion_Masculino,
					'count_atencion_Femenino' => $count_atencion_Femenino,
				];


			//	BUSCAMOS LOS CASOS ATENDIDOS POR TIPO DE SOLICITUD POR FECHA
				$query_casos_solicitud = $model->contarCasosTipoSolicitudFecha($desde, $hasta,$id_estado);
				//BUSCAMOS EL COUNT Y EL NOMBRE DEL TIPO DE SOLICITUD PARA LA GRAFICA
				$count_solicitud = [];
				$nombres_solicitud = [];
				// Verificamos si el resultado de la consulta no está vacío
				if (!empty($query_casos_solicitud)) {
					// Iteramos sobre cada atención y obtenemos el nombre
					foreach ($query_casos_solicitud as $count_solic) {
						// Suponiendo que 'nombre' es la propiedad que contiene el nombre de la atención
						$nombres_solicitud[]= $count_solic->tipo_aten_nombre;
						$count_solicitud[] = $count_solic->count;
					}
				}


			//BUSCAMOS LOS CASOS ATENDIDOS POR TIPO DE SOLICITUD MASCULINO
			$query_casos_solicitud_Masculino = $model->contarCasosTipoSolicitudMasculino($desde,$hasta,$id_estado);
			$count_solicitud_Masculino = [];
			// Verificamos si el resultado de la consulta no está vacío
			if (!empty($query_casos_solicitud_Masculino)) {
				// Iteramos sobre cada atención y obtenemos el nombre
				foreach ($query_casos_solicitud_Masculino as $solicitud) {
					// Suponiendo que 'nombre' es la propiedad que contiene el nombre de la atención
					$count_solicitud_Masculino[] = $solicitud->count;
				}
			}


			//BUSCAMOS LOS CASOS ATENDIDOS POR TIPO DE SOLICITUD Femenino
			$query_casos_solicitud_Femenino = $model->contarCasosTipoSolicitudFemenino($desde, $hasta,$id_estado);
			$count_solicitud_Femenino = [];
			// Verificamos si el resultado de la consulta no está vacío
			if (!empty($query_casos_solicitud_Femenino)) {
				// Iteramos sobre cada atención y obtenemos el nombre
				foreach ($query_casos_solicitud_Femenino as $solicitud) {
					// Suponiendo que 'nombre' es la propiedad que contiene el nombre de la atención
					$count_solicitud_Femenino[] = $solicitud->count;
				}
			}

			$data = [
				'beneficiarios' => $beneficiarios,
				'via_atencion' => $query_casos_atendidos,
				'nombre_atencion' => $nombres_atencion,
				'count_atencion' => $count_atencion,
				'count_atencion_masculino' => $count_atencion_Masculino,
				'count_atencion_Femenino' => $count_atencion_Femenino,
				'tipo_solicitud' => $query_casos_solicitud,
				'nombre_solicitud' => $nombres_solicitud,
				'count_solicitud' =>$count_solicitud,
				'count_solicitud_Masculino' => $count_solicitud_Masculino,
				'count_solicitud_Femenino' => $count_solicitud_Femenino
			];

			//	BUSCAMOS LOS CASOS POR ESTATUS
			$query_casos_EstatusCasos = $model->contarCasosEstatusFecha($desde, $hasta,$id_estado);
							
			$data = [
				'beneficiarios' => $beneficiarios,
				'via_atencion' => $query_casos_atendidos,
				'nombre_atencion' => $nombres_atencion,
				'count_atencion' => $count_atencion,
				'count_atencion_masculino' => $count_atencion_Masculino,
				'count_atencion_Femenino' => $count_atencion_Femenino,
				'tipo_solicitud' => $query_casos_solicitud,
				'nombre_solicitud' => $nombres_solicitud,
				'count_solicitud' =>$count_solicitud,
				'count_solicitud_Masculino' => $count_solicitud_Masculino,
				'count_solicitud_Femenino' => $count_solicitud_Femenino,
				'estatus_casos' => $query_casos_EstatusCasos
			];

			echo view('template/header');
			echo view('template/nav_bar');				
			echo  view('reportes/estadisticas/content.php',$data);
			echo view('template/footer');
			echo view('reportes/estadisticas/footer.php');


			}
		} else {
			return redirect()->to('/');
		}
		
	}



	public function vista_estadisticas_estadal($desde = null, $hasta = null)
	{



		if ($this->session->get('logged')) {
			$model = new Casos();
			//BUSCAMOS LOS CASOS POR ESTADOS
			$query_consultar_estados = $model->consultar_estados($desde, $hasta);
			$count_estados = [];		
			$nombres_estados = [];
			$estado_id = [];

			// Verificamos si el resultado de la consulta no está vacío
			if (!empty($query_consultar_estados))
			{
				foreach ($query_consultar_estados as $estados) 
				{
					$nombres_estados[] = $estados->estadonom;
					$count_estados[] = $estados->count;
					$estado_id[] = $estados->estadoid;
				}
			}
			$data = [
				'nombres_estados' => $nombres_estados, 
				'count_estados' => $count_estados,
				'estado_id' => $estado_id,
			];

		
		
			// //BUSCAMOS EL ESTATUS DE LOS CASOS EN FUNCION DEL ESTADO
			$query_estatus_casos_estado = $model->consultar_estatus_caso_estados($desde, $hasta);
			
			
			
			$nombres_estatus = [];		
			$count_estatus = [];
			//$id_estado_estatus = [];
			$nombre_estado_estatus = [];
			if (!empty($query_estatus_casos_estado))
			{
				foreach ($query_estatus_casos_estado as $estatus) 
				{
					$nombres_estatus[] = $estatus->estnom;
					$count_estatus[] = $estatus->count;

					$nombre_estado_estatus[] = $estatus->estadonom;
				}
			}
			$data = [
				'nombres_estados' => $nombres_estados, 
				'count_estados' => $count_estados,
				'estado_id' => $estado_id,		
				'nombres_estatus' => $nombres_estatus, 			
				'count_estatus' => $count_estatus,			
				'nombre_estado_estatus' => $nombre_estado_estatus,
			];
			
			
			$json_data = json_encode($data);
		
		echo view('template/header');
			echo view('template/nav_bar');
			echo view('reportes/estadisticas/estadal/content.php', array('json_data' => $json_data));
			echo view('template/footer');
			echo view('reportes/estadisticas/estadal/footer.php');
		} else {
			return redirect()->to('/');
		}



	}

	public function vista_estadisticas_beneficiario($desde = null, $hasta = null)
	{


		if ($this->session->get('logged')) {

			$model = new Casos();


		//BUSCAMOS LOS CASOS POR ESTADOS
		$query_consultar_estados = $model->consultar_estados($desde, $hasta);
		$count_estados = [];		
		$nombres_estados = [];
		$estado_id = [];

		// Verificamos si el resultado de la consulta no está vacío
		if (!empty($query_consultar_estados))
		{
			foreach ($query_consultar_estados as $estados) 
			{
				$nombres_estados[] = $estados->estadonom;
				$count_estados[] = $estados->count;
				$estado_id[] = $estados->estadoid;
			}
		}
		$data = [
			'nombres_estados' => $nombres_estados, 
			'count_estados' => $count_estados,
			'estado_id' => $estado_id,
		];




			// //BUSCAMOS LOS CASOS ESTADALES POR TIPO DE BENEFICIAIRIO
			$query_Tipo_beneficiarios = $model->ContarCasos_Estadal_Tipo_Beneficiario($desde, $hasta);
			$nombre_tipo_beneficiario = [];		
			$count_beneficiario = [];
			$nombre_estado_beneficiario = [];
			
			if (!empty($query_Tipo_beneficiarios)) {
				foreach ($query_Tipo_beneficiarios as $beneficiario) {
					$nombre_tipo_beneficiario[] = $beneficiario->tipo_beneficiario_nombre;
					$count_beneficiario[] = $beneficiario->count;
					$nombre_estado_beneficiario[] = $beneficiario->estadonom;
				}
			}
			
			$data = [
				'nombres_estados' => $nombres_estados, 
				'count_estados' => $count_estados,
				'estado_id' => $estado_id,
				'nombre_tipo_beneficiario' => $nombre_tipo_beneficiario, 
				'count_beneficiario' => $count_beneficiario, 
				'nombre_estado_beneficiario' => $nombre_estado_beneficiario,
			];
			
		
			
			$json_data = json_encode($data);
		
			echo view('template/header');
			echo view('template/nav_bar');
			echo view('reportes/estadisticas/tipo_beneficiario/content.php', array('json_data' => $json_data));
			echo view('template/footer');
			echo view('reportes/estadisticas/tipo_beneficiario/footer.php');
		} else {
			return redirect()->to('/');
		}


	}

	public function vista_estadisticas_prop_intelectual($desde = null, $hasta = null)
	{

		
		if ($this->session->get('logged')) {
			
			$model = new Casos();
			//BUSCAMOS LOS CASOS POR ESTADOS
			$query_consultar_estados = $model->consultar_estados($desde, $hasta);
			$count_estados = [];		
			$nombres_estados = [];
			$estado_id = [];

			// Verificamos si el resultado de la consulta no está vacío
			if (!empty($query_consultar_estados))
			{
				foreach ($query_consultar_estados as $estados) 
				{
					$nombres_estados[] = $estados->estadonom;
					$count_estados[] = $estados->count;
					$estado_id[] = $estados->estadoid;
				}
			}
			$data = [
				'nombres_estados' => $nombres_estados, 
				'count_estados' => $count_estados,
				'estado_id' => $estado_id,
			];

			
				
			// //BUSCAMOS LOS CASOS ESTADALES POR TIPO DE PROPIEDAD INTELECTUAL 
			$query_Tipo_propiedad = $model->ContarCasos_Estadal_Tipo_Prop_Intelectual($desde, $hasta);
			

			$nombre_tipo_propiedad = [];		
			$count_propiedad = [];
			$nombre_estado_propiedad = [];

			if (!empty($query_Tipo_propiedad)) {
				foreach ($query_Tipo_propiedad as $propiedad) {
					$nombre_tipo_propiedad[] = $propiedad->tipo_prop_nombre;
					$count_propiedad[] = $propiedad->count;
					$nombre_estado_propiedad[] = $propiedad->estadonom;
				}
			}

			$data = [
				'nombres_estados' => $nombres_estados, 
				'count_estados' => $count_estados,
				'estado_id' => $estado_id,
				'nombre_tipo_propiedad' => $nombre_tipo_propiedad, 
				'count_propiedad' => $count_propiedad, 
				'nombre_estado_propiedad' => $nombre_estado_propiedad,
			];

			
			
			$json_data = json_encode($data);

			echo view('template/header');
			echo view('template/nav_bar');
			echo view('reportes/estadisticas/propiedad_intelectual/content.php', array('json_data' => $json_data));
			echo view('template/footer');
			echo view('reportes/estadisticas/propiedad_intelectual/footer.php');
		} else {
			return redirect()->to('/');
		}
	}



	public function vista_estadisticas_tipo_atencion($desde = null, $hasta = null)
	{
		
		
		
		if ($this->session->get('logged')) {
			$model = new Casos();
			//BUSCAMOS LOS CASOS POR ESTADOS
			$query_consultar_estados = $model->consultar_estados($desde, $hasta);
			
			$count_estados = [];		
			$nombres_estados = [];
			

			// Verificamos si el resultado de la consulta no está vacío
			if (!empty($query_consultar_estados))
			{
				foreach ($query_consultar_estados as $estados) 
				{
					$nombres_estados[] = $estados->estadonom;
					$count_estados[] = $estados->count;	
				}
			}
			$data = [
				'nombres_estados' => $nombres_estados, 
				'count_estados' => $count_estados,
			];

			// //BUSCAMOS LOS CASOS ESTADALES POR TIPO DE TIPO DE SOLICITUD
			$query_Tipo_solicitud = $model->ContarasosTipoSolicitud_Estadal($desde, $hasta);

			$nombre_tipo_solicitud = [];		
			$count_solicitud = [];
			$nombre_estado_solicitud = [];
			
			if (!empty($query_Tipo_solicitud)) {
				foreach ($query_Tipo_solicitud as $solicitud) {
					$nombre_tipo_solicitud[] = $solicitud->tipo_aten_nombre;
					$count_solicitud[] = $solicitud->count;
					$nombre_estado_solicitud[] = $solicitud->estadonom;
				}
			}
			
			$data = [
				'nombres_estados' => $nombres_estados, 
				'count_estados' => $count_estados,
				'nombre_tipo_solicitud' => $nombre_tipo_solicitud, 
				'count_solicitud' => $count_solicitud, 
				'nombre_estado_solicitud' => $nombre_estado_solicitud,
			];
			
			
			$json_data = json_encode($data);

			

			echo view('template/header');
			echo view('template/nav_bar');
			echo view('reportes/estadisticas/tipo_atencion/content.php', array('json_data' => $json_data));
			echo view('template/footer');
			echo view('reportes/estadisticas/tipo_atencion/footer.php');
		} else {
			return redirect()->to('/');
		}
		
		
		
	}




	public function vista_estadisticas2()
	{
		echo view('template/header');
		echo view('template/nav_bar');
		echo view('reportes/estadisticas/prueba.php');
		echo view('template/footer');
		echo view('reportes/estadisticas/footer.php');
	}



	public function estadisticas_mapa()
	{
		

		if ($this->session->get('logged')) {
		echo view('template/header');
		echo view('template/nav_bar');
		echo view('reportes/estadisticas_mapa/content.php');
		echo view('template/footer');
		echo view('reportes/estadisticas_mapa/footer.php');
	} else {
		return redirect()->to('/');
	}

	}





}
