<?php

namespace App\Controllers;

use App\Models\Pdf_Model;
use CodeIgniter\API\ResponseTrait;




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
		$query_pdf = $model->obtenerCasos($idcaso);
		foreach ($query_pdf as $tipoatencion) {
			$datos_tipoatencion['id_tipo_atencion']         = $tipoatencion->id_tipo_atencion;
		}
		// Cargar la biblioteca FPDF
		$pdf = new \FPDF('P', 'mm', 'letter');
		$pdf->AddPage();
		if ($datos_tipoatencion['id_tipo_atencion'] == 1) {
			$pdf->Header_Asesoria($datos_tipoatencion);
		} else {
			$pdf->Header_planilla($datos_tipoatencion);
		}
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
				//$ente_nombre = $query_pdf->ente_nombre;
				$pdf->SetXY(40, 71);
				$pdf->Cell(10, 5, $caso, 0, 0, 'L');
				$pdf->SetXY(96, 71);
				$pdf->Cell(20, 5, $fecha_caso, 0, 0, 'C');
				$pdf->SetXY(155, 71);
				$pdf->Cell(20, 5, $caso_hora, 0, 0, 'C');
				$pdf->SetXY(40, 90);
				$pdf->Cell(60, 5, $nombre, 0, 0, 'C');
				$pdf->SetXY(24, 99);
				$pdf->Cell(20, 5, $cedula, 0, 0, 'C');
				$pdf->SetXY(75, 99);
				$pdf->Cell(90, 5, $direccion, 0, 0, 'L');
				$pdf->SetXY(25, 108);
				$pdf->Cell(20, 5, $municipionom, 0, 0, 'C');
				$pdf->SetXY(25, 108);
				$pdf->Cell(130, 5, $parroquianom, 0, 0, 'C');
				$pdf->SetXY(133, 108);
				$pdf->Cell(20, 5, $casotel, 0, 0, 'C');
				$pdf->SetXY(42, 117);
				$pdf->Cell(90, 5, $correo, 0, 0, 'L');
				//$pdf->SetXY(33, 127);
				//$pdf->Cell(90, 5, $ente_nombre, 0, 0, 'L');
				$datos_Content_Planilla['casodesc']         = $query_pdf->casodesc;
				$datos_Content_Planilla['user_name']        = $query_pdf->user_name;
			}
		}
		$pdf->Content_planilla($datos_Content_Planilla);
		$pdf->SetMargins(10, 10);
		$pdf->SetAutoPageBreak(true, 20);
		$pdf->Footer_Planilla();
		$this->response->setHeader('Content-Type', 'application/pdf');
		$pdf->Output("salidas_pdf.pdf", "I");
	}
}
