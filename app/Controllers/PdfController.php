<?php

namespace App\Controllers;

use App\Models\Pdf_Model;
use CodeIgniter\API\ResponseTrait;
use App\Models\Casos_denuncias_Model;



use CodeIgniter\RESTful\ResourceController;
use VARIANT;

class PdfController extends BaseController
{
	use ResponseTrait;


	/*
      * Función parar cargar los registros del Módulo en el Data Table o en las Persianas
      */

	public function generar_pdf($idcaso = null)
	{
		$model = new Pdf_Model();
		$model_denuncias = new Casos_denuncias_Model();
		$query_tipo_atencion = $model->obtenerCasos($idcaso);
		$query_pdf = $model->obtenerCasos($idcaso);
		foreach ($query_tipo_atencion as $tipoatencion) {
			$datos_tipoatencion['id_tipo_atencion']         = $tipoatencion->id_tipo_atencion;
		}

		// Cargar la biblioteca FPDF
		$pdf = new \FPDF('P', 'mm', 'letter');
		$pdf->AddPage();
		if ($datos_tipoatencion['id_tipo_atencion'] == 1) {
			$pdf->Header_Asesoria($datos_tipoatencion);
			if (empty($query_pdf)) {
				$pdf->cell(196, 5, utf8_decode('Sin Información Coincidente'), 1, 1, 'C', 1);
			} else {
				foreach ($query_pdf as $query_pdf) {
					$caso = $query_pdf->idcaso;
					$fecha_caso = $query_pdf->casofec;
					$nombre = $query_pdf->nombre;
					$cedula = $query_pdf->cedula;
					$caso_hora = $query_pdf->caso_hora;
					$direccion = $query_pdf->direccion;
					$correo = $query_pdf->correo;
					$casotel = $query_pdf->casotel;
					$municipionom = $query_pdf->municipionom;
					$parroquianom = $query_pdf->parroquianom;
					$ente_nombre = $query_pdf->ente_nombre;
					$pdf->SetXY(40, 63);
					$pdf->Cell(10, 5, $caso, 0, 0, 'L');
					$pdf->SetXY(96, 63);
					$pdf->Cell(20, 5, $fecha_caso, 0, 0, 'C');
					$pdf->SetXY(155, 63);
					$pdf->Cell(20, 5, $caso_hora, 0, 0, 'C');
					$pdf->SetXY(42, 83);
					$pdf->Cell(60, 5, iconv("UTF-8", "CP1252", $nombre), 0, 0, 'C');
					$pdf->SetXY(135, 90);
					$pdf->Cell(20, -10, $cedula, 0, 0, 'C');
					$pdf->SetXY(75, 99);
					//$pdf->Cell(90, -10, $direccion, 0, 0, 'L');
					$pdf->SetXY(27, 99);
					$pdf->Cell(20, -10, iconv("UTF-8", "CP1252", $municipionom), 0, 0, 'C');
					$pdf->SetXY(27, 99);
					$pdf->Cell(130, -10, iconv("UTF-8", "CP1252", $parroquianom), 0, 0, 'C');
					$pdf->SetXY(133, 98);
					$pdf->Cell(20, -10, $casotel, 0, 0, 'C');
					$pdf->SetXY(42, 108);
					$pdf->Cell(90, -10, $correo, 0, 0, 'L');
					$pdf->SetXY(33, 124);
					$pdf->Cell(90, 5 - 10, $ente_nombre, 0, 0, 'L');
					$datos_Content_Planilla['casodesc']         = $query_pdf->casodesc;
					$datos_Content_Planilla['user_name']        = $query_pdf->user_name;
					$datos_Content_Planilla['competencia_cgr']  = $query_pdf->competencia_cgr;
					$datos_Content_Planilla['asume_cgr']        = $query_pdf->asume_cgr;
					$datos_Content_Planilla['usercargo']        = $query_pdf->usercargo;
				}
				$pdf->Content_Asesoria($datos_Content_Planilla);
				$pdf->SetMargins(10, 10);
				$pdf->SetAutoPageBreak(true, 10);
				$pdf->Footer_Planilla();
				$this->response->setHeader('Content-Type', 'application/pdf');
				$pdf->Output("SIAC.pdf", "I");
			}
		} else if ($datos_tipoatencion['id_tipo_atencion'] == 5) {
			$pdf->Header_Denuncia($datos_tipoatencion);
			foreach ($query_pdf as $query_pdf) {
				$caso = $query_pdf->idcaso;
				$fecha_caso = $query_pdf->casofec;
				$nombre = $query_pdf->nombre;
				$cedula = $query_pdf->cedula;
				$caso_hora = $query_pdf->caso_hora;
				$direccion = $query_pdf->direccion;
				$correo = $query_pdf->correo;
				$casotel = $query_pdf->casotel;
				$municipionom = $query_pdf->municipionom;
				$parroquianom = $query_pdf->parroquianom;
				$pdf->SetXY(40, 71);
				$pdf->Cell(10, -11, $caso, 0, 0, 'L');
				$pdf->SetXY(96, 63);
				$pdf->Cell(20, 5, $fecha_caso, 0, 0, 'C');
				$pdf->SetXY(155, 71);
				$pdf->Cell(20, -11, $caso_hora, 0, 0, 'C');
				$pdf->SetXY(35, 90);
				$pdf->Cell(60, -10, iconv("UTF-8", "CP1252", $nombre), 0, 0, 'C');
				$pdf->SetXY(24, 99);
				$pdf->Cell(235, -27, $cedula, 0, 0, 'C');
		
				$pdf->SetXY(25, 99);
				$pdf->Cell(20, -10, iconv("UTF-8", "CP1252", $municipionom), 0, 0, 'C');
				$pdf->SetXY(26, 99);
				$pdf->Cell(130, -10, iconv("UTF-8", "CP1252", $parroquianom), 0, 0, 'C');
				$pdf->SetXY(133, 99);
				$pdf->Cell(20, -10, $casotel, 0, 0, 'C');
				$pdf->SetXY(42, 117);
				$pdf->Cell(90, -27, $correo, 0, 0, 'L');
				$datos_Content_Planilla['casodesc']         = $query_pdf->casodesc;
				$datos_Content_Planilla['user_name']        = $query_pdf->user_name;
			}
			$query_info_denuncia = $model_denuncias->info_denuncias($idcaso);


			foreach ($query_info_denuncia as $info_denuncia) {
				$datos_Content_Planilla['denu_afecta_persona']         = $info_denuncia->denu_afecta_persona;
				$datos_Content_Planilla['denu_afecta_comunidad']        = $info_denuncia->denu_afecta_comunidad;
				$datos_Content_Planilla['denu_afecta_terceros']        = $info_denuncia->denu_afecta_terceros;
				$datos_Content_Planilla['usercargo']        = $query_pdf->usercargo;
				$denu_fecha_hechos = $info_denuncia->denu_fecha_hechos;
				$denu_instancia_popular = $info_denuncia->denu_instancia_popular;
				$denu_rif_instancia = $info_denuncia->denu_rif_instancia;
				$denu_ente_financiador = $info_denuncia->denu_ente_financiador;
				$denu_nombre_proyecto = $info_denuncia->denu_nombre_proyecto;
				$denu_monto_aprovado = $info_denuncia->denu_monto_aprovado;
				$denu_involucrados = $info_denuncia->denu_involucrados;
				$pdf->SetXY(10, 126);
				$pdf->MultiCell(195, 5, iconv('utf-8', 'cp1252', $denu_involucrados), 0, 1, 'LRT', 'J', 0);
				$pdf->Cell(64, 5, '3- Fecha en que ocurrieron los hechos : ', 0, 0, 'L', 0);
				$pdf->Cell(18, 5, $denu_fecha_hechos, 1, 1, 'C');
				$pdf->Ln(3);
				$pdf->Cell(190, 5, iconv('utf-8', 'cp1252', 'EN CASO DE TRATARSE DE UNA INSTANCIA DEL PODER POPULAR INDIQUE  :'), 1, 1, 'C', 'C');
				$pdf->Ln(2);
				$pdf->Cell(50, 5, ' 4- Nombre de la instancia del Poder Popular : ', 0, 0, 'L', 0);
				$pdf->Cell(80, 5, $denu_instancia_popular, 0, 1, 'C');
				$pdf->Ln(2);
				$pdf->Cell(15, 5, ' 5- RIF : ', 0, 0, 'L', 0);
				$pdf->Cell(30, 5, $denu_rif_instancia, 0, 0, 'L');
				$pdf->Cell(35, 5, ' 6- Ente Financiador : ', 0, 0, 'L', 0);
				$pdf->Cell(30, 5, $denu_ente_financiador, 0, 1, 'L');
				$pdf->Ln(2);
				$pdf->Cell(40, 5, ' 7- Nombre del proyecto : ', 0, 0, 'L', 0);
				$pdf->Cell(60, 5, $denu_nombre_proyecto, 0, 0, 'L');
				$pdf->Cell(35, 5, ' 8- Monto Aprobado : ', 0, 0, 'L', 0);
				$pdf->Cell(30, 5, $denu_monto_aprovado, 0, 0, 'L');
				$pdf->Ln(7);
				$pdf->Cell(190, 5, iconv('utf-8', 'cp1252', 'BREVE DESCRIPCIÓN DE LA DENUNCIA :'), 1, 1, 'C', 'C');
				$descripcion_casodesc = iconv('utf-8', 'cp1252', $datos_Content_Planilla['casodesc']);
				$pdf->Ln(2);
				$pdf->MultiCell(195, 5, trim($descripcion_casodesc), 0, 1, 'LRT', 'J', 0);
				$pdf->Ln(3);
				$pdf->Cell(156, 5, 'Anexa documentos :     SI: ________ No ________ Original: _______ Copias: _______ Paginas: _______:', 0, 1, 'C', 'L');
				$pdf->Ln(2);
				$pdf->Cell(50, 9, 'Receptor: ' . '  ' . '   ' . $datos_Content_Planilla['user_name'], '  ', 0, 0, 'L', 'L');
				$pdf->Cell(50, 5, ' ', 0, 0, 'L', 0);
				$pdf->Cell(59, 9, 'Cargo: ' . '  ' . '   ' . $datos_Content_Planilla['usercargo'], '  ', 0, 0, 'L', 'L');
				$pdf->Ln(10);
				$pdf->Cell(64, 9, 'Fecha: ______________________________', 0, 0, 'C', 'L');
				$pdf->Cell(60, 9, '  ', 0, 0, 'C', 'L');
				$pdf->Cell(60, 9, 'Firma: ______________________________', 0, 0, 'C', 'L');
				$pdf->Ln(12);
				$pdf->MultiCell(190, 5, iconv('utf-8', 'cp1252', 'IMPORTANTE: SI LA DENUNCIA RESULTARE FALSA E INFUNDIDA O VERSARE SOBRE HECHOS QUE NO MERITEN AVERIGUACIÓN O CUYA SUSTANCIACIÓN NO CORRESPONDA A ESTA CONTRALORÍA SE PROCEDERÁ A DEJAR CONSTANCIA MEDIANTE AUTO EXPRESO. :'), 0, 1, 'C', 'C');
			}
			$pdf->Content_Denuncia($datos_Content_Planilla);
			$pdf->SetMargins(10, 10);
			$pdf->SetAutoPageBreak(true, 10);
			$pdf->Footer_Planilla();
			$this->response->setHeader('Content-Type', 'application/pdf');
			$pdf->Output("SIAC.pdf", "I");
		} else {
			$pdf->Header_Planilla($datos_tipoatencion);
			foreach ($query_pdf as $query_pdf) {
				$caso = $query_pdf->idcaso;
				$fecha_caso = $query_pdf->casofec;
				$nombre = $query_pdf->nombre;
				$cedula = $query_pdf->cedula;
				$caso_hora = $query_pdf->caso_hora;
				$direccion = $query_pdf->direccion;
				$correo = $query_pdf->correo;
				$casotel = $query_pdf->casotel;
				$municipionom = $query_pdf->municipionom;
				$parroquianom = $query_pdf->parroquianom;
				$pdf->SetXY(25, 63);
				$pdf->Cell(10, 5, $caso, 0, 0, 'L');
				$pdf->SetXY(58, 63);
				$pdf->Cell(20, 5, $fecha_caso, 0, 0, 'C');
				$pdf->SetXY(155, 71);
				$pdf->Cell(-108, -10, $caso_hora, 0, 0, 'C');
				$pdf->SetXY(60, 82);
				$pdf->Cell(29, 5, iconv('utf-8', 'cp1252', $nombre), 0, 0, 'C');
				$pdf->SetXY(125, 90);
				$pdf->Cell(20, -10, $cedula, 0, 0, 'C');
				$pdf->SetXY(75, 99);
				//$pdf->Cell(90, -10, $direccion, 0, 0, 'L');
				$pdf->SetXY(30, 99);
				$pdf->Cell(20, -10, iconv("UTF-8", "CP1252", $municipionom), 0, 0, 'C');
				$pdf->SetXY(25, 99);
				$pdf->Cell(130, -10, iconv("UTF-8", "CP1252", $parroquianom), 0, 0, 'C');
				$pdf->SetXY(133, 99);
				$pdf->Cell(20, -10, $casotel, 0, 0, 'C');
				$pdf->SetXY(42, 117);
				$pdf->Cell(90, -27, $correo, 0, 0, 'L');

				$datos_Content_Planilla['casodesc']         = $query_pdf->casodesc;
				$datos_Content_Planilla['user_name']        = $query_pdf->user_name;
				$datos_Content_Planilla['usercargo']        = $query_pdf->usercargo;
			}
			$pdf->Content_planilla($datos_Content_Planilla);
			$pdf->SetMargins(10, 10);
			$pdf->SetAutoPageBreak(true, 10);
			$pdf->Footer_Planilla();
			$this->response->setHeader('Content-Type', 'application/pdf');
			$pdf->Output("SIAC.pdf", "I");
		}
	}
}
