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



class Reporte_Atencion_Controler extends BaseController
{
	public function vista_atencion()
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
			echo view('reportes/atencion/content', $data);
			echo view('template/footer');
			echo view('reportes/atencion/footer.php');
		} else {
			return redirect()->to('/');
		}
	}


	//Metodo queo obtiene  los todos los casos disponibles
	public function Listar_Atencion($desde = null, $hasta = null, $tipo_pi = null, $tipo_atencion_usu = null, $sexo = null, $via_atencion = null, $direcciones_caso = null, $tipo_beneficiario = 0, $atencion_cuidadano = 0, $estatus = 0)
	{
		$model = new Casos();
		$query = $model->reporte_atencion($desde, $hasta, $tipo_pi, $tipo_atencion_usu, $sexo, $via_atencion, $direcciones_caso, $tipo_beneficiario, $atencion_cuidadano, $estatus);

		if (empty($query)) {
			$casos = [];
		} else {
			$casos = $query;
		}
		echo json_encode($casos);
	}


	
	//Metodo queo obtiene  los todos los casos disponibles POR USUARIO
	public function reporte_operador($desde = null, $hasta = null, $tipo_pi = null, $tipo_atencion_usu = null, $sexo = null, $via_atencion = null, $direcciones_caso = null, $tipo_beneficiario = 0, $usuarios = null)
	{
		$model = new Casos();
		$idusuopr   = $this->session->get('iduser');
		$query = $model->reporte_operador($desde, $hasta, $tipo_pi, $tipo_atencion_usu, $sexo, $idusuopr, $via_atencion, $direcciones_caso, $tipo_beneficiario, $usuarios);
		if (empty($query)) {
			$casos = [];
		} else {
			$casos = $query;
		}
		echo json_encode($casos);
	}

	public function vista_estadisticas()
	{

		
		if ($this->session->get('logged')) {
			$model = new Casos();
			$desde = 'null';
			$hasta = 'null';
			//BUSCAMOS LOS CASOS ATENDIDOS POR TIPO BENEFICIARIO USUARIO
			$estadisticas["usuario"] = 0;
			$beneficiario_usuario = $model->contarCasos_Beneficiario_Usuario($desde, $hasta);
			if (!empty($beneficiario_usuario)) {
				for ($i = 0; $i < count($beneficiario_usuario); $i++) {
					if ($beneficiario_usuario[$i]->tipo_beneficiario == "1") {
						$estadisticas["usuario"] = $beneficiario_usuario[$i]->count;
					} else {
						$estadisticas[$beneficiario_usuario[$i]->tipo_beneficiario] = $beneficiario_usuario[$i]->count;
					}
				}
			} else {
				$estadisticas["usuario"] = 0;
			}
			//BUSCAMOS LOS CASOS ATENDIDOS POR TIPO BENEFICIARIO EMPRENDERDOR
			$beneficiario_emprendedor = $model->contarCasos_Beneficiario_Emprendedor($desde, $hasta);
			if (!empty($beneficiario_emprendedor)) {
				for ($i = 0; $i < count($beneficiario_emprendedor); $i++) {
					if ($beneficiario_emprendedor[$i]->tipo_beneficiario == "2") {
						$estadisticas["emprendedor"] = $beneficiario_emprendedor[$i]->count;
					} else {
						$estadisticas[$beneficiario_emprendedor[$i]->tipo_beneficiario] = $beneficiario_emprendedor[$i]->count;
					}
				}
			} else {
				$estadisticas["emprendedor"] = 0;
			}
			if ($estadisticas["emprendedor"] == 0 && $estadisticas["usuario"] == 0) {
				echo view('template/header');
				echo view('template/nav_bar');
				echo view('reportes/estadisticas/error_estadisticas.php');
				echo view('template/footer');
			} else {
				//	BUSCAMOS LOS CASOS ATENDIDOS POR RED SOCIAL
				$query_casos_atendidos = $model->contarCasosAtendidos();
				$estadisticas["Whatsapp"] = 0;
				$estadisticas["CorreoElectronico"] = 0;
				$estadisticas["Llamadatelefonica"] = 0;
				$estadisticas["Personal"] = 0;
				$estadisticas["No_Aplica_red_social"] = 0;
				
				if (empty($query_casos_atendidos)) {
					$estadisticas = [];
				} else {
					for ($i = 0; $i < count($query_casos_atendidos); $i++) {

						if ($query_casos_atendidos[$i]->red_s_nom === "Correo Electrónico") {
							$estadisticas["CorreoElectronico"] = $query_casos_atendidos[$i]->count;
						} else if ($query_casos_atendidos[$i]->red_s_nom === "Llamada Telefónica") {
							$estadisticas["Llamadatelefonica"] = $query_casos_atendidos[$i]->count;
						} else if ($query_casos_atendidos[$i]->red_s_nom === "Whatsapp") {
							$estadisticas["Whatsapp"] = $query_casos_atendidos[$i]->count;
						} else if ($query_casos_atendidos[$i]->red_s_nom === "Personal") {
							$estadisticas["Personal"] = $query_casos_atendidos[$i]->count;
						} else if ($query_casos_atendidos[$i]->red_s_nom === "Portal web ") {
							$estadisticas["No_Aplica_red_social"] = $query_casos_atendidos[$i]->count;
						}
					}
				}
				
				$estadisticas["Sexo_CorreoElectronico_M"] = 0;
				$estadisticas["Sexo_Llamadatelefonica_M"] = 0;
				$estadisticas["Sexo_Whatsapp_M"] = 0;
				$estadisticas["Sexo_Personal_M"] = 0;
				$estadisticas["sexo_no_Aplica_red_social_M"] = 0;
				$estadisticas["Sexo_CorreoElectronico_F"] = 0;
				$estadisticas["Sexo_Llamadatelefonica_F"] = 0;
				$estadisticas["Sexo_Whatsapp_F"] = 0;
				$estadisticas["Sexo_Personal_F"] = 0;
				$estadisticas["sexo_no_Aplica_red_social_F"] = 0;
				//BUSCAMOS LOS CASOS ATENDIDOS POR GENERO MASCULINO
				$query_casos_atendidos_Masculino = $model->contarCasosAtendidos_MASCULINO($desde, $hasta);
			if (!empty($query_casos_atendidos_Masculino)) {
					for ($i = 0; $i < count($query_casos_atendidos_Masculino); $i++) {
						if ($query_casos_atendidos_Masculino[$i]->red_s_nom === "Correo Electrónico") {
							$estadisticas["Sexo_CorreoElectronico_M"] = $query_casos_atendidos_Masculino[$i]->count;
						} else if ($query_casos_atendidos_Masculino[$i]->red_s_nom === "Llamada telefonica") {
							$estadisticas["Sexo_Llamadatelefonica_M"] = $query_casos_atendidos_Masculino[$i]->count;
						} else if ($query_casos_atendidos_Masculino[$i]->red_s_nom === "Whatsapp") {
							$estadisticas["Sexo_Whatsapp_M"] = $query_casos_atendidos_Masculino[$i]->count;
						} else if ($query_casos_atendidos_Masculino[$i]->red_s_nom === "Personal") {
							$estadisticas["Sexo_Personal_M"] = $query_casos_atendidos_Masculino[$i]->count;
						}else if ($query_casos_atendidos_Masculino[$i]->red_s_nom === "Portal web ") {
							$estadisticas["sexo_no_Aplica_red_social_M"] = $query_casos_atendidos_Masculino[$i]->count;
						} else {
							$estadisticas[$query_casos_atendidos_Masculino[$i]->red_s_nom] = $query_casos_atendidos_Masculino[$i]->count;
						}
					}
				}

				//BUSCAMOS LOS CASOS ATENDIDOS POR GENERO FEMENINO
				$query_casos_atendidos_Femenino = $model->contarCasosAtendidos_FEMENINO($desde, $hasta);
			
				if (!empty($query_casos_atendidos_Femenino)) {
					for ($i = 0; $i < count($query_casos_atendidos_Femenino); $i++) {
						if ($query_casos_atendidos_Femenino[$i]->red_s_nom === "Correo Electrónico") {
							$estadisticas["Sexo_CorreoElectronico_F"] = $query_casos_atendidos_Femenino[$i]->count;
						} else if ($query_casos_atendidos_Femenino[$i]->red_s_nom === "Llamada telefonica") {
							$estadisticas["Sexo_Llamadatelefonica_F"] = $query_casos_atendidos_Femenino[$i]->count;
						} else if ($query_casos_atendidos_Femenino[$i]->red_s_nom === "Whatsapp") {
							$estadisticas["Sexo_Whatsapp_F"] = $query_casos_atendidos_Femenino[$i]->count;
						} else if ($query_casos_atendidos_Femenino[$i]->red_s_nom === "Personal") {
							$estadisticas["Sexo_Personal_F"] = $query_casos_atendidos_Femenino[$i]->count;
						}else if ($query_casos_atendidos_Femenino[$i]->red_s_nom === "Portal web ") {
							$estadisticas["sexo_no_Aplica_red_social_F"] = $query_casos_atendidos_Femenino[$i]->count;
						} else {
							$estadisticas[$query_casos_atendidos_Femenino[$i]->red_s_nom] = $query_casos_atendidos_Femenino[$i]->count;
						}
					}
				}

				//BUSCAMOS LOS CASOS ATENDIDOS POR PROPIEDAD INTELECTUAL
				$query = $model->contarCasosPorPI();
				$estadisticas["Marcas"] = 0;
				$estadisticas["Patentes"] = 0;
				$estadisticas["DerechoAutor"] = 0;
				$estadisticas["Indicaciones_Geograficas"] = 0;
				$estadisticas["No_Aplica"] = 0;
				if (empty($query)) {
					$estadisticas = [];
				} else {
					for ($i = 0; $i < count($query); $i++) {
						if ($query[$i]->tipo_prop_nombre === "Derecho de Autor") {
							$estadisticas["DerechoAutor"] = $query[$i]->count;
						} else if ($query[$i]->tipo_prop_nombre === "Indicación Geográfica Protegida") {
							$estadisticas["Indicaciones_Geograficas"] = $query[$i]->count;
						} else if ($query[$i]->tipo_prop_nombre === "Marcas") {
							$estadisticas["Marcas"] = $query[$i]->count;
						} else if ($query[$i]->tipo_prop_nombre === "Patentes") {
							$estadisticas["Patentes"] = $query[$i]->count;
						} else if ($query[$i]->tipo_prop_nombre === "No Aplica") {
							$estadisticas["No_Aplica"] = $query[$i]->count;
						}
					}




					//BUSCAMOS LOS CASOS ATENDIDOS POR PROPIEDAD INTELECTUAL GENERO MASCULINO
					$query_casos_MASCULINOS = $model->contarCasos_PI_MACULINO($desde, $hasta);
					$estadisticas["sexo_Marcas_M"] = 0;
					$estadisticas["sexo_Patentes_M"] = 0;
					$estadisticas["sexo_DerechoAutor_M"] = 0;
					$estadisticas["sexo_Indicaciones_Geograficas_M"] = 0;
					for ($i = 0; $i < count($query_casos_MASCULINOS); $i++) {
						if ($query_casos_MASCULINOS[$i]->tipo_prop_nombre === "Derecho de Autor") {
							$estadisticas["sexo_DerechoAutor_M"] = $query_casos_MASCULINOS[$i]->count;
						} else if ($query_casos_MASCULINOS[$i]->tipo_prop_nombre === "Indicación Geográfica Protegida") {
							$estadisticas["sexo_Indicaciones_Geograficas_M"] = $query_casos_MASCULINOS[$i]->count;
						} else if ($query_casos_MASCULINOS[$i]->tipo_prop_nombre === "Marcas") {
							$estadisticas["sexo_Marcas_M"] = $query_casos_MASCULINOS[$i]->count;
						} else if ($query_casos_MASCULINOS[$i]->tipo_prop_nombre === "Patentes") {
							$estadisticas["sexo_Patentes_M"] = $query_casos_MASCULINOS[$i]->count;
						} else {
							$estadisticas[$query_casos_MASCULINOS[$i]->tipo_prop_nombre] = $query_casos_MASCULINOS[$i]->count;
						}
					}

					//BUSCAMOS LOS CASOS ATENDIDOS POR PROPIEDAD INTELECTUAL GENERO FEMENINO
					$query_casos_FEMENINOS = $model->contarCasos_PI_FEMENINO($desde, $hasta);
					$estadisticas["sexo_Marcas_F"] = 0;
					$estadisticas["sexo_Patentes_F"] = 0;
					$estadisticas["sexo_DerechoAutor_F"] = 0;
					$estadisticas["sexo_Indicaciones_Geograficas_F"] = 0;
					for ($i = 0; $i < count($query_casos_FEMENINOS); $i++) {
						if ($query_casos_FEMENINOS[$i]->tipo_prop_nombre === "Derecho de Autor") {
							$estadisticas["sexo_DerechoAutor_F"] = $query_casos_FEMENINOS[$i]->count;
						} else if ($query_casos_FEMENINOS[$i]->tipo_prop_nombre === "Indicación Geográfica Protegida") {
							$estadisticas["sexo_Indicaciones_Geograficas_F"] = $query_casos_FEMENINOS[$i]->count;
						} else if ($query_casos_FEMENINOS[$i]->tipo_prop_nombre === "Marcas") {
							$estadisticas["sexo_Marcas_F"] = $query_casos_FEMENINOS[$i]->count;
						} else if ($query_casos_FEMENINOS[$i]->tipo_prop_nombre === "Patentes") {
							$estadisticas["sexo_Patentes_F"] = $query_casos_FEMENINOS[$i]->count;
						} else {
							$estadisticas[$query_casos_FEMENINOS[$i]->tipo_prop_nombre] = $query_casos_FEMENINOS[$i]->count;
						}
					}

					//var_dump($estadisticas);
				}
				//BUSCAMOS LOS CASOS ATENDIDOS POR ATENCION CIUDADANO
				$query = $model->contarCasosAtencionCiudadano();
				$estadisticas["Asesoría"] = 0;
				$estadisticas["Sugerencia"] = 0;
				$estadisticas["Queja"] = 0;
				$estadisticas["Reclamo"] = 0;
				$estadisticas["Denuncia"] = 0;
				$estadisticas["Petición"] = 0;
				if (empty($query)) {
					$estadisticas = [];
				} else {
					for ($i = 0; $i < count($query); $i++) {
						if ($query[$i]->tipo_aten_nombre === "Asesoría") {
							$estadisticas["Asesoría"] = $query[$i]->count;
						} else if ($query[$i]->tipo_aten_nombre === "Sugerencia") {
							$estadisticas["Sugerencia"] = $query[$i]->count;
						} else if ($query[$i]->tipo_aten_nombre === "Queja") {
							$estadisticas["Queja"] = $query[$i]->count;
						} else if ($query[$i]->tipo_aten_nombre === "Reclamo") {
							$estadisticas["Reclamo"] = $query[$i]->count;
						} else if ($query[$i]->tipo_aten_nombre === "Denuncia") {
							$estadisticas["Denuncia"] = $query[$i]->count;
						} else if ($query[$i]->tipo_aten_nombre === "Petición") {
							$estadisticas["Petición"] = $query[$i]->count;
						}
					}
				}

				//BUSCAMOS LOS CASOS ABIERTOS
				$query_CasosAbiertos = $model->contarCasosAbiertos($desde, $hasta);
				if (!empty($query_CasosAbiertos)) {
					for ($i = 0; $i < count($query_CasosAbiertos); $i++) {
						if ($query_CasosAbiertos[$i]->idest == "1") {
							$estadisticas["Abiertos"] = $query_CasosAbiertos[$i]->count;
						} else {
							$estadisticas[$query_CasosAbiertos[$i]->idest] = $query_CasosAbiertos[$i]->count;
						}
					}
				} else {
					$estadisticas["Abiertos"] = 0;
				}

				//BUSCAMOS LOS CASOS Cerrados
				$query_CasosCerrados = $model->ContarCasosCerrados($desde, $hasta);
				
				if (!empty($query_CasosCerrados)) {
					for ($i = 0; $i < count($query_CasosCerrados); $i++) {
						if ($query_CasosCerrados[$i]->idest == "2") {
							$estadisticas["Cerrados"] = $query_CasosCerrados[$i]->count;
						} else {
							$estadisticas[$query_CasosCerrados[$i]->idest] = $query_CasosCerrados[$i]->count;
						}
					}
				} else {
					$estadisticas["Cerrados"] = 0;
				}


				$estadisticas["fecha_desde"] = '';
				$estadisticas["fecha_hasta"] ='';

				//Pasamos la tabla como parametro para la vista
				echo view('template/header');
				echo view('template/nav_bar');
				echo view('reportes/estadisticas/content.php', $estadisticas);
				echo view('template/footer');
				echo view('reportes/estadisticas/footer.php');
			}
		} else {
			return redirect()->to('/');
		}
	}
	public function vista_estadisticas_filtros($desde = null, $hasta = null)
	{

		if ($this->session->get('logged')) {
			$model = new Casos();
			//VERIFICAMOS SI HAY CASOS PARA LA FECHA INGRESADA
			$querybuscarcasos = $model->contarCasosPorFecha($desde, $hasta);
			if (empty($querybuscarcasos->getResult())) {
				//INICIALIZAMOS LA VARIABLES EN 0
				$estadisticas["Whatsapp"] = 0;
				$estadisticas["CorreoElectronico"] = 0;
				$estadisticas["Llamadatelefonica"] = 0;
				$estadisticas["No_Aplica_red_social"] = 0;
				$estadisticas["Personal"] = 0;
				$estadisticas["Marcas"] = 0;
				$estadisticas["Patentes"] = 0;
				$estadisticas["DerechoAutor"] = 0;
				$estadisticas["No_Aplica"] = 0;
				$estadisticas["Indicaciones_Geograficas"] = 0;
				$estadisticas["sexo_Marcas_M"] = 0;
				$estadisticas["sexo_Patentes_M"] = 0;
				$estadisticas["sexo_DerechoAutor_M"] = 0;
				$estadisticas["sexo_Indicaciones_Geograficas_M"] = 0;
				$estadisticas["sexo_Marcas_F"] = 0;
				$estadisticas["sexo_Patentes_F"] = 0;
				$estadisticas["sexo_DerechoAutor_F"] = 0;
				$estadisticas["sexo_Indicaciones_Geograficas_F"] = 0;
				$estadisticas["Sexo_CorreoElectronico_M"] = 0;
				$estadisticas["Sexo_Llamadatelefonica_M"] = 0;
				$estadisticas["Sexo_Whatsapp_M"] = 0;
				$estadisticas["Sexo_Personal_M"] = 0;
				$estadisticas["Sexo_CorreoElectronico_F"] = 0;
				$estadisticas["Sexo_Llamadatelefonica_F"] = 0;
				$estadisticas["sexo_no_Aplica_red_social_M"] = 0;
				$estadisticas["sexo_no_Aplica_red_social_F"] = 0;
				$estadisticas["Sexo_Whatsapp_F"] = 0;
				$estadisticas["Sexo_Personal_F"] = 0;
				$estadisticas["usuario"] = 0;
				$estadisticas["emprendedor"] = 0;
				$estadisticas["Asesoría"] = 0;
				$estadisticas["Sugerencia"] = 0;
				$estadisticas["Queja"] = 0;
				$estadisticas["Reclamo"] = 0;
				$estadisticas["Denuncia"] = 0;
				$estadisticas["Petición"] = 0;
				$estadisticas["Abiertos"] = 0;
				$estadisticas["Cerrados"] = 0;
				$estadisticas["No_Aplica_red_social"] = 0;
				$fecha_desde = $desde;
				$fecha_hasta = $hasta; // Fecha en formato YYYY-MM-DD
				// Formatear la fecha al formato dd-mm-yy
				$fecha_formateada_desde = date("d-m-Y", strtotime($fecha_desde));
				$fecha_formateada_hasta = date("d-m-Y", strtotime($fecha_hasta));
				$estadisticas["fecha_desde"] = $fecha_formateada_desde;
				$estadisticas["fecha_hasta"] = $fecha_formateada_hasta;
				//Pasamos la tabla como parametro para la vista
				echo view('template/header');
				echo view('template/nav_bar');
				echo view('reportes/estadisticas/content.php', $estadisticas);
				echo view('template/footer');
				echo view('reportes/estadisticas/footer.php');
			} else {
				
				//INICIALIZAMOS LA VARIABLES EN 0
				$estadisticas["Whatsapp"] = 0;
				$estadisticas["CorreoElectronico"] = 0;
				$estadisticas["Llamadatelefonica"] = 0;
				$estadisticas["No_Aplica_red_social"] = 0;
				$estadisticas["Personal"] = 0;
				$estadisticas["Marcas"] = 0;
				$estadisticas["Patentes"] = 0;
				$estadisticas["DerechoAutor"] = 0;
				$estadisticas["No_Aplica"] = 0;
				$estadisticas["Indicaciones_Geograficas"] = 0;
				$estadisticas["sexo_Marcas_M"] = 0;
				$estadisticas["sexo_Patentes_M"] = 0;
				$estadisticas["sexo_DerechoAutor_M"] = 0;
				$estadisticas["sexo_Indicaciones_Geograficas_M"] = 0;
				$estadisticas["sexo_Marcas_F"] = 0;
				$estadisticas["sexo_Patentes_F"] = 0;
				$estadisticas["sexo_DerechoAutor_F"] = 0;
				$estadisticas["sexo_Indicaciones_Geograficas_F"] = 0;
				$estadisticas["Sexo_CorreoElectronico_M"] = 0;
				$estadisticas["Sexo_Llamadatelefonica_M"] = 0;
				$estadisticas["Sexo_Whatsapp_M"] = 0;
				$estadisticas["Sexo_Personal_M"] = 0;
				$estadisticas["Sexo_CorreoElectronico_F"] = 0;
				$estadisticas["Sexo_Llamadatelefonica_F"] = 0;
				$estadisticas["Sexo_Whatsapp_F"] = 0;
				$estadisticas["Sexo_Personal_F"] = 0;
				$estadisticas["usuario"] = 0;
				$estadisticas["emprendedor"] = 0;
				$estadisticas["Abiertos"] = 0;
				$estadisticas["Cerrados"] = 0;
				$estadisticas["Asesoría"] = 0;
				$estadisticas["Sugerencia"] = 0;
				$estadisticas["Queja"] = 0;
				$estadisticas["Reclamo"] = 0;
				$estadisticas["Denuncia"] = 0;
				$estadisticas["Petición"] = 0;
				$estadisticas["No_Aplica_red_social"] = 0;
				$estadisticas["sexo_no_Aplica_red_social_M"] = 0;
				$estadisticas["sexo_no_Aplica_red_social_F"] = 0;
				//BUSCAMOS LOS CASOS ATENDIDOS POR RED SOCIAL
				$query_casos_atendidos = $model->contarCasosAtendidos_filtros($desde, $hasta);
				

				if (!empty($query_casos_atendidos)) {

					$fecha_desde = $desde;
				    $fecha_hasta = $hasta;

					
					for ($i = 0; $i < count($query_casos_atendidos); $i++) {
						if ($query_casos_atendidos[$i]->red_s_nom === "Correo Electrónico") {
							$estadisticas["CorreoElectronico"] = $query_casos_atendidos[$i]->count;
						} else if ($query_casos_atendidos[$i]->red_s_nom === "Llamada Telefónica") {
							$estadisticas["Llamadatelefonica"] = $query_casos_atendidos[$i]->count;
						} else if ($query_casos_atendidos[$i]->red_s_nom === "Whatsapp") {
							$estadisticas["Whatsapp"] = $query_casos_atendidos[$i]->count;
						} else if ($query_casos_atendidos[$i]->red_s_nom === "Personal") {
							$estadisticas["Personal"] = $query_casos_atendidos[$i]->count;
						} else if ($query_casos_atendidos[$i]->red_s_nom === "Portal web ") {
							$estadisticas["No_Aplica_red_social"] = $query_casos_atendidos[$i]->count;
						}
					}
				
					//BUSCAMOS LOS CASOS ATENDIDOS POR TIPO BENEFICIARIO USUARIO
					$beneficiario_usuario = $model->contarCasos_Beneficiario_Usuario($desde, $hasta);
					if (!empty($beneficiario_usuario)) {
						for ($i = 0; $i < count($beneficiario_usuario); $i++) {
							if ($beneficiario_usuario[$i]->tipo_beneficiario == "1") {
								$estadisticas["usuario"] = $beneficiario_usuario[$i]->count;
							} else {
								$estadisticas[$beneficiario_usuario[$i]->tipo_beneficiario] = $beneficiario_usuario[$i]->count;
							}
						}
					}

				
					//BUSCAMOS LOS CASOS ATENDIDOS POR TIPO BENEFICIARIO EMPRENDERDOR
					$beneficiario_emprendedor = $model->contarCasos_Beneficiario_Emprendedor($desde, $hasta);
					if (!empty($beneficiario_emprendedor)) {
						for ($i = 0; $i < count($beneficiario_emprendedor); $i++) {
							if ($beneficiario_emprendedor[$i]->tipo_beneficiario == "2") {
								$estadisticas["emprendedor"] = $beneficiario_emprendedor[$i]->count;
							} else {
								$estadisticas[$beneficiario_emprendedor[$i]->tipo_beneficiario] = $beneficiario_emprendedor[$i]->count;
							}
						}
					}

					//BUSCAMOS LOS CASOS ABIERTOS
					$query_CasosAbiertos = $model->contarCasosAbiertos($desde, $hasta);
					if (!empty($query_CasosAbiertos)) {
						for ($i = 0; $i < count($query_CasosAbiertos); $i++) {
							if ($query_CasosAbiertos[$i]->idest == "1") {
								$estadisticas["Abiertos"] = $query_CasosAbiertos[$i]->count;
							} else {
								$estadisticas[$query_CasosAbiertos[$i]->idest] = $query_CasosAbiertos[$i]->count;
							}
						}
					} else {
						$estadisticas["Abiertos"] = 0;
					}

					
					//BUSCAMOS LOS CASOS Cerrados
					$query_CasosCerrados = $model->ContarCasosCerrados($desde, $hasta);
					if (!empty($query_CasosCerrados)) {
						for ($i = 0; $i < count($query_CasosCerrados); $i++) {
							if ($query_CasosCerrados[$i]->idest == "2") {
								$estadisticas["Cerrados"] = $query_CasosCerrados[$i]->count;
							} else {
								$estadisticas[$query_CasosCerrados[$i]->idest] = $query_CasosCerrados[$i]->count;
							}
						}
					} else {
						$estadisticas["Cerrados"] = 0;
					}

					


					//BUSCAMOS LOS CASOS ATENDIDOS POR ATENCION CIUDADANO
					$query = $model->contarCasosAtencionCiudadano_filtro($desde, $hasta);
					$estadisticas["Asesoría"] = 0;
					$estadisticas["Sugerencia"] = 0;
					$estadisticas["Queja"] = 0;
					$estadisticas["Reclamo"] = 0;
					$estadisticas["Denuncia"] = 0;
					$estadisticas["Petición"] = 0;
					if (empty($query)) {
						$estadisticas = [];
					} else {
						for ($i = 0; $i < count($query); $i++) {
							if ($query[$i]->tipo_aten_nombre === "Asesoría") {
								$estadisticas["Asesoría"] = $query[$i]->count;
							} else if ($query[$i]->tipo_aten_nombre === "Sugerencia") {
								$estadisticas["Sugerencia"] = $query[$i]->count;
							} else if ($query[$i]->tipo_aten_nombre === "Queja") {
								$estadisticas["Queja"] = $query[$i]->count;
							} else if ($query[$i]->tipo_aten_nombre === "Reclamo") {
								$estadisticas["Reclamo"] = $query[$i]->count;
							} else if ($query[$i]->tipo_aten_nombre === "Denuncia") {
								$estadisticas["Denuncia"] = $query[$i]->count;
							} else if ($query[$i]->tipo_aten_nombre === "Petición") {
								$estadisticas["Petición"] = $query[$i]->count;
							}
						}
					}
					//BUSCAMOS LOS CASOS ATENDIDOS POR GENERO MASCULINO
					$query_casos_atendidos_Masculino = $model->contarCasosAtendidos_MASCULINO($desde, $hasta);
					if (!empty($query_casos_atendidos_Masculino)) {
						for ($i = 0; $i < count($query_casos_atendidos_Masculino); $i++) {
							if ($query_casos_atendidos_Masculino[$i]->red_s_nom == "Correo Electronico") {
								$estadisticas["Sexo_CorreoElectronico_M"] = $query_casos_atendidos_Masculino[$i]->count;
							} else if ($query_casos_atendidos_Masculino[$i]->red_s_nom == "Llamada telefonica") {
								$estadisticas["Sexo_Llamadatelefonica_M"] = $query_casos_atendidos_Masculino[$i]->count;
							} else if ($query_casos_atendidos_Masculino[$i]->red_s_nom == "Whatsapp") {
								$estadisticas["Sexo_Whatsapp_M"] = $query_casos_atendidos_Masculino[$i]->count;
							} else if ($query_casos_atendidos_Masculino[$i]->red_s_nom == "Personal") {
								$estadisticas["Sexo_Personal_M"] = $query_casos_atendidos_Masculino[$i]->count;
							} else {
								$estadisticas[$query_casos_atendidos_Masculino[$i]->red_s_nom] = $query_casos_atendidos_Masculino[$i]->count;
							}
						}
					}
					//BUSCAMOS LOS CASOS ATENDIDOS POR GENERO FEMENINO
					$query_casos_atendidos_Femenino = $model->contarCasosAtendidos_FEMENINO($desde, $hasta);
					if (!empty($query_casos_atendidos_Femenino)) {
						for ($i = 0; $i < count($query_casos_atendidos_Femenino); $i++) {
							if ($query_casos_atendidos_Femenino[$i]->red_s_nom == "Correo Electronico") {
								$estadisticas["Sexo_CorreoElectronico_F"] = $query_casos_atendidos_Femenino[$i]->count;
							} else if ($query_casos_atendidos_Femenino[$i]->red_s_nom == "Llamada telefonica") {
								$estadisticas["Sexo_Llamadatelefonica_F"] = $query_casos_atendidos_Femenino[$i]->count;
							} else if ($query_casos_atendidos_Femenino[$i]->red_s_nom == "Whatsapp") {
								$estadisticas["Sexo_Whatsapp_F"] = $query_casos_atendidos_Femenino[$i]->count;
							} else if ($query_casos_atendidos_Femenino[$i]->red_s_nom == "Personal") {
								$estadisticas["Sexo_Personal_F"] = $query_casos_atendidos_Femenino[$i]->count;
							} else {
								$estadisticas[$query_casos_atendidos_Femenino[$i]->red_s_nom] = $query_casos_atendidos_Femenino[$i]->count;
							}
						}
					}

					//BUSCAMOS LOS CASOS ATENDIDOS POR PROPIEDAD INTELECTUAL
					$query = $model->contarCasosPorPI_filtros($desde, $hasta);
					if (!empty($query)) {
						for ($i = 0; $i < count($query); $i++) {
							if ($query[$i]->tipo_prop_nombre === "Derecho de Autor") {
								$estadisticas["DerechoAutor"] = $query[$i]->count;
							} else if ($query[$i]->tipo_prop_nombre === "Indicación Geográfica Protegida") {
								$estadisticas["Indicaciones_Geograficas"] = $query[$i]->count;
							} else if ($query[$i]->tipo_prop_nombre === "Marcas") {
								$estadisticas["Marcas"] = $query[$i]->count;
							} else if ($query[$i]->tipo_prop_nombre === "Patentes") {
								$estadisticas["Patentes"] = $query[$i]->count;
							} else if ($query[$i]->tipo_prop_nombre === "No Aplica") {
								$estadisticas["No_Aplica"] = $query[$i]->count;
							}
						}
					}
					//BUSCAMOS LOS CASOS ATENDIDOS POR PROPIEDAD INTELECTUAL GENERO MASCULINO
					$query_casos_MASCULINOS = $model->contarCasos_PI_MACULINO($desde, $hasta);
					for ($i = 0; $i < count($query_casos_MASCULINOS); $i++) {
						if ($query_casos_MASCULINOS[$i]->tipo_prop_nombre == "Derecho de Autor") {
							$estadisticas["sexo_DerechoAutor_M"] = $query_casos_MASCULINOS[$i]->count;
						} else if ($query_casos_MASCULINOS[$i]->tipo_prop_nombre == "Indicación Geográfica Protegida") {
							$estadisticas["sexo_Indicaciones_Geograficas_M"] = $query_casos_MASCULINOS[$i]->count;
						} else if ($query_casos_MASCULINOS[$i]->tipo_prop_nombre == "Marcas") {
							$estadisticas["sexo_Marcas_M"] = $query_casos_MASCULINOS[$i]->count;
						} else if ($query_casos_MASCULINOS[$i]->tipo_prop_nombre == "Patentes") {
							$estadisticas["sexo_Patentes_M"] = $query_casos_MASCULINOS[$i]->count;
						} else {
							$estadisticas[$query_casos_MASCULINOS[$i]->tipo_prop_nombre] = $query_casos_MASCULINOS[$i]->count;
						}
					}
					//BUSCAMOS LOS CASOS ATENDIDOS POR PROPIEDAD INTELECTUAL GENERO FEMENINO
					$query_casos_FEMENINOS = $model->contarCasos_PI_FEMENINO($desde, $hasta);
					$estadisticas["sexo_Marcas_F"] = 0;
					$estadisticas["sexo_Patentes_F"] = 0;
					$estadisticas["sexo_DerechoAutor_F"] = 0;
					$estadisticas["sexo_Indicaciones_Geograficas_F"] = 0;
					for ($i = 0; $i < count($query_casos_FEMENINOS); $i++) {
						if ($query_casos_FEMENINOS[$i]->tipo_prop_nombre == "Derecho de Autor") {
							$estadisticas["sexo_DerechoAutor_F"] = $query_casos_FEMENINOS[$i]->count;
						} else if ($query_casos_FEMENINOS[$i]->tipo_prop_nombre == "Indicación Geográfica Protegida") {
							$estadisticas["sexo_Indicaciones_Geograficas_F"] = $query_casos_FEMENINOS[$i]->count;
						} else if ($query_casos_FEMENINOS[$i]->tipo_prop_nombre == "Marcas") {
							$estadisticas["sexo_Marcas_F"] = $query_casos_FEMENINOS[$i]->count;
						} else if ($query_casos_FEMENINOS[$i]->tipo_prop_nombre == "Patentes") {
							$estadisticas["sexo_Patentes_F"] = $query_casos_FEMENINOS[$i]->count;
						} else {
							$estadisticas[$query_casos_FEMENINOS[$i]->tipo_prop_nombre] = $query_casos_FEMENINOS[$i]->count;
						}
					}
					$fecha_desde = $desde;
					$fecha_hasta = $hasta; 
					
				
					// Fecha en formato YYYY-MM-DD
					// Formatear la fecha al formato dd-mm-yy
					$fecha_formateada_desde = date("d-m-Y", strtotime($fecha_desde));
					$fecha_formateada_hasta = date("d-m-Y", strtotime($fecha_hasta));
					$estadisticas["fecha_desde"] = $fecha_formateada_desde;
					$estadisticas["fecha_hasta"] = $fecha_formateada_hasta;
				}

				$fecha_desde = $desde;
				$fecha_hasta = $hasta; // Fecha en formato YYYY-MM-DD
				// Formatear la fecha al formato dd-mm-yy
				$fecha_formateada_desde = date("d-m-Y", strtotime($fecha_desde));
				$fecha_formateada_hasta = date("d-m-Y", strtotime($fecha_hasta));
				$estadisticas["fecha_desde"] = $fecha_formateada_desde;
				$estadisticas["fecha_hasta"] = $fecha_formateada_hasta;
				//Pasamos la tabla como parametro para la vista
				echo view('template/header');
				echo view('template/nav_bar');
				echo view('reportes/estadisticas/content.php', $estadisticas);
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
		$query = $model->consultar_estados($desde, $hasta);

			
			
			$estadisticas = array();
			if (!empty($query)) {
				for ($i = 0; $i < count($query); $i++) {
					if (is_array($estadisticas)) {

						array_push($estadisticas, $query[$i]);
					} else {
						$estadisticas["estadosnom"] = isset($estadisticas["estadosnom"]) ? $estadisticas["estadosnom"] + $query[$i]->estadonom : $query[$i]->estadonom;
					}
				}
			}
			$data =
				[
					'estadisticas' => $estadisticas
				];


			//BUSCAMOS LOS CASOS ABIERTOS POR ESTADOS
			$query_casosAbiertosEstadal = $model->ContarCasosAbiertosEstadal($desde, $hasta);
			$estadisticas_abiertas = array();
			if (!empty($query_casosAbiertosEstadal)) {
				for ($a = 0; $a < count($query_casosAbiertosEstadal); $a++) {
					if (is_array($estadisticas_abiertas)) {
						array_push($estadisticas_abiertas, $query_casosAbiertosEstadal[$a]);
					} else {
						$estadisticas_abiertas["estadosnom"] = isset($estadisticas_abiertas["estadosnom"]) ? $estadisticas_abiertas["estadosnom"] + $query_casosAbiertosEstadal[$a]->estadonom : $query_casosAbiertosEstadal[$a]->estadonom;
					}
				}
			}
			$data =
				[
					'estadisticas' => $estadisticas,
					'estadisticas_abiertas' => $estadisticas_abiertas

				];
			// //BUSCAMOS LOS CASOS CERRADOS POR ESTADOS
			$query_casosCerradosEstadal = $model->ContarCasosCerradosEstadal($desde, $hasta);
			$estadisticas_cerradas = array();
			if (!empty($query_casosCerradosEstadal)) {
				for ($a = 0; $a < count($query_casosCerradosEstadal); $a++) {
					if (is_array($estadisticas_cerradas)) {
						array_push($estadisticas_cerradas, $query_casosCerradosEstadal[$a]);
					} else {
						$estadisticas_cerradas["estadosnom"] = isset($estadisticas_cerradas["estadosnom"]) ? $estadisticas_cerradas["estadosnom"] + $query_casosCerradosEstadal[$a]->estadonom : $query_casosCerradosEstadal[$a]->estadonom;
					}
				}
			}
			$data =
				[
					'estadisticas' => $estadisticas,
					'estadisticas_abiertas' => $estadisticas_abiertas,
					'estadisticas_cerradas' => $estadisticas_cerradas
				];

			echo view('template/header');
			echo view('template/nav_bar');
			echo view('reportes/estadisticas/estadal/content.php', $data);
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
			$query = $model->consultar_estados($desde, $hasta);
			$estadisticas = array();
			if (!empty($query)) {
				for ($i = 0; $i < count($query); $i++) {
					if (is_array($estadisticas)) {

						array_push($estadisticas, $query[$i]);
					} else {
						$estadisticas["estadosnom"] = isset($estadisticas["estadosnom"]) ? $estadisticas["estadosnom"] + $query[$i]->estadonom : $query[$i]->estadonom;
					}
				}
			}
			$data =
				[
					'estadisticas' => $estadisticas
				];

			//BUSCAMOS LOS CASOS ESTADALES POR TIPO DE BENEFICIARIO USUARIO 
			$query_casos_usuarios = $model->ContarCasosUsuariosEstadal($desde, $hasta);
			$estadisticas_usuario = array();
			if (!empty($query_casos_usuarios)) {
				for ($a = 0; $a < count($query_casos_usuarios); $a++) {
					if (is_array($estadisticas_usuario)) {
						array_push($estadisticas_usuario, $query_casos_usuarios[$a]);
					} else {
						$estadisticas_usuario["estadosnom"] = isset($estadisticas_usuario["estadosnom"]) ? $estadisticas_usuario["estadosnom"] + $query_casos_usuarios[$a]->estadonom : $query_casos_usuarios[$a]->estadonom;
					}
				}
			}
			$data =
				[
					'estadisticas' => $estadisticas,
					'estadisticas_usuario' => $estadisticas_usuario
				];
			//BUSCAMOS LOS CASOS ESTADALES POR TIPO DE BENEFICIARIO EMRENDEDOR

			$query_casos_emprendedor = $model->ContarCasosEmprendedorEstadal($desde, $hasta);
			$estadisticas_emprendedor = array();
			if (!empty($query_casos_emprendedor)) {
				for ($a = 0; $a < count($query_casos_emprendedor); $a++) {
					if (is_array($estadisticas_emprendedor)) {
						array_push($estadisticas_emprendedor, $query_casos_emprendedor[$a]);
					} else {
						$estadisticas_emprendedor["estadosnom"] = isset($estadisticas_emprendedor["estadosnom"]) ? $estadisticas_emprendedor["estadosnom"] + $query_casos_emprendedor[$a]->estadonom : $query_casos_emprendedor[$a]->estadonom;
					}
				}
			}
			$data =
				[
					'estadisticas' => $estadisticas,
					'estadisticas_usuario' => $estadisticas_usuario,
					'estadisticas_emprendedor' => $estadisticas_emprendedor
				];
			echo view('template/header');
			echo view('template/nav_bar');
			echo view('reportes/estadisticas/tipo_beneficiario/content.php', $data);
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
			$query = $model->consultar_estados($desde, $hasta);
			$estadisticas = array();
			if (!empty($query)) {
				for ($i = 0; $i < count($query); $i++) {
					if (is_array($estadisticas)) {

						array_push($estadisticas, $query[$i]);
					} else {
						$estadisticas["estadosnom"] = isset($estadisticas["estadosnom"]) ? $estadisticas["estadosnom"] + $query[$i]->estadonom : $query[$i]->estadonom;
					}
				}
			}
			$data =
				[
					'estadisticas' => $estadisticas
				];
			
			//BUSCAMOS LOS CASOS ESTADALES DE PATENTES
			$query_casos_patentes = $model->ContarCasosPatentesEstadal($desde, $hasta);
			$estadisticas_patentes = array();
			if (!empty($query_casos_patentes)) {
				for ($a = 0; $a < count($query_casos_patentes); $a++) {
					if (is_array($estadisticas_patentes)) {
						array_push($estadisticas_patentes, $query_casos_patentes[$a]);
					} else {
						$estadisticas_patentes["estadosnom"] = isset($estadisticas_patentes["estadosnom"]) ? $estadisticas_patentes["estadosnom"] + $query_casos_patentes[$a]->estadonom : $query_casos_patentes[$a]->estadonom;
					}
				}
			}
			$data =
				[
					'estadisticas' => $estadisticas,
					'estadisticas_patentes' => $estadisticas_patentes
				];
			//BUSCAMOS LOS CASOS ESTADALES DE NO APLICA
			$query_casos_no_aplica = $model->ContarCasosNoAplicaEstadal($desde, $hasta);
			$estadisticas_no_aplica = array();
			if (!empty($query_casos_no_aplica)) {
				for ($a = 0; $a < count($query_casos_no_aplica); $a++) {
					if (is_array($estadisticas_no_aplica)) {
						array_push($estadisticas_no_aplica, $query_casos_no_aplica[$a]);
					} else {
						$estadisticas_no_aplica["estadosnom"] = isset($estadisticas_no_aplica["estadosnom"]) ? $estadisticas_no_aplica["estadosnom"] + $query_casos_no_aplica[$a]->estadonom : $query_casos_no_aplica[$a]->estadonom;
					}
				}
			}
			$data =
				[
					'estadisticas' => $estadisticas,
					'estadisticas_patentes' => $estadisticas_patentes,
					'estadisticas_no_aplica' => $estadisticas_no_aplica
				];

				

			//BUSCAMOS LOS CASOS ESTADALES DE DERECHO DE AUTOR	
			$query_casos_derecho_autor = $model->ContarCasosDerecho_AutorEstadal($desde, $hasta);

			$estadisticas_derecho_autor = array();
			if (!empty($query_casos_derecho_autor)) {
				for ($a = 0; $a < count($query_casos_derecho_autor); $a++) {
					if (is_array($estadisticas_derecho_autor)) {
						array_push($estadisticas_derecho_autor, $query_casos_derecho_autor[$a]);
					} else {
						$estadisticas_derecho_autor["estadosnom"] = isset($estadisticas_derecho_autor["estadosnom"]) ? $estadisticas_derecho_autor["estadosnom"] + $query_casos_derecho_autor[$a]->estadonom : $query_casos_derecho_autor[$a]->estadonom;
					}
				}
			}
			$data =
				[
					'estadisticas' => $estadisticas,
					'estadisticas_patentes' => $estadisticas_patentes,
					'estadisticas_no_aplica' => $estadisticas_no_aplica,
					'estadisticas_derecho_autor' => $estadisticas_derecho_autor
				];
			//BUSCAMOS LOS CASOS ESTADALES DE INDICACIONES GEOGRAFICAS
			$query_casos_indicaciones_geograficas = $model->ContarCasosIndicaciondesGeograficas($desde, $hasta);
			$estadisticas_indicaciones_geograficas = array();
			if (!empty($query_casos_indicaciones_geograficas)) {
				for ($a = 0; $a < count($query_casos_indicaciones_geograficas); $a++) {
					if (is_array($estadisticas_indicaciones_geograficas)) {
						array_push($estadisticas_indicaciones_geograficas, $query_casos_indicaciones_geograficas[$a]);
					} else {
						$estadisticas_indicaciones_geograficas["estadosnom"] = isset($estadisticas_indicaciones_geograficas["estadosnom"]) ? $estadisticas_indicaciones_geograficas["estadosnom"] + $query_casos_indicaciones_geograficas[$a]->estadonom : $query_casos_indicaciones_geograficas[$a]->estadonom;
					}
				}
			}
			$data =
				[
					'estadisticas' => $estadisticas,
					'estadisticas_patentes' => $estadisticas_patentes,
					'estadisticas_no_aplica' => $estadisticas_no_aplica,
					'estadisticas_derecho_autor' => $estadisticas_derecho_autor,
					'estadisticas_indicaciones_geograficas' => $estadisticas_indicaciones_geograficas
				];

				
			//BUSCAMOS LOS CASOS ESTADALES DE MARCAS
			
			$query_casos_marcas = $model->ContarCasosMarcas($desde, $hasta);
			
			$estadisticas_marcas = array();
			if (!empty($query_casos_marcas)) {
				for ($a = 0; $a < count($query_casos_marcas); $a++) {
					if (is_array($estadisticas_marcas)) {
						array_push($estadisticas_marcas, $query_casos_marcas[$a]);
					} else {
						$estadisticas_marcas["estadosnom"] = isset($estadisticas_marcas["estadosnom"]) ? $estadisticas_marcas["estadosnom"] + $query_casos_marcas[$a]->estadonom : $query_casos_marcas[$a]->estadonom;
					}
				}
			}
			$data =
				[
					'estadisticas' => $estadisticas,
					'estadisticas_patentes' => $estadisticas_patentes,
					'estadisticas_no_aplica' => $estadisticas_no_aplica,
					'estadisticas_derecho_autor' => $estadisticas_derecho_autor,
					'estadisticas_indicaciones_geograficas' => $estadisticas_indicaciones_geograficas,
					'estadisticas_marcas' => $estadisticas_marcas
				];
				
			echo view('template/header');
			echo view('template/nav_bar');
			echo view('reportes/estadisticas/propiedad_intelectual/content.php', $data);
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
			$query = $model->consultar_estados($desde, $hasta);
			$estadisticas = array();
			if (!empty($query)) {
				for ($i = 0; $i < count($query); $i++) {
					if (is_array($estadisticas)) {

						array_push($estadisticas, $query[$i]);
					} else {
						$estadisticas["estadosnom"] = isset($estadisticas["estadosnom"]) ? $estadisticas["estadosnom"] + $query[$i]->estadonom : $query[$i]->estadonom;
					}
				}
			}
			$data =
				[
					'estadisticas' => $estadisticas
				];
			//BUSCAMOS LOS CASOS ESTADALES DE ASESORIA
			$query_casos_asesoria = $model->ContarCasosAsesoriaEstadal($desde, $hasta);
			$estadisticas_asesoria = array();
			if (!empty($query_casos_asesoria)) {
				for ($a = 0; $a < count($query_casos_asesoria); $a++) {
					if (is_array($estadisticas_asesoria)) {
						array_push($estadisticas_asesoria, $query_casos_asesoria[$a]);
					} else {
						$estadisticas_asesoria["estadosnom"] = isset($estadisticas_asesoria["estadosnom"]) ? $estadisticas_asesoria["estadosnom"] + $query_casos_asesoria[$a]->estadonom : $query_casos_asesoria[$a]->estadonom;
					}
				}
			}
			$data =
				[
					'estadisticas' => $estadisticas,
					'estadisticas_asesoria' => $estadisticas_asesoria
				];
			//BUSCAMOS LOS CASOS ESTADALES DE SUGERENCIA 
			$query_casos_sugerencia = $model->ContarCasosSugerenciaEstadal($desde, $hasta);
			$estadisticas_sugerencia = array();
			if (!empty($query_casos_sugerencia)) {
				for ($a = 0; $a < count($query_casos_sugerencia); $a++) {
					if (is_array($estadisticas_sugerencia)) {
						array_push($estadisticas_sugerencia, $query_casos_sugerencia[$a]);
					} else {
						$estadisticas_sugerencia["estadosnom"] = isset($estadisticas_sugerencia["estadosnom"]) ? $estadisticas_sugerencia["estadosnom"] + $query_casos_sugerencia[$a]->estadonom : $query_casos_sugerencia[$a]->estadonom;
					}
				}
			}
			$data =
				[
					'estadisticas' => $estadisticas,
					'estadisticas_asesoria' => $estadisticas_asesoria,
					'estadisticas_sugerencia' => $estadisticas_sugerencia
				];
			//BUSCAMOS LOS CASOS ESTADALES POR QUEJA
			$query_casos_queja = $model->ContarCasosQuejaEstadal($desde, $hasta);
			$estadisticas_queja = array();
			if (!empty($query_casos_queja)) {
				for ($a = 0; $a < count($query_casos_queja); $a++) {
					if (is_array($estadisticas_queja)) {
						array_push($estadisticas_queja, $query_casos_queja[$a]);
					} else {
						$estadisticas_queja["estadosnom"] = isset($estadisticas_queja["estadosnom"]) ? $estadisticas_queja["estadosnom"] + $query_casos_queja[$a]->estadonom : $query_casos_queja[$a]->estadonom;
					}
				}
			}
			$data =
				[
					'estadisticas' => $estadisticas,
					'estadisticas_asesoria' => $estadisticas_asesoria,
					'estadisticas_sugerencia' => $estadisticas_sugerencia,
					'estadisticas_queja' => $estadisticas_queja
				];
			//BUSCAMOS LOS CASOS ESTADALES POR RECLAMO		
			$query_casos_reclamo = $model->ContarCasosReclamoEstadal($desde, $hasta);
			$estadisticas_reclamo = array();
			if (!empty($query_casos_reclamo)) {
				for ($a = 0; $a < count($query_casos_reclamo); $a++) {
					if (is_array($estadisticas_reclamo)) {
						array_push($estadisticas_reclamo, $query_casos_reclamo[$a]);
					} else {
						$estadisticas_reclamo["estadosnom"] = isset($estadisticas_reclamo["estadosnom"]) ? $estadisticas_reclamo["estadosnom"] + $query_casos_reclamo[$a]->estadonom : $query_casos_reclamo[$a]->estadonom;
					}
				}
			}
			$data =
				[
					'estadisticas' => $estadisticas,
					'estadisticas_asesoria' => $estadisticas_asesoria,
					'estadisticas_sugerencia' => $estadisticas_sugerencia,
					'estadisticas_queja' => $estadisticas_queja,
					'estadisticas_reclamo' => $estadisticas_reclamo
				];

			//BUSCAMOS LOS CASOS ESTADALES POR DENUNCIA		
			$query_casos_denuncia = $model->ContarCasosDenunciaEstadal($desde, $hasta);
			$estadisticas_denuncia = array();
			if (!empty($query_casos_denuncia)) {
				for ($a = 0; $a < count($query_casos_denuncia); $a++) {
					if (is_array($estadisticas_denuncia)) {
						array_push($estadisticas_denuncia, $query_casos_denuncia[$a]);
					} else {
						$estadisticas_denuncia["estadosnom"] = isset($estadisticas_denuncia["estadosnom"]) ? $estadisticas_denuncia["estadosnom"] + $query_casos_denuncia[$a]->estadonom : $query_casos_denuncia[$a]->estadonom;
					}
				}
			}
			$data =
				[
					'estadisticas' => $estadisticas,
					'estadisticas_asesoria' => $estadisticas_asesoria,
					'estadisticas_sugerencia' => $estadisticas_sugerencia,
					'estadisticas_queja' => $estadisticas_queja,
					'estadisticas_reclamo' => $estadisticas_reclamo,
					'estadisticas_denuncia' => $estadisticas_denuncia
				];

			//BUSCAMOS LOS CASOS ESTADALES POR PETICION	
			$query_casos_peticion = $model->ContarCasosPeticionEstadal($desde, $hasta);
			$estadisticas_peticion = array();
			if (!empty($query_casos_peticion)) {
				for ($a = 0; $a < count($query_casos_peticion); $a++) {
					if (is_array($estadisticas_peticion)) {
						array_push($estadisticas_peticion, $query_casos_peticion[$a]);
					} else {
						$estadisticas_peticion["estadosnom"] = isset($estadisticas_peticion["estadosnom"]) ? $estadisticas_peticion["estadosnom"] + $query_casos_peticion[$a]->estadonom : $query_casos_peticion[$a]->estadonom;
					}
				}
			}
			$data =
				[
					'estadisticas' => $estadisticas,
					'estadisticas_asesoria' => $estadisticas_asesoria,
					'estadisticas_sugerencia' => $estadisticas_sugerencia,
					'estadisticas_queja' => $estadisticas_queja,
					'estadisticas_reclamo' => $estadisticas_reclamo,
					'estadisticas_denuncia' => $estadisticas_denuncia,
					'estadisticas_peticion' => $estadisticas_peticion
				];
			echo view('template/header');
			echo view('template/nav_bar');
			echo view('reportes/estadisticas/tipo_atencion/content.php', $data);
			echo view('template/footer');
			echo view('reportes/estadisticas/tipo_atencion/footer.php');
		} else {
			return redirect()->to('/');
		}
	}
	public function Listar_Casos_Municipios()
	{
		$model = new Casos();
		$casos = $model->Listar_Casos_Municipios();  
		
		// Inicializar un array para almacenar los resultados
		$resultados = [];
	
		// Procesar cada caso
		$index = 1;
		foreach ($casos as $caso) {
			// Verificar que el caso tenga las propiedades necesarias
			if (!isset($caso->estadoid,$caso->municipioid, $caso->municipionom, $caso->casos, $caso->tipo_aten_nombre)) {
				continue; // O manejar el error de otra manera
			}
			$estado = $caso->estadonom;
			$estadoid = $caso->estadoid;
			$municipioId = $caso->municipioid;
			$municipio = $caso->municipionom;
			$casos = (int)$caso->casos;
		
			// Inicializar el municipio si no existe en el array de resultados
			if (!isset($resultados[$index])) {
				$resultados[$index] = [
					'ID_estado' => $estadoid,
					'estado' => $estado,
					'ID_municipio' => $municipioId,
					'municipio' => $municipio,
					'Asesoría' => 0,
					'Sugerencia' => 0,
					'Queja' => 0,
					'Reclamo' => 0,
					'Denuncia' => 0,
					'Petición' => 0,
					'Talleres' => 0,
					'total_atencion' => 0,
				];
			}
	
			
			// Clasificar los casos en los diferentes tipos de atención
			switch ($caso->tipo_aten_nombre) {
				case 'Asesoría':
					$resultados[$index]['Asesoría'] += $casos;
					break;
				case 'Sugerencia':
					$resultados[$index]['Sugerencia'] += $casos;
					break;
				case 'Queja':
					$resultados[$index]['Queja'] += $casos;
					break;
				case 'Reclamo':
					$resultados[$index]['Reclamo'] += $casos;
					break;
				case 'Denuncia':
					$resultados[$index]['Denuncia'] += $casos;
					break;
				case 'Petición':
					$resultados[$index]['Petición'] += $casos;
					break;
				case 'Talleres':
					$resultados[$index]['Talleres'] += $casos;
					break;
			}
	
			// Actualizar el total de atenciones
			$resultados[$index]['total_atencion'] += $casos;
			$index++;
		}
	
		// Retornar el array de resultados en formato JSON
		header('Content-Type: application/json; charset=utf-8');
		echo json_encode($resultados, JSON_UNESCAPED_UNICODE);

		
	}



	public function Listar_Casos_Estados()
	{
		$model = new Casos();
		$casos = $model->Listar_Casos_Estados();  
		
		// Inicializar un array para almacenar los resultados
		$resultados = [];
	
		// Procesar cada caso
		foreach ($casos as $caso) {
			// Verificar que el caso tenga las propiedades necesarias
			if (!isset($caso->estadoid, $caso->estadonom, $caso->casos, $caso->tipo_aten_nombre)) {
				continue; // O manejar el error de otra manera
			}
			$estado = $caso->estadonom;
			$estadoid = $caso->estadoid;
			$casos = (int)$caso->casos;
	
			// Inicializar el municipio si no existe en el array de resultados
			if (!isset($resultados[$estadoid])) {
				$resultados[$estadoid] = [
					'ID_estado' => $estadoid,
					'estado' => $estado,
					'Asesoría' => 0,
					'Sugerencia' => 0,
					'Queja' => 0,
					'Reclamo' => 0,
					'Denuncia' => 0,
					'Petición' => 0,
					'Talleres' => 0,
					'total_atencion' => 0,
				];
			}
			// Clasificar los casos en los diferentes tipos de atención
			switch ($caso->tipo_aten_nombre) {
				case 'Asesoría':
					$resultados[$estadoid]['Asesoría'] += $casos;
					break;
				case 'Sugerencia':
					$resultados[$estadoid]['Sugerencia'] += $casos;
					break;
				case 'Queja':
					$resultados[$estadoid]['Queja'] += $casos;
					break;
				case 'Reclamo':
					$resultados[$estadoid]['Reclamo'] += $casos;
					break;
				case 'Denuncia':
					$resultados[$estadoid]['Denuncia'] += $casos;
					break;
				case 'Petición':
					$resultados[$estadoid]['Petición'] += $casos;
					break;
				case 'Talleres':
					$resultados[$estadoid]['Talleres'] += $casos;
					break;
			}
	
			// Actualizar el total de atenciones
			$resultados[$estadoid]['total_atencion'] += $casos;
		}
	
		// Retornar el array de resultados en formato JSON
		header('Content-Type: application/json; charset=utf-8');
		echo json_encode($resultados, JSON_UNESCAPED_UNICODE);

		
	}


	public function vista_estadisticas2()
	{
		echo view('template/header');
		echo view('template/nav_bar');
		echo view('reportes/estadisticas/prueba.php');
		echo view('template/footer');
		echo view('reportes/estadisticas/footer.php');
	}
}
