<?php

namespace App\Controllers;

use App\Models\Pdf_Model;
use CodeIgniter\API\ResponseTrait;
use App\Models\Casos_denuncias_Model;
use App\Models\Mediacion;
use CodeIgniter\RESTful\ResourceController;
use App\Models\Tipo_Beneficiario_Model;
use App\Models\Organismo_pp_Model;

class PdfController extends BaseController
{
    use ResponseTrait;


public function generar_plantilla_formacion($idcaso = null)
{
    $model = new Pdf_Model();
    $tipoBeneficiarioModel = new Tipo_Beneficiario_Model();
    $organismoModel = new Organismo_pp_Model();
    $query_pdf = $model->obtenerCasos($idcaso);

    if (empty($query_pdf)) {
        return $this->failNotFound('No se encontró información para el caso.');
    }

    $row = (is_array($query_pdf)) ? $query_pdf[0] : $query_pdf;
    $tipos = $tipoBeneficiarioModel->Listar_Tipo_Beneficiarios_filtro();
    $organismos = $organismoModel->Listar_Organismo_PP_filtro();

    // Configuración A4 Horizontal (297mm x 210mm)
    $pdf = new \FPDF('L', 'mm', 'letter');
    $pdf->AliasNbPages(); 
    $pdf->SetMargins(10, 10, 10);
    
    // Margen para que el footer respire
    $pdf->SetAutoPageBreak(true, 23); 

    $info_pdf = [
        'caso'         => $row->idcaso,
        'fecha_caso'   => $row->casofec,
        'nombre'       => $row->nombre,
        'cedula'       => $row->cedula,
        'estadonom'    => mb_strtoupper($row->estadonom ?? 'N/P'),
        'municipionom' => mb_strtoupper($row->municipionom ?? 'N/P'),
        'parroquianom' => mb_strtoupper($row->parroquianom ?? 'N/P'),
        'casotel'      => $row->casotel,
        'casodesc'     => $row->casodesc,
    ];

    // Asignación de datos a las propiedades de la clase para que Header y Footer tengan acceso
    $pdf->info_pdf_header = $info_pdf; 
    $pdf->tipos_footer = $tipos; 
    $pdf->tipos_organismos_footer = $organismos; // <--- AGREGAR ESTA LÍNEA

    $pdf->AddPage(); 
    $pdf->Content_Formacion($info_pdf, $tipos, $organismos);

    $this->response->setHeader('Content-Type', 'application/pdf');
    $pdf->Output("I", "Lista_Asistencia_{$row->idcaso}.pdf");
    exit();
}
    public function generar_pdf($idcaso = null)
    {
        $model = new Pdf_Model();
        $model_denuncias = new Casos_denuncias_Model();
        
        $query_pdf = $model->obtenerCasos($idcaso);

        if (empty($query_pdf)) {
            return $this->failNotFound('No se encontró información para el caso.');
        }

        $row = (is_array($query_pdf)) ? $query_pdf[0] : $query_pdf;
        $id_tipo_atencion = $row->id_tipo_atencion;

        // Inicializamos FPDF
        $pdf = new \FPDF('P', 'mm', 'letter');
        $pdf->SetMargins(10, 10, 10);
        $pdf->SetAutoPageBreak(false);

        // Color Azul SAPI para Títulos
        $azul_sapi = [25, 55, 90];

        // --- 1. ASESORÍA ---
        if ($id_tipo_atencion == 1) {
            $pdf->AddPage();
            $info_pdf = [
                'caso'         => $row->idcaso,
                'fecha_caso'   => $row->casofec,
                'caso_hora'    => $row->caso_hora,
                'nombre'       => $row->nombre,
                'cedula'       => $row->cedula,
                'estadonom' => $row->estadonom,
                'municipionom' => $row->municipionom,
                'parroquianom' => $row->parroquianom,
                'casotel'      => $row->casotel,
                'correo'       => $row->correo,
                'ente'         => $row->ente_nombre,
                'casodesc'     => $row->casodesc,
                'user_name'    => $row->user_name,
                'usercargo'    => $row->usercargo
            ];
            $pdf->Header_Asesoria($info_pdf); 
            $pdf->Content_Asesoria($info_pdf);
            $pdf->Footer_Planilla();
        }

     // --- 5. DENUNCIA ---
else if ($id_tipo_atencion == 5) {
    $pdf->AddPage();
    $query_info_denuncia = $model_denuncias->info_denuncias($row->idcaso);
    $info_d = $query_info_denuncia[0] ?? null;

    // Cabecera principal
    $pdf->Header_Denuncia((array)$row); 

    // Checkboxes (Sección 1 y 2)
    $pdf->Content_Denuncia([
        'denu_afecta_persona'   => $info_d->denu_afecta_persona ?? 'f', 
        'denu_afecta_comunidad' => $info_d->denu_afecta_comunidad ?? 'f', 
        'denu_afecta_terceros'  => $info_d->denu_afecta_terceros ?? 'f'
    ]);

    // Cuadro Involucrados (Compacto)
    $pdf->SetTextColor(0, 0, 0);
    $pdf->SetFont('Arial', '', 8);
    $involucrados = $info_d->denu_involucrados ?? 'N/A';
    $pdf->MultiCell(190, 4, iconv('UTF-8', 'CP1252', $involucrados), 1, 'J');

    // Sección 3: Fecha
    $pdf->Ln(2);
    $pdf->SetFont('Arial', 'B', 8);
    $pdf->SetTextColor(25, 55, 90);
    $pdf->Cell(45, 5, iconv('UTF-8', 'CP1252', '3- FECHA DE LOS HECHOS: '), 0, 0, 'L');
    $pdf->SetTextColor(0, 0, 0);
    $pdf->SetFont('Arial', '', 8);
    $pdf->Cell(30, 5, ($info_d->denu_fecha_hechos ?? 'N/A'), 'B', 1, 'L');

    // Poder Popular (Compacto)
    $pdf->Ln(2);
    $pdf->SetFillColor(25, 55, 90);
    $pdf->SetTextColor(255, 255, 255);
    $pdf->SetFont('Arial', 'B', 8);
    $pdf->Cell(190, 5, iconv('UTF-8', 'CP1252', 'DATOS DEL PODER POPULAR'), 1, 1, 'C', true);
    
    $pdf->SetTextColor(0, 0, 0);
    $pdf->SetFont('Arial', '', 7);
    $pdf->Cell(95, 5, iconv('UTF-8', 'CP1252', '  Instancia: ') . iconv('UTF-8', 'CP1252', $info_d->denu_instancia_popular ?? 'N/A'), 'LRB', 0, 'L');
    $pdf->Cell(95, 5, '  RIF: ' . ($info_d->denu_rif_instancia ?? 'N/A'), 'RB', 1, 'L');
    $pdf->Cell(95, 5, iconv('UTF-8', 'CP1252', '  Ente: ') . iconv('UTF-8', 'CP1252', $info_d->denu_ente_financiador ?? 'N/A'), 'LRB', 0, 'L');
    $pdf->Cell(95, 5, '  Monto: ' . ($info_d->denu_monto_aprovado ?? '0.00'), 'RB', 1, 'L');

    // Descripción
    $pdf->Ln(2);
    $pdf->SetFont('Arial', 'B', 8);
    $pdf->SetTextColor(25, 55, 90);
    $pdf->Cell(190, 5, iconv('UTF-8', 'CP1252', 'BREVE DESCRIPCIÓN DE LA DENUNCIA:'), 0, 1, 'L');
    
    $pdf->SetTextColor(0, 0, 0);
    $pdf->SetFont('Arial', '', 7);
    // Limitamos la altura de la descripción para evitar que empuje el footer
    $pdf->MultiCell(190, 3.5, iconv('UTF-8', 'CP1252', $row->casodesc), 1, 'J');

    // --- SECCIÓN FIRMAS (FIJA) ---
    // Usamos 230 para asegurar que no toque el borde de seguridad de la página
     $pdf->Ln(40);
   $pdf->SetFont('Arial', 'B', 7);

// Ajusta el primer número (20) para moverlo más o menos a la derecha
$pdf->Cell(20, 4, '', 0, 0); 

// Reducimos un poco el ancho de las celdas (de 90 a 80) para que no se desborden por el margen derecho
$pdf->Cell(110, 4, 'RECEPTOR: ' . iconv('UTF-8', 'CP1252', $row->user_name), 0, 0, 'L');
$pdf->Cell(80, 4, 'CARGO: ' . iconv('UTF-8', 'CP1252', $row->usercargo), 0, 1, 'L');
$pdf->Ln(15); // Un poco más de espacio para la firma

// 2. LÍNEAS DE FIRMA: Centradas en sus respectivas columnas de 95
$pdf->Cell(95, 4, '__________________________', 0, 0, 'C');
$pdf->Cell(95, 4, '__________________________', 0, 1, 'C');

// 3. ETIQUETAS: Centradas exactamente debajo de las líneas
$pdf->Cell(95, 4, 'FECHA', 0, 0, 'C');
$pdf->Cell(95, 4, 'FIRMA DEL SOLICITANTE', 0, 1, 'C');
    // El Footer_Planilla ya no debería saltar de página
    $pdf->Footer_Planilla();
}

        // --- 23. MEDIACIÓN ---
        else if ($id_tipo_atencion == 23) {
            $pdf->AddPage();
            $mediacion_model = new \App\Models\Mediacion();
            $info_mediacion = $mediacion_model->buscar_Info_Mediacion($row->idcaso);
            $datos_m = $info_mediacion[0] ?? (object)[]; 

            $formarUbicacion = function($p, $e, $m, $pa) {
                $partes = array_filter([trim($p ?? ''), trim($e ?? ''), $m ? "Mun. $m" : "", $pa ? "Parr. $pa" : ""]);
                return empty($partes) ? 'N/A' : implode(' / ', $partes);
            };

            $datos_para_planilla = [
                'caso'             => $row->idcaso,
                'fecha_caso'       => $row->casofec,
                'casodesc'         => $row->casodesc,
                'user_name'        => $row->user_name, 
                'tipo_prop_nombre' => $row->tipo_prop_nombre,
                'A_nombre'         => $row->nombre,
                'A_cedula'         => $row->cedula,
                'A_telefono'       => $row->casotel,
                'A_correo'         => $row->correo, 
                'A_ubicacion_completa' => $formarUbicacion($row->paisnom, $row->estadonom, $row->municipionom, $row->parroquianom),
                'B_nombre'   => $datos_m->nombre_apo_sol ?? '',
                'B_CI'       => $datos_m->id_apo_sol ?? '',
                'B_IMPRE'    => $datos_m->impre_abogado_apo_sol ?? '',
                'B_telefono' => $datos_m->telefono_apo_sol ?? '',
                'B_correo'   => $datos_m->correo_apo_sol ?? '',
                'B_direccion'=> $datos_m->direccion_apo_sol ?? '',
                'B_ubicacion_completa' => $formarUbicacion($datos_m->pais_apo_sol ?? '', $datos_m->estado_apo_sol ?? '', $datos_m->municipio_apo_sol ?? '', $datos_m->parroquia_apo_sol ?? ''),
                'C_nombre'   => $datos_m->nombre_contra ?? '',
                'C_CI_RIF'   => ($datos_m->tipo_per_contra ?? '').($datos_m->id_contra ?? ''),
                'C_telefono' => $datos_m->telefono_contra ?? '',
                'C_correo'   => $datos_m->correo_contra ?? '',
                'C_direccion'=> $datos_m->direccion_contra ?? '',
                'C_ubicacion_completa' => $formarUbicacion($datos_m->pais_contra ?? '', $datos_m->estado_contra ?? '', $datos_m->municipio_contra ?? '', $datos_m->parroquia_contra ?? ''),
                'D_nombre'   => $datos_m->nombre_apo_contra ?? '',
                'D_CI'       => $datos_m->id_apo_contra ?? '', 
                'D_IMPRE'    => $datos_m->impre_abogado_apo_contra ?? '',
                'D_telefono' => $datos_m->telefono_apo_contra ?? '',
                'D_correo'   => $datos_m->correo_apo_contra ?? '',
                'D_direccion'=> $datos_m->direccion_apo_contra ?? '',
                'D_ubicacion_completa' => $formarUbicacion($datos_m->pais_apo_contra ?? '', $datos_m->estado_apo_contra ?? '', $datos_m->municipio_apo_contra ?? '', $datos_m->parroquia_apo_contra ?? ''),
            ];

            $pdf->Content_Planilla_SAPI($datos_para_planilla); 
            $pdf->Footer_Mediacion();
        }

        //NO BORRAR NUEVA PLANTILLA DE MEDIACION

        
       else if($id_tipo_atencion == 7)
        {
                $talleres_model = new \App\Models\Talleres_Participantes_Model();
                $participantes = $talleres_model->getParticipantesPorCaso($row->idcaso);
                $row->participantes = $participantes;

             
                $model = new Pdf_Model();
                $tipoBeneficiarioModel = new Tipo_Beneficiario_Model();
                $organismoModel = new Organismo_pp_Model();
                $query_pdf = $model->obtenerCasos($idcaso);

                if (empty($query_pdf)) {
                    return $this->failNotFound('No se encontró información para el caso.');
                }

                $row = (is_array($query_pdf)) ? $query_pdf[0] : $query_pdf;
                $tipos = $tipoBeneficiarioModel->Listar_Tipo_Beneficiarios_filtro();
                $organismos = $organismoModel->Listar_Organismo_PP_filtro();

                // Configuración A4 Horizontal (297mm x 210mm)
                $pdf = new \FPDF('L', 'mm', 'letter');
                $pdf->AliasNbPages(); 
                $pdf->SetMargins(10, 10, 10);
                
                // Margen para que el footer respire
                $pdf->SetAutoPageBreak(true, 23); 

                $info_pdf = [
                    'caso'         => $row->idcaso,
                    'fecha_caso'   => $row->casofec,
                    'nombre'       => $row->nombre,
                    'cedula'       => $row->cedula,
                    'estadonom'    => mb_strtoupper($row->estadonom ?? 'N/P'),
                    'municipionom' => mb_strtoupper($row->municipionom ?? 'N/P'),
                    'parroquianom' => mb_strtoupper($row->parroquianom ?? 'N/P'),
                    'casotel'      => $row->casotel,
                    'casodesc'     => $row->casodesc,
                ];
   
                // Asignación de datos a las propiedades de la clase para que Header y Footer tengan acceso
                $pdf->info_pdf_header = $info_pdf; 
                $pdf->tipos_footer = $tipos; 
                $pdf->tipos_organismos_footer = $organismos; // <--- AGREGAR ESTA LÍNEA

                $pdf->AddPage(); 
                $pdf->Content_Formacion($info_pdf, $tipos, $organismos,$participantes);

                $this->response->setHeader('Content-Type', 'application/pdf');
                $pdf->Output("I", "Lista_Asistencia_{$row->idcaso}.pdf");
                exit();
        }

// --- OTROS TIPOS DE ATENCIÓN ---
        else {
            $pdf->AddPage();

            // Preparar array con claves específicas requeridas
            $row->caso = $row->idcaso;
            $row->fecha_caso = $row->casofec;

         

            $pdf->Header_Planilla((array)$row);
            $pdf->Content_planilla((array)$row);
            $pdf->Footer_Planilla();
        }

        $this->response->setHeader('Content-Type', 'application/pdf');
        $pdf->Output("I", "SIAC_Caso_{$row->idcaso}.pdf");
        exit();
    }
}